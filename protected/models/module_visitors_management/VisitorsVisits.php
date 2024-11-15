<?php

/**
 * This is the model class for table "visitors_visits".
 *
 * The followings are the available columns in table 'visitors_visits':
 * @property integer $id
 * @property integer $card_id
 * @property string $card_code
 * @property string $card_information
 * @property string $employee
 * @property string $employee_identification
 * @property string $employee_comments
 * @property string $visitor_first_name
 * @property string $visitor_middle_name
 * @property string $visitor_last_name
 * @property string $visitor_full_name
 * @property string $visitor_identification
 * @property string $visitor_business
 * @property integer $visitor_vehicle
 * @property string $visitor_vehicle_plate
 * @property string $visitor_destiny_vehicle
 * @property string $visitor_comments
 * @property string $visitor_signature
 * @property string $reason
 * @property string $type
 * @property integer $status
 * @property string $start_date
 * @property string $end_date
 */
class VisitorsVisits extends CExportedActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Visits the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection() {
		return Yii::app()->db_rainbow_visitorsmanagement;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'visitors_visits';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('card_id', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('card_code', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')), 
         array('type', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('employee', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('employee_identification', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('visitor_first_name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('visitor_middle_name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('visitor_identification', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('visitor_business', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('start_date', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('end_date', 'type', 'type'=>'datetime', 'datetimeFormat'=>'yyyyMMddhhmmss'),
         array('id_group_device', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')), 

         array('visitor_vehicle, status', 'boolean'),
         array('visitor_destiny_vehicle', 'YiiConditionalValidator',
            'if'=>array(
               array('visitor_vehicle', 'compare', 'compareValue'=>'1'),
            ),
            'then'=>array(
               array('visitor_destiny_vehicle', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('visitor_destiny_vehicle', 'YiiConditionalValidator',
            'if'=>array(
               array('visitor_vehicle', 'compare', 'compareValue'=>'1'),
            ),
            'then'=>array(
               array('visitor_vehicle_plate', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
		 
         array('card_information', 'length', 'max'=>20),
         
		   array('card_code', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),   	
         array('employee_comments', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('visitor_first_name', 'length', 'min'=>2, 'max'=>12, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'2'))),
         array('visitor_middle_name', 'length', 'min'=>2, 'max'=>12, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'2'))),
         array('visitor_last_name', 'length', 'min'=>2, 'max'=>12, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'2'))),
         array('visitor_identification', 'length', 'min'=>5, 'max'=>12, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'5'))),
         array('visitor_business', 'length', 'min'=>3, 'max'=>32, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('visitor_comments', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('reason', 'length', 'min'=>3, 'max'=>64, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('card_code', 'match', 'pattern'=>FRegEx::getNumericPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_ONLY_NUMERIC')),          
         array('visitor_first_name', 'match', 'pattern'=>FRegEx::getNamePattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_NAME')),
         array('visitor_middle_name', 'match', 'pattern'=>FRegEx::getNamePattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_NAME')),
         array('visitor_last_name', 'match', 'pattern'=>FRegEx::getNamePattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_NAME')),
         array('visitor_business', 'match', 'pattern'=>FRegEx::getBusinessPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_BUSINESS')),
         array('visitor_identification', 'match', 'pattern'=>FRegEx::getIdentificationPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_IDENTIFICATION')),
         //array('visitor_vehicle_plate', 'match', 'pattern'=>FRegEx::getPlatePattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_PLATE')),
         
         array('visitor_full_name', 'filter', 'filter'=>array($this, 'strcpy_fullname')),
            
         array('visitor_identification', 'filter', 'filter'=>'strtoupper'),
         array('visitor_business', 'filter', 'filter'=>'strtoupper'),
         array('visitor_vehicle_plate', 'filter', 'filter'=>'strtoupper'),
         
         array('id_biostar', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('visitor_full_name, card_code, type, start_date, end_date, status, id_biostar', 'safe', 'on'=>'search'),
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
			'card_id'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_CARDID'),
			'card_code'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_CARDCODE'),
         'card_information'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_CARDINFORMATION'),
			'employee'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_EMPLOYEE'),
			'employee_identification'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_EMPLOYEEIDENTIFICATION'),
			'employee_comments'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_EMPLOYEECOMMENTS'),
			'visitor_first_name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_VISITORFIRSTNAME'),
			'visitor_middle_name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_VISITORMIDDLENAME'),
			'visitor_last_name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_VISITORLASTNAME'),
			'visitor_full_name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_VISITORFULLNAME'),
         'visitor_identification'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_VISITORIDENTIFICATION'),
			'visitor_business'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_VISITORBUSINESS'),
			'visitor_vehicle'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_VISITORVEHICLE'),
			'visitor_vehicle_plate'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_VISITORVEHICLEPLATE'),
			'visitor_destiny_vehicle'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_VISITORDESTINYVEHICLE'),
			'visitor_comments'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_VISITORCOMMENTS'),
         'visitor_signature'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_VISITORSIGNATURE'),
			'reason'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_REASON'),
			'type'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_TYPE'),
			'status'=>'Status',
			'start_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_STARTDATE'),
			'end_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_ENDDATE'),
         'id_group_device'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_IDGROUPDEVICE'),
		   'id_biostar'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSVISITS_FIELD_IDBIOSTAR'),
      );
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($sShowOnlyActives = 'true') {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$oCriteria = new CDbCriteria;

      $oCriteria->compare('visitor_full_name', $this->visitor_full_name, true);
		$oCriteria->compare('card_code', $this->card_code, true);
		$oCriteria->compare('type', $this->type, true);
      
      if ($sShowOnlyActives == 'true') $oCriteria->compare('status', '1');
      else $oCriteria->compare('status', '0');
      
      if (!FString::isNullOrEmpty($this->start_date)) $oCriteria->addCondition('start_date >= \'' . FDate::getEnglishDate($this->start_date) . FString::STRING_SPACE . FDate::START_HOUR_OF_DAY . '\'');
      if (!FString::isNullOrEmpty($this->end_date)) $oCriteria->addCondition('end_date <= \'' . FDate::getEnglishDate($this->end_date) . FString::STRING_SPACE . FDate::END_HOUR_OF_DAY . '\'');
      
		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'start_date DESC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_BIG),
		));
	}
   
   public static function getVisitorsVisit($nId) {
      $oVisitorsVisit = VisitorsVisits::model()->findByPk($nId);
        
      return $oVisitorsVisit;
   }
   
   public static function getActiveVisitorsVisits() {
      $oVisitorsVisits = VisitorsVisits::model()->findAll('status = ' . FModuleVisitorsManagement::STATUS_INSIDE);
      
      return $oVisitorsVisits;   
   }
   
   public function strcpy_fullname() {
      if (strlen($this->visitor_last_name) > 0) $this->visitor_full_name = $this->visitor_first_name . FString::STRING_SPACE . $this->visitor_middle_name . FString::STRING_SPACE . $this->visitor_last_name;
      else $this->visitor_full_name = $this->visitor_first_name . FString::STRING_SPACE . $this->visitor_middle_name;
      
      return $this->visitor_full_name;  
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('type', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Yii::t(\'frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '\', \'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_?\')', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][1] = array('visitor_vehicle', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');                                                            
      $this->oExportSpecifications['data'][2] = array('visitor_destiny_vehicle', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Yii::t(\'frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '\', FString::getUntilLastStr(\'MODEL_TYPEDESTINYCAR_FIELD_NAME_VALUE_?\', \'_\'), array(\'{1}\'=>FString::getLastToken(\'?\',\'_\')))', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][3] = array('start_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][4] = array('end_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][5] = array('id_group_device', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'AccessControlGroupsDevices::getAccessControlGroupDeviceName(?)', 'FString::STRING_EMPTY');
      
      $this->oExportSpecifications['columns'] = array('visitor_full_name', 'visitor_identification', 'type', 'card_code', 'card_information', 'visitor_business', 'visitor_vehicle', 'visitor_destiny_vehicle', 'reason', 'visitor_comments', 'employee', 'employee_identification', 'employee_comments', 'start_date', 'end_date', 'id_group_device', 'id_biostar');  
      return $this->oExportSpecifications; 
   }
}