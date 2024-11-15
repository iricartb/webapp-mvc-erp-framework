<?php

/**
 * This is the model class for table "maintenance_forms_tasks".
 *
 * The followings are the available columns in table 'forms_tasks':
 * @property integer $id
 * @property string $name
 * @property string $task
 * @property string $type_task
 * @property string $owner
 * @property string $priority
 * @property integer $priority_number
 * @property integer $working_part
 * @property integer $working_part_number
 * @property string $working_part_owner
 * @property integer $id_warehouse_form_output
 * @property integer $id_zone
 * @property string $zone
 * @property integer $id_region
 * @property string $region
 * @property integer $id_equipment
 * @property string $equipment
 * @property string $failure_reason
 * @property string $failure_solution
 * @property string $comments
 * @property string $status
 * @property string $start_date
 * @property string $execution_date
 * @property string $end_date
 * @property string $attachment
 * @property integer $id_user
 * @property integer $id_scheduled_task
 * @property integer $admin
 * @property integer $data_completed
 * 
 * The followings are the available model relations:
 * @property MaintenanceFormTaskComponents[] $formTaskComponents
 * @property MaintenanceFormTaskDepartments[] $formTaskDepartments
 */
class MaintenanceFormsTasks extends CExportedActiveRecord {
   public $sFilterStatusPending;
   public $sFilterStatusRunning;
   public $sFilterStatusFinalized;
   public $sComponents;
   public $sDepartments;
   public $sSupplies;
   public $sEmployees;
   public $sWorkingPartPost;
   public $sWorkingPartNumberPost;
   public $bAlarm;
   
