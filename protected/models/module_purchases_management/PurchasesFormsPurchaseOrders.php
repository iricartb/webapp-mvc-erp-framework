<?php

/**
 * This is the model class for table "purchases_forms_purchase_orders".
 *
 * The followings are the available columns in table 'purchases_forms_purchase_orders':
 * @property integer $id
 * @property string $owner
 * @property string $user_accept
 * @property string $description
 * @property string $department
 * @property string $price
 * @property string $offer
 * @property string $order
 * @property string $delivery
 * @property string $send_method
 * @property string $payment_method
 * @property string $comments
 * @property string $status
 * @property string $accept_date
 * @property integer $notify
 * @property string $notify_date
 * @property integer $changes_pending
 * @property string $changes_price
 * @property string $changes_reason
 * @property integer $id_provider
 * @property integer $id_user
 * @property integer $id_financial_cost_line
 * @property integer $id_form_request_offer
 * 
 * The followings are the available model relations:
 * @property Providers $idProvider
 * @property PurchasesFinancialCostsLines $idFinancialCostLine
 */
class PurchasesFormsPurchaseOrders extends CExportedActiveRecord {
   public $type;
   public $bPartialFinalized;
   public $bFinalized; 
   public $sFilterInvoiceNumber;
   public $sFilterStatusPending;
   public $sFilterStatusPartialFinalized;
   public $sFilterStatusFinalized;
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return PurchasesFormsPurchaseOrders the static model class
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
		return 'purchases_forms_purchase_orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('owner', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('user_accept', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('offer', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('status', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('accept_date', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_provider', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_user', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_financial_cost_line', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_request_offer', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('send_method', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('payment_method', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('price', 'length', 'max'=>14),
         array('price', 'numerical', 'min'=>0, 'max'=>9999999999.99, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'0')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>'9999999999.99'))),
         array('offer', 'length', 'max'=>255),
         array('order', 'length', 'max'=>255),
         array('delivery', 'length', 'max'=>255),
         array('changes_price', 'length', 'max'=>14),
         array('changes_price', 'numerical', 'min'=>0.01, 'max'=>9999999999.99, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'0.01')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>'9999999999.99'))),
          
         array('description', 'length', 'min'=>3, 'max'=>1024, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('send_method', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('payment_method', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('comments', 'length', 'min'=>3, 'max'=>256, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('changes_reason', 'length', 'min'=>3, 'max'=>256, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('notify, changes_pending', 'boolean'),
         array('bFinalized', 'boolean'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, owner, user_accept, description, department, price, offer, status, accept_date, notify, notify_date, changes_pending, changes_price, id_provider, id_user, id_financial_cost_line', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'provider'=>array(self::BELONGS_TO, 'Providers', 'id_provider'),
			'financial_cost_line'=>array(self::BELONGS_TO, 'PurchasesFinancialCostsLines', 'id_financial_cost_line'),
         'form_request_offer'=>array(self::BELONGS_TO, 'PurchasesFormsRequestOffers', 'id_form_request_offer'),
         'articles'=>array(self::HAS_MANY, 'PurchasesFormsPurchaseOrdersArticles', 'id_form_purchase_order'),
         'invoices'=>array(self::HAS_MANY, 'PurchasesFormsPurchaseOrdersInvoices', 'id_form_purchase_order'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_ID'),
			'owner'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_OWNER'),
			'user_accept'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_USERACCEPT'),
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_DESCRIPTION'),
         'department'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_DEPARTMENT'),
			'price'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_PRICE'),
			'offer'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_OFFER'),
         'order'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_ORDER'), 
         'delivery'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_DELIVERY'), 
         'send_method'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_SENDMETHOD'), 
         'payment_method'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_PAYMENTMETHOD'), 
         'comments'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_COMMENTS'),  
			'status'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_STATUS'),
			'accept_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_ACCEPTDATE'),
			'notify'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_NOTIFY'),
			'notify_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_NOTIFYDATE'),
			'id_provider'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_IDPROVIDER'),
         'type'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_TYPE'),  
         'changes_price'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_CHANGESPRICE'),  
         'changes_reason'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_CHANGESREASON'),  
         'bPartialFinalized'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_PARTIAL_FINALIZED'),
         'bFinalized'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_FINALIZED'),
			'id_financial_cost_line'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_IDFINANCIALCOSTLINE'),
		   'id_form_request_offer'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERS_FIELD_IDFORMREQUESTOFFER'),
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
	public function search($nIdProvider = null, $sFilterInvoiceNumber = null, $sFilterStatusPending = true, $sFilterStatusPartialFinalized = null, $sFilterStatusFinalized = null, $nPageSize = null) {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$oCriteria = new CDbCriteria;

      $oCriteria->compare('t.id', $this->id);
      $oCriteria->compare('t.owner', $this->owner, true);
      $oCriteria->compare('t.description', $this->description, true);
      $oCriteria->compare('t.department', $this->department);
      $oCriteria->compare('t.accept_date', FDate::getEnglishDate($this->accept_date), true);
      
      if (!FString::isNullOrEmpty($nIdProvider)) $oCriteria->compare('t.id_provider', $nIdProvider);
      else $oCriteria->compare('t.id_provider', $this->id_provider);
      
      $oCriteria->compare('t.id_financial_cost_line', $this->id_financial_cost_line);
      
      if ((!FString::isNullOrEmpty($sFilterInvoiceNumber)) || (!FString::isNullOrEmpty($this->sFilterInvoiceNumber))) {
         if (!FString::isNullOrEmpty($sFilterInvoiceNumber)) $oCriteria->addCondition('invoices.number LIKE \'%' . $sFilterInvoiceNumber . '%\''); 
         else $oCriteria->addCondition('invoices.number LIKE \'%' . $this->sFilterInvoiceNumber . '%\'');   
         
         $oCriteria->with = array('invoices');
         $oCriteria->together = true;   
      }
      
      if ((((!is_null($this->sFilterStatusPending)) && ($this->sFilterStatusPending)) || ((!is_null($sFilterStatusPending)) && ($sFilterStatusPending))) || (((!is_null($this->sFilterStatusPartialFinalized)) && ($this->sFilterStatusPartialFinalized)) || ((!is_null($sFilterStatusPartialFinalized)) && ($sFilterStatusPartialFinalized))) || (((!is_null($this->sFilterStatusFinalized)) && ($this->sFilterStatusFinalized)) || ((!is_null($sFilterStatusFinalized)) && ($sFilterStatusFinalized)))) {
         $sStatusCondition = FString::STRING_EMPTY;
         
         if (((!is_null($this->sFilterStatusPending)) && ($this->sFilterStatusPending)) || ((!is_null($sFilterStatusPending)) && ($sFilterStatusPending))) {
            $sStatusCondition = 't.status = \'' . FModulePurchasesManagement::STATUS_PENDING . '\'';   
         }
      
         if (((!is_null($this->sFilterStatusPartialFinalized)) && ($this->sFilterStatusPartialFinalized)) || ((!is_null($sFilterStatusPartialFinalized)) && ($sFilterStatusPartialFinalized))) {
            if (strlen($sStatusCondition) > 0) $sStatusCondition .= ' OR t.status = \'' . FModulePurchasesManagement::STATUS_PARTIAL_FINALIZED . '\'';   
            else $sStatusCondition = 't.status = \'' . FModulePurchasesManagement::STATUS_PARTIAL_FINALIZED . '\'';   
         }
         
         if (((!is_null($this->sFilterStatusFinalized)) && ($this->sFilterStatusFinalized)) || ((!is_null($sFilterStatusFinalized)) && ($sFilterStatusFinalized))) {
            if (strlen($sStatusCondition) > 0) $sStatusCondition .= ' OR t.status = \'' . FModulePurchasesManagement::STATUS_FINALIZED . '\'';   
            else $sStatusCondition = 't.status = \'' . FModulePurchasesManagement::STATUS_FINALIZED . '\'';   
         }
      }
      else $sStatusCondition = 't.status IS NULL';
      
      $oCriteria->addCondition($sStatusCondition);   
      
      if (!is_null($nPageSize)) {
         $oPagination = array('pageSize'=>$nPageSize);   
      }
      else $oPagination = false;
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'t.id DESC',
         ),
         'pagination'=>$oPagination,
      ));
	}

   public static function getPurchasesFormPurchaseOrder($nId) {
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::model()->findByPk($nId);
      
      return $oPurchasesFormPurchaseOrder;
   }
   
   public static function getPurchasesFormsPurchaseOrders($nIdUser = null, $nIdFinancialCostLine = null, $nYear = null, $nIdProvider = null, $sOwner = null, $sDepartment = null, $sStartDate = null, $sEndDate = null, $bOnlyNotInvoices = false, $sGroupByField = null, $sOrderByField = null) {
      $oCriteria = new CDbCriteria;
      $sSentence = FString::STRING_EMPTY;
      $bCondition = false;
      
      if (!is_null($nIdUser)) {
         if ($bCondition) $sSentence = 't.id_user = ' . $nIdUser . ' AND ' . $sSentence;
         else $sSentence = 't.id_user = ' . $nIdUser . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!is_null($nIdFinancialCostLine)) {
         if ($bCondition) $sSentence = 't.id_financial_cost_line = ' . $nIdFinancialCostLine . ' AND ' . $sSentence;
         else $sSentence = 't.id_financial_cost_line = ' . $nIdFinancialCostLine . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!is_null($nYear)) {
         if ($bCondition) $sSentence = 'financial_cost.year = ' . $nYear . ' AND ' . $sSentence;
         else $sSentence = 'financial_cost.year = ' . $nYear . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
     
      if (!FString::isNullOrEmpty($nIdProvider)) {
         if ($bCondition) $sSentence = 't.id_provider = ' . $nIdProvider . ' AND ' . $sSentence;
         else $sSentence = 't.id_provider = ' . $nIdProvider . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!FString::isNullOrEmpty($sOwner)) {
         if ($bCondition) $sSentence = 't.owner LIKE \'%' . $sOwner . '%\' AND ' . $sSentence;
         else $sSentence = 't.owner LIKE \'%' . $sOwner . '%\' ' . $sSentence;
         $bCondition = true;
      }
       
      if (!FString::isNullOrEmpty($sDepartment)) {
         if ($bCondition) $sSentence = 't.department = \'' . $sDepartment . '\' AND ' . $sSentence;
         else $sSentence = 't.department = \'' . $sDepartment . '\' ' . $sSentence;
         $bCondition = true;
      }
      
      if (!FString::isNullOrEmpty($sStartDate)) {
         if ($bCondition) $sSentence = 't.accept_date >= \'' . $sStartDate . '\' AND ' . $sSentence;
         else $sSentence = 't.accept_date >= \'' . $sStartDate . '\'' . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!FString::isNullOrEmpty($sEndDate)) {
         if ($bCondition) $sSentence = 't.accept_date <= \'' . $sEndDate . ' 23:59:59\' AND ' . $sSentence;
         else $sSentence = 't.accept_date <= \'' . $sEndDate . '\'' . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }

      if ($bOnlyNotInvoices) {
         if ($bCondition) $sSentence = 'invoices.id IS NULL AND ' . $sSentence;
         else $sSentence = 'invoices.id IS NULL' . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!FString::isNullOrEmpty($nYear)) {
         if ($bOnlyNotInvoices) {
            $oCriteria->with = array('financial_cost_line.financial_cost', 'invoices'=>array('joinType'=>'LEFT JOIN'), 'provider');
            $oCriteria->together = true; 
         }
         else {
            $oCriteria->with = array('financial_cost_line.financial_cost', 'provider');
            $oCriteria->together = true;  
         } 
      }    
      else {
         if ($bOnlyNotInvoices) {      
            $oCriteria->with = array('invoices'=>array('joinType'=>'LEFT JOIN'), 'provider');
            $oCriteria->together = true; 
         }
         else {
            $oCriteria->with = array('provider');
            $oCriteria->together = true;
         }   
      }
      
      $oCriteria->condition = $sSentence;
      if (!FString::isNullOrEmpty($sGroupByField)) $oCriteria->group = $sGroupByField;
      
      if (!FString::isNullOrEmpty($sOrderByField)) $oCriteria->order = $sOrderByField;
      else $oCriteria->order = 't.id DESC';
            
      return PurchasesFormsPurchaseOrders::model()->findAll($oCriteria);     
   }
   
   public static function getPurchasesFormPurchaseOrderConsumption($nId) {
      $nConsumption = 0;
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::model()->findByPk($nId);

      if (!is_null($oPurchasesFormPurchaseOrder)) {
         $nConsumption += $oPurchasesFormPurchaseOrder->price; 
         
         if ($oPurchasesFormPurchaseOrder->status == FModulePurchasesManagement::STATUS_FINALIZED) {
            $nTotalSumInvoices = 0;
            $oPurchasesFormsPurchaseOrdersInvoices = PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormsPurchasesOrdersInvoicesByIdFormFK($oPurchasesFormPurchaseOrder->id);
            foreach($oPurchasesFormsPurchaseOrdersInvoices as $oPurchasesFormPurchaseOrderInvoice) {
               $nTotalSumInvoices += $oPurchasesFormPurchaseOrderInvoice->base;   
            }
            
            $nConsumption -= (round($oPurchasesFormPurchaseOrder->price - $nTotalSumInvoices, 2));
         } 
      }
      
      return $nConsumption;
   }  
      
   public static function getPurchasesFormPurchaseOrderPaid($nId) {
      $bPaid = false;
      $nPurchaseFormPurchaseOrderInvoicePaid = 0;
      
      $oPurchasesFormPurchaseOrder = PurchasesFormsPurchaseOrders::model()->findByPk($nId);
      if ((!is_null($oPurchasesFormPurchaseOrder)) && ($oPurchasesFormPurchaseOrder->status == FModulePurchasesManagement::STATUS_FINALIZED)) {
         $oPurchasesFormsPurchaseOrdersInvoices = PurchasesFormsPurchaseOrdersInvoices::getPurchasesFormsPurchasesOrdersInvoicesByIdFormFK($oPurchasesFormPurchaseOrder->id);
         if (count($oPurchasesFormsPurchaseOrdersInvoices) > 0) {
            foreach($oPurchasesFormsPurchaseOrdersInvoices as $oPurchasesFormPurchaseOrderInvoice) {
               if ($oPurchasesFormPurchaseOrderInvoice->paid) $nPurchaseFormPurchaseOrderInvoicePaid++;    
            }
            
            $bPaid = (count($oPurchasesFormsPurchaseOrdersInvoices) == $nPurchaseFormPurchaseOrderInvoicePaid);
         }  
      }
      
      return $bPaid;
   }
   
   public static function getPurchasesFormsPurchaseOrdersByIdFormFK($nIdFormFK) {
      return PurchasesFormsPurchaseOrders::model()->findAll('id_form_request_offer = ' . $nIdFormFK . ' ORDER BY id ASC');   
   }
   
   public static function getPurchasesFormsPurchaseOrdersByIdProviderAndIdFormFK($nIdProvider, $nIdFormFK) {
      return PurchasesFormsPurchaseOrders::model()->findAll('id_provider = ' . $nIdProvider . ' AND id_form_request_offer = ' . $nIdFormFK . ' ORDER BY id ASC');   
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('accept_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][1] = array('notify_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][2] = array('id_provider', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Providers::getProviderName(?)', 'FString::STRING_EMPTY');
      
      $this->oExportSpecifications['columns'] = array('id', 'owner', 'user_accept', 'description', 'price', 'offer', 'send_method', 'payment_method', 'accept_date', 'notify_date', 'comments');
        
      return $this->oExportSpecifications; 
   }
}