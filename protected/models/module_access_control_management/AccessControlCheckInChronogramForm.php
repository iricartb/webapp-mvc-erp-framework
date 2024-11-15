<?php

class AccessControlCheckInChronogramForm extends CCompareDatesFormModel {
   public $employee;
   public $allEmployees;
   public $startDate;
   public $endDate;
   public $docFormat;
   public $docDetailInformation;
   public $sourceData;
   
   /**
    * Declares the validation rules.
    */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('allEmployees', 'boolean'),
         
         array('employee', 'YiiConditionalValidator',
            'if'=>array(
               array('allEmployees', 'compare', 'compareValue'=>'0'),
            ),
            'then'=>array(
               array('employee', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('startDate', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('endDate', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('docFormat', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('sourceData', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('docDetailInformation', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('endDate', 'compareDates', 'compareAttribute'=>'startDate', 'operator'=>'>=', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_DATE_RANGE')),                                                                             
		);
	}
   
   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
         'employee'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINCHRONOGRAM_FIELD_EMPLOYEE'),
         'allEmployees'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINCHRONOGRAM_FIELD_ALLEMPLOYEES'),
         'startDate'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINCHRONOGRAM_FIELD_STARTDATE'),
         'endDate'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINCHRONOGRAM_FIELD_ENDDATE'),
         'docFormat'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINCHRONOGRAM_FIELD_DOCFORMAT'),
         'sourceData'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINCHRONOGRAM_FIELD_SOURCEDATA'),
         'docDetailInformation'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHECKINCHRONOGRAM_FIELD_DOCDETAILINFORMATION'),
      );
   }
}