   /**
    * Returns the static model of the specified AR class.
    * @param string $className active record class name.
    * @return FormsWorkingParts the static model class
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
      return 'maintenance_forms_tasks';
   }
   
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('task', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('type_task', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('owner', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('priority', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('priority_number', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_zone', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('zone', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_region', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('region', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_equipment', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('status', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('start_date', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_user', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('working_part_number', 'length', 'max'=>20),
         array('failure_reason', 'length', 'min'=>3, 'max'=>255, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('failure_solution', 'length', 'min'=>3, 'max'=>255, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('comments', 'length', 'min'=>3, 'max'=>512, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('equipment', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('name', 'length', 'min'=>3, 'max'=>50, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('task', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3')), 'tooLong'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_LONG', array('{1}'=>'128'))),
         array('attachment', 'length', 'max'=>255),
         
         array('data_completed, admin', 'boolean'),
          
         array('equipment', 'YiiConditionalValidator',
            'if'=>array(
               array('id_equipment', 'compare', 'compareValue'=>FApplication::EQUIPMENT_OTHERS),
            ),
            'then'=>array(
               array('equipment', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
          
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, task, type_task, owner, priority, priority_number, working_part_number, id_zone, zone, id_region, region, id_equipment, equipment, failure_reason, failure_solution, comments, status, start_date, execution_date, end_date, id_user, id_scheduled_task, data_completed', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
   public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'components'=>array(self::HAS_MANY, 'MaintenanceFormTaskComponents', 'id_form_task'),
			'departments'=>array(self::HAS_MANY, 'MaintenanceFormTaskDepartments', 'id_form_task'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),            
			'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_NAME'),
			'task'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_TASK'),
         'type_task'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_TYPETASK'),
			'owner'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_OWNER'),
			'priority'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_PRIORITY'),
			'priority_number'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_PRIORITYNUMBER'),
         'working_part'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_WORKINGPART'),
         'working_part_number'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_WORKINGPARTNUMBER'),
         'working_part_owner'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_WORKINGPARTOWNER'),
			'id_zone'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_IDZONE'),
			'zone'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_ZONE'),
			'id_region'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_IDREGION'),
			'region'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_REGION'),
			'id_equipment'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_IDEQUIPMENT'),
			'equipment'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_EQUIPMENT'),
			'failure_reason'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_FAILUREREASON'),
			'failure_solution'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_FAILURESOLUTION'),
			'comments'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_COMMENTS'),
			'status'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_STATUS'),
			'start_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_STARTDATE'),
         'execution_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_EXECUTIONDATE'),
			'end_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_ENDDATE'),
			'attachment'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_ATTACHMENT'),
         'id_user'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_IDUSER'),
			'id_scheduled_task'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_IDSCHEDULEDTASK'),
         'sComponents'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_COMPONENTS'),
         'sDepartments'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_DEPARTMENTS'),
         'sSupplies'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_SUPPLIES'),
         'sEmployees'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_EMPLOYEES'),
         'bAlarm'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEFORMSTASKS_FIELD_ALARM'),
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
	public function search($sFilterStatusPending = null, $sFilterStatusRunning = null, $sFilterStatusFinalized = null) {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('id', $this->id);
		$oCriteria->compare('name', $this->name, true);
		$oCriteria->compare('task', $this->task, true);
      $oCriteria->compare('type_task', $this->type_task, true);
		$oCriteria->compare('owner', $this->owner, true);
		$oCriteria->compare('priority', $this->priority, true);
		$oCriteria->compare('priority_number', $this->priority_number);
      $oCriteria->compare('working_part_number', $this->working_part_number, true);
		$oCriteria->compare('id_zone', $this->id_zone);
		$oCriteria->compare('zone', $this->zone, true);
		$oCriteria->compare('id_region', $this->id_region);
		$oCriteria->compare('region', $this->region, true);
		$oCriteria->compare('id_equipment', $this->id_equipment);
		$oCriteria->compare('equipment', $this->equipment, true);
		$oCriteria->compare('failure_reason', $this->failure_reason, true);
		$oCriteria->compare('failure_solution', $this->failure_solution, true);
		$oCriteria->compare('comments', $this->comments, true);
		$oCriteria->compare('status', $this->status, true);
      $oCriteria->compare('start_date', FDate::getEnglishDate($this->start_date), true);
      $oCriteria->compare('execution_date', FDate::getEnglishDate($this->execution_date), true);      
		$oCriteria->compare('end_date', $this->end_date, true);
		$oCriteria->compare('id_user', $this->id_user);
		$oCriteria->compare('id_scheduled_task', $this->id_scheduled_task);
      $oCriteria->compare('data_completed', true);
      
      $sStatusCondition = FString::STRING_EMPTY;
      if ((!is_null($this->sFilterStatusPending))  || (!is_null($this->sFilterStatusRunning)) || (!is_null($this->sFilterStatusFinalized)) || (!is_null($sFilterStatusPending)) || (!is_null($sFilterStatusRunning)) || (!is_null($sFilterStatusFinalized))) {
         if (((!is_null($this->sFilterStatusPending)) && ($this->sFilterStatusPending)) || ((!is_null($sFilterStatusPending)) && ($sFilterStatusPending))) $sStatusCondition = '(status = \'' . FModulePlantMaintenanceManagement::STATUS_PENDING . '\'';
         if (((!is_null($this->sFilterStatusRunning)) && ($this->sFilterStatusRunning)) || ((!is_null($sFilterStatusRunning)) && ($sFilterStatusRunning))) {
            if (strlen($sStatusCondition) > 0) $sStatusCondition .= ' OR status = \'' . FModulePlantMaintenanceManagement::STATUS_RUNNING . '\''; 
            else $sStatusCondition = 'status = \'' . FModulePlantMaintenanceManagement::STATUS_RUNNING . '\'';
         }
         if (((!is_null($this->sFilterStatusFinalized)) && ($this->sFilterStatusFinalized)) || ((!is_null($sFilterStatusFinalized)) && ($sFilterStatusFinalized))) {
            if (strlen($sStatusCondition) > 0) $sStatusCondition .= ' OR status = \'' . FModulePlantMaintenanceManagement::STATUS_FINALIZED . '\''; 
            else $sStatusCondition = 'status = \'' . FModulePlantMaintenanceManagement::STATUS_FINALIZED . '\'';
         }
         
         $sStatusCondition .= ')';
      }
      
      if (!Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) {  
         $oCriteria->with = array('departments');
         $oCriteria->together = true; 
                    
         $oEmployee = Users::getEmployeeByIdUser(Yii::app()->user->id);
         if (!is_null($oEmployee)) {
            $oEmployeeDepartments = EmployeesDepartments::getEmployeesDepartmentsByEmployeeIdentification($oEmployee->identification);
            
            if (count($oEmployeeDepartments) > 0) {
               if (strlen($sStatusCondition) > 0) $sStatusCondition .= ' AND '; 
                    
               foreach($oEmployeeDepartments as $oEmployeeDepartment) {
                  if (strlen($sStatusConditionDepartments) > 0) {
                     $sStatusConditionDepartments .= ' OR departments.name = \'' . $oEmployeeDepartment->department . '\'';    
                  }
                  else {
                     $sStatusConditionDepartments = '(departments.name = \'' . $oEmployeeDepartment->department . '\'';    
                  }
               }
               
               $sStatusConditionDepartments .= ')';
               
               if (strlen($sStatusCondition) > 0) $sStatusCondition .= $sStatusConditionDepartments; 
               else $sStatusCondition = $sStatusConditionDepartments;
            }
            else $oCriteria->addCondition('false');    
         }
         else $oCriteria->addCondition('false');   
      }
      
      if ($sStatusCondition != FString::STRING_EMPTY) $oCriteria->addCondition($sStatusCondition);
      else $oCriteria->addCondition('false');
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'priority_number DESC, start_date DESC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getMaintenanceFormTask($nId) {
      $oMaintenanceFormTask = MaintenanceFormsTasks::model()->findByPk($nId);
      
      return $oMaintenanceFormTask;
   }
   
   public static function getMaintenanceFormTaskResume($nId) {
      $oMaintenanceFormTask = MaintenanceFormsTasks::model()->findByPk($nId);
      $sResumeDescription = FString::STRING_EMPTY;
      
      if (!is_null($oMaintenanceFormTask)) {
         $sResumeDescription = $oMaintenanceFormTask->owner . ':' . FString::STRING_SPACE . $oMaintenanceFormTask->name; 
      }
      
      return $sResumeDescription;
   }
   
   public static function getMaintenanceFormsTasks($bDataCompleted = null, $nIdUser = null, $sAttachment = null) {
      if ((is_null($bDataCompleted)) && (is_null($nIdUser)) && (FString::isNullOrEmpty($sAttachment))) $sSentence = 'true ORDER BY priority_number DESC, start_date DESC';
      else $sSentence = 'ORDER BY priority_number DESC, start_date DESC';
      $bCondition = false;
               
      if (!is_null($bDataCompleted)) { 
         if ($bDataCompleted) $sSentence = 'data_completed = 1' . FString::STRING_SPACE . $sSentence;
         else $sSentence = 'data_completed = 0' . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!is_null($nIdUser)) {
         if ($bCondition) $sSentence = 'id_user = ' . $nIdUser . ' AND ' . $sSentence;
         else $sSentence = 'id_user = ' . $nIdUser . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!FString::isNullOrEmpty($sAttachment)) {
         if ($bCondition) $sSentence = 'attachment = \'' . $sAttachment . '\'' . ' AND ' . $sSentence;
         else $sSentence = 'attachment = \'' . $sAttachment . '\'' . FString::STRING_SPACE . $sSentence;
      }  
       
      return MaintenanceFormsTasks::model()->findAll($sSentence);        
   }
   
   public static function getComponentsDescription($nId) {
      $oMaintenanceFormTask = MaintenanceFormsTasks::model()->findByPk($nId);
      $sComponentsDescription = FString::STRING_EMPTY;
      
      if (!is_null($oMaintenanceFormTask)) { 
         $oMaintenanceFormTaskComponents = MaintenanceFormTaskComponents::getMaintenanceFormTaskComponentsByIdFormFK($oMaintenanceFormTask->id);
         foreach($oMaintenanceFormTaskComponents as $oMaintenanceFormTaskComponent) {
            $oComponent = Components::getComponent($oMaintenanceFormTaskComponent->id_component);
            if (!is_null($oComponent)) {
               if (strlen($sComponentsDescription) > 0) $sComponentsDescription .= ', ' . $oComponent->name;
               else $sComponentsDescription = $oComponent->name; 
            }      
         }
      }
      return $sComponentsDescription; 
   }
   
   public static function getDepartmentsDescription($nId) {
      $oMaintenanceFormTask = MaintenanceFormsTasks::model()->findByPk($nId);
      $sDepartmentsDescription = FString::STRING_EMPTY;
      
      if (!is_null($oMaintenanceFormTask)) { 
         $oMaintenanceFormTaskDepartments = MaintenanceFormTaskDepartments::getMaintenanceFormTaskDepartmentsByIdFormFK($oMaintenanceFormTask->id);
         foreach($oMaintenanceFormTaskDepartments as $oMaintenanceFormTaskDepartment) {
            if (strlen($sDepartmentsDescription) > 0) $sDepartmentsDescription .= ', ' . Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oMaintenanceFormTaskDepartment->name);
            else $sDepartmentsDescription = Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oMaintenanceFormTaskDepartment->name);      
         }
      }
      return $sDepartmentsDescription; 
   }
   
   public static function getSuppliesDescription($nId) {
      $oMaintenanceFormTask = MaintenanceFormsTasks::model()->findByPk($nId);
      $sSuppliesDescription = FString::STRING_EMPTY;
      
      if (!is_null($oMaintenanceFormTask)) { 
         $oMaintenanceFormTaskSupplies = MaintenanceFormTaskSupplies::getMaintenanceFormTaskSuppliesByIdFormFK($oMaintenanceFormTask->id);
         foreach($oMaintenanceFormTaskSupplies as $oMaintenanceFormTaskSupply) {
            if (strlen($sSuppliesDescription) > 0) $sSuppliesDescription .= ', ' . $oMaintenanceFormTaskSupply->quantity . strtolower(Yii::t('system', 'SYS_UNITS_ABBREVIATION')) . FString::STRING_SPACE . $oMaintenanceFormTaskSupply->supply;
            else $sSuppliesDescription = $oMaintenanceFormTaskSupply->quantity . strtolower(Yii::t('system', 'SYS_UNITS_ABBREVIATION')) . FString::STRING_SPACE . $oMaintenanceFormTaskSupply->supply;     
         }
      }
      return $sSuppliesDescription; 
   }
   
   public static function getEmployeesDescription($nId) {
      $oMaintenanceFormTask = MaintenanceFormsTasks::model()->findByPk($nId);
      $sEmployeesDescription = FString::STRING_EMPTY;
      
      if (!is_null($oMaintenanceFormTask)) { 
         $oMaintenanceFormTaskEmployees = MaintenanceFormTaskEmployees::getMaintenanceFormTaskEmployeesByIdFormFK($oMaintenanceFormTask->id);
         foreach($oMaintenanceFormTaskEmployees as $oMaintenanceFormTaskEmployee) {
            if (strlen($sEmployeesDescription) > 0) $sEmployeesDescription .= ', ' . $oMaintenanceFormTaskEmployee->name;
            else $sEmployeesDescription = $oMaintenanceFormTaskEmployee->name;     
         }
      }
      return $sEmployeesDescription; 
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('sEmployees', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, '?', 'MaintenanceFormsTasks::getEmployeesDescription($oArrayData[$i][\'id\'])');
      $this->oExportSpecifications['data'][1] = array('type_task', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Yii::t(\'frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '\', \'MODEL_MAINTENANCEFORMSTASKS_FIELD_TYPETASK_VALUE_?\')', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][2] = array('working_part', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Yii::t(\'frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '\', \'MODEL_MAINTENANCEFORMSTASKS_FIELD_WORKINGPART_VALUE_?\')', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][3] = array('start_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][4] = array('execution_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][5] = array('end_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][6] = array('sDepartments', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, '?', 'MaintenanceFormsTasks::getDepartmentsDescription($oArrayData[$i][\'id\'])');
      $this->oExportSpecifications['data'][7] = array('id_zone', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Zones::getZoneName(?)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][8] = array('id_region', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Regions::getRegionName(?)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][9] = array('id_equipment', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Equipments::getEquipmentName(?)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][10] = array('sComponents', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, '?', 'MaintenanceFormsTasks::getComponentsDescription($oArrayData[$i][\'id\'])');
      $this->oExportSpecifications['data'][11] = array('sSupplies', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, '?', 'MaintenanceFormsTasks::getSuppliesDescription($oArrayData[$i][\'id\'])');
      $this->oExportSpecifications['data'][12] = array('status', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Yii::t(\'frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '\', \'MODEL_MAINTENANCEFORMSTASKS_FIELD_STATUS_VALUE_?\')', 'FString::STRING_EMPTY');
      
      
      $this->oExportSpecifications['columns'] = array('id', 'owner', 'name', 'type_task', 'task', 'priority');
      if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) {
         $this->oExportSpecifications['columns'] = array_merge($this->oExportSpecifications['columns'], array('working_part', 'working_part_number', 'working_part_owner'));   
      }
      $this->oExportSpecifications['columns'] = array_merge($this->oExportSpecifications['columns'], array('sEmployees', 'start_date', 'execution_date', 'end_date', 'sDepartments', 'id_zone', 'id_region', 'id_equipment', 'sComponents'));
      if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_WAREHOUSE_MANAGEMENT)) {
         $this->oExportSpecifications['columns'] = array_merge($this->oExportSpecifications['columns'], array('sSupplies'));   
      }
      $this->oExportSpecifications['columns'] = array_merge($this->oExportSpecifications['columns'], array('failure_reason', 'failure_solution', 'comments', 'status'));
      
      return $this->oExportSpecifications; 
   }
}
