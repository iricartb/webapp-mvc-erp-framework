<?php

/**
 * This is the model class for table "users_modules_privileges".
 *
 * The followings are the available columns in table 'users_modules_privileges':
 * @property integer $id
 * @property string $role
 * @property integer $active
 * @property string $module
 * @property integer $id_user
 *
 * The followings are the available model relations:
 * @property Users $idUser
 */
class UsersModulesPrivileges extends CActiveRecord {
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UsersModulesPrivileges the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'users_modules_privileges';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('module, id_user', 'required'),
			array('active, id_user', 'numerical', 'integerOnly'=>true),
			array('role', 'length', 'max'=>20),
			array('module', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, role, active, module, id_user', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idUser'=>array(self::BELONGS_TO, 'Users', 'id_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>'ID',
			'role'=>'Role',
			'active'=>'Active',
			'module'=>'Module',
			'id_user'=>'Id User',
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
		$oCriteria->compare('role', $this->role, true);
		$oCriteria->compare('active', $this->active);
		$oCriteria->compare('module', $this->module, true);
		$oCriteria->compare('id_user', $this->id_user);

		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
	   ));
	}
   
   public static function getUserModulePrivileges($sModule, $nIdUser) {
      $oUserModulePrivileges = UsersModulesPrivileges::model()->find('module = ? AND id_user = ?', array($sModule, $nIdUser));
      
      return $oUserModulePrivileges;
   }
   
   public static function getAvaliableUserModulePrivileges($sModule, $nIdUser) {
      $oUserModulePrivileges = UsersModulesPrivileges::model()->find('module = ? AND id_user = ? AND active = 1', array($sModule, $nIdUser));
      
      return $oUserModulePrivileges;
   }
}