<?php

/**
 * This is the model class for table "modules_headers".
 *
 * The followings are the available columns in table 'modules_headers':
 * @property integer $id
 * @property string $name 
 * @property string $module
 * @property string $role
 *
 * The followings are the available model relations:
 * @property ModulesHeadersLines[] $modulesHeadersLines
 */
class ModulesHeaders extends CActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModulesHeaders the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'modules_headers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, module', 'required'),
			array('name, module', 'length', 'max'=>40),
			array('role', 'length', 'max'=>20),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, module, role', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'modulesHeadersLines'=>array(self::HAS_MANY, 'ModulesHeadersLines', 'id_module_header'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>'ID',
         'name'=>'Name',
			'module'=>'Module',
			'role'=>'Role',
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
		$oCriteria->compare('module', $this->module, true);
		$oCriteria->compare('role', $this->role, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
		));
	}
   
   public static function getModuleHeader($nId) {
      $oModuleHeader = ModulesHeaders::model()->findByPk($nId);
      
      return $oModuleHeader;
   }
   
   public static function getModuleHeaders($sModule, $sRole) {
      $oModuleHeaders = array();
      $bErrRole = false;
      $sCriteria;
      
      if ($sRole == FApplication::ROLE_MODULE_ADMIN) $sCriteria = ''; 
      else if ($sRole == FApplication::ROLE_MODULE_USER) $sCriteria = ' AND ((role = \'' . FApplication::ROLE_MODULE_USER . '\') OR (role = \'' . FApplication::ROLE_MODULE_RESTRICTED_USER . '\'))';
      else if ($sRole == FApplication::ROLE_MODULE_RESTRICTED_USER) $sCriteria = ' AND role = \'' . FApplication::ROLE_MODULE_RESTRICTED_USER . '\'';
      else $bErrRole = true;
      
      if (!$bErrRole) {
         $oModuleHeaders = ModulesHeaders::model()->findAll('module = ?' . $sCriteria, array($sModule));
      }
      return $oModuleHeaders;
   }
}