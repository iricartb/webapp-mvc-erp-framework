<?php

/**
 * This is the model class for table "risks_ipes".
 *
 * The followings are the available columns in table 'risks_ipes':
 * @property integer $id
 * @property integer $id_risk
 * @property integer $id_ipe
 *
 * The followings are the available model relations:
 * @property Risks $idRisk
 * @property Ipes $idIpe
 */
class RisksIPEs extends CExportedActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RisksIpes the static model class
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
		return 'risks_ipes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('id_risk', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_ipe', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('id_risk', 'UniqueAttributesValidator', 'with'=>'id_ipe', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MM', array('{1}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_RISKSIPES_FIELD_IDRISK'), '{2}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_RISKSIPES_FIELD_IDIPE')))),
         array('id_ipe', 'UniqueAttributesValidator', 'with'=>'id_risk', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MM', array('{1}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_RISKSIPES_FIELD_IDIPE'), '{2}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_RISKSIPES_FIELD_IDRISK')))),
                      
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_risk, id_ipe', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
      
		return array(
			'risk'=>array(self::BELONGS_TO, 'Risks', 'id_risk'),
			'ipe'=>array(self::BELONGS_TO, 'IPEs', 'id_ipe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
			'id_risk'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_RISKSIPES_FIELD_IDRISK'),
			'id_ipe'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_RISKSIPES_FIELD_IDIPE'),
         'risk.name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_RISKSIPES_FIELD_RISKNAME'),
		   'ipe.name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_RISKSIPES_FIELD_IPENAME'),
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

		$oCriteria->compare('id_risk', $this->id_risk);
		$oCriteria->compare('id_ipe', $this->id_ipe);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'id_risk ASC, id_ipe ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getRiskIPE($nId) {
      $oRiskIPE = RisksIPEs::model()->findByPk($nId);
      
      return $oRiskIPE;
   }
   
   public static function getRisksIPEs() {
      return RisksIPEs::model()->findAll();      
   }
   
   public static function getRisksIPEsByIdRisk($nIdRisk) {
      return RisksIPEs::model()->findAll('id_risk = ' . $nIdRisk);      
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('risk.name', 'ipe.name');
        
      return $this->oExportSpecifications; 
   }
}