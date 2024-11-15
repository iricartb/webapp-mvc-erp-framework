<?php

class DigitalDiaryEventsForm extends CCompareDatesFormModel {
   public $sEmployee;
   public $bAllEmployees;
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
         array('bAllEmployees', 'boolean'),
         
         array('sEmployee', 'YiiConditionalValidator',
            'if'=>array(
               array('bAllEmployees', 'compare', 'compareValue'=>'0'),
            ),
            'then'=>array(
               array('sEmployee', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
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
         'sEmployee'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYEVENTS_FIELD_EMPLOYEE'),
         'bAllEmployees'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYEVENTS_FIELD_ALLEMPLOYEES'),
         'sStartDate'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYEVENTS_FIELD_STARTDATE'),
         'sEndDate'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYEVENTS_FIELD_ENDDATE'),
         'sDocFormat'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYEVENTS_FIELD_DOCFORMAT'),
      );
   }
}