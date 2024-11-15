<?php

/**
 * This is the model class for table "modules_headers_lines".
 *
 * The followings are the available columns in table 'modules_headers_lines':
 * @property integer $id
 * @property string $name
 * @property string $dependency
 * @property string $action
 * @property integer $id_module_header
 *
 * The followings are the available model relations:
 * @property ModulesHeaders $idModuleHeader
 */
class ModulesHeadersLines extends CActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModulesHeadersLines the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'modules_headers_lines';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, id_module_header', 'required'),
			array('id_module_header', 'numerical', 'integerOnly'=>true),
         array('name', 'length', 'max'=>40),
			array('action', 'length', 'max'=>128),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, action, id_module_header', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idModuleHeader'=>array(self::BELONGS_TO, 'ModulesHeaders', 'id_module_header'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>'ID',
         'name'=>'Name',
         'dependency'=>'Dependency',
			'action'=>'Action',
			'id_module_header'=>'Id Module Header',
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
		$oCriteria->compare('action', $this->action, true);
		$oCriteria->compare('id_module_header', $this->id_module_header);

		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
		));
	}
   
   public static function getModuleHeaderLine($nId) {
      $oModuleHeaderLine = ModulesHeadersLines::model()->findByPk($nId);
      
      return $oModuleHeaderLine;
   }
   
   public static function getModuleHeaderLines($nIdHeader) {
      return ModulesHeadersLines::model()->findAll('id_module_header = ?', array($nIdHeader));
   }
}