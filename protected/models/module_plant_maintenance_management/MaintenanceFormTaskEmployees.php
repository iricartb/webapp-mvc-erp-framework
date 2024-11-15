<?php

/**
 * This is the model class for table "maintenance_form_task_employees".
 *
 * The followings are the available columns in table 'maintenance_form_task_employees':
 * @property integer $id
 * @property string $name
 * @property integer $id_form_task
 *
 * The followings are the available model relations:
 * @property MaintenanceFormsTasks $idFormTask
 */
class MaintenanceFormTaskEmployees extends CActiveRecord  {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormTurnEventLines the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection() {
		return Yii::app()->db_rainbow_plantmaintenancemanagement;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'maintenance_form_task_employees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_task', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),  
         
         array('name', 'length', 'min'=>3, 'max'=>38, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),

         array('name', 'match', 'pattern'=>FRegEx::getNamePattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_NAME')),

         array('name', 'filter', 'filter'=>'strtolower'),
         array('name', 'filter', 'filter'=>'ucwords'),
         
         array('name', 'UniqueAttributesValidator', 'with'=>'id_form_task', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
   
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, id_form_task', 'safe', 'on'=>'search'),
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
         'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMTASKEMPLOYEES_FIELD_NAME'),
			'id_form_task'=>Yii::t('system', 'SYS_MODEL_FIELD_FK'),
		);
	}

   /**
    * Retrieves a list of models based on the current search/filter conditions.
    * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
    */
   public function search($nIdFormFK = null) {
      // Warning: Please modify the following code to remove attributes that
      // should not be searched.

      $oCriteria = new CDbCriteria;

      $oCriteria->compare('name', $this->name, true);
      if (!is_null($nIdFormFK)) $oCriteria->compare('id_form_task', $nIdFormFK);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
   }
   
   public static function getMaintenanceFormTaskEmployee($nId) {
      $oMaintenanceFormTaskEmployee = MaintenanceFormTaskEmployees::model()->findByPk($nId);
      
      return $oMaintenanceFormTaskEmployee;
   }
   
   public static function getMaintenanceFormTaskEmployeesByIdFormFK($nIdFormFK) {
      return MaintenanceFormTaskEmployees::model()->findAll('id_form_task = ' . $nIdFormFK . ' ORDER BY name ASC');   
   }
}