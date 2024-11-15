<?php

/**
 * This is the model class for table "dropzone_zones".
 *
 * The followings are the available columns in table 'dropzone_zones':
 */
class DropzoneZones extends CDropzoneActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DropzoneZones the static model class
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
         array('description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('description', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('scene_image', 'length', 'max'=>255),
         
         array('description', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
         array('scene_show', 'boolean'),
         
         // The following rule is used by search().
         // Please remove those attributes that should not be searched.
         array('id, description, module, scene_show, scene_coord_x, scene_coord_y, scene_image', 'safe', 'on'=>'search'),
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
         'description'=>Yii::t('rainbow', 'MODEL_ZONES_FIELD_DESCRIPTION'),
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

      $oCriteria->compare('description', $this->description, true);
      $oCriteria->compare('module', $this->module, true);
      $oCriteria->compare('scene_show', $this->scene_show);
      $oCriteria->compare('scene_coord_x', $this->scene_coord_x, true);
      $oCriteria->compare('scene_coord_y', $this->scene_coord_y, true);
      $oCriteria->compare('scene_image', $this->scene_image, true);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'description ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
   }

   /* Dropzone methods */
   public function isDropzoneAllowAccessRule() {
      return ((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) && (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)));   
   }
   
   public function getDropzoneSpecifications($sId) {
      $this->oDropzoneElements['field_pk'] = 'id';
      $this->oDropzoneElements['field_document'] = 'scene_image';
      $this->oDropzoneElements['path_documents'] = FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'zones/';
      $this->oDropzoneElements['elements'] = DropzoneZones::model()->findAll('id = ' . $sId);
      
      return $this->oDropzoneElements; 
   }
   
   public function getDropzoneImageOutputFormat() {
      $this->oDropzoneElements['file_image_output_extension'] = FFile::getExtensionFromFileType(FFile::FILE_PNG_TYPE);
      
      return $this->oDropzoneElements;
   }
   
   public function changeDropzoneImageElements($sIdSource, $sIdDestiny) { }
   
   public function deleteDropzoneImageElement($sId) {
      $oZone = Zones::getZone($sId);
      
      if (!is_null($oZone)) {
         if ((!FString::isNullOrEmpty($oZone->scene_image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'zones/' . $oZone->scene_image))) {
            $oZones = Zones::model()->findAll('scene_image = \'' . $oZone->scene_image . '\'');
            if (count($oZones) == 1) unlink(FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'zones/' . $oZone->scene_image);
         }
         
         $oZone->scene_image = null;
         $oZone->scene_coord_x = 0;
         $oZone->scene_coord_y = 0;
         $oZone->save();
      }    
   }
   
   public function uploadDropzoneImageElement($sFilename, $sId) {
      if (strlen($sId) > 0) {
         $oZone = Zones::getZone($sId);
         
         if (!is_null($oZone)) {
            if ((!FString::isNullOrEmpty($oZone->scene_image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'zones/' . $oZone->scene_image))) {
               $oZones = Zones::model()->findAll('scene_image = \'' . $oZone->scene_image . '\'');
               if (count($oZones) == 0) unlink(FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'zones/' . $oZone->scene_image);
            }
         
            $oZone->scene_image = $sFilename;
            $oZone->save();   
         }   
      }
   }
}