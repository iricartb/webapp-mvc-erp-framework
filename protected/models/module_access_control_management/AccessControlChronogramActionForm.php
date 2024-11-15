<?php

class AccessControlChronogramActionForm extends CCompareDatesFormModel {
   public $employee;
   public $action;
   public $datePrint;
   public $docFormat;
   
   /**
    * Declares the validation rules.
    */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('employee', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('action', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('docFormat', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_PRINT),
            ),
            'then'=>array(
               array('docFormat', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('datePrint', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_PRINT),
            ),
            'then'=>array(
               array('datePrint', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),                                                              
		);
	}
   
   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
         'employee' => Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMACTION_FIELD_EMPLOYEE'),
         'datePrint'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMACTION_FIELD_DATEPRINT'),
         'docFormat'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMACTION_FIELD_DOCFORMAT'),
         'docDetailInformation'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAMACTION_FIELD_DOCDETAILINFORMATION'),
      );
   }
}