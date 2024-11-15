<?php

/**
 * This is the model class for table "maintenance_form_task_departments".
 *
 * The followings are the available columns in table 'form_task_departments':
 * @property integer $id
 * @property string $name
 * @property integer $id_form_task
 *
 * The followings are the available model relations:
 * @property MaintenanceFormsTasks $idFormTask
 */
class MaintenanceFormTaskDepartments extends CActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return FormTaskDepartments the static model class
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
		return 'maintenance_form_task_departments';
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
         
         array('name', 'UniqueAttributesValidator', 'with'=>'id_form_task', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
   
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
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
			'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMTASKDEPARTMENTS_FIELD_NAME'),
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$oCriteria = new CDbCriteria;
      
      $oCriteria->compare('name', $this->name, true);
      if (!is_null($nIdFormFK)) $oCriteria->compare('id_form_task', $nIdFormFK);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getMaintenanceFormTaskDepartment($nId) {
      $oMaintenanceFormTaskDepartment = MaintenanceFormTaskDepartments::model()->findByPk($nId);
      
      return $oMaintenanceFormTaskDepartment;
   }
   
   public static function getMaintenanceFormTaskDepartmentsByIdFormFK($nIdFormFK) {
      return MaintenanceFormTaskDepartments::model()->findAll('id_form_task = ' . $nIdFormFK);   
   }
}
