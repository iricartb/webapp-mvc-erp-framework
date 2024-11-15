<?php

/**
 * This is the model class for table "monitoring_forms_turn_rounds".
 *
 * The followings are the available columns in table 'monitoring_forms_turn_rounds':
 * @property integer $id
 * @property string $name
 * @property string $start_date
 * @property string $end_date
 * @property string $user_name
 * @property string $status
 * @property integer $id_form_turn_event
 * @property integer $id_user
 *
 * The followings are the available model relations:
 * @property MonitoringFormsTurnRoundsGroupForms[] $monitoringFormsTurnRoundsGroupForms
 */
class MonitoringFormsTurnRounds extends CActiveRecord {
   public $oCDbConnection;
   public $sDiffDate;
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return MonitoringFormsQuestions the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
   /**
    * @return CDbConnection the database connection used for this class
    */
   public function getDbConnection() {
      return Yii::app()->db_rainbow_plantmonitoringmanagement; 
   }
   
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'monitoring_forms_turn_rounds';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('start_date', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('user_name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('status', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, start_date, end_date, user_name, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'formsTurnRoundsGroupForms'=>array(self::HAS_MANY, 'MonitoringFormsTurnRoundsGroupForms', 'id_form_turn_round'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),   
         'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDS_FIELD_NAME'),
			'start_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDS_FIELD_STARTDATE'),
			'end_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDS_FIELD_ENDDATE'),
         'sDiffDate'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDS_FIELD_SDIFFDATE'),
			'user_name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDS_FIELD_USERNAME'),
			'status'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDS_FIELD_STATUS'),
			'id_user'=>Yii::t('system', 'SYS_MODEL_FIELD_FK'),
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
	public function search($nIdFormTurnEvent = null) {
		// @todo Please modify the following code to remove attributes that should not be searched.

      $oCriteria = new CDbCriteria;

      $oCriteria->compare('user_name', $this->user_name, true);
      $oCriteria->compare('name', $this->name, true);
      $oCriteria->compare('start_date', FDate::getEnglishDate($this->start_date), true);
      $oCriteria->compare('end_date', FDate::getEnglishDate($this->end_date), true);
      $oCriteria->compare('status', $this->status, true);
      
      if (!is_null($nIdFormTurnEvent)) $oCriteria->compare(id_form_turn_event, $nIdFormTurnEvent); 
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'id DESC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_BIG),
      ));
	}
   
   public static function getMonitoringFormTurnRound($nId) {
      $oMonitoringFormTurnRound = MonitoringFormsTurnRounds::model()->findByPk($nId);
      
      return $oMonitoringFormTurnRound;
   }
   
   public static function getLastMonitoringFormTurnRoundByIdFormTurnEvent($nIdFormTurnEvent) {
      return MonitoringFormsTurnRounds::model()->find('id_form_turn_event = ? ORDER BY id DESC', array($nIdFormTurnEvent));
   }
   
   public static function getLastMonitoringFormTurnRoundId($nIdFormTurnEvent) {
      $oMonitoringFormTurnRound = MonitoringFormsTurnRounds::getLastMonitoringFormTurnRoundByIdFormTurnEvent($nIdFormTurnEvent);
      if (!is_null($oMonitoringFormTurnRound)) {
         return $oMonitoringFormTurnRound->id;   
      }
      
      return null;
   }
   
   public static function getMonitoringFormsTurnRounds() {
      return MonitoringFormsTurnRounds::model()->findAll(array('order'=>'id DESC'));   
   }

   public static function getMonitoringFormsTurnRoundsByUserDate($sUser, $sDate) {
      $oMonitoringFormsTurnRounds = MonitoringFormsTurnRounds::model()->findAll('user_name = ? AND DATE(start_date) = ?', array($sUser, $sDate));
      
      return $oMonitoringFormsTurnRounds;
   }
       
   public static function getMonitoringFormsTurnRoundsUsers() {
      return MonitoringFormsTurnRounds::model()->findAll(array('group'=>'user_name', 'order'=>'user_name ASC'));      
   }
}