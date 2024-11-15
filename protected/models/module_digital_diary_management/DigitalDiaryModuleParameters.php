<?php

/**
 * This is the model class for table "digital_diary_module_parameters".
 *
 * The followings are the available columns in table 'digital_diary_module_parameters':
 * @property string $notify_smtp_mail
 * @property string $notify_smtp_host
 * @property integer $notify_smtp_port
 * @property string $notify_smtp_user
 * @property string $notify_smtp_passwd
 * @property integer $notify_smtp_ssl
 */
class DigitalDiaryModuleParameters extends CActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleParameters the static model class
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
		return 'digitaldiary_module_parameters';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('notify_smtp_mail, notify_smtp_host, notify_smtp_port, notify_smtp_user, notify_smtp_passwd', 'required'),
			array('notify_smtp_mail, notify_smtp_host, notify_smtp_user', 'length', 'max'=>30),
			array('notify_smtp_passwd', 'length', 'max'=>20),
         
         array('notify_smtp_ssl', 'boolean'),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('notify_smtp_mail, notify_smtp_host, notify_smtp_port, notify_smtp_user, notify_smtp_passwd, notify_smtp_ssl', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations(){
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'notify_smtp_mail' => 'Notify Smtp Mail',
			'notify_smtp_host' => 'Notify Smtp Host',
			'notify_smtp_port' => 'Notify Smtp Port',
			'notify_smtp_user' => 'Notify Smtp User',
			'notify_smtp_passwd' => 'Notify Smtp Passwd',
			'notify_smtp_ssl' => 'Notify Smtp Ssl',
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

		$oCriteria->compare('notify_smtp_mail', $this->notify_smtp_mail, true);
		$oCriteria->compare('notify_smtp_host', $this->notify_smtp_host, true);
		$oCriteria->compare('notify_smtp_port', $this->notify_smtp_port);
		$oCriteria->compare('notify_smtp_user', $this->notify_smtp_user, true);
		$oCriteria->compare('notify_smtp_passwd', $this->notify_smtp_passwd, true);
		$oCriteria->compare('notify_smtp_ssl', $this->notify_smtp_ssl);
      
		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
		));
	}
   
   public static function getDigitalDiaryModuleParameters() {
      $oDigitalDiaryModuleParameters = DigitalDiaryModuleParameters::model()->find();
        
      return $oDigitalDiaryModuleParameters;
   }
}