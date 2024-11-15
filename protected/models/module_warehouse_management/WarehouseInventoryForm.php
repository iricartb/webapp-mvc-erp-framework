<?php

class WarehouseInventoryForm extends CFormModel {
   public $sDate;
   public $nIdArticle;
   public $nIdProvider;
   public $sProvider;
   public $nIdSubcategory;
   public $nIdLocation;
   public $bOnlyAbsolete;
   public $bOnlyCommonwealth;
   public $sOrder;
   public $sDocFormat;
   
   /**
    * Declares the validation rules.
    */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('sDate', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('sOrder', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')), 
         array('sDocFormat', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),                                                                         
		);
	}
   
   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
         'nIdArticle'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINVENTORY_FIELD_IDARTICLE'),
         'nIdProvider'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINVENTORY_FIELD_IDPROVIDER'),
         'sProvider'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINVENTORY_FIELD_PROVIDER'),
         'nIdSubcategory'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINVENTORY_FIELD_IDSUBCATEGORY'),
         'nIdLocation'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINVENTORY_FIELD_IDLOCATION'),
         'bOnlyAbsolete'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINVENTORY_FIELD_ONLYABSOLETE'),
         'bOnlyCommonwealth'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINVENTORY_FIELD_ONLYCOMMONWEALTH'),
         'sDate'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINVENTORY_FIELD_DATE'),
         'sOrder'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINVENTORY_FIELD_ORDER'),
         'sDocFormat'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINVENTORY_FIELD_DOCFORMAT'),
      );
   }
}