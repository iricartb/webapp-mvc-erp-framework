<?php

class PurchasesOrdersForm extends CCompareDatesFormModel {
   public $nIdProvider;
   public $sDepartment;
   public $sOwner;
   public $sStartDate;
   public $sEndDate;
   public $bOnlyNotInvoices;
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
         'nIdProvider'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESORDERS_FIELD_IDPROVIDER'),
         'sOwner'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESORDERS_FIELD_OWNER'),
         'sDepartment'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESORDERS_FIELD_DEPARTMENT'),
         'sStartDate'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESORDERS_FIELD_STARTDATE'),
         'sEndDate'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESORDERS_FIELD_ENDDATE'),
         'bOnlyNotInvoices'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESORDERS_FIELD_ONLYNOTINVOICES'),
         'sDocFormat'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESORDERS_FIELD_DOCFORMAT'),
      );
   }
}