<?php

/**
 * This is the model class for table "equipments_components".
 *
 * The followings are the available columns in table 'equipments_components':
 * @property integer $id
 * @property integer $id_equipment
 * @property integer $id_component
 *
 * The followings are the available model relations:
 * @property Equipments $idEquipment
 * @property Components $idComponent
 */
class EquipmentsComponents extends CExportedActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return EquipmentsComponents the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'equipments_components';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('id_equipment', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_component', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('id_equipment, id_component', 'numerical', 'integerOnly'=>true),
         
         array('id_equipment', 'UniqueAttributesValidator', 'with'=>'id_component', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MM', array('{1}'=>Yii::t('rainbow', 'MODEL_EQUIPMENTSCOMPONENTS_FIELD_IDEQUIPMENT'), '{2}'=>Yii::t('rainbow', 'MODEL_EQUIPMENTSCOMPONENTS_FIELD_IDCOMPONENT')))),
         array('id_component', 'UniqueAttributesValidator', 'with'=>'id_equipment', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MM', array('{1}'=>Yii::t('rainbow', 'MODEL_EQUIPMENTSCOMPONENTS_FIELD_IDCOMPONENT'), '{2}'=>Yii::t('rainbow', 'MODEL_EQUIPMENTSCOMPONENTS_FIELD_IDEQUIPMENT')))),
             
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_equipment, id_component', 'safe', 'on'=>'search'),
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
			'component'=>array(self::BELONGS_TO, 'Components', 'id_component'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
         'id_equipment'=>Yii::t('rainbow', 'MODEL_EQUIPMENTSCOMPONENTS_FIELD_IDEQUIPMENT'),
         'id_component'=>Yii::t('rainbow', 'MODEL_EQUIPMENTSCOMPONENTS_FIELD_IDCOMPONENT'),
         'equipment.name'=>Yii::t('rainbow', 'MODEL_EQUIPMENTSCOMPONENTS_FIELD_EQUIPMENTNAME'),
         'component.name'=>Yii::t('rainbow', 'MODEL_EQUIPMENTSCOMPONENTS_FIELD_COMPONENTNAME'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('id_equipment', $this->id_equipment);
		$oCriteria->compare('id_component', $this->id_component);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'id_equipment ASC, id_component ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}

   public static function getEquipmentComponent($nId) {
      $oEquipmentComponent = EquipmentsComponents::model()->findByPk($nId);

      return $oEquipmentComponent;
   }
   
   public static function getEquipmentsComponents() {
      return EquipmentsComponents::model()->findAll();      
   }
   
   public static function getEquipmentsComponentsByIdEquipment($nIdEquipment) {
      return EquipmentsComponents::model()->with('component')->findAll(array('condition'=>'id_equipment = ' . $nIdEquipment, 'order'=>'name ASC'));  
   }
   
   public static function getEquipmentsComponentsByIdComponent($nIdComponent) {
      return EquipmentsComponents::model()->with('equipment')->findAll(array('condition'=>'id_component = ' . $nIdComponent, 'order'=>'name ASC'));     
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('equipment.name', 'component.name');
        
      return $this->oExportSpecifications; 
   }
}
