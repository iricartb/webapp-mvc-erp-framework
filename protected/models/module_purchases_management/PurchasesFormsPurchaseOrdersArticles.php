<?php

/**
 * This is the model class for table "purchases_forms_purchase_orders_articles".
 *
 * The followings are the available columns in table 'purchases_forms_purchase_orders_articles':
 * @property integer $id
 * @property string $quantity
 * @property string $description
 * @property string $price
 * @property string $requirements_date
 * @property string $service
 * @property string $comments
 * @property integer $id_form_purchase_order
 *
 * The followings are the available model relations:
 * @property PurchasesFormsPurchaseOrders $idFormPurchaseOrder
 */
class PurchasesFormsPurchaseOrdersArticles extends CActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return PurchasesFormsPurchaseOrdersArticles the static model class
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
		return 'purchases_forms_purchase_orders_articles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('description, quantity, id_form_purchase_order', 'required'),
         
         array('price', 'length', 'max'=>13),
         array('price', 'numerical', 'min'=>0, 'max'=>999999999.999, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'0')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>'999999999.999'))),
         
         array('quantity', 'length', 'max'=>12),
         array('quantity', 'numerical', 'min'=>0, 'max'=>999999999.99, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'0')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>'999999999.99'))),
         
         array('description', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('comments', 'length', 'max'=>256, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT')),
         
         array('service', 'boolean'),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, quantity, description, id_form_purchase_order', 'safe', 'on'=>'search'),
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
			'quantity'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERSARTICLES_FIELD_QUANTITY'),
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERSARTICLES_FIELD_DESCRIPTION'),
         'price'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERSARTICLES_FIELD_PRICE'),
         'requirements_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERSARTICLES_FIELD_REQUIREMENTSDATE'),
         'service'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERSARTICLES_FIELD_SERVICE'),
         'comments'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSPURCHASEORDERSARTICLES_FIELD_COMMENTS'),  
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

		$oCriteria->compare('id', $this->id);
		$oCriteria->compare('quantity', $this->quantity);
		$oCriteria->compare('description', $this->description, true);
		$oCriteria->compare('id_form_purchase_order', $this->id_form_purchase_order);

      if (!is_null($nIdFormFK)) $oCriteria->compare('id_form_purchase_order', $nIdFormFK);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'id ASC',
         ),
         'pagination'=>null,
      ));
	}


   public static function getPurchasesFormPurchaseOrderArticle($nId) {
      $oPurchasesFormPurchaseOrderArticle = PurchasesFormsPurchaseOrdersArticles::model()->findByPk($nId);
      
      return $oPurchasesFormPurchaseOrderArticle;
   }
                                                            
   public static function getPurchasesFormsPurchasesOrdersArticlesByIdFormFK($nIdFormFK) {
      return PurchasesFormsPurchaseOrdersArticles::model()->findAll('id_form_purchase_order = ' . $nIdFormFK . ' ORDER BY id ASC');   
   }
}