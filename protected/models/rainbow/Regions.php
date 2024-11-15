<?php

/**
 * This is the model class for table "regions".
 *
 * The followings are the available columns in table 'regions':
 * @property integer $id
 * @property string $name
 * @property string $module
 * @property string $image
 * @property string $scene_coord_x
 * @property string $scene_coord_y
 * @property string $scene_image
 *
 * The followings are the available model relations:
 * @property RegionsEquipments[] $regionsEquipments
 */
class Regions extends CExportedActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Regions the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'regions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('area', 'numerical', 'min'=>0, 'max'=>9999, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>0)), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>9999))),
         
         array('name', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('image, scene_image', 'length', 'max'=>255),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, area, module, image, scene_image', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
         'zonesRegions'=>array(self::HAS_MANY, 'ZonesRegions', 'id_region'),
			'regionsEquipments'=>array(self::HAS_MANY, 'RegionsEquipments', 'id_region'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'), 
			'name'=>Yii::t('rainbow', 'MODEL_REGIONS_FIELD_NAME'),
         'module'=>Yii::t('rainbow', 'MODEL_REGIONS_FIELD_MODULE'),
         'image'=>Yii::t('rainbow', 'MODEL_REGIONS_FIELD_IMAGE'),
         'area'=>Yii::t('rainbow', 'MODEL_REGIONS_FIELD_AREA'),
         'area_m2'=>Yii::t('rainbow', 'MODEL_REGIONS_FIELD_AREAM2'),
         'scene_coord_x'=>Yii::t('rainbow', 'MODEL_REGIONS_FIELD_SCENECOORDX'),
         'scene_coord_y'=>Yii::t('rainbow', 'MODEL_REGIONS_FIELD_SCENECOORDY'),
         'scene_image'=>Yii::t('rainbow', 'MODEL_REGIONS_FIELD_SCENEIMAGE'),
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

		$oCriteria->compare('name', $this->name, true);
      $oCriteria->compare('module', $this->module, true);
      $oCriteria->compare('area', $this->area);
      $oCriteria->compare('image', $this->image, true);
      $oCriteria->compare('scene_image', $this->scene_image, true);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}
   
   public static function getRegion($nId) {
      $oRegion = Regions::model()->findByPk($nId);
      
      return $oRegion;
   }
   
   public static function getRegionName($nId) {
      $oRegion = Regions::getRegion($nId);
      if (!is_null($oRegion)) {
         return $oRegion->name;      
      }  
      return FString::STRING_EMPTY;
   }
   
   public static function getRegions($nIdZone = null, $sImage = null, $sSceneImage = null) {
      $oCriteria = new CDbCriteria;
            
      if (!FString::isNullOrEmpty($nIdZone)) {
         $oCriteria->with = array('zonesRegions');
         $oCriteria->compare('id_zone', $nIdZone);   
         $oCriteria->together = true; 
      }
      
      if (!FString::isNullOrEmpty($sImage)) $oCriteria->compare('t.image', $sImage);

      if (!FString::isNullOrEmpty($sSceneImage)) $oCriteria->compare('t.scene_image', $sSceneImage); 
      
      $oCActiveDataProvider = new CActiveDataProvider('Regions', array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'t.name ASC',
         ), 
         'pagination'=>false,
      ));
      
      return $oCActiveDataProvider->getData();   
   }
   
   public static function getFullRegions() {
      $oRegions = Regions::model()->findAll();

      foreach ($oRegions as $oRegion) {
         $oRegion->name = Regions::getFullRegion($oRegion->id);
      }
      return $oRegions;   
   }
   
   public static function getFullRegion($nIdRegion) {
      $oRegion = Regions::getRegion($nIdRegion);
      $sName = FString::STRING_EMPTY;
      if (!is_null($oRegion)) {
         $sName = $oRegion->name;
         $oZonesRegions = ZonesRegions::getZonesRegionsByIdRegion($nIdRegion);
         $bFirstZone = true;
         foreach ($oZonesRegions as $oZonesRegion) {
            $oZone = Zones::getZone($oZonesRegion->id_zone);
            if (!is_null($oZone)) {
               if ($bFirstZone) {
                  $sName = $oZone->name . '/' . $sName;   
               }
               else {
                  $sName = $oZone->name . '-' . $sName;    
               }
               $bFirstZone = false;
            }  
         }
      }
      return $sName;  
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('name');
        
      return $this->oExportSpecifications; 
   }        
}