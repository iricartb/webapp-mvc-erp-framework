<?php

/**
 * This is the model class for table "providers".
 *
 * The followings are the available columns in table 'providers':
 * @property integer $id
 * @property string $name
 * @property string $nif
 * @property string $account
 * @property string $phone
 * @property string $mail
 * @property string $module
 */
class Providers extends CExportedActiveRecord {
   public $nConsumption;
   public $nConsumptionAddContractingProcedures;
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return Providers the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'db_rainbow_common.providers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name, nif', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('name', 'length', 'min'=>2, 'max'=>90, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'2'))),
         array('account', 'length', 'min'=>3, 'max'=>15, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('phone', 'length', 'max'=>12),
         array('mail', 'length', 'max'=>60),
          
         array('account', 'match', 'pattern'=>FRegEx::getNumericPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_ONLY_NUMERIC')),

         array('nif', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
         array('name, nif', 'filter', 'filter'=>'strtoupper'),
        
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, module', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'), 
			'name'=>Yii::t('rainbow', 'MODEL_PROVIDERS_FIELD_NAME'),
         'nif'=>Yii::t('rainbow', 'MODEL_PROVIDERS_FIELD_NIF'),
         'account'=>Yii::t('rainbow', 'MODEL_PROVIDERS_FIELD_ACCOUNT'),
         'phone'=>Yii::t('rainbow', 'MODEL_PROVIDERS_FIELD_PHONE'),
         'mail'=>Yii::t('rainbow', 'MODEL_PROVIDERS_FIELD_MAIL'),
         'nConsumption'=>Yii::t('rainbow', 'MODEL_PROVIDERS_FIELD_CONSUMPTION'),
         'nConsumptionAddContractingProcedures'=>Yii::t('rainbow', 'MODEL_PROVIDERS_FIELD_CONSUMPTIONADDCONTRACTINGPROCEDURES'),
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
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('id', $this->id);

      if ((strlen($this->name) > 0) && ($this->name[0] == '%')) {
         $oCriteria->addCondition('name LIKE \'' . substr($this->name, 1) . '%\'');
         $oPagination = false;
      }
      else $oCriteria->compare('name', $this->name, true); 
      
      $oCriteria->compare('nif', $this->nif, true);
      $oCriteria->compare('account', $this->account, true);
      $oCriteria->compare('mail', $this->mail, true);
      $oCriteria->compare('module', $this->module, true);
      
      if (!((strlen($this->name) > 0) && ($this->name[0] == '%'))) {
         $oPagination = array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_BIG);   
      }
      else $oPagination = false;
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC',
         ),
         'pagination'=>$oPagination,
      ));
	}

   public static function getProvider($nId) {
      $oProvider = Providers::model()->findByPk($nId);
      
      return $oProvider;
   }
   
   public static function getProviders() {
      $oProviders = Providers::model()->findAll('true ORDER BY name ASC');
      
      return $oProviders;
   }
   
   public static function getProviderByNIF($sNif) {
      $oProvider = Providers::model()->find('nif = \'' . $sNif . '\'');
      
      return $oProvider; 
   }
   
   public static function getProviderName($nId) {
      $oProvider = Providers::getProvider($nId);
      if (!is_null($oProvider)) {
         return $oProvider->name;      
      }  
      return FString::STRING_EMPTY;
   }
   
   public static function getProviderConsumptionByYear($nId, $nYear, $bComputeContractingProcedures = false) {
      $nConsumption = 0;
      
      $oProvider = Providers::getProvider($nId);
      if (!is_null($oProvider)) {
         $oPurchasesFormsPurchaseOrders = PurchasesFormsPurchaseOrders::getPurchasesFormsPurchaseOrders(null, null, $nYear, $oProvider->id);
         foreach($oPurchasesFormsPurchaseOrders as $oPurchasesFormPurchaseOrder) {
            $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($oPurchasesFormPurchaseOrder->id_form_request_offer);
            
            if (($bComputeContractingProcedures) || ((!$bComputeContractingProcedures) && (!is_null($oPurchasesFormRequestOffer)) && (!$oPurchasesFormRequestOffer->contracting_procedure))) {
               $nConsumption += PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrderConsumption($oPurchasesFormPurchaseOrder->id);
            }
         }
      }
        
      return $nConsumption;
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('nConsumption', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'FString::STRING_EMPTY', 'FFormat::getFormatPrice(Providers::getProviderConsumptionByYear($oArrayData[$i][\'id\'], date(\'Y\'), false)) . FString::STRING_SPACE . Yii::t(\'system\', \'SYS_EUR\')');
      $this->oExportSpecifications['data'][1] = array('nConsumptionAddContractingProcedures', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'FString::STRING_EMPTY', 'FFormat::getFormatPrice(Providers::getProviderConsumptionByYear($oArrayData[$i][\'id\'], date(\'Y\'), true)) . FString::STRING_SPACE . Yii::t(\'system\', \'SYS_EUR\')');
      
      $this->oExportSpecifications['columns'] = array('name', 'nif', 'account', 'phone', 'mail', 'nConsumption', 'nConsumptionAddContractingProcedures');
        
      return $this->oExportSpecifications; 
   } 
}