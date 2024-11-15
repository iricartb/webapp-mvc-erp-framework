<?php

class WarehouseInputsOutputsForm extends CCompareDatesFormModel {
   public $sType;
   public $sSubtype;
   public $nIdArticle;
   public $bOnlyIPE;
   public $sProvider;
   public $sEmployee;
   public $nIdSubcategory;
   public $nIdLocation;
   public $sStartDate;
   public $sEndDate;
   public $sOrder;
   public $sDocFormat;
   
   /**
    * Declares the validation rules.
    */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('sType', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('sOrder', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('sDocFormat', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('bOnlyIPE', 'boolean'),
         
         array('sEndDate', 'compareDates', 'compareAttribute'=>'sStartDate', 'operator'=>'>=', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_DATE_RANGE')),                                                                             
		);
	}
   
   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
         'sType'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINPUTSOUTPUTS_FIELD_TYPE'),
         'sSubtype'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINPUTSOUTPUTS_FIELD_SUBTYPE'),
         'nIdArticle'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINPUTSOUTPUTS_FIELD_IDARTICLE'),
         'bOnlyIPE'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINPUTSOUTPUTS_FIELD_ONLYEIPE'),
         'sProvider'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINPUTSOUTPUTS_FIELD_PROVIDER'),
         'sEmployee'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINPUTSOUTPUTS_FIELD_EMPLOYEE'),
         'nIdSubcategory'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINPUTSOUTPUTS_FIELD_IDSUBCATEGORY'),
         'nIdLocation'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINPUTSOUTPUTS_FIELD_IDLOCATION'),
         'sStartDate'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINPUTSOUTPUTS_FIELD_STARTDATE'),
         'sEndDate'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINPUTSOUTPUTS_FIELD_ENDDATE'),
         'sOrder'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINPUTSOUTPUTS_FIELD_ORDER'),
         'sDocFormat'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEINPUTSOUTPUTS_FIELD_DOCFORMAT'),
      );
   }
}