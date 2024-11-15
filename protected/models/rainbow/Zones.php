<?php

/**
 * This is the model class for table "zones".
 *
 * The followings are the available columns in table 'zones':
 * @property integer $id
 * @property string $name
 * @property string $module
 * @property string $image
 * @property string $scene_coord_x
 * @property string $scene_coord_y
 * @property string $scene_image
 *
 * The followings are the available model relations:
 * @property ZonesRegions[] $zonesRegions
 */
class Zones extends CExportedActiveRecord {
   
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
		return 'zones';
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
			'zonesRegions'=>array(self::HAS_MANY, 'ZonesRegions', 'id_zone'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'), 
			'name'=>Yii::t('rainbow', 'MODEL_ZONES_FIELD_NAME'),
         'module'=>Yii::t('rainbow', 'MODEL_ZONES_FIELD_MODULE'),
         'image'=>Yii::t('rainbow', 'MODEL_ZONES_FIELD_IMAGE'),
         'area'=>Yii::t('rainbow', 'MODEL_ZONES_FIELD_AREA'),
         'area_m2'=>Yii::t('rainbow', 'MODEL_ZONES_FIELD_AREAM2'),
         'scene_coord_x'=>Yii::t('rainbow', 'MODEL_ZONES_FIELD_SCENECOORDX'),
         'scene_coord_y'=>Yii::t('rainbow', 'MODEL_ZONES_FIELD_SCENECOORDY'),
         'scene_image'=>Yii::t('rainbow', 'MODEL_ZONES_FIELD_SCENEIMAGE'),
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
   
   public static function getZone($nId) {
      $oZone = Zones::model()->findByPk($nId);
      
      return $oZone;
   }
   
   public static function getZoneName($nId) {
      $oZone = Zones::getZone($nId);
      if (!is_null($oZone)) {
         return $oZone->name;      
      }  
      return FString::STRING_EMPTY;
   }

   public static function getZones($sImage = null, $sSceneImage = null) {
      $oCriteria = new CDbCriteria;

      if (!FString::isNullOrEmpty($sImage)) $oCriteria->compare('t.image', $sImage);

      if (!FString::isNullOrEmpty($sSceneImage)) $oCriteria->compare('t.scene_image', $sSceneImage); 
        
      $oCActiveDataProvider = new CActiveDataProvider('Zones', array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'t.name ASC',
         ), 
         'pagination'=>false,
      ));
      
      return $oCActiveDataProvider->getData();  
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('name');
        
      return $this->oExportSpecifications; 
   }        
}