<?php

/**
 * This is the model class for table "warehouse_articles".
 *
 * The followings are the available columns in table 'warehouse_articles':
 * @property integer $id
 * @property string $name
 * @property string $model
 * @property string $code_barcode
 * @property string $code_kks
 * @property string $description
 * @property integer $quantity_initial
 * @property integer $quantity
 * @property integer $quantity_min
 * @property string $last_input_date
 * @property string $last_output_date
 * @property string $weight
 * @property string $volume
 * @property string $image
 * @property integer $ipe
 * @property integer $absolete
 * @property integer $commonwealth     
 * @property integer $price_medium 
 * @property integer $id_related_article
 * @property integer $id_equivalent_article
 * @property integer $id_subcategory
 * @property integer $id_location_subcategory
 *
 * The followings are the available model relations:
 * @property WarehouseArticlesSubcategories $idSubcategory
 */
class Articles extends CExportedActiveRecord {
   public $nPriceLast;
   public $nIdProvider;
   public $sLastProvider;
   public $sLastProviderPhone;
   public $sLastProviderMail;
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return Articles the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'articles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),

         array('id_subcategory', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_location_subcategory', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('quantity_min', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
  
         array('name', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('model', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('code_barcode', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('code_kks', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),

         array('quantity_min', 'numerical', 'min'=>0, 'max'=>999999, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>0)), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>999999))),
         array('weight', 'numerical', 'min'=>0, 'max'=>999999.99, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>0)), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>999999.99))),
         array('volume', 'numerical', 'min'=>0, 'max'=>999999.99, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>0)), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>999999.99))),

         array('code_barcode', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         array('code_kks', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),

         array('ipe, absolete, commonwealth', 'boolean'),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, name, description, quantity, quantity_min, id_subcategory, id_location_subcategory', 'safe', 'on'=>'search'),
		);
	}                                  

   public function scopes() {
      return array(
         'orderSubcategoryASC'=>array('order'=>'subcategory.name ASC, t.id ASC'),
         'orderDescriptionASC'=>array('order'=>'t.name ASC'),
      );
   }
   
	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		   'subcategory'=>array(self::BELONGS_TO, 'WarehouseArticlesSubcategories', 'id_subcategory'),
         'location_subcategory'=>array(self::BELONGS_TO, 'WarehouseArticlesLocationsSubcategories', 'id_location_subcategory'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(                                     
         'id'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_ID'),    
         'name'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_NAME'),
         'model'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_MODEL'),
         'code_barcode'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_CODEBARCODE'),
         'code_kks'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_CODEKKS'),
         'description'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_DESCRIPTION'),
         'quantity'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_QUANTITY'),
         'quantity_min'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_QUANTITYMIN'),
         'last_input_date'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_LASTINPUTDATE'),
         'last_output_date'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_LASTOUTPUTDATE'),
         'weight'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_WEIGHT'),
         'volume'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_VOLUME'),
         'nPriceLast'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_PRICELAST'),
         'sLastProvider'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_SLASTPROVIDER'),
         'sLastProviderPhone'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_SLASTPROVIDERPHONE'),
         'sLastProviderMail'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_SLASTPROVIDERMAIL'),
         'image'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_IMAGE'),
         'ipe'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_IPE'),
         'absolete'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_ABSOLETE'),
         'commonwealth'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_COMMONWEALTH'),
         'price_medium'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_PRICEMEDIUM'),
         'id_subcategory'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_IDSUBCATEGORY'),
         'id_location_subcategory'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_IDLOCATIONSUBCATEGORY'),
         'id_related_article'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_IDRELATEDARTICLE'),
         'id_equivalent_article'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_IDEQUIVALENTARTICLE'),
         'provider.name'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_PROVIDERNAME'),
         'subcategory.name'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_SUBCATEGORYNAME'),
		   'subcategory.category.name'=>Yii::t('rainbow', 'MODEL_ARTICLES_FIELD_CATEGORYNAME'), 
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
	public function search($sCodeName = null, $nPageSize = null) {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$oCriteria = new CDbCriteria;

      $oCriteria->with = array('subcategory');
       
      if ((strlen($this->name) > 0) && ($this->name[0] == '%')) {
         $oCriteria->addCondition('t.name LIKE \'' . substr($this->name, 1) . '%\'');
         $oPagination = false;
      }
      else $oCriteria->compare('t.name', $this->name, true); 
      
      $oCriteria->compare('t.model', $this->model, true);
      $oCriteria->compare('t.description', $this->description, true);
      $oCriteria->compare('t.code_kks', $this->code_kks, true);      
      $oCriteria->compare('t.id_location_subcategory', $this->id_location_subcategory);
      $oCriteria->compare('t.id_subcategory', $this->id_subcategory);
      
      if ((!FString::isNullOrEmpty($sCodeName)) && (strlen($sCodeName) > 4)) {
         $sSubcategoryName = substr($sCodeName, 0, 4);
         $sCodeId = substr($sCodeName, 4); 
         
         $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::getWarehouseArticleSubcategoryByPartialName($sSubcategoryName);
         if (!is_null($oWarehouseArticleSubcategory)) {
            $oCriteria->compare('t.id_subcategory', $oWarehouseArticleSubcategory->id);   
         } 
         
         if (strlen($sCodeId) > 0) {
            $oCriteria->compare('t.id', $sCodeId);      
         }  
      }
      else if ((!FString::isNullOrEmpty($sCodeName)) && ((strlen($sCodeName) == 2) || (strlen($sCodeName) == 4))) {
         $sSubcategoryName = $sCodeName;

         $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::getWarehouseArticleSubcategoryByPartialName($sSubcategoryName);
         if (!is_null($oWarehouseArticleSubcategory)) {
            $oCriteria->compare('t.id_subcategory', $oWarehouseArticleSubcategory->id);   
         } 
      }
      
      if ((!is_null($nPageSize)) && (!((strlen($this->name) > 0) && ($this->name[0] == '%')))) {
         $oPagination = array('pageSize'=>$nPageSize);   
      }
      else $oPagination = false;
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'subcategory.name ASC, t.id ASC',
         ),
         'pagination'=>$oPagination,
      ));
	}
   
   public static function getArticle($nId) {
      $oArticle = Articles::model()->findByPk($nId);
      
      return $oArticle;
   }
   
   public static function getArticleByCodeBarcode($sCodeBarcode) {
      $oArticle = Articles::model()->find('code_barcode = \'' . $sCodeBarcode . '\'');
      
      return $oArticle;
   }
                                      
   public static function getArticleName($nId) {
      $oArticle = Articles::getArticle($nId);
      if (!is_null($oArticle)) {
         return Articles::getArticleNameByArticle($oArticle);
      }  
      return FString::STRING_EMPTY;
   }
   
   public static function getArticleCodeName($nId) {
      $oArticle = Articles::model()->findByPk($nId);
      
      if (!is_null($oArticle)) {
         return Articles::getArticleCodeNameByArticle($oArticle); 
      }  
      return FString::STRING_EMPTY;
   }
   
   public static function getArticleNameByArticle($oArticle) {
      return $oArticle->name;    
   }
   
   public static function getArticleCodeNameByArticle($oArticle) {
      return strtoupper(WarehouseArticlesSubcategories::getWarehouseArticleSubcategoryName($oArticle->id_subcategory)) . str_pad($oArticle->id, 4, '0', STR_PAD_LEFT);    
   }
   
   public static function getArticlesByIdSubcategory($nIdSubcategory, $bOrderByName = false) {
      if ($bOrderByName) return Articles::model()->findAll('id_subcategory = ' . $nIdSubcategory . ' ORDER BY name ASC');  
      else return Articles::model()->findAll('id_subcategory = ' . $nIdSubcategory . ' ORDER BY id ASC');      
   }
   
   public static function getArticlesByIdLocationSubcategory($nIdLocationSubcategory, $bOrderByName = false) {
      if ($bOrderByName) return Articles::model()->findAll('id_location_subcategory = ' . $nIdLocationSubcategory . ' ORDER BY name ASC');     
      else return Articles::model()->findAll('id_location_subcategory = ' . $nIdLocationSubcategory . ' ORDER BY id ASC');      
   }
   
   public static function getArticles($nIdArticle = null, $nIdSubcategory = null, $nIdLocation = null, $bOnlyStock = null, $bOnlyAbsolete = null, $bOnlyCommonwealth = null, $bOrderByDescription = false) {
      if ((FString::isNullOrEmpty($nIdArticle)) && (FString::isNullOrEmpty($nIdSubcategory)) && (FString::isNullOrEmpty($nIdLocation)) && (FString::isNullOrEmpty($bOnlyStock)) && (FString::isNullOrEmpty($bOnlyAbsolete))) {
         return Articles::model()->with('subcategory')->findAll(array('order'=>'subcategory.name ASC, t.id ASC'));  
      }
      else {
         $sSentence = FString::STRING_EMPTY;
         
         if (!FString::isNullOrEmpty($nIdArticle)) {
            $sSentence = 't.id = ' . $nIdArticle;
            $bCondition = true;
         }
      
         if (!FString::isNullOrEmpty($nIdSubcategory)) {
            if ($bCondition) $sSentence = 't.id_subcategory = ' . $nIdSubcategory . ' AND ' . $sSentence;
            else $sSentence = 't.id_subcategory = ' . $nIdSubcategory;
            $bCondition = true;
         }
         
         if (!FString::isNullOrEmpty($nIdLocation)) {
            if ($bCondition) $sSentence = 't.id_location_subcategory = ' . $nIdLocation . ' AND ' . $sSentence;
            else $sSentence = 't.id_location_subcategory = ' . $nIdLocation;
            $bCondition = true;
         }
      
         if ((!FString::isNullOrEmpty($bOnlyStock)) && ($bOnlyStock)) {
            if ($bCondition) $sSentence = 't.quantity > 0  AND ' . $sSentence;
            else $sSentence = 't.quantity > 0';
            $bCondition = true;
         }
         
         if ((!FString::isNullOrEmpty($bOnlyAbsolete)) && ($bOnlyAbsolete)) {
            if ($bCondition) $sSentence = 't.absolete = 1  AND ' . $sSentence;
            else $sSentence = 't.absolete = 1';
            $bCondition = true;
         }
         
         if ((!FString::isNullOrEmpty($bOnlyCommonwealth)) && ($bOnlyCommonwealth)) {
            if ($bCondition) $sSentence = 't.commonwealth = 1  AND ' . $sSentence;
            else $sSentence = 't.commonwealth = 1';
         }
         
         if (!$bOrderByDescription) return Articles::model()->with('subcategory')->orderSubcategoryASC()->findAll($sSentence);     
         else return Articles::model()->with('subcategory')->orderDescriptionASC()->findAll($sSentence);     
      } 
   }
   
   public static function getArticlesStockPending() {
      return Articles::model()->findAll('((quantity_min > 0) AND (quantity < quantity_min)) ORDER BY id ASC');   
   }
   
   public static function getArticleLastProvider($nId) {
      $oProvider = array();
      
      $oWarehouseFormInputArticle = WarehouseFormInputArticles::getLastWarehouseFormInputArticleByIdArticle($nId);
      if (!is_null($oWarehouseFormInputArticle)) {
         $oProvider = array($oWarehouseFormInputArticle->formInput->id_provider, $oWarehouseFormInputArticle->formInput->provider);   
      } 
      
      return $oProvider;     
   }
   
   public static function getArticleLastProviderName($nId) {
      $sLastProvider = FString::STRING_EMPTY;
      $oLastProvider = array();
      
      $oWarehouseFormInputArticle = WarehouseFormInputArticles::getLastWarehouseFormInputArticleByIdArticle($nId);
      if (!is_null($oWarehouseFormInputArticle)) {
         $oLastProvider = array($oWarehouseFormInputArticle->formInput->id_provider, $oWarehouseFormInputArticle->formInput->provider);   
      } 
      
      if (count($oLastProvider) > 0) {
         if (!FString::isNullOrEmpty($oLastProvider[0])) {
            $oProvider = Providers::getProvider($oLastProvider[0]);
            if (!is_null($oProvider)) {
               $sLastProvider = $oProvider->name;   
               $sLastProviderPhone = $oProvider->phone;   
               $sLastProviderMail = $oProvider->mail;   
            }
         }
         else {
            if (!FString::isNullOrEmpty($oLastProvider[1])) $sLastProvider = $oLastProvider[1];   
         }   
      }
      
      return $sLastProvider; 
   }
   
   public static function getArticleLastInputDate($nId) {
      $sLastInputArticleDate = FString::STRING_EMPTY;
      
      $oWarehouseFormInputArticles = WarehouseFormInputArticles::getWarehouseFormInputArticlesByIdArticle($nId);
      if (count($oWarehouseFormInputArticles) > 0) $sLastInputArticleDate = date('Y-m-d', strtotime($oWarehouseFormInputArticles[count($oWarehouseFormInputArticles) - 1]->formInput->date));
   
      return $sLastInputArticleDate;
   }
   
   public static function getArticleLastOutputDate($nId) {
      $sLastOutputArticleDate = FString::STRING_EMPTY;
      
      $oWarehouseFormOutputArticles = WarehouseFormOutputArticles::getWarehouseFormOutputArticlesByIdArticle($nId);
      if (count($oWarehouseFormOutputArticles) > 0) $sLastOutputArticleDate = date('Y-m-d', strtotime($oWarehouseFormOutputArticles[count($oWarehouseFormOutputArticles) - 1]->formOutput->date));
   
      return $sLastOutputArticleDate;  
   }
   
   public static function getArticleHistoricalPriceLast($nId, $sMaxDate = null) {
      $sPrice = '0.000';
      
      $oWarehouseFormInputArticle = WarehouseFormInputArticles::getLastWarehouseFormInputArticleByIdArticle($nId, $sMaxDate);
      if (!is_null($oWarehouseFormInputArticle)) {
         $sPrice = $oWarehouseFormInputArticle->price_cost;      
      } 
      
      return $sPrice;   
   }
   
   public static function getArticleHistoricalPriceMedium($nId, $sMaxDate = null) {
      $sPrice = '0.000';

      if (!is_null($sMaxDate)) {
         $oRecordsets = Yii::app()->db->createCommand('SELECT SUM(price_cost * quantity) AS article_price, SUM(quantity) AS article_quantity FROM db_rainbow_warehousemanagement.warehouse_forms_inputs INNER JOIN db_rainbow_warehousemanagement.warehouse_form_input_articles 
                                                       ON db_rainbow_warehousemanagement.warehouse_forms_inputs.id = db_rainbow_warehousemanagement.warehouse_form_input_articles.id_form_input 
                                                       WHERE date <= \'' . $sMaxDate . ' 23:59:59\' AND id_article = ' . $nId)->queryAll();
      }
      else {
         $oRecordsets = Yii::app()->db->createCommand('SELECT SUM(price_cost * quantity) AS article_price, SUM(quantity) AS article_quantity FROM db_rainbow_warehousemanagement.warehouse_form_input_articles
                                                       WHERE id_article = ' . $nId)->queryAll();
      }  
        
      if ((count($oRecordsets) > 0) && ($oRecordsets[0]['article_quantity'] > 0)) {
         $sPrice = $oRecordsets[0]['article_price'] / $oRecordsets[0]['article_quantity'];
      }

      return $sPrice;   
   }
   
   public static function getArticleHistoricalStock($nId, $sMaxDate = null) {
      $nQuantity = 0;
      
      if (!is_null($sMaxDate)) {
         $oArticle = Articles::getArticle($nId);
         if (!is_null($oArticle)) {
            $nQuantity = $oArticle->quantity_initial; 
            
            $oRecordsetsFormInputs = Yii::app()->db->createCommand('SELECT SUM(quantity) AS article_quantity FROM db_rainbow_warehousemanagement.warehouse_forms_inputs INNER JOIN db_rainbow_warehousemanagement.warehouse_form_input_articles 
                                                                    ON db_rainbow_warehousemanagement.warehouse_forms_inputs.id = db_rainbow_warehousemanagement.warehouse_form_input_articles.id_form_input 
                                                                    WHERE date >= \'' . FModuleWarehouseManagement::HISTORICAL_CROSSLINE_DATE . '\' AND date <= \'' . $sMaxDate . ' 23:59:59\' AND id_article = ' . $nId)->queryAll();
                                    
                                                           
            $oRecordsetsFormOutputs = Yii::app()->db->createCommand('SELECT SUM(quantity) AS article_quantity FROM db_rainbow_warehousemanagement.warehouse_forms_outputs INNER JOIN db_rainbow_warehousemanagement.warehouse_form_output_articles 
                                                                     ON db_rainbow_warehousemanagement.warehouse_forms_outputs.id = db_rainbow_warehousemanagement.warehouse_form_output_articles.id_form_output 
                                                                     WHERE date >= \'' . FModuleWarehouseManagement::HISTORICAL_CROSSLINE_DATE . '\' AND date <= \'' . $sMaxDate . ' 23:59:59\' AND id_article = ' . $nId)->queryAll();
         
            if (count($oRecordsetsFormInputs) > 0) {
               $nQuantity += $oRecordsetsFormInputs[0]['article_quantity'];  
            }
            
            if (count($oRecordsetsFormOutputs) > 0) {
               $nQuantity -= $oRecordsetsFormOutputs[0]['article_quantity'];  
            }
         }
      }
      else {
         $oArticle = Articles::getArticle($nId);
         
         if (!is_null($oArticle)) {
            $nQuantity = $oArticle->quantity;  
         }
      }  

      return $nQuantity; 
   }
   
   public function getFullName() {
      return strtoupper(WarehouseArticlesSubcategories::getWarehouseArticleSubcategoryName($this->id_subcategory)) . str_pad($this->id, 4, '0', STR_PAD_LEFT) . ' - ' . $this->name;   
   } 
   
   public function getFullNameWithStock() {
      return strtoupper(WarehouseArticlesSubcategories::getWarehouseArticleSubcategoryName($this->id_subcategory)) . str_pad($this->id, 4, '0', STR_PAD_LEFT) . ' - ' . $this->name . ' (' . $this->quantity . strtolower(Yii::t('system', 'SYS_UNITS_ABBREVIATION')) . ')';   
   }
                                                                           
   public function getExportSpecifications() {    
      $this->oExportSpecifications['data'][0] = array('sLastProvider', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Articles::getArticleLastProviderName($oArrayData[$i][\'id\'])', 'Articles::getArticleLastProviderName($oArrayData[$i][\'id\'])');
      $this->oExportSpecifications['data'][1] = array('id', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Articles::getArticleCodeName(?)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][2] = array('id_subcategory', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'WarehouseArticlesSubcategories::getFullWarehouseArticleSubcategory(?)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][3] = array('id_location_subcategory', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'WarehouseArticlesLocationsSubcategories::getFullWarehouseArticleLocationSubcategory(?)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][4] = array('weight', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, '\'? g\'', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][5] = array('volume', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, '\'? cm³\'', 'FString::STRING_EMPTY');
      
      $this->oExportSpecifications['columns'] = array('id', 'name', 'model', 'id_subcategory', 'sLastProvider', 'id_location_subcategory', 'code_barcode', 'code_kks',  'description', 'weight', 'volume', 'quantity', 'quantity_min');
        
      return $this->oExportSpecifications; 
   }
}