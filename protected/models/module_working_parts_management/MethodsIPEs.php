<?php

/**
 * This is the model class for table "methods_ipes".
 *
 * The followings are the available columns in table 'methods_ipes':
 * @property integer $id
 * @property integer $id_method
 * @property integer $id_ipe
 *
 * The followings are the available model relations:
 * @property Methods $idMethod
 * @property Ipes $idIpe
 */
class MethodsIPEs extends CExportedActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MethodsIPEs the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection() {
		return Yii::app()->db_rainbow_workingpartsmanagement;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'methods_ipes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('id_method', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_ipe', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('id_method', 'UniqueAttributesValidator', 'with'=>'id_ipe', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MM', array('{1}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODSIPES_FIELD_IDMETHOD'), '{2}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODSIPES_FIELD_IDIPE')))),
         array('id_ipe', 'UniqueAttributesValidator', 'with'=>'id_method', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MM', array('{1}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODSIPES_FIELD_IDIPE'), '{2}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODSIPES_FIELD_IDMETHOD')))),
                        
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_method, id_ipe', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
      
		return array(
			'method'=>array(self::BELONGS_TO, 'Methods', 'id_method'),
			'ipe'=>array(self::BELONGS_TO, 'IPEs', 'id_ipe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
			'id_method'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODSIPES_FIELD_IDMETHOD'),
			'id_ipe'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODSIPES_FIELD_IDIPE'),
		   'method.name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODSIPES_FIELD_METHODNAME'),
         'ipe.name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODSIPES_FIELD_IPENAME'),
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

      $oCriteria->with = array('method', 'ipe');
      
		$oCriteria->compare('id_method', $this->id_method);
		$oCriteria->compare('id_ipe', $this->id_ipe);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'method.code ASC, ipe.name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getMethodIPE($nId) {
      $oMethodIPE = MethodsIPEs::model()->findByPk($nId);
      
      return $oMethodIPE;
   }
   
   public static function getMethodsIPEsByIdMethod($nIdMethod) {
      $oCriteria = new CDbCriteria;
      $oCriteria->with = array('ipe');
      
      $oCriteria->addCondition('id_method = ' . $nIdMethod);
      
      $oCriteria->order = 'ipe.name ASC';

      return MethodsIPEs::model()->findAll($oCriteria);    
   }
   
   public static function getMethodsIPEs() {
      return MethodsIPEs::model()->findAll();      
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('method.name', 'ipe.name');
        
      return $this->oExportSpecifications; 
   }
}