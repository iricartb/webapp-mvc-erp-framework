<?php

class PurchasesStatisticOrdersFinancialCostsForm extends CFormModel {
   public $nYear;
   public $sTypeHighchart;
   
   /**
    * Declares the validation rules.
    */
   public function rules() {
      // NOTE: you should only define rules for those attributes that
      // will receive user inputs.
      return array(
         array('nYear', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),  
         array('sTypeHighchart', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),                                                                          
      );
   }
   
   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
         'nYear'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESSTATISTICORDERSFINANCIALCOSTS_FIELD_YEAR'),
         'sTypeHighchart'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESSTATISTICORDERSFINANCIALCOSTS_FIELD_TYPEHIGHCHART'),
      );
   }
}