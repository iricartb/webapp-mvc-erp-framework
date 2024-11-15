<?php

/**
 * This is the model class for table "purchases_forms_request_offers_lines_objectives".
 *
 * The followings are the available columns in table 'purchases_forms_request_offers_lines_objectives':
 * @property integer $id
 * @property string $type
 * @property string $description
 * @property string $quantity
 * @property string $estimated_date
 * @property string $estimated_price
 * @property string $accomplished_date
 * @property string $accomplished_price
 * @property integer $accomplished
 * @property integer $id_user
 * @property integer $id_financial_cost_line
 * @property integer $id_form_request_offer_line
 *
 * The followings are the available model relations:
 * @property PurchasesFormsRequestOffersLines $idFormRequestOfferLine
 */
class PurchasesFormsRequestOffersLinesObjectives extends CActiveRecord {
   public $bSelected; 
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return PurchasesFormsRequestOffersLinesObjectives the static model class
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
		return 'purchases_forms_request_offers_lines_objectives';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('quantity', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('type', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_request_offer_line', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),

         array('quantity', 'length', 'max'=>12),
         array('quantity', 'numerical', 'min'=>0, 'max'=>999999999.99, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'0')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>'999999999.99'))),
         
         array('estimated_price', 'length', 'max'=>13),
         array('estimated_price', 'numerical', 'min'=>0, 'max'=>999999999.999, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'0')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>'999999999.999'))),
         array('accomplished_price', 'length', 'max'=>13),
         array('accomplished_price', 'numerical', 'min'=>0, 'max'=>999999999.999, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'0')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>'999999999.999'))),
         
         array('accomplished', 'boolean'),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, description, estimated_date, estimated_price, accomplished_date, accomplished_price, accomplished, id_user, id_financial_cost_line, id_form_request_offer_line', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'form_request_offer_line'=>array(self::BELONGS_TO, 'PurchasesFormsRequestOffersLines', 'id_form_request_offer_line'),
         'financial_cost_line'=>array(self::BELONGS_TO, 'PurchasesFinancialCostsLines', 'id_financial_cost_line'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
         'type'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINESOBJECTIVES_FIELD_TYPE'),
         'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINESOBJECTIVES_FIELD_DESCRIPTION'),
         'quantity'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINESOBJECTIVES_FIELD_QUANTITY'),
         'estimated_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINESOBJECTIVES_FIELD_ESTIMATEDDATE'),
         'estimated_price'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINESOBJECTIVES_FIELD_ESTIMATEDPRICE'),
         'accomplished_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINESOBJECTIVES_FIELD_ACCOMPLISHEDDATE'),
         'accomplished_price'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINESOBJECTIVES_FIELD_ACCOMPLISHEDPRICE'),
         'accomplished'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINESOBJECTIVES_FIELD_ACCOMPLISHED'),
         'id_user'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINESOBJECTIVES_FIELD_IDUSER'),
         'id_financial_cost_line'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINESOBJECTIVES_FIELD_IDFINANCIALCOSTLINE'),
         'bSelected'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINESOBJECTIVES_FIELD_BSELECTED'),
			'id_form_request_offer_line'=>Yii::t('system', 'SYS_MODEL_FIELD_FK'),
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
		$oCriteria->compare('id_form_request_offer_line',$this->id_form_request_offer_line);
          
      if (!is_null($nIdFormFK)) $oCriteria->compare('id_form_request_offer_line', $nIdFormFK);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'id ASC',
         ),
         'pagination'=>null,
      ));
	}

   public static function getPurchasesFormRequestOfferLineObjective($nId) {
      $oPurchasesFormRequestOfferLineObjective = PurchasesFormsRequestOffersLinesObjectives::model()->findByPk($nId);
      
      return $oPurchasesFormRequestOfferLineObjective;
   }
  
   public static function getPurchasesFormsRequestOffersLinesObjectivesByIdFinancialCostLine($nIdFinancialCostLine) {
      return PurchasesFormsRequestOffersLinesObjectives::model()->with('form_request_offer_line')->findAll('id_financial_cost_line = ' . $nIdFinancialCostLine);   
   }
   
   public static function getPurchasesFormsRequestOffersSelectedLinesObjectivesByIdFinancialCostLine($nIdFinancialCostLine) {
      return PurchasesFormsRequestOffersLinesObjectives::model()->with('form_request_offer_line')->findAll('id_financial_cost_line = ' . $nIdFinancialCostLine . ' AND form_request_offer_line.selected = 1');   
   }
     
   public static function getPurchasesFormsRequestOffersSelectedLinesObjectivesByYearAndIdProvider($nYear, $nIdProvider) {
      return PurchasesFormsRequestOffersLinesObjectives::model()->with(array('financial_cost_line.financial_cost', 'form_request_offer_line'))->findAll('financial_cost.year = ' . $nYear . ' AND form_request_offer_line.id_provider = ' . $nIdProvider . ' AND form_request_offer_line.selected = 1');   
   }
                                                 
   public static function getPurchasesFormsRequestOffersLinesObjectivesByIdFormFK($nIdFormFK) {
      return PurchasesFormsRequestOffersLinesObjectives::model()->findAll('id_form_request_offer_line = ' . $nIdFormFK . ' ORDER BY id ASC');   
   }
}