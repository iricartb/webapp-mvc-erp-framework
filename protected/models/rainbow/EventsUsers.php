<?php

/**
 * This is the model class for table "events_users".
 *
 * The followings are the available columns in table 'events_users':
 * @property integer $id
 * @property integer $read_event
 * @property integer $notify_event
 * @property integer $id_user
 * @property integer $id_event
 *
 * The followings are the available model relations:
 * @property Users $idUser
 * @property Events $idEvent
 */
class EventsUsers extends CActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return EventsUsers the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'events_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, id_event', 'required'),
			array('id_user, id_event', 'numerical', 'integerOnly'=>true),
         
         array('read_event, notify_event', 'boolean'),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, read_event, notify_event, id_user, id_event', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user'=>array(self::BELONGS_TO, 'Users', 'id_user'),
			'event'=>array(self::BELONGS_TO, 'Events', 'id_event'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
			'read_event'=>Yii::t('rainbow', 'MODEL_EVENTSUSERS_FIELD_READEVENT'),
         'notify_event'=>Yii::t('rainbow', 'MODEL_EVENTSUSERS_FIELD_NOTIFYEVENT'),
			'id_user'=>Yii::t('rainbow', 'MODEL_EVENTSUSERS_FIELD_IDUSER'),
			'id_event'=>Yii::t('system', 'SYS_MODEL_FIELD_FK'),
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

		$oCriteria->compare('id', $this->id);
		$oCriteria->compare('read_event', $this->read_event);
      $oCriteria->compare('notify_event', $this->notify_event);
		$oCriteria->compare('id_user', $this->id_user);
		$oCriteria->compare('id_event', $this->id_event);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'read_event ASC, id_event DESC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getEventUser($nId) {
      $oEventUser = EventsUser::model()->findByPk($nId);
        
      return $oEventUser;
   }
   
   public static function getEventsUsers($nIdUser = null, $bNotify = null, $bRead = null, $sMinDate = null) {
      if ((is_null($nIdUser)) && (is_null($bNotify)) && (is_null($bRead)) && (FString::isNullOrEmpty($sMinDate))) $sSentence = 'true ORDER BY read_event ASC, id_event DESC';
      else $sSentence = FString::STRING_EMPTY; 
      $bCondition = false;
      
      if (!is_null($nIdUser)) {
         $sSentence = 't.id_user = ' . $nIdUser . FString::STRING_SPACE . $sSentence;   
         $bCondition = true;    
      }
      
      if (!is_null($bNotify)) {
         if ($bNotify) {
            if ($bCondition) $sSentence = 't.notify_event = 1 AND ' . $sSentence; 
            else $sSentence = 't.notify_event = 1' . FString::STRING_SPACE . $sSentence; 
         }
         else {
            if ($bCondition) $sSentence = 't.notify_event = 0 AND ' . $sSentence; 
            else $sSentence = 't.notify_event = 0' . FString::STRING_SPACE . $sSentence; 
         }
      }
      
      if (!is_null($bRead)) {
         if ($bRead) {
            if ($bCondition) $sSentence = 't.read_event = 1 AND ' . $sSentence; 
            else $sSentence = 't.read_event = 1' . FString::STRING_SPACE . $sSentence; 
         }
         else {
            if ($bCondition) $sSentence = 't.read_event = 0 AND ' . $sSentence; 
            else $sSentence = 't.read_event = 0' . FString::STRING_SPACE . $sSentence; 
         }
      }
      
      if (!FString::isNullOrEmpty($sMinDate)) {
         if ($bCondition) $sSentence = 'event.send_date >= \'' . $sMinDate . '\'  AND ' . $sSentence; 
         else $sSentence = $sSentence = 'event.send_date >= \'' . $sMinDate . '\'' . FString::STRING_SPACE . $sSentence;
      }
      
      if ((is_null($nIdUser)) && (is_null($bNotify)) && (is_null($bRead)) && (FString::isNullOrEmpty($sMinDate))) return EventsUsers::model()->findAll($sSentence);     
      else return EventsUsers::model()->with('event')->findAll($sSentence, array('order'=>'notify_event ASC, event.system DESC, id_event ASC'));         
   }
   
   public static function addEventUser($nIdUser, $nIdEvent) {
      $oEventUser = new EventsUsers();
      
      $oEventUser->id_user = $nIdUser;
      $oEventUser->id_event = $nIdEvent;

      return ($oEventUser->save());
   }
}
