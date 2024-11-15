<?php

/**
 * This is the model class for table "employees".
 *
 * The followings are the available columns in table 'employees':
 * @property integer $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $full_name
 * @property string $identification
 * @property string $start_date
 * @property string $end_date
 * @property string $type
 * @property string $access_code
 * @property integer $access_process_delay
 * @property integer $access_tolerance
 * @property string $access_information
 * @property integer $grade_preventive_action
 * @property integer $active
 * @property integer $inside
 * @property string $signature
 * @property string $image
 * @property integer $id_user
 */
class Employees extends CExportedActiveRecord {
   public $sSearchBusiness;
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Employees the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'employees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('first_name, middle_name, full_name, identification, start_date, id_business, type', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('first_name, middle_name, last_name, identification', 'length', 'max'=>12),
         array('full_name', 'length', 'max'=>38),
         array('type', 'length', 'max'=>20),
         
         array('full_name', 'filter', 'filter'=>array($this, 'strcpy_fullname')),
        
         array('access_process_delay, active, inside, show_visual_presence, pending_synchronize', 'boolean'),
         
         array('identification', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, first_name, middle_name, last_name, full_name, identification, start_date, end_date, type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
         'business'=>array(self::BELONGS_TO, 'Businesses', 'id_business'),
      );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
         'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),
         'first_name'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_FIRSTNAME'),
         'middle_name'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_MIDDLENAME'),
         'last_name'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_LASTNAME'),
         'full_name'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_FULLNAME'),
         'identification'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_IDENTIFICATION'),
         'num_employee'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_NUMEMPLOYEE'),
         'start_date'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_STARTDATE'),
         'end_date'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_ENDDATE'),
         'type'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_TYPE'),
         'access_code'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_ACCESSCODE'),
         'access_code_FIR'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_ACCESSCODEFIR'),
         'access_code_FIR_2'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_ACCESSCODEFIR2'),
         'access_information'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_ACCESSINFORMATION'),
         'access_process_delay'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_ACCESSPROCESSDELAY'),
         'access_tolerance'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_ACCESSTOLERANCE'),
         'show_visual_presence'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_SHOWVISUALPRESENCE'),
         'signature'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_SIGNATURE'),
         'image'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_IMAGE'),
         'id_group_device'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_IDGROUPDEVICE'),
         'id_business'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_IDBUSINESS'),
         'id_biostar'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_IDBIOSTAR'),
         'pending_synchronize_action'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_PENDINGSYNCHRONIZEACTION'),
         'sSearchBusiness'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_SEARCHBUSINESS'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($sInside = FString::STRING_EMPTY) {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('id', $this->id);
		$oCriteria->compare('first_name', $this->first_name, true);
		$oCriteria->compare('middle_name', $this->middle_name, true);
		$oCriteria->compare('last_name', $this->last_name, true);
      $oCriteria->compare('full_name', $this->full_name, true);
		$oCriteria->compare('identification', $this->identification, true);
      $oCriteria->compare('type', $this->type);
      
      if ($sInside == FApplication::EMPLOYEE_INSIDE_YES) $oCriteria->compare('inside', true);
      else if ($sInside == FApplication::EMPLOYEE_INSIDE_NO) $oCriteria->compare('inside', false);
      
