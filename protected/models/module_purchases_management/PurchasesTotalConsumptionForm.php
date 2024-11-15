<?php

class PurchasesTotalConsumptionForm extends CFormModel {
   public $nIdProvider;
   public $nYear;
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
         'nIdProvider'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESTOTALCONSUMPTION_FIELD_IDPROVIDER'),
         'nYear'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESTOTALCONSUMPTION_FIELD_YEAR'),
         'sDocFormat'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESTOTALCONSUMPTION_FIELD_DOCFORMAT'),
      );
   }
}