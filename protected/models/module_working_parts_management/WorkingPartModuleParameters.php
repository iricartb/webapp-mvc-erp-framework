<?php

/**
 * This is the model class for table "workingpart_module_parameters".
 *
 * The followings are the available columns in table 'workingpart_module_parameters':
 * @property integer $working_part_show_status_created
 * @property integer $working_part_show_status_pending
 * @property integer $working_part_show_status_running
 * @property integer $working_part_show_status_pending_absence
 * @property integer $working_part_show_status_halted
 * @property integer $working_part_show_status_finalized
 * @property integer $maintenance_working_part_show_status_created
 * @property integer $maintenance_working_part_show_status_pending
 * @property integer $maintenance_working_part_show_status_running
 * @property integer $maintenance_working_part_show_status_pending_absence 
 * @property integer $maintenance_working_part_show_status_halted
 * @property integer $maintenance_working_part_show_status_finalized
 * @property integer $special_working_part_show_status_created
 * @property integer $special_working_part_show_status_pending
 * @property integer $special_working_part_show_status_running
 * @property integer $special_working_part_show_status_pending_absence
 * @property integer $special_working_part_show_status_halted
 * @property integer $special_working_part_show_status_finalized
 * @property integer $show_components
 */
class WorkingPartModuleParameters extends CActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModuleParameters the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection() {
		return Yii::app()->db_rainbow_workingpartsmanagement;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'workingpart_module_parameters';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('working_part_show_status_created, working_part_show_status_pending, working_part_show_status_running, working_part_show_status_pending_absence, working_part_show_status_halted, working_part_show_status_finalized, maintenance_working_part_show_status_created, maintenance_working_part_show_status_pending, maintenance_working_part_show_status_running, maintenance_working_part_show_status_pending_absence, maintenance_working_part_show_status_halted, maintenance_working_part_show_status_finalized, special_working_part_show_status_created, special_working_part_show_status_pending, special_working_part_show_status_running, special_working_part_show_status_pending_absence, special_working_part_show_status_halted, special_working_part_show_status_finalized, show_components', 'boolean'),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('show_components', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations(){
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
         'working_part_show_status_created' => 'Working Part Show Status Created',
         'working_part_show_status_pending' => 'Working Part Show Status Pending',
         'working_part_show_status_running' => 'Working Part Show Status Running',
         'working_part_show_status_pending_absence' => 'Working Part Show Status Pending Asbsence',
         'working_part_show_status_halted' => 'Working Part Show Status Halted',
         'working_part_show_status_finalized' => 'Working Part Show Status Finalized',
         'maintenance_working_part_show_status_created' => 'Maintenance Working Part Show Status Created',
         'maintenance_working_part_show_status_pending' => 'Maintenance Working Part Show Status Pending',
         'maintenance_working_part_show_status_running' => 'Maintenance Working Part Show Status Running',
         'maintenance_working_part_show_status_pending_absence' => 'Maintenance Working Part Show Status Pending Asbsence',
         'maintenance_working_part_show_status_halted' => 'Maintenance Working Part Show Status Pending',   
         'maintenance_working_part_show_status_finalized' => 'Maintenance Working Part Show Status Finalized',
         'special_working_part_show_status_created' => 'Special Working Part Show Status Created',
         'special_working_part_show_status_pending' => 'Special Working Part Show Status Pending',
         'special_working_part_show_status_running' => 'Special Working Part Show Status Running',
         'special_working_part_show_status_pending_absence' => 'Special Working Part Show Status Pending Asbsence',
         'special_working_part_show_status_halted' => 'Special Working Part Show Status Pending', 
         'special_working_part_show_status_finalized' => 'Special Working Part Show Status Finalized', 
         'show_components' => 'Show Components',
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

      $oCriteria->compare('working_part_show_status_created', $this->working_part_show_status_created);
      $oCriteria->compare('working_part_show_status_pending', $this->working_part_show_status_pending);
      $oCriteria->compare('working_part_show_status_running', $this->working_part_show_status_running);
      $oCriteria->compare('working_part_show_status_pending_absence', $this->working_part_show_status_pending_absence);
      $oCriteria->compare('working_part_show_status_halted', $this->working_part_show_status_halted);
      $oCriteria->compare('working_part_show_status_finalized', $this->working_part_show_status_finalized);
      $oCriteria->compare('maintenance_working_part_show_status_created', $this->maintenance_working_part_show_status_created);
      $oCriteria->compare('maintenance_working_part_show_status_pending', $this->maintenance_working_part_show_status_pending);
      $oCriteria->compare('maintenance_working_part_show_status_running', $this->maintenance_working_part_show_status_running);
      $oCriteria->compare('maintenance_working_part_show_status_pending_absence', $this->maintenance_working_part_show_status_pending_absence);
      $oCriteria->compare('maintenance_working_part_show_status_halted', $this->maintenance_working_part_show_status_halted);
      $oCriteria->compare('maintenance_working_part_show_status_finalized', $this->maintenance_working_part_show_status_finalized);
      $oCriteria->compare('special_working_part_show_status_created', $this->special_working_part_show_status_created);
      $oCriteria->compare('special_working_part_show_status_pending', $this->special_working_part_show_status_pending);
      $oCriteria->compare('special_working_part_show_status_running', $this->special_working_part_show_status_running);
      $oCriteria->compare('special_working_part_show_status_pending_absence', $this->special_working_part_show_status_pending_absence);
      $oCriteria->compare('special_working_part_show_status_halted', $this->special_working_part_show_status_halted);
      $oCriteria->compare('special_working_part_show_status_finalized', $this->special_working_part_show_status_finalized);
		$oCriteria->compare('show_components', $this->show_components);
      
		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
		));
	}
   
   public static function getWorkingPartModuleParameters() {
      $oWorkingPartModuleParameters = WorkingPartModuleParameters::model()->find();
        
      return $oWorkingPartModuleParameters;
   }
}