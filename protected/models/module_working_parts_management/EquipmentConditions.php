<?php

/**
 * This is the model class for table "equipment_conditions".
 *
 * The followings are the available columns in table 'equipment_conditions':
 * @property integer $id
 * @property string $description
 * @property string $alert
 * @property integer $visible_default_working_part
 * @property integer $visible_default_special_working_part
 * @property integer $visible_default_maintenance_working_part
 * @property integer $visible_alert_value_yes
 * @property integer $visible_alert_value_no
 * @property integer $visible_alert_value_np
 * @property integer $visible_alert_value_default
 * @property string $information
 */
class EquipmentConditions extends CExportedActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EquipmentConditions the static model class
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
		return 'equipment_conditions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('description', 'length', 'min'=>3, 'max'=>90, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('alert', 'length', 'min'=>3, 'max'=>64, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('information', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('description', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         array('visible_default_working_part, visible_default_special_working_part, visible_default_maintenance_working_part, visible_alert_value_yes, visible_alert_value_no, visible_alert_value_np, visible_alert_value_default', 'boolean'),
         
         array('alert', 'YiiConditionalValidator',
            'if'=>array(
               array('visible_alert_value_yes', 'compare', 'compareValue'=>'1'),
            ),
            'then'=>array(
               array('alert', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('alert', 'YiiConditionalValidator',
            'if'=>array(
               array('visible_alert_value_no', 'compare', 'compareValue'=>'1'),
            ),
            'then'=>array(
               array('alert', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('alert', 'YiiConditionalValidator',
            'if'=>array(
               array('visible_alert_value_np', 'compare', 'compareValue'=>'1'),
            ),
            'then'=>array(
               array('alert', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('alert', 'YiiConditionalValidator',
            'if'=>array(
               array('visible_alert_value_default', 'compare', 'compareValue'=>'1'),
            ),
            'then'=>array(
               array('alert', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         
         // The following rule is used by search().
         // Please remove those attributes that should not be searched.
         array('description, visible_default_working_part, visible_default_special_working_part, visible_default_maintenance_working_part', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
         'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
         'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTCONDITIONS_FIELD_DESCRIPTION'),
         'visible_default_working_part'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTCONDITIONS_FIELD_VISIBLEDEFAULTWORKINGPART'),
         'visible_default_special_working_part'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTCONDITIONS_FIELD_VISIBLEDEFAULTSPECIALWORKINGPART'),
         'visible_default_maintenance_working_part'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTCONDITIONS_FIELD_VISIBLEDEFAULTMAINTENANCEWORKINGPART'),
         'alert'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTCONDITIONS_FIELD_ALERT'),
         'visible_alert_value_yes'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTCONDITIONS_FIELD_VISIBLEALERTVALUEYES'),
         'visible_alert_value_no'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTCONDITIONS_FIELD_VISIBLEALERTVALUENO'),
         'visible_alert_value_np'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTCONDITIONS_FIELD_VISIBLEALERTVALUENP'),
         'visible_alert_value_default'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTCONDITIONS_FIELD_VISIBLEALERTVALUEDEFAULT'),
		   'information'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_EQUIPMENTCONDITIONS_FIELD_INFORMATION'),
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

      $oCriteria->compare('description', $this->description, true);
      
      $oCriteria->compare('visible_default_working_part', $this->visible_default_working_part);
      $oCriteria->compare('visible_default_special_working_part', $this->visible_default_special_working_part);
      $oCriteria->compare('visible_default_maintenance_working_part', $this->visible_default_maintenance_working_part);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'visible_default_working_part DESC, visible_default_special_working_part DESC, visible_default_maintenance_working_part DESC, description ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}
   
   public static function getEquipmentCondition($nId) {
      $oEquipmentCondition = EquipmentConditions::model()->findByPk($nId);
      
      return $oEquipmentCondition;
   }
   
   public static function getEquipmentConditionByDescription($sDescription) {
      $oEquipmentCondition = EquipmentConditions::model()->find('description = \'' . $sDescription . '\'');
      
      return $oEquipmentCondition;   
   }
   
   public static function getEquipmentConditions($bVisibleWorkingParts = null, $bVisibleSpecialWorkingParts = null, $bVisibleMaintenanceWorkingParts = null) {
      $sCondition = FString::STRING_EMPTY;
      if (!is_null($bVisibleWorkingParts)) {
         if ($bVisibleWorkingParts) {
            $sCondition = 'visible_default_working_part = 1';    
         }
         else $sCondition = 'visible_default_working_part = 0';
      } 
      if (!is_null($bVisibleSpecialWorkingParts)) {
         if ($bVisibleSpecialWorkingParts) {
            if (strlen($sCondition) > 0) $sCondition .= ' AND visible_default_special_working_part = 1';
            else $sCondition = 'visible_default_special_working_part = 1';    
         }
         else {
            if (strlen($sCondition) > 0) $sCondition .= ' AND visible_default_special_working_part = 0';
            else $sCondition = 'visible_default_special_working_part = 0';   
         }
      }  
      if (!is_null($bVisibleMaintenanceWorkingParts)) {
         if ($bVisibleMaintenanceWorkingParts) {
            if (strlen($sCondition) > 0) $sCondition .= ' AND visible_default_maintenance_working_part = 1';
            else $sCondition = 'visible_default_maintenance_working_part = 1';    
         }
         else {
            if (strlen($sCondition) > 0) $sCondition .= ' AND visible_default_maintenance_working_part = 0';
            else $sCondition = 'visible_default_maintenance_working_part = 0';   
         }
      }

      if (strlen($sCondition) > 0) $sCondition .= ' ORDER BY visible_default_working_part DESC, visible_default_special_working_part DESC, visible_default_maintenance_working_part DESC, description ASC';
      else $sCondition = 'true ORDER BY visible_default_working_part DESC, visible_default_special_working_part DESC, visible_default_maintenance_working_part DESC, description ASC';
      
      return EquipmentConditions::model()->findAll($sCondition);            
   } 
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('visible_default_working_part', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');                                                            
      $this->oExportSpecifications['data'][1] = array('visible_default_special_working_part', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');                                              
      $this->oExportSpecifications['data'][2] = array('visible_default_maintenance_working_part', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');                                              
      $this->oExportSpecifications['data'][3] = array('visible_alert_value_yes', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')'); 
      $this->oExportSpecifications['data'][4] = array('visible_alert_value_no', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')'); 
      $this->oExportSpecifications['data'][5] = array('visible_alert_value_np', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')'); 
      $this->oExportSpecifications['data'][6] = array('visible_alert_value_default', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')'); 
      
      $this->oExportSpecifications['columns'] = array('description', 'visible_default_working_part', 'visible_default_special_working_part', 'visible_default_maintenance_working_part', 'alert', 'visible_alert_value_yes', 'visible_alert_value_no', 'visible_alert_value_np', 'visible_alert_value_default', 'information');
                                                                           
      return $this->oExportSpecifications; 
   }
}