<?php

/**
 * This is the model class for table "maintenance_form_daily_event_lines".
 *
 * The followings are the available columns in table 'maintenance_form_daily_event_lines':
 * @property integer $id
 * @property string $hour
 * @property string $duration
 * @property string $description
 * @property integer $id_form_daily_event
 *
 * The followings are the available model relations:
 * @property MaintenanceFormsDailyEvents $idFormDailyEvent
 */
class MaintenanceFormDailyEventLines extends CExportedActiveRecord {
   public $sHourHour;
   public $sHourMinutes;
   public $sDurationHour;
   public $sDurationMinutes;
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return FormDailyEventLines the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
   /**
    * @return CDbConnection the database connection used for this class
    */
   public function getDbConnection() {
      return Yii::app()->db_rainbow_plantmaintenancemanagement;
   }

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'maintenance_form_daily_event_lines';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('hour', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('sHourHour', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('sHourMinutes', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('duration', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('sDurationHour', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('sDurationMinutes', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_daily_event', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('hour, duration, description, id_form_daily_event', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'formDailyEvent'=>array(self::BELONGS_TO, 'MaintenanceFormsDailyEvents', 'id_form_daily_event'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),
         'hour'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMDAILYEVENTLINES_FIELD_HOUR'), 
         'duration'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMDAILYEVENTLINES_FIELD_DURATION'), 
         'sHourHour'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMDAILYEVENTLINES_FIELD_HOURHOUR'),  
			'sHourMinutes'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMDAILYEVENTLINES_FIELD_HOURMINUTES'),
         'sDurationHour'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMDAILYEVENTLINES_FIELD_DURATIONHOUR'),  
         'sDurationMinutes'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMDAILYEVENTLINES_FIELD_DURATIONMINUTES'),
         'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMDAILYEVENTLINES_FIELD_DESCRIPTION'),
			'id_form_daily_event'=>Yii::t('system', 'SYS_MODEL_FIELD_FK'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($nIdFormFK = null) {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('id', $this->id);
		$oCriteria->compare('hour', $this->hour, true);
		$oCriteria->compare('duration', $this->duration, true);
		$oCriteria->compare('description', $this->description, true);

      if (!is_null($nIdFormFK)) $oCriteria->compare('id_form_daily_event', $nIdFormFK);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'hour ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getMaintenanceFormDailyEventLine($nId) {
      $oMaintenanceFormDailyEventLine = MaintenanceFormDailyEventLines::model()->findByPk($nId);
      
      return $oMaintenanceFormDailyEventLine;
   }
   
   public static function getMaintenanceFormDailyEventLinesByIdFormFK($nIdFormFK) {
      return MaintenanceFormDailyEventLines::model()->findAll('id_form_daily_event = ' . $nIdFormFK . ' ORDER BY id ASC');   
   }
   
   public static function getMaintenanceFormsDailyEventLines($sEmployee = null, $sStartDate = null, $sEndDate = null) {
      $sSentence = FString::STRING_EMPTY; 
      $bCondition = false;
       
      if (!FString::isNullOrEmpty($sEmployee)) {
         $sSentence = 'formDailyEvent.owner = \'' . $sEmployee . '\' ' . $sSentence; 
         $bCondition = true;  
      } 
      
      if (!FString::isNullOrEmpty($sStartDate)) {
         if ($bCondition) $sSentence = 'formDailyEvent.date >= \'' . FDate::getEnglishDate($sStartDate) . '\' AND ' . $sSentence; 
         else $sSentence = 'formDailyEvent.date >= \'' . FDate::getEnglishDate($sStartDate) . '\'' . FString::STRING_SPACE . $sSentence; 
         $bCondition = true;  
      } 
      
      if (!FString::isNullOrEmpty($sEndDate)) {
         if ($bCondition) $sSentence = 'formDailyEvent.date <= \'' . FDate::getEnglishDate($sEndDate) . '\' AND ' . $sSentence; 
         else $sSentence = 'formDailyEvent.date <= \'' . FDate::getEnglishDate($sEndDate) . '\'' . FString::STRING_SPACE . $sSentence; 
         $bCondition = true;  
      }    
      
      return MaintenanceFormDailyEventLines::model()->with('formDailyEvent')->findAll(array('condition'=>$sSentence, 'order'=>'formDailyEvent.date ASC, hour ASC'));
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['columns'] = array('hour', 'duration', 'description');
        
      return $this->oExportSpecifications; 
   }
}
