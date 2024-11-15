<?php

/**
 * This is the model class for table "modules".
 *
 * The followings are the available columns in table 'modules':
 * @property integer $id
 * @property string $name
 * @property string $serial
 * @property integer $order
 */                                 
class Modules extends CActiveRecord {
    
   /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Modules the static model class
	 */
   public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'modules';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name, serial', 'length', 'max'=>40),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, serial', 'safe', 'on'=>'search'),
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
			'id'=>'ID',
			'name'=>'Name',
			'serial'=>'Serial',
         'order'=>'Order',
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
		$oCriteria->compare('serial', $this->serial, true);
      
		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
		));
	}
   
   public static function getModule($nId) {
      $oModule = Modules::model()->findByPk($nId);
      
      return $oModule;
   }
   
   public static function getIdModuleByName($sModule) {
      $oModule = Modules::model()->find('name = ?', array($sModule));
      
      if (!is_null($oModule)) return $oModule->id;
      
      return null;
   }
   
   public static function getIsValidSerialModule($nId) {
      $oModule = Modules::getModule($nId);
      if (!is_null($oModule)) {
         return true;
         //return ($oModule->serial == md5($oModule->name . '_' . gethostname()));    
      }   
      return false;
   }
   
   public static function getIsAvaliableModuleByName($sModule) {
      $nIdModule = Modules::getIdModuleByName($sModule);
      if (!is_null($nIdModule)) {
         return Modules::getIsValidSerialModule($nIdModule);      
      }
      return false;      
   }
   
   public static function getAvaliableModules() {
      $oAvaliableModules = array();
      $oModules = Modules::model()->findAll('true ORDER BY `order` ASC');

      foreach ($oModules as $oModule) {
         if (Modules::getIsValidSerialModule($oModule->id)) $oAvaliableModules[count($oAvaliableModules)] = $oModule;
      }
      
      return $oAvaliableModules;
   }
   
   public static function getNumAvaliableModules() {
      return count(Modules::getAvaliableModules());
   }
}