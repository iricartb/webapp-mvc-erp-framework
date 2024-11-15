<?php

/**
 * This is the model class for table "digitaldiary_form_turn_event_sections_notifications".
 *
 * The followings are the available columns in table 'digitaldiary_form_turn_event_sections_notifications':
 * @property integer $id
 * @property string $mail
 * @property integer $only_recv_urgent_events
 * @property integer $id_form_turn_event_section
 *
 * The followings are the available model relations:
 * @property DigitalDiaryFormTurnEventSections $idFormTurnEventSection
 */
class DigitalDiaryFormTurnEventSectionsNotifications extends CActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormTurnEventSectionsNotifications the static model class
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
		return 'digitaldiary_form_turn_event_sections_notifications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mail, id_form_turn_event_section', 'required'),
			array('id_form_turn_event_section', 'numerical', 'integerOnly'=>true),
			array('mail', 'length', 'max'=>60),
         array('only_recv_urgent_events', 'boolean'),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mail, id_form_turn_event_section', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'formTurnEventSection'=>array(self::BELONGS_TO, 'DigitalDiaryFormTurnEventSections', 'id_form_turn_event_section'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'mail' => 'Mail',
         'only_recv_urgent_events'=>'Only Recv Urgent Events',
			'id_form_turn_event_section' => 'Id Form Turn Event Section',
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

		$oCriteria->compare('id', $this->id);
		$oCriteria->compare('mail', $this->mail, true);
		$oCriteria->compare('id_form_turn_event_section', $this->id_form_turn_event_section);

		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
		));
	}
   
   public static function getDigitalDiaryFormTurnEventSectionNotificationsByIdFormFK($nIdFormFK) {
      return DigitalDiaryFormTurnEventSectionsNotifications::model()->findAll('id_form_turn_event_section = ' . $nIdFormFK . ' ORDER BY mail ASC');   
   }
}