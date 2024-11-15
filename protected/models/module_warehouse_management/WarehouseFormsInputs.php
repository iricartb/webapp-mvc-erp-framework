<?php

/**
 * This is the model class for table "warehouse_forms_inputs".
 *
 * The followings are the available columns in table 'warehouse_forms_inputs':
 * @property integer $id
 * @property string $type
 * @property string $code
 * @property string $owner
 * @property string $comments
 * @property string $date
 * @property integer $id_user
 * @property integer $id_form_purchase_order
 * @property integer $id_provider
 * @property string $provider
 * @property string $status
 * @property integer $data_completed
 *
 * The followings are the available model relations:
 * @property WarehouseFormInputArticles[] $warehouseFormInputArticles
 */
class WarehouseFormsInputs extends CExportedActiveRecord {              
   public $nTotal;
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return WarehouseFormsInputs the static model class
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
		return 'warehouse_forms_inputs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('type', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('owner', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('date', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_user', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('status', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
          
         array('code', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('comments', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
          
         array('data_completed', 'boolean'),
         
         array('type', 'YiiConditionalValidator',
            'if'=>array(
               array('type', 'compare', 'compareValue'=>FModuleWarehouseManagement::TYPE_INPUT_BENEFIT),
            ),
            'then'=>array(                    
               array('id_provider', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         
         array('type', 'YiiConditionalValidator',
            'if'=>array(
               array('type', 'compare', 'compareValue'=>FModuleWarehouseManagement::TYPE_INPUT_REPAIR),
            ),
            'then'=>array(                    
               array('id_provider, code', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         
         array('type', 'YiiConditionalValidator',
            'if'=>array(
               array('type', 'compare', 'compareValue'=>FModuleWarehouseManagement::TYPE_INPUT_WAYBILL),
            ),
            'then'=>array(                    
               array('id_provider, code', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, code, owner, comments, date, id_form_purchase_order, id_user, id_provider, provider, status, data_completed', 'safe', 'on'=>'search'),
		);
	}

   public function scopes() {
      return array(
         'orderDateASC'=>array('order'=>'date ASC'),
         'orderDateDESC'=>array('order'=>'date DESC'),
         'orderProviderASC'=>array('order'=>'provider ASC'),
      );
   }
   
	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'articles'=>array(self::HAS_MANY, 'WarehouseFormInputArticles', 'id_form_input'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),            
			'type'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_TYPE'),
			'code'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_CODE'),
			'owner'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_OWNER'),
			'comments'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_COMMENTS'),
			'date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_DATE'),
         'nTotal'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_TOTAL'),
         'id_form_purchase_order'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_IDFORMPURCHASEORDER'),
			'id_user'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_IDUSER'),
         'id_provider'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_IDPROVIDER'),
         'provider'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_PROVIDER'),
		   'status'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_STATUS'),
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
		$oCriteria->compare('type', $this->type, true);
		$oCriteria->compare('code', $this->code, true);
		$oCriteria->compare('owner', $this->owner, true);
		$oCriteria->compare('comments', $this->comments, true);
		$oCriteria->compare('date', FDate::getEnglishDate($this->date), true);
		$oCriteria->compare('id_user', $this->id_user);
		$oCriteria->compare('data_completed', true);
      $oCriteria->compare('id_provider', $this->id_provider);
      $oCriteria->compare('provider', $this->provider, true);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'date DESC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_BIG),
      ));
	}
   
   public static function getWarehouseFormInput($nId) {
      $oWarehouseFormInput = WarehouseFormsInputs::model()->findByPk($nId);
      
      return $oWarehouseFormInput;
   }
   
   public static function getWarehouseFormInputByCode($sCode) {
      $oWarehouseFormInput = WarehouseFormsInputs::model()->find('code = \'' . $sCode . '\'');
      
      return $oWarehouseFormInput;
   }
   
   public static function getWarehouseFormInputTotalPriceCost($nId) {
      $nTotalPriceCost = 0.00;
      
      $oWarehouseFormInput = WarehouseFormsInputs::getWarehouseFormInput($nId);
      if (!is_null($oWarehouseFormInput)) {
         $oWarehouseFormInputArticles = WarehouseFormInputArticles::getWarehouseFormInputArticlesByIdFormFK($oWarehouseFormInput->id);
         
         foreach($oWarehouseFormInputArticles as $oWarehouseFormInputArticle) {
            $nTotalPriceCost += WarehouseFormInputArticles::getWarehouseFormInputArticleTotalPriceCost($oWarehouseFormInputArticle->id); 
         }
      }  
      
      return $nTotalPriceCost; 
   }

   public static function getWarehouseFormsInputs($bDataCompleted = null, $nIdUser = null, $nIdFormPurchaseOrder = null, $sType = null, $nIdArticle = null, $bOnlyIPE = false, $nIdProvider = null, $sProvider = null, $nIdSubcategory = null, $nIdLocation = null, $sStartDate = null, $sEndDate = null, $bOrderByDateASC = false, $bOrderByProviderASC = false) {   
      if (!is_null($bDataCompleted)) { 
         if ($bDataCompleted) $sSentence = 'data_completed = 1' . FString::STRING_SPACE . $sSentence;
         else $sSentence = 'data_completed = 0' . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!is_null($nIdUser)) {
         if ($bCondition) $sSentence = 'id_user = ' . $nIdUser . ' AND ' . $sSentence;
         else $sSentence = 'id_user = ' . $nIdUser . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }

      if (!is_null($nIdFormPurchaseOrder)) {
         if ($bCondition) $sSentence = 'id_form_purchase_order = ' . $nIdFormPurchaseOrder . ' AND ' . $sSentence;
         else $sSentence = 'id_form_purchase_order = ' . $nIdFormPurchaseOrder . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!FString::isNullOrEmpty($sType)) {
         if ($bCondition) $sSentence = 'type = \'' . $sType . '\' AND ' . $sSentence;
         else $sSentence = 'type = \'' . $sType . '\'' . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!FString::isNullOrEmpty($nIdArticle)) {
         if ($bCondition) $sSentence = 'articles.id_article = ' . $nIdArticle . ' AND ' . $sSentence;
         else $sSentence = 'articles.id_article = ' . $nIdArticle . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if ($bOnlyIPE) {
         if ($bCondition) $sSentence = 'articles.article_ipe = 1 AND ' . $sSentence;
         else $sSentence = 'articles.article_ipe = 1' . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!FString::isNullOrEmpty($nIdProvider)) {
         if ($bCondition) $sSentence = 'id_provider = ' . $nIdProvider . ' AND ' . $sSentence;
         else $sSentence = 'id_provider = ' . $nIdProvider . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!FString::isNullOrEmpty($sProvider)) {
         if ($bCondition) $sSentence = 'provider LIKE \'%' . $sProvider . '%\' AND ' . $sSentence;
         else $sSentence = 'provider LIKE \'%' . $sProvider . '%\'' . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!FString::isNullOrEmpty($nIdSubcategory)) {
         if ($bCondition) $sSentence = 'articles.id_subcategory = ' . $nIdSubcategory . ' AND ' . $sSentence;
         else $sSentence = 'articles.id_subcategory = ' . $nIdSubcategory . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!FString::isNullOrEmpty($nIdLocation)) {
         if ($bCondition) $sSentence = 'articles.id_location_subcategory = ' . $nIdLocation . ' AND ' . $sSentence;
         else $sSentence = 'articles.id_location_subcategory = ' . $nIdLocation . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
     
      if (!FString::isNullOrEmpty($sStartDate)) {
         if ($bCondition) $sSentence = 'date >= \'' . $sStartDate . '\' AND ' . $sSentence;
         else $sSentence = 'date >= \'' . $sStartDate . '\'' . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!FString::isNullOrEmpty($sEndDate)) {
         if ($bCondition) $sSentence = 'date <= \'' . $sEndDate . ' 23:59:59\' AND ' . $sSentence;
         else $sSentence = 'date <= \'' . $sEndDate . '\'' . FString::STRING_SPACE . $sSentence;
      }
                                                                                                         
      if ((!FString::isNullOrEmpty($nIdArticle)) || ($bOnlyIPE) || (!FString::isNullOrEmpty($nIdSubcategory)) || (!FString::isNullOrEmpty($nIdLocation))) {
         if ($bOrderByDateASC) return WarehouseFormsInputs::model()->with('articles')->orderDateASC()->findAll($sSentence);  
         else if ($bOrderByProviderASC) return WarehouseFormsInputs::model()->with('articles')->orderProviderASC()->findAll($sSentence); 
         else return WarehouseFormsInputs::model()->with('articles')->orderDateDESC()->findAll($sSentence);  
      }
      else {
         if ($bOrderByDateASC) return WarehouseFormsInputs::model()->orderDateASC()->findAll($sSentence);  
         else if ($bOrderByProviderASC) return WarehouseFormsInputs::model()->orderProviderASC()->findAll($sSentence); 
         else return WarehouseFormsInputs::model()->orderDateDESC()->findAll($sSentence);     
      }      
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'][0] = array('date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][1] = array('type', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Yii::t(\'frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '\', \'MODEL_WAREHOUSEFORMSINPUTS_FIELD_TYPE_VALUE_?\')', 'FString::STRING_EMPTY');
      
      $this->oExportSpecifications['columns'] = array('owner', 'date', 'type', 'code', 'comments');
        
      return $this->oExportSpecifications; 
   }
}
