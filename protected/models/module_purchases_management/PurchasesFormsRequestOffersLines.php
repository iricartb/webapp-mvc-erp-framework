<?php

/**
 * This is the model class for table "purchases_forms_request_offers_lines".
 *
 * The followings are the available columns in table 'purchases_forms_request_offers_lines':
 * @property integer $id
 * @property string $offer
 * @property integer $price
 * @property string $start_date
 * @property string $notify_date
 * @property integer $notify
 * @property integer $selected
 * @property integer $id_provider
 * @property integer $id_form_request_offer
 *
 * The followings are the available model relations:
 * @property Providers $idProvider
 * @property PurchasesFormsRequestOffers $idFormRequestOffer
 */
class PurchasesFormsRequestOffersLines extends CActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return PurchasesFormsRequestOffersLines the static model class
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
		return 'purchases_forms_request_offers_lines';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('start_date', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_provider', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_request_offer', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('price', 'length', 'max'=>14),
         array('price', 'numerical', 'min'=>0, 'max'=>9999999999.99, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'0')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>'9999999999.99'))),
         array('offer', 'length', 'max'=>255),
        
         array('notify, selected', 'boolean'),
              
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, start_date, notify_date, notify, id_provider, offer, id_form_request_offer', 'safe', 'on'=>'search'),
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
			'form_request_offer'=>array(self::BELONGS_TO, 'PurchasesFormsRequestOffers', 'id_form_request_offer'),
         'forms_request_offers_lines_objectives'=>array(self::HAS_MANY, 'PurchasesFormsRequestOffersLinesObjectives', 'id_form_request_offer_line'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
         'price'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINES_FIELD_PRICE'),
         'offer'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINES_FIELD_OFFER'),  
			'start_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINES_FIELD_STARTDATE'),
			'notify_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINES_FIELD_NOTIFYDATE'),
			'notify'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINES_FIELD_NOTIFY'),
			'id_provider'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINES_FIELD_IDPROVIDER'),
			'id_form_request_offer'=>Yii::t('system', 'SYS_MODEL_FIELD_FK'),
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
		$oCriteria->compare('start_date', FDate::getEnglishDate($this->start_date), true);
      $oCriteria->compare('start_date', FDate::getEnglishDate($this->notify_date), true);
		$oCriteria->compare('id_form_request_offer', $this->id_form_request_offer);

      if (!is_null($nIdFormFK)) $oCriteria->compare('id_form_request_offer', $nIdFormFK);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'id ASC',
         ),
         'pagination'=>null,
      ));
	}
   
   public static function getPurchasesFormRequestOfferLine($nId) {
      $oPurchasesFormRequestOfferLine = PurchasesFormsRequestOffersLines::model()->findByPk($nId);
      
      return $oPurchasesFormRequestOfferLine;
   }
   
   public static function getPurchasesFormRequestOfferLineByProviderAndIdFormFK($nIdProvider, $nIdFormFK) {
      $oPurchasesFormRequestOfferLine = PurchasesFormsRequestOffersLines::model()->find('id_provider = ' . $nIdProvider . ' AND id_form_request_offer = ' . $nIdFormFK);
      
      return $oPurchasesFormRequestOfferLine;
   }
                                                            
   public static function getPurchasesFormsRequestOffersLinesByIdFormFK($nIdFormFK) {
      return PurchasesFormsRequestOffersLines::model()->findAll('id_form_request_offer = ' . $nIdFormFK . ' ORDER BY id ASC');   
   }
   
   public static function getPurchasesFormRequestOfferLineProviderMail($nId) {
      $sProviderMail = FString::STRING_EMPTY;
      $oPurchasesFormRequestOfferLine = PurchasesFormsRequestOffersLines::getPurchasesFormRequestOfferLine($nId);
      
      if (!is_null($oPurchasesFormRequestOfferLine)) {
         $oProvider = Providers::getProvider($oPurchasesFormRequestOfferLine->id_provider);
         if ((!is_null($oProvider)) && (!FString::isNullOrEmpty($oProvider->mail))) {
            $sProviderMail = $oProvider->mail;
         }
      }
      
      return $sProviderMail;
   }
}