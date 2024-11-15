<?php

/**
 * This is the model class for table "components".
 *
 * The followings are the available columns in table 'components':
 * @property integer $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property EquipmentsComponents[] $equipmentsComponents
 */
class Components extends CExportedActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return Components the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'components';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('name', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
         'equipmentsComponents'=>array(self::HAS_MANY, 'EquipmentsComponents', 'id_component'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
         'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),
         'name'=>Yii::t('rainbow', 'MODEL_COMPONENTS_FIELD_NAME'),
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

		$oCriteria->compare('name', $this->name, true);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}
   
   public static function getComponent($nId) {
      $oComponent = Components::model()->findByPk($nId);
      
      return $oComponent;
   }
   
   public static function getComponentName($nId) {
      $oComponent = Components::getComponent($nId);
      if (!is_null($oComponent)) {
         return $oComponent->name;      
      }  
      return FString::STRING_EMPTY;
   }
   
   public static function getComponents($nIdEquipment = null) {
      $oCriteria = new CDbCriteria;
            
      if (!FString::isNullOrEmpty($nIdEquipment)) {
         $oCriteria->with = array('equipmentsComponents');
         $oCriteria->compare('id_equipment', $nIdEquipment);   
         $oCriteria->together = true; 
      }

      $oCActiveDataProvider = new CActiveDataProvider('Components', array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'t.name ASC',
         ), 
         'pagination'=>false,
      ));
      
      return $oCActiveDataProvider->getData();   
   }
   
   public static function getFullComponents() {
      $oComponents = Components::model()->findAll();
      
      foreach ($oComponents as $oComponent) {
         $oComponent->name = Components::getFullComponent($oComponent->id);
      }
      return $oComponents;   
   }
   
   public static function getFullComponent($nIdComponent) {
      $oComponent = Components::getComponent($nIdComponent);
      $sName = FString::STRING_EMPTY;
      if (!is_null($oComponent)) {
         $sName = $oComponent->name;
         $oEquipmentsComponents = EquipmentsComponents::getEquipmentsComponentsByIdComponent($nIdComponent);
         $bFirstEquipment = true;
         foreach ($oEquipmentsComponents as $oEquipmentComponent) {
            $oEquipment = Equipments::getEquipment($oEquipmentComponent->id_equipment);
            if (!is_null($oEquipment)) {
               if ($bFirstEquipment) {
                  $sName = Equipments::getFullEquipment($oEquipment->id) . '/' . $sName;   
               }
               else {
                  $sName = Equipments::getFullEquipment($oEquipment->id) . '-' . $sName;    
               }
               $bFirstEquipment = false;
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
