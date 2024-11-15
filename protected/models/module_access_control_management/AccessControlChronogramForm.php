<?php

class AccessControlChronogramForm extends CCompareDatesFormModel {
   public $employee;
   public $action;
   public $typeAdd;
   public $timetableAdd;
   public $startDateAdd;
   public $endDateAdd;
   public $typeDel;
   public $startDateDel;
   public $endDateDel;
   public $startDateCopy;
   public $endDateCopy;
   public $startDatePaste;
   public $endDatePaste;
   public $startDateCopyChronogram;
   public $endDateCopyChronogram;
   public $employeeCopyChronogram;
   
   /**
    * Declares the validation rules.
    */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('action', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('timetableAdd', 'YiiConditionalValidator',
            'if'=>array(
               array('typeAdd', 'compare', 'compareValue'=>FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING),
            ),
            'then'=>array(
               array('timetableAdd', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('typeAdd', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_SAVE),
            ),
            'then'=>array(
               array('typeAdd', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('endDateAdd', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_SAVE),
            ),
            'then'=>array(
               array('endDateAdd', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('startDateAdd', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_SAVE),
            ),
            'then'=>array(
               array('startDateAdd', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('startDateAdd', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_SAVE),
            ),
            'then'=>array(
                array('startDateAdd', 'compareDates', 'compareAttribute'=>'endDateAdd', 'operator'=>'<=', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_DATE_RANGE')),
            ),
         ),
         array('endDateAdd', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_SAVE),
            ),
            'then'=>array(
                array('endDateAdd', 'compareDates', 'compareAttribute'=>'startDateAdd', 'operator'=>'>=', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_DATE_RANGE')),
            ),
         ),
         
         array('typeDel', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_DELETE),
            ),
            'then'=>array(
               array('typeDel', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('endDateDel', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_DELETE),
            ),
            'then'=>array(
               array('endDateDel', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')), 
            ),
         ),
         array('startDateDel', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_DELETE),
            ),
            'then'=>array(
               array('startDateDel', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')), 
            ),
         ),
         array('startDateDel', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_DELETE),
            ),
            'then'=>array(
                array('startDateDel', 'compareDates', 'compareAttribute'=>'endDateDel', 'operator'=>'<=', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_DATE_RANGE')),
            ),
         ),
         array('endDateDel', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_DELETE),
            ),
            'then'=>array(
                array('endDateDel', 'compareDates', 'compareAttribute'=>'startDateDel', 'operator'=>'>=', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_DATE_RANGE')),
            ),
         ),
         
         array('endDatePaste', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_COPY_PASTE),
            ),
            'then'=>array(
               array('endDatePaste', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('startDatePaste', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_COPY_PASTE),
            ),
            'then'=>array(
               array('startDatePaste', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('endDateCopy', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_COPY_PASTE),
            ),
            'then'=>array(
               array('endDateCopy', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('startDateCopy', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_COPY_PASTE),
            ),
            'then'=>array(
               array('startDateCopy', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('startDateCopy', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_COPY_PASTE),
            ),
            'then'=>array(
                array('startDateCopy', 'compareDates', 'compareAttribute'=>'endDateCopy', 'operator'=>'<=', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_DATE_RANGE')),
            ),
         ),
         array('endDateCopy', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_COPY_PASTE),
            ),
            'then'=>array(
                array('endDateCopy', 'compareDates', 'compareAttribute'=>'startDateCopy', 'operator'=>'>=', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_DATE_RANGE')),
            ),
         ),
         array('startDatePaste', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_COPY_PASTE),
            ),
            'then'=>array(
                array('startDatePaste', 'compareDates', 'compareAttribute'=>'endDatePaste', 'operator'=>'<=', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_DATE_RANGE')),
            ),
         ),
         array('endDatePaste', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_COPY_PASTE),
            ),
            'then'=>array(
                array('endDatePaste', 'compareDates', 'compareAttribute'=>'startDatePaste', 'operator'=>'>=', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_DATE_RANGE')),
            ),
         ),
         
         array('employeeCopyChronogram', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_COPY_PASTE_CHRONOGRAM),
            ),
            'then'=>array(
               array('employeeCopyChronogram', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('endDateCopyChronogram', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_COPY_PASTE_CHRONOGRAM),
            ),
            'then'=>array(
               array('endDateCopyChronogram', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('startDateCopyChronogram', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_COPY_PASTE_CHRONOGRAM),
            ),
            'then'=>array(
               array('startDateCopyChronogram', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         array('startDateCopyChronogram', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_COPY_PASTE_CHRONOGRAM),
            ),
            'then'=>array(
                array('startDateCopyChronogram', 'compareDates', 'compareAttribute'=>'endDateCopyChronogram', 'operator'=>'<=', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_DATE_RANGE')),
            ),
         ),
         array('endDateCopyChronogram', 'YiiConditionalValidator',
            'if'=>array(
               array('action', 'compare', 'compareValue'=>FApplication::FORM_ACTION_COPY_PASTE_CHRONOGRAM),
            ),
            'then'=>array(
                array('endDateCopyChronogram', 'compareDates', 'compareAttribute'=>'startDateCopyChronogram', 'operator'=>'>=', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_DATE_RANGE')),
            ),
         ),                                                                      
		);
	}
   
   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
         'employee'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAM_FIELD_EMPLOYEE'),
         'typeAdd'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAM_FIELD_TYPEADD'),
         'typeDel'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAM_FIELD_TYPEDEL'),
         'timetableAdd'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAM_FIELD_TIMETABLEADD'),
         'startDateAdd'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAM_FIELD_STARTDATEADD'),
         'endDateAdd'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAM_FIELD_ENDDATEADD'),
         'startDateDel'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAM_FIELD_STARTDATEDEL'),
         'endDateDel'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAM_FIELD_ENDDATEDEL'),
         'startDateCopy'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAM_FIELD_STARTDATECOPY'),
         'endDateCopy'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAM_FIELD_ENDDATECOPY'),
         'startDatePaste'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAM_FIELD_STARTDATEPASTE'),
         'endDatePaste'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAM_FIELD_ENDDATEPASTE'),
         'employeeCopyChronogram'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAM_FIELD_EMPLOYEECOPYCHRONOGRAM'),
         'startDateCopyChronogram'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAM_FIELD_STARTDATECOPYCHRONOGRAM'),
         'endDateCopyChronogram'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCHRONOGRAM_FIELD_ENDDATECOPYCHRONOGRAM'),
      );
   }
}