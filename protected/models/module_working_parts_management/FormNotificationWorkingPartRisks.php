<?php

/**
 * This is the model class for table "form_notification_working_part_risks".
 *
 * The followings are the available columns in table 'form_notification_working_part_risks':
 * @property integer $id
 * @property string $name
 * @property integer $id_form_notification_working_part
 *
 * The followings are the available model relations:
 * @property FormsNotificationWorkingParts $idFormNotificationWorkingPart
 */
class FormNotificationWorkingPartRisks extends CActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return FormNotificationWorkingPartRisks the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
   /**
    * @return CDbConnection the database connection used for this class
    */
   public function getDbConnection() {
      return Yii::app()->db_rainbow_workingpartsmanagement;
   }

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'form_notification_working_part_risks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_notification_working_part', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('name', 'length', 'min'=>3, 'max'=>64, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('name', 'UniqueAttributesValidator', 'with'=>'id_form_notification_working_part', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
   
         // The following rule is used by search().
         // Please remove those attributes that should not be searched.
         array('name, id_form_notification_working_part', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idFormNotificationWorkingPart' => array(self::BELONGS_TO, 'FormsNotificationWorkingParts', 'id_form_notification_working_part'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'id_form_notification_working_part' => 'Id Form Notification Working Part',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('id_form_notification_working_part',$this->id_form_notification_working_part);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


}
