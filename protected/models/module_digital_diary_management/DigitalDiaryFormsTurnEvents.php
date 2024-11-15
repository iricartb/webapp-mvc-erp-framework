<?php

/**
 * This is the model class for table "digitaldiary_forms_turn_events".
 *
 * The followings are the available columns in table 'digitaldiary_forms_turn_events':
 * @property integer $id
 * @property string $owner
 * @property string $date
 * @property string $turn
 * @property integer $status
 * @property string $start_date
 * @property string $comments
 * 
 * The followings are the available model relations:
 * @property DigitalDiaryFormTurnEventLines[] $formTurnEventLines
 * @property DigitalDiaryFormTurnEventSections[] $formTurnEventSections
 */
class DigitalDiaryFormsTurnEvents extends CExportedActiveRecord {
   public $read_last_turn;
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormsTurnEvents the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection() {
		return Yii::app()->db_rainbow_digitaldiarymanagement;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'digitaldiary_forms_turn_events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('owner', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('turn', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('date', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('status', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('read_last_turn', 'required', 'on'=>'new', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('comments', 'length', 'max'=>512),
         
         array('read_last_turn', 'boolean'),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('date, turn, owner', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'lines'=>array(self::HAS_MANY, 'DigitalDiaryFormTurnEventLines', 'id_form_turn_event'),
			'sections'=>array(self::HAS_MANY, 'DigitalDiaryFormTurnEventSections', 'id_form_turn_event'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
			'owner'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_OWNER'),
			'date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_DATE'),
			'turn'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_TURN'),
			'status'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_STATUS'),
         'comments'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_COMMENTS'),
		   'read_last_turn'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_READLASTTURN'),
      );
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('date', FDate::getEnglishDate($this->date), true);
      $oCriteria->compare('turn', $this->turn, true);
      $oCriteria->compare('owner', $this->owner,true);
      
		return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'date DESC, turn DESC, owner ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_BIG),
		));
	}
   
   public static function getDigitalDiaryFormsTurnEventsOwner() {
      return DigitalDiaryFormsTurnEvents::model()->findAll(array('group'=>'owner', 'order'=>'owner ASC'));   
   }
    
   public static function getDigitalDiaryFormTurnEvent($nId) {
      $oDigitalDiaryFormTurnEvent = DigitalDiaryFormsTurnEvents::model()->findByPk($nId);
      
      return $oDigitalDiaryFormTurnEvent;
   }
   
   public static function getLastDigitalDiaryFormTurnEvent() {
      $oDigitalDiaryFormTurnEvent = DigitalDiaryFormsTurnEvents::model()->find('true ORDER BY date DESC, turn DESC, owner ASC');
      
      return $oDigitalDiaryFormTurnEvent;
   }
   
   public static function getDigitalDiaryFormsTurnEventsByDateAndTurn($sDate, $sTurn) {
      $oDigitalDiaryFormsTurnEvents = DigitalDiaryFormsTurnEvents::model()->findAll('date = \'' . $sDate . '\' AND turn = \'' . $sTurn . '\'');
      
      return $oDigitalDiaryFormsTurnEvents;
   }
   
   public static function getDigitalDiaryFormTurnEventByAttributes($sDate, $sTurn, $sOwner) {
      $oDigitalDiaryFormTurnEvent = DigitalDiaryFormsTurnEvents::model()->find('date = \'' . $sDate . '\' AND turn = \'' . $sTurn . '\' AND owner = \'' . $sOwner . '\'');
      
      return $oDigitalDiaryFormTurnEvent;
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', false)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][1] = array('turn', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Yii::t(\'system\', \'SYS_TURN_\' . substr(\'?\', 2))', 'FString::STRING_EMPTY');
            
      $this->oExportSpecifications['columns'] = array('date', 'turn', 'owner');
        
      return $this->oExportSpecifications; 
   }
}