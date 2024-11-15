<?php

class MonitoringRoundsForm extends CCompareDatesFormModel {
   public $sEmployee;
   public $sStartDate;
   public $sEndDate;
   public $sDocFormat;
   
   /**
    * Declares the validation rules.
    */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('sEmployee', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('sStartDate', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('sEndDate', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('sDocFormat', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),

         array('sEndDate', 'compareDates', 'compareAttribute'=>'sStartDate', 'operator'=>'>=', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_DATE_RANGE')),                                                                             
		);
	}
   
   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
         'sEmployee'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGROUNDS_FIELD_EMPLOYEE'),
         'sStartDate'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGROUNDS_FIELD_STARTDATE'),
         'sEndDate'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGROUNDS_FIELD_ENDDATE'),
         'sDocFormat'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGROUNDS_FIELD_DOCFORMAT'),
      );
   }
}