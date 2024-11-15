<?php

/**
 * This is the model class for table "regions_equipments".
 *
 * The followings are the available columns in table 'regions_equipments':
 * @property integer $id
 * @property integer $id_region
 * @property integer $id_equipment
 * @property string $module
 *
 * The followings are the available model relations:
 * @property Regions $idRegion
 * @property Equipments $idEquipment
 */
class RegionsEquipments extends CExportedActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RegionsEquipments the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'regions_equipments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('id_region', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_equipment', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('id_region', 'UniqueAttributesValidator', 'with'=>'id_equipment', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_FM', array('{1}'=>Yii::t('rainbow', 'MODEL_REGIONSEQUIPMENTS_FIELD_IDREGION'), '{2}'=>Yii::t('rainbow', 'MODEL_REGIONSEQUIPMENTS_FIELD_IDEQUIPMENT')))),
         array('id_equipment', 'UniqueAttributesValidator', 'with'=>'id_region', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MF', array('{1}'=>Yii::t('rainbow', 'MODEL_REGIONSEQUIPMENTS_FIELD_IDEQUIPMENT'), '{2}'=>Yii::t('rainbow', 'MODEL_REGIONSEQUIPMENTS_FIELD_IDREGION')))),
             
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_region, id_equipment', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'region'=>array(self::BELONGS_TO, 'Regions', 'id_region'),
			'equipment'=>array(self::BELONGS_TO, 'Equipments', 'id_equipment'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
			'id_region'=>Yii::t('rainbow', 'MODEL_REGIONSEQUIPMENTS_FIELD_IDREGION'),
			'id_equipment'=>Yii::t('rainbow', 'MODEL_REGIONSEQUIPMENTS_FIELD_IDEQUIPMENT'),
         'region.name'=>Yii::t('rainbow', 'MODEL_REGIONSEQUIPMENTS_FIELD_REGIONNAME'),
         'equipment.name'=>Yii::t('rainbow', 'MODEL_REGIONSEQUIPMENTS_FIELD_EQUIPMENTNAME'),
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

		$oCriteria->compare('id_region', $this->id_region);
		$oCriteria->compare('id_equipment', $this->id_equipment);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'id_region ASC, id_equipment ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getRegionEquipment($nId) {
      $oRegionEquipment = RegionsEquipments::model()->findByPk($nId);
      
      return $oRegionEquipment;  
   }
   
   public static function getRegionsEquipments() {
      $oCriteria = new CDbCriteria;
      
      $oCActiveDataProvider = new CActiveDataProvider('RegionsEquipments', array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'t.id_region ASC, t.id_equipment ASC',
         ), 
         'pagination'=>false,
      ));
      
      return $oCActiveDataProvider->getData();     
   }
   
   public static function getRegionsEquipmentsByIdRegion($nIdRegion) {
      $oCriteria = new CDbCriteria;
      
      $oCriteria->compare('t.id_region', $nIdRegion);
      
      $oCActiveDataProvider = new CActiveDataProvider('RegionsEquipments', array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'t.id_equipment ASC',
         ), 
         'pagination'=>false,
      ));
      
      return $oCActiveDataProvider->getData();   
   }
   
   public static function getRegionsEquipmentsByIdEquipment($nIdEquipment) {
      $oCriteria = new CDbCriteria;
      
      $oCriteria->compare('t.id_equipment', $nIdEquipment);
      
      $oCActiveDataProvider = new CActiveDataProvider('RegionsEquipments', array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'t.id_region ASC',
         ), 
         'pagination'=>false,
      ));
      
      return $oCActiveDataProvider->getData();   
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('region.name', 'equipment.name');
        
      return $this->oExportSpecifications; 
   }
}