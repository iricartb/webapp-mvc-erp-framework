<?php

/**
 * This is the model class for table "form_maintenance_working_part_measures".
 *
 * The followings are the available columns in table 'form_working_part_measures':
 * @property integer $id
 * @property string $description
 * @property string $alert
 * @property integer $value
 * @property integer $visible_alert_value_yes
 * @property integer $visible_alert_value_no
 * @property integer $visible_alert_value_np
 * @property integer $visible_alert_value_default
 * @property integer $required_grade_preventive_action
 * @property string $information
 * @property string $information_field
 * @property integer $custom
 * @property string $custom_field
 * @property integer $id_form_maintenance_working_part
 * 
 * The followings are the available model relations:
 * @property FormsMaintenanceWorkingParts $idFormMaintenanceWorkingPart
 */
class FormMaintenanceWorkingPartMeasures extends CActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormWorkingPartMeasures the static model class
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
		return 'form_maintenance_working_part_measures';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_maintenance_working_part', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('description', 'length', 'min'=>3, 'max'=>90, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('alert', 'length', 'min'=>3, 'max'=>64, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('custom_field', 'length', 'min'=>3, 'max'=>90, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('information_field', 'length', 'max'=>40),
         
         array('description', 'UniqueAttributesValidator', 'with'=>'id_form_maintenance_working_part', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         array('visible_alert_value_yes, visible_alert_value_no, visible_alert_value_np, visible_alert_value_default, required_grade_preventive_action, custom', 'boolean'),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('description, id_form_maintenance_working_part', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'form_maintenance_working_part'=>array(self::BELONGS_TO, 'FormsMaintenanceWorkingParts', 'id_form_maintenance_working_part'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),   
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTMEASURES_FIELD_DESCRIPTION'),
			'value'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTMEASURES_FIELD_VALUE'),
         'alert'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTMEASURES_FIELD_ALERT'),
         'visible_alert_value_yes'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTMEASURES_FIELD_VISIBLEALERTVALUEYES'),
         'visible_alert_value_no'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTMEASURES_FIELD_VISIBLEALERTVALUENO'),
         'visible_alert_value_np'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTMEASURES_FIELD_VISIBLEALERTVALUENP'),
         'visible_alert_value_default'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTMEASURES_FIELD_VISIBLEALERTVALUEDEFAULT'),
         'required_grade_preventive_action'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTMEASURES_FIELD_REQUIREDGRADEPREVENTIVEACTION'),
         'information'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTMEASURES_FIELD_INFORMATION'),
         'information_field'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTMEASURES_FIELD_INFORMATIONFIELD'),
         'custom'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTMEASURES_FIELD_CUSTOM'),
         'custom_field'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMMAINTENANCEWORKINGPARTMEASURES_FIELD_CUSTOMFIELD'),
         'id_form_maintenance_working_part'=>Yii::t('system', 'SYS_MODEL_FIELD_FK'),
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
      
		$oCriteria->compare('description' ,$this->description, true);
      if (!is_null($nIdFormFK)) $oCriteria->compare('id_form_maintenance_working_part', $nIdFormFK);
            
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'custom ASC, id ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}
   
   public static function getFormMaintenanceWorkingPartMeasure($nId) {
      $oFormMaintenanceWorkingPartMeasure = FormMaintenanceWorkingPartMeasures::model()->findByPk($nId);
      
      return $oFormMaintenanceWorkingPartMeasure;
   }
   
   public static function getFormMaintenanceWorkingPartMeasuresByIdFormFK($nIdFormFK) {
      return FormMaintenanceWorkingPartMeasures::model()->findAll('id_form_maintenance_working_part = ' . $nIdFormFK . ' ORDER BY custom ASC, id ASC');   
   }
}