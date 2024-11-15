<?php

/**
 * This is the model class for table "maintenance_module_parameters".
 *
 * The followings are the available columns in table 'maintenance_module_parameters':
 * @property string $allow_create_working_part   
 * @property string $allow_users_create_tasks
 */
class MaintenanceModuleParameters extends CActiveRecord {
   
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
		return Yii::app()->db_rainbow_plantmaintenancemanagement;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'maintenance_module_parameters';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('allow_create_working_part, allow_users_create_tasks', 'boolean'),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('allow_create_working_part, allow_users_create_tasks', 'safe', 'on'=>'search'),
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
         'allow_create_working_part' => 'Allow Create Working Part',
         'allow_users_create_tasks' => 'Allow Users Create Tasks',
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

		$oCriteria->compare('allow_create_working_part', $this->allow_create_working_part);
      $oCriteria->compare('allow_users_create_tasks', $this->allow_users_create_tasks);
      
		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
		));
	}
   
   public static function getMaintenanceModuleParameters() {
      $oMaintenanceModuleParameters = MaintenanceModuleParameters::model()->find();
        
      return $oMaintenanceModuleParameters;
   }
}