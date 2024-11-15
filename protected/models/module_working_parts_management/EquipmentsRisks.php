<?php

/**
 * This is the model class for table "equipments_risks".
 *
 * The followings are the available columns in table 'equipments_risks':
 * @property integer $id
 * @property integer $id_equipment
 * @property integer $id_risk
 *
 * The followings are the available model relations:
 * @property Equipments $idEquipment
 * @property Risks $idRisk
 */
class EquipmentsRisks extends CExportedActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EquipmentsRisks the static model class
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
		return 'equipments_risks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('id_equipment', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_risk', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('id_equipment', 'UniqueAttributesValidator', 'with'=>'id_risk', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MM', array('{1}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTSRISKS_FIELD_IDEQUIPMENT'), '{2}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTSRISKS_FIELD_IDRISK')))),
         array('id_risk', 'UniqueAttributesValidator', 'with'=>'id_equipment', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MM', array('{1}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTSRISKS_FIELD_IDRISK'), '{2}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTSRISKS_FIELD_IDEQUIPMENT')))),
                        
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_equipment, id_risk', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
      
		return array(
			'equipment'=>array(self::BELONGS_TO, 'Equipments', 'id_equipment'),
			'risk'=>array(self::BELONGS_TO, 'Risks', 'id_risk'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
			'id_equipment'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTSRISKS_FIELD_IDEQUIPMENT'),
			'id_risk'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTSRISKS_FIELD_IDRISK'),
		   'equipment.name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTSRISKS_FIELD_EQUIPMENTNAME'),
         'risk.name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTSRISKS_FIELD_RISKNAME'),
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

		$oCriteria->compare('id_equipment', $this->id_equipment);
		$oCriteria->compare('id_risk', $this->id_risk);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'id_equipment ASC, id_risk ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getEquipmentRisk($nId) {
      $oEquipmentRisk = EquipmentsRisks::model()->findByPk($nId);
      
      return $oEquipmentRisk;
   }
   
   public static function getEquipmentsRisksByIdEquipment($nIdEquipment) {
      return EquipmentsRisks::model()->findAll('id_equipment = ' . $nIdEquipment);      
   }
   
   public static function getEquipmentsRisks() {
      return EquipmentsRisks::model()->findAll();      
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('equipment.name', 'risk.name');
        
      return $this->oExportSpecifications; 
   }
}