      $oCriteria->addCondition('start_date >= \'' . FDate::getEnglishDate($this->start_date) . FString::STRING_SPACE . FDate::START_HOUR_OF_DAY . '\'');
      if (!is_null($this->end_date)) $oCriteria->addCondition('end_date <= \'' . FDate::getEnglishDate($this->end_date) . FString::STRING_SPACE . FDate::END_HOUR_OF_DAY . '\'');
      
		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'full_name ASC',
         ),
		)); 
	}
   
   public static function getEmployee($nId) {
      $oEmployee = Employees::model()->findByPk($nId);
        
      return $oEmployee;
   }
   
   public static function getEmployeeByIdBiostar($nIdBiostar) {
      $oEmployee = Employees::model()->find('id_biostar = ?', array($nIdBiostar));
      
      return $oEmployee;   
   }
   
   public static function getEmployeeByAccessCode($sAccessCode) {
      $oEmployee = Employees::model()->find('access_code = ?', array($sAccessCode));
      
      return $oEmployee;   
   }
   
   public static function getEmployeeByAccessCodeFIR($sAccessCodeFIR) {
      $oEmployee = Employees::model()->find('access_code_FIR = ?', array($sAccessCodeFIR));
      
      return $oEmployee;   
   }
   
   public static function getEmployeeByAccessCodeFIR2($sAccessCodeFIR) {
      $oEmployee = Employees::model()->find('access_code_FIR_2 = ?', array($sAccessCodeFIR));
      
      return $oEmployee;   
   }
   
   public static function getEmployeeByIdentification($sIdentification) {
      $oEmployee = Employees::model()->find('identification = ?', array($sIdentification));
      
      return $oEmployee;   
   } 
   
   public static function getEmployeeByIdUser($nIdUser) {
      $oEmployee = Employees::model()->find('id_user = ?', array($nIdUser));
      
      return $oEmployee;   
   }
   
   public static function getEmployeeByFullName($sEmployee) {
      $oEmployee = Employees::model()->find('full_name = \'' . $sEmployee . '\'');
      
      return $oEmployee;   
   }
   
   public static function getEmployeesByIdGroupDevice($nIdGroupDevice) {
      $oEmployees = Employees::model()->findAll('id_group_device = ?', array($nIdGroupDevice));
      
      return $oEmployees;   
   }
   
   public static function getEmployeeWithAccessCodeByIdentification($sIdentification) {
      $oEmployee = Employees::model()->find('identification = ? AND ((access_code IS NOT NULL) OR (access_code_FIR IS NOT NULL))', array($sIdentification));
      
      return $oEmployee;   
   }
   
   public static function getEmployees($oTypes = null, $oDepartments = null, $sAccessCode = null, $bActive = null, $bGradePreventiveAction = null, $bInside = null, $bShowVisualPresence = null, $bOrderByBusinessAndEmployee = false) {
      $bFilters = false;
      
      if ((is_null($oTypes)) && (is_null($oDepartments)) && (FString::isNullOrEmpty($sAccessCode)) && (is_null($bActive))  && (is_null($bGradePreventiveAction))) {
        if ($bOrderByBusinessAndEmployee) {
          $sSentence = 'true ORDER BY id_business ASC, full_name ASC'; 
        }
        else $sSentence = 'true ORDER BY full_name ASC';
      }
      else {
         $bFilters = true;
         if ($bOrderByBusinessAndEmployee) {
            $sSentence = 'ORDER BY id_business ASC, full_name ASC';    
         }
         else $sSentence = 'ORDER BY full_name ASC';
      } 
      $bCondition = false;
       
      if (!is_null($oTypes)) {
         foreach($oTypes as $sType) {
            if ($bCondition) $sSentence = 'type = \'' . $sType . '\'' . ' OR ' . $sSentence;  
            else $sSentence = 'type = \'' . $sType . '\')' . FString::STRING_SPACE . $sSentence;
            
            $bCondition = true;   
         }
         if (count($oTypes) > 0) $sSentence =  '(' . $sSentence;    
      }
      
      $bFindEmployee = false;
      if (!is_null($oDepartments)) {
         foreach($oDepartments as $oDepartment) {
            $sResponsability = $oDepartment[0];
            $sDepartment = $oDepartment[1];
            $bStrict = false;
            
            if (!FString::isNullOrEmpty($oDepartment[2])) $bStrict = $oDepartment[2]; 

            $oEmployeesDepartments = EmployeesDepartments::getEmployeesDepartmentsByDepartament($sResponsability, $sDepartment, $bStrict);
            foreach($oEmployeesDepartments as $oEmployeeDepartment) {
               if (($bCondition) && ($bFindEmployee)) $sSentence = 'identification = \'' . $oEmployeeDepartment->employee_identification . '\'' . ' OR ' . $sSentence;  
               else if ($bCondition) $sSentence = 'identification = \'' . $oEmployeeDepartment->employee_identification . '\') AND ' . $sSentence;  
               else $sSentence = 'identification = \'' . $oEmployeeDepartment->employee_identification . '\')' . FString::STRING_SPACE . $sSentence;  
               
               $bFindEmployee = true;
               $bCondition = true;      
            }     
         } 
         if ($bFindEmployee) $sSentence =  '(' . $sSentence; 
      }
         
      if (!FString::isNullOrEmpty($sAccessCode)) {
         if ($sAccessCode == FApplication::EMPLOYEE_ACCESS_CODE_NULL) {
            if ($bCondition) $sSentence = 'access_code IS NULL AND ' . $sSentence; 
            else $sSentence = 'access_code IS NULL' . FString::STRING_SPACE . $sSentence;  
         }
         else {
            if ($bCondition) $sSentence = 'access_code IS NOT NULL AND ' . $sSentence; 
            else $sSentence = 'access_code IS NOT NULL' . FString::STRING_SPACE . $sSentence;   
         }
         $bCondition = true;  
      }   
      
      if (!is_null($bActive)) {
         if ($bActive) {
            if ($bCondition) $sSentence = 'active = 1 AND ' . $sSentence; 
            else $sSentence = 'active = 1' . FString::STRING_SPACE . $sSentence;        
         }
         else {
            if ($bCondition) $sSentence = 'active = 0 AND ' . $sSentence; 
            else $sSentence = 'active = 0' . FString::STRING_SPACE . $sSentence;   
         }
         $bCondition = true;  
      }
      
      if (!is_null($bGradePreventiveAction)) {
         if ($bGradePreventiveAction) {
            if ($bCondition) $sSentence = 'grade_preventive_action = 1 AND ' . $sSentence; 
            else $sSentence = 'grade_preventive_action = 1' . FString::STRING_SPACE . $sSentence;        
         }
         else {
            if ($bCondition) $sSentence = 'grade_preventive_action = 0 AND ' . $sSentence; 
            else $sSentence = 'grade_preventive_action = 0' . FString::STRING_SPACE . $sSentence;   
         }
         $bCondition = true;  
      }
    
      if (!is_null($bInside)) {
         if ($bInside) {
            if ($bCondition) $sSentence = 'inside = 1 AND ' . $sSentence; 
            else $sSentence = 'inside = 1' . FString::STRING_SPACE . $sSentence;        
         }
         else {
            if ($bCondition) $sSentence = 'inside = 0 AND ' . $sSentence; 
            else $sSentence = 'inside = 0' . FString::STRING_SPACE . $sSentence;   
         }
         $bCondition = true;  
      }
      
      if (!is_null($bShowVisualPresence)) {
         if ($bShowVisualPresence) {
            if ($bCondition) $sSentence = 'show_visual_presence = 1 AND ' . $sSentence; 
            else $sSentence = 'show_visual_presence = 1' . FString::STRING_SPACE . $sSentence;        
         }
         else {
            if ($bCondition) $sSentence = 'show_visual_presence = 0 AND ' . $sSentence; 
            else $sSentence = 'show_visual_presence = 0' . FString::STRING_SPACE . $sSentence;   
         }
         $bCondition = true;  
      }
      
      if (($bFilters) && (FString::getFirstToken($sSentence, FString::STRING_SPACE) == 'ORDER')) $sSentence = 'false ' . $sSentence; 
      return Employees::model()->findAll($sSentence);
   }
   
   public function strcpy_fullname() {
      if (strlen($this->last_name) > 0) $this->full_name = $this->first_name . FString::STRING_SPACE . $this->middle_name . FString::STRING_SPACE . $this->last_name;
      else $this->full_name = $this->first_name . FString::STRING_SPACE . $this->middle_name;
      
      return $this->full_name;  
   }
  
   public static function getFullName($nId) {
      $oEmployee = Employees::getEmployee($nId);
      if (!is_null($oEmployee)) {
         if (strlen($oEmployee->last_name) > 0) return $oEmployee->first_name . FString::STRING_SPACE . $oEmployee->middle_name . FString::STRING_SPACE . $oEmployee->last_name;
         else return $oEmployee->first_name . FString::STRING_SPACE . $oEmployee->middle_name;      
      }
      else return null; 
   }
    
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('full_name', 'identification');  
      
      return $this->oExportSpecifications; 
   }
}