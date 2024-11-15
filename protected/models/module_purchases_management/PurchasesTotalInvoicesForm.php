<?php

class PurchasesTotalInvoicesForm extends CCompareDatesFormModel {
   public $nIdProvider;
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
         array('sDocFormat', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),   
         
         array('sEndDate', 'compareDates', 'compareAttribute'=>'sStartDate', 'operator'=>'>=', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_DATE_RANGE')),                                                                               
      );
   }
   
   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
         'nIdProvider'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESTOTALINVOICES_FIELD_IDPROVIDER'),
         'sStartDate'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESTOTALINVOICES_FIELD_STARTDATE'),
         'sEndDate'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESTOTALINVOICES_FIELD_ENDDATE'),
         'sDocFormat'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESTOTALINVOICES_FIELD_DOCFORMAT'),
      );
   }
}