<?php

/**
 * This is the model class for table "purchases_forms_request_offers_documents".
 *
 * The followings are the available columns in table 'purchases_forms_request_offers_documents':
 * @property integer $id
 * @property string $type
 * @property string $type_description
 * @property string $name
 * @property string $folder
 * @property string $document
 * @property integer $version
 * @property string $date
 * @property integer $id_user
 * @property integer $id_form_request_offer_document
 * @property integer $id_form_request_offer
 *
 * The followings are the available model relations:
 * @property PurchasesFormsRequestOffers $idFormRequestOffer
 */
class PurchasesFormsRequestOffersDocuments extends CActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return PurchasesFormsRequestOffersDocuments the static model class
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
		return 'purchases_forms_request_offers_documents';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('type', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('type_description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('folder', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_user', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_request_offer', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('name', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),

         array('folder', 'match', 'pattern'=>FRegEx::getFolderPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_FOLDER')), 
         array('name', 'match', 'pattern'=>FRegEx::getDocumentPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_DOCUMENT')), 
          
         array('name', 'UniqueAttributesValidator', 'with'=>'id_form_request_offer', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, type_description, name, folder, document, date, id_user, id_form_request_offer_document, id_form_request_offer', 'safe', 'on'=>'search'),
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
			'type'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSDOCUMENTS_FIELD_TYPE'),
			'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSDOCUMENTS_FIELD_NAME'),
			'folder'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSDOCUMENTS_FIELD_FOLDER'),
			'document'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSDOCUMENTS_FIELD_DOCUMENT'),
         'version'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSDOCUMENTS_FIELD_VERSION'),
         'date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSDOCUMENTS_FIELD_DATE'),
         'id_user'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSDOCUMENTS_FIELD_IDUSER'),
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

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC, version ASC',
         ),
         'pagination'=>null,
      ));
	}

   public static function getPurchasesFormRequestOfferDocument($nId) {
      $oPurchasesFormRequestOfferDocument = PurchasesFormsRequestOffersDocuments::model()->findByPk($nId);
      
      return $oPurchasesFormRequestOfferDocument;
   }
                                                     
   public static function getPurchasesFormsRequestOffersDocumentsByIdFormFK($nIdFormFK) {
      return PurchasesFormsRequestOffersDocuments::model()->findAll('id_form_request_offer = ' . $nIdFormFK . ' ORDER BY name ASC, version ASC');   
   }
   
   public static function getPurchasesFormsRequestOffersParentDocumentsByIdFormFK($nIdFormFK) {
      return PurchasesFormsRequestOffersDocuments::model()->findAll('id_form_request_offer = ' . $nIdFormFK . ' AND id_form_request_offer_document IS NULL ORDER BY name ASC, version ASC');   
   }
   
   public static function getPurchasesFormsRequestOffersChildDocumentsByIdFormFK($nIdDocument, $nIdFormFK) {
      return PurchasesFormsRequestOffersDocuments::model()->findAll('id_form_request_offer = ' . $nIdFormFK . ' AND id_form_request_offer_document = ' . $nIdDocument . ' ORDER BY name ASC, version ASC');   
   }
   
   public static function getPurchasesFormsRequestOffersLastChildDocumentByIdFormFK($nIdDocument, $nIdFormFK) {
      return PurchasesFormsRequestOffersDocuments::model()->find('id_form_request_offer = ' . $nIdFormFK . ' AND id_form_request_offer_document = ' . $nIdDocument . ' ORDER BY version DESC');   
   }
}