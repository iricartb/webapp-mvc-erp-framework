<?php

/**
 * This is the model class for table "maintenance_form_task_supplies".
 *
 * The followings are the available columns in table 'maintenance_form_task_supplies':
 * @property integer $id
 * @property string $id_supply
 * @property string $supply
 * @property string $supply_code
 * @property string $quantity
 * @property integer $id_form_task
 *
 * The followings are the available model relations:
 * @property MaintenanceFormsWorkingParts $idFormTask
 */
class MaintenanceFormTaskSupplies extends CActiveRecord {
   public $nIdSubcategory;
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return FormWorkingPartSupplies the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
   /**
    * @return CDbConnection the database connection used for this class
    */
   public function getDbConnection() {
      return Yii::app()->db_rainbow_plantmaintenancemanagement;
   }
   
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'maintenance_form_task_supplies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('id_supply', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('nIdSubcategory', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('supply', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('supply_code', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('quantity', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_task', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('supply', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('supply_code', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('quantity', 'numerical', 'min'=>1, 'max'=>999999, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>1)), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>999999))),

         array('id_supply', 'UniqueAttributesValidator', 'with'=>'id_form_task', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
   
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
         array('supply, id_form_task', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'formTask'=>array(self::BELONGS_TO, 'MaintenanceFormsTasks', 'id_form_task'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
         'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),   
         'id_supply'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMTASKSUPPLIES_FIELD_IDSUPPLY'),
         'supply'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMTASKSUPPLIES_FIELD_SUPPLY'),
         'quantity'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMTASKSUPPLIES_FIELD_QUANTITY'),
         'nIdSubcategory'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMTASKSUPPLIES_FIELD_IDSUBCATEGORY'),
         'id_form_task'=>Yii::t('system', 'SYS_MODEL_FIELD_FK'),
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
	public function search($nIdFormFK = null) {
      // Warning: Please modify the following code to remove attributes that
      // should not be searched.

      $oCriteria = new CDbCriteria;

      $oCriteria->compare('supply', $this->supply, true);
      if (!is_null($nIdFormFK)) $oCriteria->compare('id_form_task', $nIdFormFK);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'supply ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
   }
   
   public static function getMaintenanceFormTaskSupply($nId) {
      $oMaintenanceFormTaskSupply = MaintenanceFormTaskSupplies::model()->findByPk($nId);
      
      return $oMaintenanceFormTaskSupply;
   }
   
   public static function getMaintenanceFormTaskSuppliesByIdFormFK($nIdFormFK) {
      return MaintenanceFormTaskSupplies::model()->findAll('id_form_task = ' . $nIdFormFK);   
   }
}
