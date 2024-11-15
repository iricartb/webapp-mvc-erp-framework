<?php

/**
 * This is the model class for table "maintenance_scheduled_tasks_departments".
 *
 * The followings are the available columns in table 'maintenance_scheduled_tasks_departments':
 * @property integer $id
 * @property integer $name
 * @property integer $id_scheduled_task
 *
 * The followings are the available model relations:
 * @property Components $name
 * @property MaintenanceScheduledTasks $idScheduledTask
 */
class MaintenanceScheduledTasksDepartments extends CActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return MaintenanceScheduledTasksComponents the static model class
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
		return 'maintenance_scheduled_tasks_departments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_scheduled_task', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('name', 'UniqueAttributesValidator', 'with'=>'id_scheduled_task', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
   
   
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, id_scheduled_task', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'scheduledTask'=>array(self::BELONGS_TO, 'MaintenanceScheduledTasks', 'id_scheduled_task'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),   
			'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKSDEPARTMENTS_FIELD_NAME'),
			'id_scheduled_task'=>Yii::t('system', 'SYS_MODEL_FIELD_FK'),
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

		$oCriteria->compare('name', $this->name);
      if (!is_null($nIdFormFK)) $oCriteria->compare('id_scheduled_task', $nIdFormFK);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'id ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}

   public static function getMaintenanceScheduledTaskDepartment($nId) {
      $oMaintenanceScheduledTaskDepartment = MaintenanceScheduledTasksDepartments::model()->findByPk($nId);
      
      return $oMaintenanceScheduledTaskDepartment;
   }
   
   public static function getMaintenanceScheduledTaskDepartmentsByIdFormFK($nIdFormFK) {
      return MaintenanceScheduledTasksDepartments::model()->findAll('id_scheduled_task = ' . $nIdFormFK);   
   }
   
   public static function getMaintenanceScheduledTaskComponentByDepartmentAndIdFormFK($sDepartment, $nIdFormFK) {
      return MaintenanceScheduledTasksDepartments::model()->find('name = \'' . $sDepartment . '\' AND id_scheduled_task = ' . $nIdFormFK);   
   }
}
