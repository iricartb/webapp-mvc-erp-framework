<?php

/**
 * This is the model class for table "purchases_forms_purchase_orders_invoices".
 *
 * The followings are the available columns in table 'purchases_forms_purchase_orders_invoices':
 * @property integer $id
 * @property string $date
 * @property string $number
 * @property string $base
 * @property string $iva
 * @property string $price
 * @property integer $paid
 * @property integer $id_form_purchase_order
 *
 * The followings are the available model relations:
 * @property PurchasesFormsPurchaseOrders $idFormPurchaseOrder
 */
class PurchasesFormsPurchaseOrdersInvoices extends CActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return PurchasesFormsPurchaseOrdersInvoices the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
   /**
    * @return CDbConnection the database connection used for this class
    */
   public function getDbConnection() {
      return Yii::app()->db_rainbow_purchasesmanagement;
   }

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'purchases_forms_purchase_orders_invoices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_form_purchase_order', 'required'),
         
			array('number', 'length', 'max'=>20),

         array('base', 'length', 'max'=>13),
         array('base', 'numerical', 'min'=>0, 'max'=>9999999999.99, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'0')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>'9999999999.99'))),
 
         array('iva', 'length', 'max'=>13),
         array('iva', 'numerical', 'min'=>0, 'max'=>9999999999.99, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'0')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>'9999999999.99'))),
 
         array('price', 'length', 'max'=>13),
         array('price', 'numerical', 'min'=>0, 'max'=>9999999999.99, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'0')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>'9999999999.99'))),
 
         array('paid', 'boolean'),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, number, price, id_form_purchase_order', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'form_purchase_order'=>array(self::BELONGS_TO, 'PurchasesFormsPurchaseOrders', 'id_form_purchase_order'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
			'number'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERSINVOICES_FIELD_NUMBER'),
         'date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERSINVOICES_FIELD_DATE'),
         'base'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERSINVOICES_FIELD_BASE'),
			'iva'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERSINVOICES_FIELD_IVA'),
         'price'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERSINVOICES_FIELD_PRICE'),
         'paid'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERSINVOICES_FIELD_PAID'),
			'id_form_purchase_order'=>Yii::t('system', 'SYS_MODEL_FIELD_FK'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($nIdFormFK = null) {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('id',$this->id);
		$oCriteria->compare('number',$this->number,true);
		$oCriteria->compare('price',$this->price,true);
		$oCriteria->compare('id_form_purchase_order',$this->id_form_purchase_order);

      if (!is_null($nIdFormFK)) $oCriteria->compare('id_form_purchase_order', $nIdFormFK);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'id ASC',
         ),
         'pagination'=>null,
      ));
	}

   public static function getPurchasesFormPurchaseOrderInvoice($nId) {
      $oPurchasesFormPurchaseOrderInvoice = PurchasesFormsPurchaseOrdersInvoices::model()->findByPk($nId);
      
      return $oPurchasesFormPurchaseOrderInvoice;
   }
                                                            
   public static function getPurchasesFormsPurchasesOrdersInvoicesByIdFormFK($nIdFormFK) {
      return PurchasesFormsPurchaseOrdersInvoices::model()->findAll('id_form_purchase_order = ' . $nIdFormFK . ' ORDER BY id ASC');   
   }
   
   public static function getPurchasesFormsPurchasesOrdersTotalSumInvoicesByIdFormFK($nIdFormFK, $bOnlyPaid = false) {
      $nTotalSum = 0;
      
      $oPurchasesFormsPurchaseOrdersInvoices = PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormsPurchasesOrdersInvoicesByIdFormFK($nIdFormFK);
      foreach($oPurchasesFormsPurchaseOrdersInvoices as $oPurchasesFormPurchaseOrderInvoice) {
         if ((!$bOnlyPaid) || ($bOnlyPaid) && ($oPurchasesFormPurchaseOrderInvoice->paid)) $nTotalSum += $oPurchasesFormPurchaseOrderInvoice->base;   
      }
      
      return $nTotalSum;
   }
   
   public static function getPurchasesFormsPurchasesOrdersInvoicesPendingPayment($nIdProvider = null) {
      $oCriteria = new CDbCriteria;
      $oCriteria->with = array('form_purchase_order');
      $oCriteria->together = true; 
         
      $oCriteria->addCondition('(LENGTH(t.date) > 0) AND (LENGTH(form_purchase_order.payment_method) > 0) AND (DATE_ADD(t.date, INTERVAL (CAST(SUBSTRING_INDEX(form_purchase_order.payment_method, \'_\', 1) AS SIGNED)) DAY) <= DATE(NOW())) AND (t.paid = 0)');
      
      if (!FString::isNullOrEmpty($nIdProvider)) {
         $oCriteria->addCondition('form_purchase_order.id_provider = ' . $nIdProvider);
      }
      
      $oCriteria->order = 't.date DESC';
      
      return PurchasesFormsPurchaseOrdersInvoices::model()->findAll($oCriteria);
   }
   
   public static function getPurchasesFormsPurchasesOrdersTotalInvoices($nIdProvider = null, $sStartDate = null, $sEndDate = null) {
      $oCriteria = new CDbCriteria;
      $oCriteria->with = array('form_purchase_order');
      $oCriteria->together = true; 
         
      if (!FString::isNullOrEmpty($nIdProvider)) {
         $oCriteria->addCondition('form_purchase_order.id_provider = ' . $nIdProvider);
      }
      
      if (!FString::isNullOrEmpty($sStartDate)) {
         $oCriteria->addCondition('t.date >= \'' . $sStartDate . '\' OR t.date IS NULL');
      }
      
      if (!FString::isNullOrEmpty($sEndDate)) {
         $oCriteria->addCondition('t.date <= \'' . $sEndDate . '\' OR t.date IS NULL');
      }
             
      $oCriteria->order = 't.date DESC';
      
      return PurchasesFormsPurchaseOrdersInvoices::model()->findAll($oCriteria);
   }
}