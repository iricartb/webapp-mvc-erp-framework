<?php

/**
 * This is the model class for table "accesscontrol_module_parameters".
 *
 * The followings are the available columns in table 'module_parameters':
 * @property integer $show_checkin_manual
 * @property integer $block_synchronization
 */
class AccessControlModuleParameters extends CActiveRecord {
   
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
		return Yii::app()->db_rainbow_accesscontrolmanagement;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'accesscontrol_module_parameters';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('show_checkin_manual, block_synchronization', 'boolean'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('show_checkin_manual, block_synchronization', 'safe', 'on'=>'search'),
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
			'show_checkin_manual' => 'Show Checkin Manual',
         'block_synchronization' => 'Block Synchronization',
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

		$oCriteria->compare('show_checkin_manual', $this->show_checkin_manual);
      $oCriteria->compare('block_synchronization', $this->block_synchronization);
      
		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
		));
	}
   
   public static function getAccessControlModuleParameters() {
      $oAccessControlModuleParameters = AccessControlModuleParameters::model()->find();
        
      return $oAccessControlModuleParameters;
   }
}