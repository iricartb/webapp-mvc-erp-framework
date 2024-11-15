<?php

/**
 * This is the model class for table "purchases_forms_request_offers".
 *
 * The followings are the available columns in table 'purchases_forms_request_offers':
 * @property integer $id
 * @property string $owner
 * @property string $user_accept_discard
 * @property string $description
 * @property string $department
 * @property string $status
 * @property string $discard_reason
 * @property string $start_date
 * @property string $accept_date
 * @property integer $id_user
 * @property integer $id_financial_cost_line
 * @property integer $contracting_procedure
 * @property string $contracting_procedure_project_code
 * @property string $contracting_procedure_type
 * @property string $contracting_procedure_service
 * @property string $contracting_procedure_expedient
 * @property string $contracting_procedure_expedient_external
 * @property string $contracting_procedure_start_date
 * @property string $contracting_procedure_end_date
 * @property string $contracting_procedure_comments
 * @property string $id_contracting_procedure
 * @property integer $data_completed 
 *
 * The followings are the available model relations:
 * @property PurchasesFinancialCostsLines $idFinancialCostLine
 */
class PurchasesFormsRequestOffers extends CCompareDatesExportedActiveRecord {
   public $type;
   public $nIdProvider;
   public $sFilterStatusCreated;
   public $sFilterStatusPending;
   public $sFilterStatusAccepted;
   public $sFilterStatusDiscarded;
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return PurchasesFormsRequestOffers the static model class
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
		return 'purchases_forms_request_offers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('owner', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('status', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('start_date', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_user', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),  
                                       
         array('id_financial_cost_line, department', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY'), 'on'=>'request_offers'), 
         array('contracting_procedure_type, contracting_procedure_expedient', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY'), 'on'=>'contracting_procedure'),
         
         array('status', 'YiiConditionalValidator',
            'if'=>array(
               array('status', 'compare', 'compareValue'=>FModulePurchasesManagement::STATUS_DISCARDED),
            ),
            'then'=>array(
               array('discard_reason', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         
         array('description', 'length', 'min'=>3, 'max'=>1024, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('contracting_procedure_comments', 'length', 'min'=>3, 'max'=>1024, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('contracting_procedure_service', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('discard_reason', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),

         array('contracting_procedure_project_code', 'length', 'min'=>3, 'max'=>12, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
          
         array('contracting_procedure_expedient', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('contracting_procedure_expedient_external', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
          
         array('contracting_procedure_expedient', 'match', 'pattern'=>FRegEx::getAlphaNumericWithSlashNoSpacePattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_ALPHANUMERIC_SLASH_NO_SPACE')), 

         array('contracting_procedure_end_date', 'YiiConditionalValidator',
            'if'=>array(
               array('contracting_procedure_end_date', 'compare', 'operator'=>'!=', 'compareValue'=>FString::STRING_EMPTY),
            ),
            'then'=>array(
               array('contracting_procedure_end_date', 'compareDates', 'compareAttribute'=>'contracting_procedure_start_date', 'operator'=>'>=', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_DATE_RANGE')),               
            ),
         ),

         array('contracting_procedure_expedient', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
           
         array('data_completed', 'boolean'),
          
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, owner, description, department, start_date, accept_date, data_completed', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		   'financial_cost_line'=>array(self::BELONGS_TO, 'PurchasesFinancialCostsLines', 'id_financial_cost_line'),
         'forms_request_offers_lines' => array(self::HAS_MANY, 'PurchasesFormsRequestOffersLines', 'id_form_request_offer'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),            
			'owner'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_OWNER'),
         'user_accept_discard'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_USERACCEPTDISCARD'),
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_DESCRIPTION'),
         'department'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_DEPARTMENT'),
			'status'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_STATUS'),
			'discard_reason'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_DISCARDREASON'),
			'start_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_STARTDATE'),
			'accept_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_ACCEPTDATE'),
         'type'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_TYPE'),
         'id_financial_cost_line'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_IDFINANCIALCOSTLINE'),         
         'id_contracting_procedure'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_IDCONTRACTINGPROCEDURE'),
         'contracting_procedure_project_code'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDUREPROJECTCODE'),
         'contracting_procedure_type'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDURETYPE'),
         'contracting_procedure_service'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDURESERVICE'),
         'contracting_procedure_expedient'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDUREEXPEDIENT'),
         'contracting_procedure_expedient_external'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDUREEXPEDIENTEXTERNAL'),
         'contracting_procedure_start_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDURESTARTDATE'),
         'contracting_procedure_end_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDUREENDDATE'),
         'contracting_procedure_comments'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_CONTRACTINGPROCEDURECOMMENTS'),
         'nIdProvider'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERS_FIELD_IDPROVIDER'),
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
	public function search($bContractingProcedure = null, $sFilterStatusCreated = null, $sFilterStatusPending = null, $sFilterStatusAccepted = null, $sFilterStatusDiscarded = null, $nIdProvider = null, $bShowFormsManagementContractingProcedure = false, $nPageSize = null) {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$oCriteria = new CDbCriteria;

      $oCriteria->compare('t.id', $this->id);
		$oCriteria->compare('t.owner', $this->owner, true);
      $oCriteria->compare('t.description', $this->description, true);
      $oCriteria->compare('t.department', $this->department);
      $oCriteria->compare('t.contracting_procedure_expedient', $this->contracting_procedure_expedient, true);
      $oCriteria->compare('t.contracting_procedure_service', $this->contracting_procedure_service, true);
      $oCriteria->compare('t.accept_date', FDate::getEnglishDate($this->accept_date), true);
      $oCriteria->compare('t.start_date', FDate::getEnglishDate($this->start_date), true);
      $oCriteria->compare('t.id_financial_cost_line', $this->id_financial_cost_line);
      
      if ($bShowFormsManagementContractingProcedure) {
         $oCriteria->with = array('forms_request_offers_lines', 'forms_request_offers_lines.forms_request_offers_lines_objectives');
         $oCriteria->together = true;
         
         $sCondition = 't.contracting_procedure = 1 AND t.data_completed = 1 AND t.status = \'' . FModulePurchasesManagement::STATUS_ACCEPTED . '\' AND forms_request_offers_lines.selected = 1 AND (forms_request_offers_lines_objectives.id > 0)';
         
         if (!FString::isNullOrEmpty($nIdProvider)) {
            $sCondition .= ' AND forms_request_offers_lines.id_provider = ' . $nIdProvider;   
         }
                    
         $oCriteria->addCondition($sCondition); 
      }
      else {
         if (!is_null($bContractingProcedure)) {
            if ($bContractingProcedure) $oCriteria->compare('contracting_procedure', 1);  
            else $oCriteria->compare('contracting_procedure', 0); 
         }

         $oCriteria->compare('data_completed', true);
           
         if ((!is_null($this->sFilterStatusCreated)) || (!is_null($this->sFilterStatusPending))  || (!is_null($this->sFilterStatusAccepted)) || (!is_null($this->sFilterStatusDiscarded)) || (!is_null($sFilterStatusCreated)) || (!is_null($sFilterStatusPending)) || (!is_null($sFilterStatusAccepted)) || (!is_null($sFilterStatusDiscarded))) {
            $sStatusCondition = FString::STRING_EMPTY;
            if (((!is_null($this->sFilterStatusCreated)) && ($this->sFilterStatusCreated)) || ((!is_null($sFilterStatusCreated)) && ($sFilterStatusCreated))) $sStatusCondition = 'status = \'' . FModulePurchasesManagement::STATUS_CREATED . '\'';
            if (((!is_null($this->sFilterStatusPending)) && ($this->sFilterStatusPending)) || ((!is_null($sFilterStatusPending)) && ($sFilterStatusPending))) {
               if (strlen($sStatusCondition) > 0) $sStatusCondition .= ' OR status = \'' . FModulePurchasesManagement::STATUS_PENDING . '\''; 
               else $sStatusCondition = 'status = \'' . FModulePurchasesManagement::STATUS_PENDING . '\'';
            }
            if (((!is_null($this->sFilterStatusAccepted)) && ($this->sFilterStatusAccepted)) || ((!is_null($sFilterStatusAccepted)) && ($sFilterStatusAccepted))) {
               if (strlen($sStatusCondition) > 0) $sStatusCondition .= ' OR status = \'' . FModulePurchasesManagement::STATUS_ACCEPTED . '\''; 
               else $sStatusCondition = 'status = \'' . FModulePurchasesManagement::STATUS_ACCEPTED . '\'';
            }
            if (((!is_null($this->sFilterStatusDiscarded)) && ($this->sFilterStatusDiscarded)) || ((!is_null($sFilterStatusDiscarded)) && ($sFilterStatusDiscarded))) {
               if (strlen($sStatusCondition) > 0) $sStatusCondition .= ' OR status = \'' . FModulePurchasesManagement::STATUS_DISCARDED . '\''; 
               else $sStatusCondition = 'status = \'' . FModulePurchasesManagement::STATUS_DISCARDED . '\'';
            }
            
            if ($sStatusCondition != FString::STRING_EMPTY) $oCriteria->addCondition($sStatusCondition);
            else $oCriteria->addCondition('false');
         }
      }
      
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
              
   public static function getPurchasesFormRequestOffer($nId) {
      $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::model()->findByPk($nId);
      
      return $oPurchasesFormRequestOffer;
   }
   
   public static function getPurchasesLastCompletedFormRequestOfferContractingProcedure() {
      $oPurchasesFormContractingProcedure = PurchasesFormsRequestOffers::model()->find('contracting_procedure = 1 AND data_completed = 1 AND contracting_procedure_expedient IS NOT NULL ORDER BY id DESC');
      
      return $oPurchasesFormContractingProcedure;
   }
   
   public static function getPurchasesFormsRequestOffers($bContractingProcedure = null, $bDataCompleted = null, $nIdUser = null, $nIdFinancialCostLine = null, $sStatus = null) {
      if ((is_null($bContractingProcedure)) && (is_null($bDataCompleted)) && (is_null($nIdUser)) && (is_null($nIdFinancialCostLine))) $sSentence = 'true ORDER BY id DESC';
      else $sSentence = 'ORDER BY id DESC';
      $bCondition = false;
       
      if (!is_null($bContractingProcedure)) { 
         if ($bContractingProcedure) $sSentence = 'contracting_procedure = 1' . FString::STRING_SPACE . $sSentence;
         else $sSentence = 'contracting_procedure = 0' . FString::STRING_SPACE . $sSentence;
         
         $bCondition = true;
      }
      
      if (!is_null($bDataCompleted)) { 
         if ($bDataCompleted) {
            if ($bCondition) $sSentence = 'data_completed = 1' . ' AND ' . $sSentence;
            else $sSentence = 'data_completed = 1' . FString::STRING_SPACE . $sSentence;
         }
         else {
            if ($bCondition) $sSentence = 'data_completed = 0' . ' AND ' . $sSentence;
            else $sSentence = 'data_completed = 0' . FString::STRING_SPACE . $sSentence;
         }
         
         $bCondition = true;
      }
              
      if (!is_null($nIdUser)) {
         if ($bCondition) $sSentence = 'id_user = ' . $nIdUser . ' AND ' . $sSentence;
         else $sSentence = 'id_user = ' . $nIdUser . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!is_null($nIdFinancialCostLine)) {
         if ($bCondition) $sSentence = 'id_financial_cost_line = ' . $nIdFinancialCostLine . ' AND ' . $sSentence;
         else $sSentence = 'id_financial_cost_line = ' . $nIdFinancialCostLine . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!is_null($sStatus)) {
         if ($bCondition) $sSentence = 'status = \'' . $sStatus . '\' AND ' . $sSentence;
         else $sSentence = 'status = \'' . $sStatus . '\'' . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      return PurchasesFormsRequestOffers::model()->findAll($sSentence);        
   }
   
   public static function getPurchasesFormRequestOfferSelectedProvider($nId) {
      $nIdProvider = 0;
      $bFindPurchaseFormRequestOfferLine = false;
      $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::model()->findByPk($nId);
      
      if (!is_null($oPurchasesFormRequestOffer)) {
         if ($oPurchasesFormRequestOffer->status == FModulePurchasesManagement::STATUS_ACCEPTED) {
            $oPurchasesFormsRequestOffersLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oPurchasesFormRequestOffer->id);
            foreach($oPurchasesFormsRequestOffersLines as $oPurchasesFormRequestOfferLine) {
               if (!$bFindPurchaseFormRequestOfferLine) {
                  if ($oPurchasesFormRequestOfferLine->selected) {
                     $nIdProvider = $oPurchasesFormRequestOfferLine->id_provider;
                     
                     $bFindPurchaseFormRequestOfferLine = true;
                  }
               }
            }   
         }
      }  
      
      return $nIdProvider; 
   }
   
   public static function getPurchasesFormRequestOfferSelectedPrice($nId) {
      $nPrice = 0;
      $bFindPurchaseFormRequestOfferLine = false;
      $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::model()->findByPk($nId);
      
      if (!is_null($oPurchasesFormRequestOffer)) {
         if ($oPurchasesFormRequestOffer->status == FModulePurchasesManagement::STATUS_ACCEPTED) {
            $oPurchasesFormsRequestOffersLines = PurchasesFormsRequestOffersLines::getPurchasesFormsRequestOffersLinesByIdFormFK($oPurchasesFormRequestOffer->id);
            foreach($oPurchasesFormsRequestOffersLines as $oPurchasesFormRequestOfferLine) {
               if (!$bFindPurchaseFormRequestOfferLine) {
                  if ($oPurchasesFormRequestOfferLine->selected) {
                     $nPrice = $oPurchasesFormRequestOfferLine->price;
                     
                     $bFindPurchaseFormRequestOfferLine = true;
                  }
               }
            }   
         }
      }  
      
      return $nPrice; 
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('start_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][1] = array('accept_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');

      $this->oExportSpecifications['columns'] = array('id', 'owner', 'user_accept_discard', 'description', 'discard_reason', 'start_date', 'accept_date');
        
      return $this->oExportSpecifications; 
   }
}