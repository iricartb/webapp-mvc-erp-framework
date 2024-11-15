<?php

/**
 * This is the model class for table "equipments".
 *
 * The followings are the available columns in table 'equipments':
 * @property integer $id
 * @property string $name
 * @property string $tag
 * @property string $manufacturer
 * @property string $installation_date
 * @property string $model
 * @property string $serial_number
 * @property string $module
 * @property string $image
 * @property string $attachment
 * @property string $dimension_x
 * @property string $dimension_y
 * @property string $dimension_z
 * @property string $scene_coord_x
 * @property string $scene_coord_y
 * @property string $scene_image
 *
 * The followings are the available model relations:
 * @property EquipmentsRisks[] $equipmentsRisks
 */
class Equipments extends CExportedActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Equipments the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'equipments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('name, manufacturer, model, serial_number', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('tag', 'length', 'min'=>2, 'max'=>10, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'2'))),
         array('dimension_x, dimension_y, dimension_z', 'length', 'max'=>6),
         array('image, attachment, scene_image', 'length', 'max'=>255),
         
         array('dimension_x, dimension_y, dimension_z', 'numerical', 'min'=>0, 'max'=>999.99, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>0)), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>999.99))),
        
         array('tag', 'filter', 'filter'=>'strtoupper'),
        
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, tag, manufacturer, model, serial_number, module, image, dimension_x, dimension_y, dimension_z, scene_image', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'risks'=>array(self::HAS_MANY, 'EquipmentsRisks', 'id_equipment'),
         'regionsEquipments'=>array(self::HAS_MANY, 'RegionsEquipments', 'id_equipment'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
		   'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'), 
			'name'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_NAME'),
         'tag'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_TAG'),
         'manufacturer'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_MANUFACTURER'),
         'installation_date'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_INSTALLATIONDATE'),
         'model'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_MODEL'),
         'serial_number'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_SERIALNUMBER'),
         'module'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_MODULE'),
         'image'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_IMAGE'),
         'attachment'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_ATTACHMENT'),
         'dimension_x'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_DIMENSIONX'),
         'dimension_y'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_DIMENSIONY'),
         'dimension_z'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_DIMENSIONZ'),
         'dimension_x_m'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_DIMENSIONXM'),
         'dimension_y_m'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_DIMENSIONYM'),
         'dimension_z_m'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_DIMENSIONZM'),
         'scene_coord_x'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_SCENECOORDX'),
         'scene_coord_y'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_SCENECOORDY'),
         'scene_image'=>Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_SCENEIMAGE'),
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
      $oCriteria->compare('tag', $this->tag, true);
      $oCriteria->compare('manufacturer', $this->manufacturer, true);
      $oCriteria->compare('model', $this->model, true);
      $oCriteria->compare('serial_number', $this->serial_number, true);
      $oCriteria->compare('module', $this->module, true);
      $oCriteria->compare('image', $this->image, true);
      $oCriteria->compare('dimension_x', $this->dimension_x);
      $oCriteria->compare('dimension_y', $this->dimension_y);
      $oCriteria->compare('dimension_z', $this->dimension_z);
      $oCriteria->compare('scene_image', $this->scene_image, true);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}
   
   public static function getEquipment($nId) {
      $oEquipment = Equipments::model()->findByPk($nId);
      
      return $oEquipment;
   }
   
   public static function getEquipmentName($nId) {
      $oEquipment = Equipments::getEquipment($nId);
      if (!is_null($oEquipment)) {
         return $oEquipment->name;      
      }  
      return FString::STRING_EMPTY;
   }
   
   public static function getEquipments($nIdRegion = null, $sImage = null, $sSceneImage = null, $sAttachment = null, $bShowOthers = false) {
      $oCriteria = new CDbCriteria;
            
      if (!FString::isNullOrEmpty($nIdRegion)) {
         $oCriteria->with = array('regionsEquipments');
         $oCriteria->compare('id_region', $nIdRegion);   
         $oCriteria->together = true; 
      }
      
      if (!FString::isNullOrEmpty($sImage)) $oCriteria->compare('t.image', $sImage);

      if (!FString::isNullOrEmpty($sSceneImage)) $oCriteria->compare('t.scene_image', $sSceneImage); 

      if (!FString::isNullOrEmpty($sAttachment)) $oCriteria->compare('t.attachment', $sAttachment); 
      
      $oCActiveDataProvider = new CActiveDataProvider('Equipments', array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'t.name ASC',
         ), 
         'pagination'=>false,
      ));
      
      if (($bShowOthers) && (count($oCActiveDataProvider->getData()) > 0)) {
         $oEquipment = new Equipments();
         $oEquipment->id = FApplication::EQUIPMENT_OTHERS;
         $oEquipment->name = Yii::t('system', 'SYS_OTHERS_M');
         
         $oCActiveDataProvider->setData(array_merge($oCActiveDataProvider->getData(), array($oEquipment)));
      }
      
      return $oCActiveDataProvider->getData();
   }
   
   public static function getFullEquipments() {
      $oEquipments = Equipments::model()->findAll();

      foreach ($oEquipments as $oEquipment) {
         $oEquipment->name = Equipments::getFullEquipment($oEquipment->id);
      }
      return $oEquipments;   
   }
   
   public static function getFullEquipment($nIdEquipment) {
      $oEquipment = Equipments::getEquipment($nIdEquipment);
      $sName = FString::STRING_EMPTY;
      if (!is_null($oEquipment)) {
         $sName = $oEquipment->name;
         $oRegionsEquipments = RegionsEquipments::getRegionsEquipmentsByIdEquipment($nIdEquipment);
         $bFirstRegion = true;
         foreach ($oRegionsEquipments as $oRegionsEquipment) {
            $oRegion = Regions::getRegion($oRegionsEquipment->id_region);
            if (!is_null($oRegion)) {
               if ($bFirstRegion) {
                  $sName = Regions::getFullRegion($oRegion->id) . '/' . $sName;   
               }
               else {
                  $sName = Regions::getFullRegion($oRegion->id) . '-' . $sName;    
               }
               $bFirstRegion = false;
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