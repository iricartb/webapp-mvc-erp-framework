<?php

/**
 * This is the model class for table "warehouse_form_input_articles".
 *
 * The followings are the available columns in table 'warehouse_form_input_articles':
 * @property integer $id
 * @property integer $id_category
 * @property string $category
 * @property integer $id_subcategory
 * @property string $subcategory
 * @property integer $id_location_subcategory
 * @property string $location_subcategory
 * @property integer $id_article
 * @property string $article
 * @property string $article_code_barcode
 * @property string $article_code_kks
 * @property integer $article_ipe
 * @property string $article_description
 * @property string $price_cost
 * @property integer $quantity
 * @property integer $id_form_input
 *
 * The followings are the available model relations:
 * @property WarehouseFormsInputs $idFormInput
 */
class WarehouseFormInputArticles extends CActiveRecord {
   public $nIdArticleSearch;
   public $nTotal;

   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return WarehouseFormInputArticles the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
   /**
    * @return CDbConnection the database connection used for this class
    */
   public function getDbConnection() {
      return Yii::app()->db_rainbow_warehousemanagement;
   }

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'warehouse_form_input_articles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('id_category', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('category', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_subcategory', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('subcategory', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),

         array('id_article', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('article', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_input', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('quantity', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('price_cost', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('article', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),

         array('quantity', 'numerical', 'min'=>1, 'max'=>999999, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>1)), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>999999))),
         array('price_cost', 'numerical', 'min'=>0, 'max'=>999999999.999, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>0)), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>999999999.999))),
            
         array('article_ipe', 'boolean'),
      
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_category, category, id_subcategory, subcategory, id_location_subcategory, location_subcategory, id_article, article, article_description, id_form_input', 'safe', 'on'=>'search'),
		);
	}

   public function scopes() {
      return array(                       
         'orderIdDESC'=>array('order'=>'t.id DESC'),
      );
   }
   
	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'formInput'=>array(self::BELONGS_TO, 'WarehouseFormsInputs', 'id_form_input'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),   
			'id_category'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_IDCATEGORY'),
			'category'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_CATEGORY'),
			'id_subcategory'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_IDSUBCATEGORY'),
			'subcategory'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_SUBCATEGORY'),
         'id_location_subcategory'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_IDLOCATIONSUBCATEGORY'),
         'location_subcategory'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_LOCATIONSUBCATEGORY'),
			'subcategory.name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_SUBCATEGORYNAME'),
         'id_article'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_IDARTICLE'),
			'article'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_ARTICLE'),
         'article_code_barcode'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_ARTICLECODEBARCODE'),
         'article_code_kks'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_ARTICLECODEKKS'),
         'article_ipe'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_ARTICLEIPE'),
			'article_description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_ARTICLEDESCRIPTION'),
			'price_cost'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_PRICECOST'),
			'quantity'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_QUANTITY'),
         'nIdArticleSearch'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_IDARTICLESEARCH'), 
         'nTotal'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMINPUTARTICLES_FIELD_TOTAL'),    
         'id_form_input'=>Yii::t('system', 'SYS_MODEL_FIELD_FK'),
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
		$oCriteria->compare('id_category', $this->id_category);
		$oCriteria->compare('category', $this->category, true);
		$oCriteria->compare('id_subcategory', $this->id_subcategory); 
		$oCriteria->compare('subcategory', $this->subcategory, true);
      $oCriteria->compare('id_location_subcategory', $this->id_location_subcategory); 
      $oCriteria->compare('location_subcategory', $this->location_subcategory, true);
		$oCriteria->compare('id_article', $this->id_article);
		$oCriteria->compare('article', $this->article, true);
		$oCriteria->compare('article_description', $this->article_description, true);
      if (!is_null($nIdFormFK)) $oCriteria->compare('id_form_input', $nIdFormFK);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'article ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getWarehouseFormInputArticle($nId) {
      $oWarehouseFormInputArticle = WarehouseFormInputArticles::model()->findByPk($nId);
      
      return $oWarehouseFormInputArticle;
   }
       
   public static function getWarehouseFormInputArticlesByIdFormFK($nIdFormFK) {
      return WarehouseFormInputArticles::model()->findAll('id_form_input = ' . $nIdFormFK);   
   }
   
   public static function getWarehouseFormInputArticlesByIdArticle($nIdArticle, $sMaxDate = null) {
      if (!is_null($sMaxDate)) {
         return WarehouseFormInputArticles::model()->with('formInput')->findAll('formInput.date <= \'' . $sMaxDate . ' 23:59:59\' AND id_article = ' . $nIdArticle);      
      }
      else return WarehouseFormInputArticles::model()->findAll('id_article = ' . $nIdArticle);   
   }
   
   public static function getLastWarehouseFormInputArticleByIdArticle($nIdArticle, $sMaxDate = null) {
      if (!is_null($sMaxDate)) {
         return WarehouseFormInputArticles::model()->with('formInput')->orderIdDESC()->find('formInput.date <= \'' . $sMaxDate . ' 23:59:59\' AND id_article = ' . $nIdArticle);      
      }
      else return WarehouseFormInputArticles::model()->find('id_article = ' . $nIdArticle . ' ORDER BY id DESC');   
   }
   
   public static function getWarehouseFormInputArticleByIdArticleAndIdFormFK($nIdArticle, $nIdFormFK) {
      return WarehouseFormInputArticles::model()->find('id_article = ' . $nIdArticle . ' AND id_form_input = ' . $nIdFormFK);   
   }
   
   public static function getWarehouseFormInputArticleByIdArticleAndPriceCostAndIdFormFK($nIdArticle, $nPriceCost, $nIdFormFK) {
      return WarehouseFormInputArticles::model()->find('id_article = ' . $nIdArticle . ' AND price_cost = ' . $nPriceCost . ' AND id_form_input = ' . $nIdFormFK);   
   }
        
   public static function getWarehouseFormInputArticleTotalPriceCost($nId) {
      $nTotalPriceCost = 0.00;
      
      $oWarehouseFormInputArticle = WarehouseFormInputArticles::getWarehouseFormInputArticle($nId);
      if (!is_null($oWarehouseFormInputArticle)) {
         $nTotalPriceCost += $oWarehouseFormInputArticle->price_cost * $oWarehouseFormInputArticle->quantity;  
      }  
      
      return $nTotalPriceCost; 
   }
}
