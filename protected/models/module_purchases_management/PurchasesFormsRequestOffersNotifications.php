<?php

/**
 * This is the model class for table "purchases_forms_request_offers_notifications".
 *
 * The followings are the available columns in table 'purchases_forms_request_offers_notifications':
 * @property integer $id
 * @property string $start_date
 * @property string $end_date
 * @property string $message
 * @property integer $public
 * @property integer $id_user
 * @property integer $id_form_request_offer
 *
 * The followings are the available model relations:
 * @property PurchasesFormsRequestOffers $idFormRequestOffer
 */
class PurchasesFormsRequestOffersNotifications extends CCompareDatesExportedActiveRecord {
   
   /**
    * @return CDbConnection the database connection used for this class
    */
   public function getDbConnection() {
      return Yii::app()->db_rainbow_purchasesmanagement;
   }

   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return PurchasesFormsRequestOffersNotifications the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
   /**
    * @return string the associated database table name
    */
   public function tableName() {
      return 'purchases_forms_request_offers_notifications';
   }

   /**
    * @return array validation rules for model attributes.
    */
   public function rules(){
      // NOTE: you should only define rules for those attributes that
      // will receive user inputs.
      return array(
         array('start_date', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('end_date', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('message', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_request_offer', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('message', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),

         array('end_date', 'compareDates', 'compareAttribute'=>'start_date', 'operator'=>'>=', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_DATE_RANGE')),                     
         
         array('public', 'boolean'),
         
         // The following rule is used by search().
         // @todo Please remove those attributes that should not be searched.
         array('id, start_date, end_date, message, id_user, id_form_request_offer', 'safe', 'on'=>'search'),
      );
   }
   
   public function scopes() {
      return array(
         'orderRequestOfferDatesASC'=>array('order'=>'form_request_offer.id ASC, t.start_date ASC, t.end_date ASC, t.id DESC'),
      );
   }
   
	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'form_request_offer'=>array(self::BELONGS_TO, 'PurchasesFormsRequestOffers', 'id_form_request_offer'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
         'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
         'start_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSNOTIFICATIONS_FIELD_STARTDATE'),
         'end_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSNOTIFICATIONS_FIELD_ENDDATE'),
         'message'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSNOTIFICATIONS_FIELD_MESSAGE'),
         'id_user'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSNOTIFICATIONS_FIELD_IDUSER'),
         'public'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSNOTIFICATIONS_FIELD_PUBLIC'),
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
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('id',$this->id);
		$oCriteria->compare('start_date',$this->start_date,true);
		$oCriteria->compare('end_date',$this->end_date,true);
		$oCriteria->compare('message',$this->message,true);
		$oCriteria->compare('public',$this->public);
		$oCriteria->compare('id_user',$this->id_user);
		$oCriteria->compare('id_form_request_offer',$this->id_form_request_offer);

      if (!is_null($nIdFormFK)) $oCriteria->compare('id_form_request_offer', $nIdFormFK);
      
		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'start_date ASC, end_date ASC, id DESC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
		));
	}
   
   public static function getPurchasesFormRequestOfferNotification($nId) {
      $oPurchasesFormRequestOfferNotification = PurchasesFormsRequestOffersNotifications::model()->findByPk($nId);
      
      return $oPurchasesFormRequestOfferNotification;
   }
                                                            
   public static function getPurchasesFormsRequestOffersNotificationsByIdFormFK($nIdFormFK) {
      return PurchasesFormsRequestOffersNotifications::model()->findAll('id_form_request_offer = ' . $nIdFormFK . ' ORDER BY start_date ASC, end_date ASC, id DESC');   
   }
   
   public static function getPurchasesFormsRequestOffersNotificationsByDates($sStartDate, $sEndDate) {
      return PurchasesFormsRequestOffersNotifications::model()->with('form_request_offer')->orderRequestOfferDatesASC()->findAll('t.start_date >= \'' . FDate::getEnglishDate($sStartDate) . '\' AND t.end_date <= \'' . FDate::getEnglishDate($sEndDate) . '\'');   
   }
}