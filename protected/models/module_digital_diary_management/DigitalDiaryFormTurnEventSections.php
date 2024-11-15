<?php

/**
 * This is the model class for table "digitaldiary_form_turn_event_sections".
 *
 * The followings are the available columns in table 'digitaldiary_form_turn_event_sections':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $id_form_turn_event
 *
 * The followings are the available model relations:
 * @property DigitalDiaryFormsTurnEvents $idFormTurnEvent
 * @property DigitalDiaryFormTurnEventSectionsNotifications[] $formTurnEventSectionsNotifications
 */
class DigitalDiaryFormTurnEventSections extends CActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormTurnEventSections the static model class
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
		return 'digitaldiary_form_turn_event_sections';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, id_form_turn_event', 'required'),
			array('id_form_turn_event', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>20),
			array('description', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, id_form_turn_event', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'formTurnEvent'=>array(self::BELONGS_TO, 'DigitalDiaryFormsTurnEvents', 'id_form_turn_event'),
			'notifications'=>array(self::HAS_MANY, 'DigitalDiaryFormTurnEventSectionsNotifications', 'id_form_turn_event_section'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'id_form_turn_event' => 'Id Form Turn Event',
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
		$oCriteria->compare('name', $this->name, true);
		$oCriteria->compare('description', $this->description, true);
		$oCriteria->compare('id_form_turn_event', $this->id_form_turn_event);

		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
		));
	}
   
   public static function getDigitalDiaryFormTurnEventSectionsByIdFormFK($nIdFormFK) {
      return DigitalDiaryFormTurnEventSections::model()->findAll('id_form_turn_event = ' . $nIdFormFK . ' ORDER BY name ASC');   
   }
}