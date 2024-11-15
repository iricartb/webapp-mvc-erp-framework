<?php

/**
 * This is the model class for table "zones_regions".
 *
 * The followings are the available columns in table 'zones_regions':
 * @property integer $id
 * @property integer $id_zone
 * @property integer $id_region
 * @property string $module
 *
 * The followings are the available model relations:
 * @property Regions $idZone
 * @property Equipments $idRegion
 */
class ZonesRegions extends CExportedActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ZonesRegions the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'zones_regions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('id_zone', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_region', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('id_zone', 'UniqueAttributesValidator', 'with'=>'id_region', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_FF', array('{1}'=>Yii::t('rainbow', 'MODEL_ZONESREGIONS_FIELD_IDZONE'), '{2}'=>Yii::t('rainbow', 'MODEL_ZONESREGIONS_FIELD_IDREGION')))),
         array('id_region', 'UniqueAttributesValidator', 'with'=>'id_zone', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_FF', array('{1}'=>Yii::t('rainbow', 'MODEL_ZONESREGIONS_FIELD_IDREGION'), '{2}'=>Yii::t('rainbow', 'MODEL_ZONESREGIONS_FIELD_IDZONE')))),
             
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_zone, id_region', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'zone'=>array(self::BELONGS_TO, 'Zones', 'id_zone'),
			'region'=>array(self::BELONGS_TO, 'Regions', 'id_region'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
			'id_zone'=>Yii::t('rainbow', 'MODEL_ZONESREGIONS_FIELD_IDZONE'),
			'id_region'=>Yii::t('rainbow', 'MODEL_ZONESREGIONS_FIELD_IDREGION'),
         'zone.name'=>Yii::t('rainbow', 'MODEL_ZONESREGIONS_FIELD_ZONENAME'),
         'region.name'=>Yii::t('rainbow', 'MODEL_ZONESREGIONS_FIELD_REGIONNAME'),
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

		$oCriteria->compare('id_zone', $this->id_zone);
		$oCriteria->compare('id_region', $this->id_region);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'id_zone ASC, id_region ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getZoneRegion($nId) {
      $oZoneRegion = ZonesRegions::model()->findByPk($nId);
      
      return $oZoneRegion;
   }
   
   public static function getZonesRegions() {
      $oCriteria = new CDbCriteria;
      
      $oCActiveDataProvider = new CActiveDataProvider('ZonesRegions', array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'t.id_zone ASC, t.id_region ASC',
         ), 
         'pagination'=>false,
      ));
      
      return $oCActiveDataProvider->getData();     
   }
   
   public static function getZonesRegionsByIdZone($nIdZone) {
      $oCriteria = new CDbCriteria;
      
      $oCriteria->compare('t.id_zone', $nIdZone);
      
      $oCActiveDataProvider = new CActiveDataProvider('ZonesRegions', array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'t.id_region ASC',
         ), 
         'pagination'=>false,
      ));
      
      return $oCActiveDataProvider->getData(); 
   }
   
   public static function getZonesRegionsByIdRegion($nIdRegion) {
      $oCriteria = new CDbCriteria;
      
      $oCriteria->compare('t.id_region', $nIdRegion);
      
      $oCActiveDataProvider = new CActiveDataProvider('ZonesRegions', array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'t.id_zone ASC',
         ), 
         'pagination'=>false,
      ));
      
      return $oCActiveDataProvider->getData();  
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('zone.name', 'region.name');
        
      return $this->oExportSpecifications; 
   }
}