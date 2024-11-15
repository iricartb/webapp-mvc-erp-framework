<?php

/**
 * This is the model class for table "maintenance_scheduled_tasks".
 *
 * The followings are the available columns in table 'maintenance_scheduled_tasks':
 * @property integer $id
 * @property string $name
 * @property string $owner
 * @property string $priority
 * @property integer $priority_number
 * @property string $execution_date
 * @property integer $id_zone
 * @property integer $id_region
 * @property integer $id_equipment
 * @property string $task
 * @property string $type_task
 * @property integer $repeat_minutes
 * @property integer $repeat_hours
 * @property integer $repeat_days
 * @property integer $repeat_months
 * @property integer $repeat_years
 * @property integer $admin
 * @property string $attachment
 * @property integer $id_user
 *
 * The followings are the available model relations:
 * @property Regions $idRegion
 * @property Equipments $idEquipment
 */
class MaintenanceScheduledTasks extends CExportedActiveRecord {
   public $sPeriodicity;
   public $sComponents;
   public $sDepartments;
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return MaintenanceScheduledTasks the static model class
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
		return 'maintenance_scheduled_tasks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('owner', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('priority', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('priority_number', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_zone', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_region', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_equipment', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('execution_date', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('task', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('type_task', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_user', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
			array('id_zone, id_region, id_equipment, repeat_minutes, repeat_hours, repeat_days, repeat_months, repeat_years, id_user', 'numerical', 'integerOnly'=>true),
         
         array('name', 'length', 'min'=>3, 'max'=>50, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('task', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3')), 'tooLong'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_LONG', array('{1}'=>'128'))),
         array('attachment', 'length', 'max'=>255),
         
         array('alarm', 'boolean'),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, owner, priority, execution_date, id_zone, id_region, id_equipment, task, type_task, repeat_minutes, repeat_hours, repeat_days, repeat_months, repeat_years, id_user', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
         'zone'=>array(self::BELONGS_TO, 'Zones', 'id_zone'),
         'region'=>array(self::BELONGS_TO, 'Regions', 'id_region'),
         'equipment'=>array(self::BELONGS_TO, 'Equipments', 'id_equipment'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
         'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),
         'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_NAME'),
         'owner'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_OWNER'),
         'priority'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_PRIORITY'),
         'priority_number'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_PRIORITYNUMBER'),
         'execution_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_EXECUTIONDATE'),
         'sPeriodicity'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_PERIODICITY'),
         'id_zone'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_IDZONE'),
         'id_region'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_IDREGION'),
         'id_equipment'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_IDEQUIPMENT'),
         'task'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_TASK'),
         'type_task'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_TYPETASK'),
         'repeat_minutes'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_REPEATMINUTES'),
         'repeat_hours'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_REPEATHOURS'),
         'repeat_days'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_REPEATDAYS'),
         'repeat_months'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_REPEATMONTHS'),
         'repeat_years'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_REPEATYEARS'),
         'last_creation_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_LASTCREATIONDATE'),
         'alarm'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_ALARM'),
         'attachment'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_ATTACHMENT'),
         'id_user'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_IDUSER'),
         'sComponents'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_COMPONENTS'),
         'sDepartments'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_DEPARTMENTS'),
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

		$oCriteria->compare('id', $this->id);
      $oCriteria->compare('name', $this->name, true);
		$oCriteria->compare('owner', $this->owner, true);
      $oCriteria->compare('priority', $this->priority, true);
      $oCriteria->compare('id_zone', $this->id_zone);
		$oCriteria->compare('id_region', $this->id_region);
		$oCriteria->compare('id_equipment', $this->id_equipment);
		$oCriteria->compare('task', $this->task, true);
      $oCriteria->compare('type_task', $this->type_task, true);
		$oCriteria->compare('repeat_minutes', $this->repeat_minutes);
		$oCriteria->compare('repeat_hours', $this->repeat_hours);
		$oCriteria->compare('repeat_days', $this->repeat_days);
		$oCriteria->compare('repeat_months', $this->repeat_months);
		$oCriteria->compare('repeat_years', $this->repeat_years);
		$oCriteria->compare('id_user', $this->id_user);
      $oCriteria->compare('execution_date', FDate::getEnglishDate($this->execution_date), true);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'id DESC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getMaintenanceScheduledTasks($sAttachment = null) {
      if (FString::isNullOrEmpty($sAttachment)) $sSentence = 'true ORDER BY id DESC';
      else $sSentence = 'ORDER BY id DESC';
      
      if (!FString::isNullOrEmpty($sAttachment)) {
         $sSentence = 'attachment = \'' . $sAttachment . '\' ' . $sSentence;
      }  
      
      return MaintenanceScheduledTasks::model()->findAll($sSentence);
   }
   
   public static function getMaintenanceScheduledTask($nId) {
      $oMaintenanceScheduledTask = MaintenanceScheduledTasks::model()->findByPk($nId);

      return $oMaintenanceScheduledTask;
   }
   
