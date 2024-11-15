<?php

/**
 * This is the model class for table "accesscontrolemployees".
 *
 * The followings are the available columns in table 'accesscontrolemployees':
 */
class AccessControlEmployees extends Employees {

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
      $oCurrentRules = array(
         array('id_biostar, id_group_device', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('access_code', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('access_information', 'length', 'max'=>20),
         array('num_employee', 'length', 'max'=>12),
         array('access_tolerance', 'numerical', 'min'=>0, 'max'=>FApplication::EMPLOYEE_MAX_TOLERANCE, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'0')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>FApplication::EMPLOYEE_MAX_TOLERANCE))),
         
         array('access_code', 'YiiConditionalValidator',
            'if'=>array(
               array('access_code_FIR', 'compare', 'compareValue'=>''),
            ),
            'then'=>array(
               array('access_code', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         
         array('access_code_FIR', 'YiiConditionalValidator',
            'if'=>array(
               array('access_code', 'compare', 'compareValue'=>''),
            ),
            'then'=>array(
               array('access_code_FIR', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),           
         
         array('num_employee', 'match', 'pattern'=>FRegEx::getNumericPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_ONLY_NUMERIC')),  
         array('access_code', 'match', 'pattern'=>FRegEx::getNumericPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_ONLY_NUMERIC')),
         array('access_tolerance', 'match', 'pattern'=>FRegEx::getNumericPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_ONLY_NUMERIC')),
         
         array('access_code, access_code_FIR, access_code_FIR_2, id_biostar', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
         array('full_name, access_code, access_code_FIR, access_code_FIR_2, access_process_delay, access_tolerance, id_biostar', 'safe', 'on'=>'search'),
      );
        
      return array_merge(parent::rules(), $oCurrentRules);
	}
   
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
      $oCurrentAttributeLabels = array(
         'full_name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLEMPLOYEES_FIELD_FULLNAME'),
      );
        
      return array_merge(parent::attributeLabels(), $oCurrentAttributeLabels);
	}
   
   /**
    * Retrieves a list of models based on the current search/filter conditions.
    * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
    */
   public function search($sAccessCode = FString::STRING_EMPTY, $bPendingSynchronization = null) {
      // Warning: Please modify the following code to remove attributes that
      // should not be searched.

      $oCriteria = new CDbCriteria;

      $oCriteria->compare('full_name', $this->full_name, true);
      $oCriteria->compare('identification', $this->identification, true);
      $oCriteria->compare('access_code', $this->access_code, true);
      
      $oCriteria->compare('id_group_device', $this->id_group_device);
      
      if ($sAccessCode == FApplication::EMPLOYEE_ACCESS_CODE_NULL) $oCriteria->addCondition('access_code IS NULL'); 
      else if ($sAccessCode == FApplication::EMPLOYEE_ACCESS_CODE_NOT_NULL) $oCriteria->addCondition('access_code IS NOT NULL');
      $oCriteria->addCondition('(type = \'' . FApplication::EMPLOYEE_BUSINESS . '\' OR type = \'' . FApplication::EMPLOYEE_SUBCONTRACT . '\')');
      
      if (!is_null($bPendingSynchronization)) {
         if ($bPendingSynchronization) $oCriteria->compare('pending_synchronize', true);   
         else $oCriteria->compare('pending_synchronize', false);   
      }
      
      if (!FString::isNullOrEmpty($this->start_date)) $oCriteria->addCondition('start_date = \'' . FDate::getEnglishDate($this->start_date) . '\'');
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'full_name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_BIG),
      )); 
   }
   
   public static function getAccessControlEmployee($nId) {
      $oEmployee = AccessControlEmployees::model()->findByPk($nId);
 
      if (!is_null($oEmployee)) {
         $oAccessControlEmployee = new AccessControlEmployees();

         $oAccessControlEmployee->isNewRecord = false; 
   
         $oAccessControlEmployee->id = $oEmployee->id;
         $oAccessControlEmployee->primaryKey = $oEmployee->id;
         $oAccessControlEmployee->attributes = $oEmployee->attributes;
         $oAccessControlEmployee->image = $oEmployee->image;
         
         return $oAccessControlEmployee;     
      }
      else return null;
   }
   
   public static function getAccessControlEmployeesByPendingSynchronization($bPendingSynchronization) {
      if ($bPendingSynchronization) $oEmployees = Employees::model()->findAll('pending_synchronize = 1 ORDER BY full_name ASC');
      else $oEmployees = Employees::model()->findAll('pending_synchronize = 0 ORDER BY full_name ASC');
      
      return $oEmployees;   
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('id_business', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Businesses::getBusinessName(\'?\')', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][1] = array('access_process_delay', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')'); 
      $this->oExportSpecifications['data'][2] = array('start_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\')', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][3] = array('id_group_device', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'AccessControlGroupsDevices::getAccessControlGroupDeviceName(?)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][4] = array('show_visual_presence', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
                  
      $this->oExportSpecifications['columns'] = array('full_name', 'identification', 'num_employee', 'id_business', 'start_date', 'access_code_FIR', 'access_code_FIR_2', 'access_code', 'access_information', 'access_process_delay', 'access_tolerance', 'show_visual_presence', 'id_group_device', 'id_biostar');
        
      return $this->oExportSpecifications; 
   }
}