<?php

/**
 * This is the model class for table "maintenance_form_task_components".
 *
 * The followings are the available columns in table 'maintenance_form_task_components':
 * @property integer $id
 * @property string $component
 * @property string $id_component
 * @property integer $id_form_task
 *
 * The followings are the available model relations:
 * @property MaintenanceFormsWorkingParts $idFormTask
 */
class MaintenanceFormTaskComponents extends CActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return FormWorkingPartComponents the static model class
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
		return 'maintenance_form_task_components';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('id_component', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('component', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_task', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('component', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('id_component', 'UniqueAttributesValidator', 'with'=>'id_form_task', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
   
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
         array('component, id_form_task', 'safe', 'on'=>'search'),
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
         'id_component'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMTASKCOMPONENTS_FIELD_IDCOMPONENT'),
         'component'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMTASKCOMPONENTS_FIELD_COMPONENT'),
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

      $oCriteria->compare('component', $this->component, true);
      if (!is_null($nIdFormFK)) $oCriteria->compare('id_form_task', $nIdFormFK);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'component ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
   }
   
   public static function getMaintenanceFormTaskComponent($nId) {
      $oMaintenanceFormTaskComponent = MaintenanceFormTaskComponents::model()->findByPk($nId);
      
      return $oMaintenanceFormTaskComponent;
   }
   
   public static function getMaintenanceFormTaskComponentsByIdFormFK($nIdFormFK) {
      return MaintenanceFormTaskComponents::model()->findAll('id_form_task = ' . $nIdFormFK);   
   }
}