   public static function getPeriodicityDescription($nId) {
      $oMaintenanceScheduledTask = MaintenanceScheduledTasks::model()->findByPk($nId);
      $sPeriodicityDescription = FString::STRING_EMPTY;
      
      if (!is_null($oMaintenanceScheduledTask)) {
         $sPeriodicityDescription = Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCESCHEDULEDTASKS_PERIODICITY_DESCRIPTION', array('{1}'=>$oMaintenanceScheduledTask->repeat_years, '{2}'=>$oMaintenanceScheduledTask->repeat_months, '{3}'=>$oMaintenanceScheduledTask->repeat_days, '{4}'=>$oMaintenanceScheduledTask->repeat_hours, '{5}'=>$oMaintenanceScheduledTask->repeat_minutes));
         $sPeriodicityDescriptionResult = FString::STRING_EMPTY;
         
         $oParameters = explode(FString::STRING_SPACE, $sPeriodicityDescription);
         $i = 0;
         foreach($oParameters as $sParameter) {
            if (($i % 2) == 0) {
               $bDiscardNextParameter = false;
               $bSingleInformation = false;
               
               if ($sParameter == '0') {
                  $bDiscardNextParameter = true;
               }
               else {
                  if (strlen($sPeriodicityDescriptionResult) > 0) $sPeriodicityDescriptionResult .= FString::STRING_SPACE . $sParameter;  
                  else $sPeriodicityDescriptionResult = $sParameter;
                  
                  if ($sParameter == '1') $bSingleInformation = true;
               }    
            }
            else {
               if (!$bDiscardNextParameter) {
                  if ($bSingleInformation) {
                     $sParameter = FString::getUntilLastStr($sParameter, '/');   
                  }
                  else {
                     $sParameter = str_replace('/', FString::STRING_EMPTY, $sParameter);
                     
                     if (strpos($sParameter, '-') !== false) {
                        $nPos = strpos($sParameter, '-');   
                        
                        $sParameter = substr($sParameter, 0, $nPos - 1) . substr($sParameter, $nPos + 1, strlen($sParameter) - 2); 
                     }
                  }
                  
                  $sPeriodicityDescriptionResult .= FString::STRING_SPACE . $sParameter;   
               }
            }
            
            $i++;
         }
         
         return $sPeriodicityDescriptionResult;               
      }  
      return FString::STRING_EMPTY; 
   }
   
   public static function getComponentsDescription($nId) {
      $oMaintenanceScheduledTask = MaintenanceScheduledTasks::model()->findByPk($nId);
      $sComponentsDescription = FString::STRING_EMPTY;
      
      if (!is_null($oMaintenanceScheduledTask)) { 
         $oMaintenanceScheduledTaskComponents = MaintenanceScheduledTasksComponents::getMaintenanceScheduledTaskComponentsByIdFormFK($oMaintenanceScheduledTask->id);
         foreach($oMaintenanceScheduledTaskComponents as $oMaintenanceScheduledTaskComponent) {
            $oComponent = Components::getComponent($oMaintenanceScheduledTaskComponent->id_component);
            if (!is_null($oComponent)) {
               if (strlen($sComponentsDescription) > 0) $sComponentsDescription .= ', ' . $oComponent->name;
               else $sComponentsDescription = $oComponent->name; 
            }      
         }
      }
      return $sComponentsDescription; 
   }
   
   public static function getDepartmentsDescription($nId) {
      $oMaintenanceScheduledTask = MaintenanceScheduledTasks::model()->findByPk($nId);
      $sDepartmentsDescription = FString::STRING_EMPTY;
      
      if (!is_null($oMaintenanceScheduledTask)) { 
         $oMaintenanceScheduledTaskDepartments = MaintenanceScheduledTasksDepartments::getMaintenanceScheduledTaskDepartmentsByIdFormFK($oMaintenanceScheduledTask->id);
         foreach($oMaintenanceScheduledTaskDepartments as $oMaintenanceScheduledTaskDepartment) {
            if (strlen($sDepartmentsDescription) > 0) $sDepartmentsDescription .= ', ' . Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oMaintenanceScheduledTaskDepartment->name);
            else $sDepartmentsDescription = Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oMaintenanceScheduledTaskDepartment->name);      
         }
      }
      return $sDepartmentsDescription; 
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('execution_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][1] = array('type_task', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Yii::t(\'frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '\', \'MODEL_MAINTENANCESCHEDULEDTASKS_FIELD_TYPETASK_VALUE_?\')', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][2] = array('sDepartments', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, '?', 'MaintenanceScheduledTasks::getDepartmentsDescription($oArrayData[$i][\'id\'])');
      $this->oExportSpecifications['data'][3] = array('sPeriodicity', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, '?', 'MaintenanceScheduledTasks::getPeriodicityDescription($oArrayData[$i][\'id\'])');       
      $this->oExportSpecifications['data'][4] = array('id_zone', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Zones::getZoneName(?)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][5] = array('id_region', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Regions::getRegionName(?)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][6] = array('id_equipment', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Equipments::getEquipmentName(?)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][7] = array('sComponents', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, '?', 'MaintenanceScheduledTasks::getComponentsDescription($oArrayData[$i][\'id\'])');

      $this->oExportSpecifications['columns'] = array('owner', 'name', 'type_task', 'task', 'execution_date', 'priority', 'sDepartments', 'sPeriodicity', 'id_zone', 'id_region', 'id_equipment', 'sComponents');
        
      return $this->oExportSpecifications; 
   }
}
