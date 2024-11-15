<?php

class PurchasesInvoicesForm extends CFormModel {
   public $nIdProvider;
   public $sDocFormat;
   
   /**
    * Declares the validation rules.
    */
   public function rules() {
      // NOTE: you should only define rules for those attributes that
      // will receive user inputs.
      return array(
         array('sDocFormat', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),                                                                          
      );
   }
   
   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
         'nIdProvider'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESINVOICES_FIELD_IDPROVIDER'),
         'sDocFormat'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESINVOICES_FIELD_DOCFORMAT'),
      );
   }
}