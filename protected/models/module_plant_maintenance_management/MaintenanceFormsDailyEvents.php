<?php

/**
 * This is the model class for table "maintenance_forms_daily_events".
 *
 * The followings are the available columns in table 'maintenance_forms_daily_events':
 * @property integer $id
 * @property string $owner
 * @property string $date
 *
 * The followings are the available model relations:
 * @property MaintenanceFormDailyEventLines[] $formDailyEventLines
 */
class MaintenanceFormsDailyEvents extends CExportedActiveRecord {

   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return FormsDailyEvents the static model class
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
		return 'maintenance_forms_daily_events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('owner', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('date', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('owner, date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'lines'=>array(self::HAS_MANY, 'MaintenanceFormDailyEventLines', 'id_form_daily_event'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
         'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
         'owner'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSDAILYEVENTS_FIELD_OWNER'),
         'date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSDAILYEVENTS_FIELD_DATE'),
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
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('owner', $this->owner, true);
		$oCriteria->compare('date', FDate::getEnglishDate($this->date), true);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'date DESC, owner ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getMaintenanceFormsDailyEventsOwner() {
      return MaintenanceFormsDailyEvents::model()->findAll(array('group'=>'owner', 'order'=>'owner ASC'));   
   }
    
   public static function getMaintenanceFormDailyEvent($nId) {
      $oMaintenanceFormDailyEvent = MaintenanceFormsDailyEvents::model()->findByPk($nId);
      
      return $oMaintenanceFormDailyEvent;
   }
   
   public static function getMaintenanceFormsDailyEventsByDate($sDate) {
      $oMaintenanceFormsDailyEvents = MaintenanceFormsDailyEvents::model()->findAll('date = \'' . $sDate);
      
      return $oMaintenanceFormsDailyEvents;
   }
   
   public static function getMaintenanceFormDailyEventByAttributes($sDate, $sOwner) {
      $oMaintenanceFormDailyEvent = MaintenanceFormsDailyEvents::model()->find('date = \'' . $sDate . '\' AND owner = \'' . $sOwner . '\'');
      
      return $oMaintenanceFormDailyEvent;
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', false)', 'FString::STRING_EMPTY');

      $this->oExportSpecifications['columns'] = array('date', 'owner');
        
      return $this->oExportSpecifications; 
   }
}
