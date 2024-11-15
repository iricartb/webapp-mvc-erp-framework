<?php

/**
 * This is the model class for table "accesscontrol_check_in_machine".
 *
 * The followings are the available columns in table 'accesscontrol_check_in_machine':
 * @property integer $id
 * @property string $date
 * @property string $incidence_code
 * @property string $employee_type_access_code
 * @property string $employee_identification
 * @property string $id_device
 * @property integer $type
 */
class AccessControlCheckInMachine extends CExportedActiveRecord {
   public $start_date;
   public $end_date;
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccessControlCheckInMachine the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection() {
		return Yii::app()->db_rainbow_accesscontrolmanagement;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'accesscontrol_check_in_machine';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('date', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('employee_identification', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),

         array('incidence_code', 'length', 'max'=>20),
         array('employee_identification', 'length', 'max'=>12),
         
         array('employee_identification', 'UniqueAttributesValidator', 'with'=>'date', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MF', array('{1}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_EMPLOYEEIDENTIFICATION'), '{2}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_DATE')))),
         array('date', 'UniqueAttributesValidator', 'with'=>'employee_identification', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MF', array('{1}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_EMPLOYEEIDENTIFICATION'), '{2}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_DATE')))),
          
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date, incidence_code, employee_type_access_code, employee_identification, start_date, end_date, type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),
			'date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_DATE'),  
			'type'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_TYPE'),
         'incidence_code'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_INCIDENCECODE'),
			'employee_type_access_code'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_EMPLOYEETYPEACCESSCODE'),
			'employee_identification'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_EMPLOYEEIDENTIFICATION'),
         'start_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_STARTDATE'),
         'end_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINMACHINE_FIELD_ENDDATE'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$oCriteria=new CDbCriteria;

		$oCriteria->compare('id', $this->id);
		$oCriteria->compare('date', $this->date, true);
		$oCriteria->compare('incidence_code', $this->incidence_code,true);
		$oCriteria->compare('employee_type_access_code', $this->employee_type_access_code);
		$oCriteria->compare('employee_identification', $this->employee_identification, true);
      $oCriteria->compare('type', $this->type);
      
      if ((!is_null($this->start_date)) && (strlen($this->start_date) > 0)) $oCriteria->addCondition('date >= \'' . FDate::getEnglishDate($this->start_date) . FString::STRING_SPACE . FDate::START_HOUR_OF_DAY . '\'');
      if ((!is_null($this->end_date)) && (strlen($this->end_date) > 0)) $oCriteria->addCondition('date <= \'' . FDate::getEnglishDate($this->end_date) . FString::STRING_SPACE . FDate::END_HOUR_OF_DAY . '\'');

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'date DESC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_BIG),
      ));
	}
   
   public static function getAccessControlCheckin($id) {
      $oAccessControlCheckin = AccessControlCheckInMachine::model()->findByPk($id);
        
      return $oAccessControlCheckin;
   }
   
   public static function getAccessControlCheckinByEmployeeDate($employee, $date) {
      $oAccessControlCheckin = AccessControlCheckInMachine::model()->findAll('employee_identification = \'' . $employee . '\' AND date >= \'' . $date . ' 00:00:00\' AND date <= \'' . $date . ' 23:59:59\' ORDER BY date ASC');
      
      return $oAccessControlCheckin;
   }
   
   public static function getAccessControlCheckinByEmployeeDateHour($employee, $date, $hour, $min) {
      $oAccessControlCheckin = AccessControlCheckInMachine::model()->findAll('employee_identification = \'' . $employee . '\' AND DATE(date) = \'' . FString::getFirstToken($date, FString::STRING_SPACE) . '\' AND ((HOUR(date) > ' . $hour . ') OR ((HOUR(date) = ' . $hour . ') AND (MINUTE(date) > ' . $min . '))) ORDER BY date ASC');
               
      return $oAccessControlCheckin;
   }
   
   public static function getLastAccessControlCheckinByEmployee($employee) {
      $oAccessControlCheckin = AccessControlCheckInMachine::model()->find('employee_identification = \'' . $employee . '\' AND ((type = ' . FModuleAccessControlManagement::TYPE_MAIN_INPUT . ') OR (' . FModuleAccessControlManagement::TYPE_MAIN_OUTPUT . ')) ORDER BY date DESC');
      
      return $oAccessControlCheckin;      
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('employee_identification', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Employees::getEmployeeByIdentification(\'?\')->full_name', 'FString::STRING_EMPTY', '(!is_null(Employees::getEmployeeByIdentification(\'?\')))');
      $this->oExportSpecifications['data'][1] = array('date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][2] = array('incidence_code', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'AccessControlIncidences::getAccessControlIncidenceByCode(\'?\')->description', 'FString::STRING_EMPTY', '(!is_null(AccessControlIncidences::getAccessControlIncidenceByCode(\'?\')))');
      
      $this->oExportSpecifications['columns'] = array('employee_identification', 'employee_type_access_code', 'date', 'incidence_code');
      return $this->oExportSpecifications; 
   }
}

