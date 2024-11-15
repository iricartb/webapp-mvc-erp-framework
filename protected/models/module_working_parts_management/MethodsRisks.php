<?php

/**
 * This is the model class for table "methods_risks".
 *
 * The followings are the available columns in table 'methods_risks':
 * @property integer $id
 * @property integer $id_method
 * @property integer $id_risk
 *
 * The followings are the available model relations:
 * @property Methods $idMethod
 * @property Risks $idRisk
 */
class MethodsRisks extends CExportedActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MethodsRisks the static model class
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
		return 'methods_risks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('id_method', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_risk', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('id_method', 'UniqueAttributesValidator', 'with'=>'id_risk', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MM', array('{1}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODSRISKS_FIELD_IDMETHOD'), '{2}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODSRISKS_FIELD_IDRISK')))),
         array('id_risk', 'UniqueAttributesValidator', 'with'=>'id_method', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MM', array('{1}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODSRISKS_FIELD_IDRISK'), '{2}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODSRISKS_FIELD_IDMETHOD')))),
                        
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_method, id_risk', 'safe', 'on'=>'search'),
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
			'risk'=>array(self::BELONGS_TO, 'Risks', 'id_risk'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
			'id_method'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODSRISKS_FIELD_IDMETHOD'),
			'id_risk'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODSRISKS_FIELD_IDRISK'),
		   'method.name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODSRISKS_FIELD_METHODNAME'),
         'risk.name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODSRISKS_FIELD_RISKNAME'),
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

      $oCriteria->with = array('method', 'risk');
      
		$oCriteria->compare('id_method', $this->id_method);
		$oCriteria->compare('id_risk', $this->id_risk);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'method.code ASC, risk.name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getMethodRisk($nId) {
      $oMethodRisk = MethodsRisks::model()->findByPk($nId);
      
      return $oMethodRisk;
   }
   
   public static function getMethodsRisksByIdMethod($nIdMethod) {
      $oCriteria = new CDbCriteria;
      $oCriteria->with = array('risk');
      
      $oCriteria->addCondition('id_method = ' . $nIdMethod);
      
      $oCriteria->order = 'risk.name ASC';

      return MethodsRisks::model()->findAll($oCriteria);      
   }
   
   public static function getMethodsRisks() {
      return MethodsRisks::model()->findAll();      
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('method.name', 'risk.name');
        
      return $this->oExportSpecifications; 
   }
}