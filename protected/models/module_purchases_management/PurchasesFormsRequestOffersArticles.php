<?php

/**
 * This is the model class for table "purchases_forms_request_offers_articles".
 *
 * The followings are the available columns in table 'purchases_forms_request_offers_articles':
 * @property integer $id
 * @property string $quantity
 * @property string $description
 * @property string $requirements_date
 * @property string $service
 * @property integer $id_form_request_offer
 *
 * The followings are the available model relations:
 * @property PurchasesFormsRequestOffers $idFormRequestOffer
 */
class PurchasesFormsRequestOffersArticles extends CActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return PurchasesFormsRequestOffersArticles the static model class
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
		return 'purchases_forms_request_offers_articles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('description, quantity, id_form_request_offer', 'required'),

         array('quantity', 'length', 'max'=>12),
         array('quantity', 'numerical', 'min'=>0, 'max'=>999999999.99, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'0')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>'999999999.99'))),
         
         array('description', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('service', 'boolean'),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, quantity, description, requirements_date, id_form_request_offer', 'safe', 'on'=>'search'),
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
			'quantity'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSARTICLES_FIELD_QUANTITY'),
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSARTICLES_FIELD_DESCRIPTION'),
         'requirements_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSARTICLES_FIELD_REQUIREMENTSDATE'),
         'service'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSARTICLES_FIELD_SERVICE'),
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

		$oCriteria->compare('id', $this->id);
		$oCriteria->compare('quantity', $this->quantity);
		$oCriteria->compare('description', $this->description, true);
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


   public static function getPurchasesFormRequestOfferArticle($nId) {
      $oPurchasesFormRequestOfferArticle = PurchasesFormsRequestOffersArticles::model()->findByPk($nId);
      
      return $oPurchasesFormRequestOfferArticle;
   }
                                                            
   public static function getPurchasesFormsRequestOffersArticlesByIdFormFK($nIdFormFK) {
      return PurchasesFormsRequestOffersArticles::model()->findAll('id_form_request_offer = ' . $nIdFormFK . ' ORDER BY id ASC');   
   }
}