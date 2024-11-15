<?php

/**
 * This is the model class for table "warehouse_forms_outputs".
 *
 * The followings are the available columns in table 'warehouse_forms_outputs':
 * @property integer $id
 * @property string $type
 * @property string $code
 * @property string $owner
 * @property string $comments
 * @property string $date
 * @property integer $id_maintenance_form_task  
 * @property integer $id_user
 * @property integer $id_provider
 * @property string $provider
 * @property string $id_employee
 * @property string $employee
 * @property string $employee_department
 * @property string $id_form_working_part
 * @property integer $data_completed
 *
 * The followings are the available model relations:
 * @property WarehouseFormOutputArticles[] $warehouseFormOutputArticles
 */
class WarehouseFormsOutputs extends CExportedActiveRecord {
   public $nTotal;
   public $sStatus;
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return WarehouseFormsOutputs the static model class
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
		return 'warehouse_forms_outputs';
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

         array('code', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('comments', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('employee', 'length', 'max'=>38),
         array('id_form_working_part', 'length', 'max'=>20),

         array('id_employee', 'numerical'),
         
         array('data_completed', 'boolean'),
         
         array('type', 'YiiConditionalValidator',
            'if'=>array(
               array('type', 'compare', 'compareValue'=>FModuleWarehouseManagement::TYPE_OUTPUT_DEVOLUTION),
            ),
            'then'=>array(                    
               array('code', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         
         array('type', 'YiiConditionalValidator',
            'if'=>array(
               array('type', 'compare', 'compareValue'=>FModuleWarehouseManagement::TYPE_OUTPUT_PLANT),
            ),
            'then'=>array(                    
               array('id_employee', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
          
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, code, owner, comments, date, id_user, id_provider, provider, id_employee, employee, id_form_working_part, data_completed', 'safe', 'on'=>'search'),
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
			'articles'=>array(self::HAS_MANY, 'WarehouseFormOutputArticles', 'id_form_output'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),            
			'type'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE'),
         'code'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_CODE'),
			'owner'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_OWNER'),
			'comments'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_COMMENTS'),
			'date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_DATE'),
         'nTotal'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TOTAL'),
         'sStatus'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_STATUS'),
			'id_user'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_IDUSER'),
         'id_provider'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_IDPROVIDER'),
         'id_employee'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_IDEMPLOYEE'),
         'employee'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_EMPLOYEE'),
         'employee_department'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_EMPLOYEEDEPARTMENT'),
         'id_form_working_part'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_IDFORMWORKINGPART'),
         'provider'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_PROVIDER'),
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
      $oCriteria->compare('employee', $this->employee, true);
		$oCriteria->compare('comments', $this->comments, true);
		$oCriteria->compare('date', FDate::getEnglishDate($this->date), true);
		$oCriteria->compare('id_user', $this->id_user);
		$oCriteria->compare('data_completed', true);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'date DESC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_BIG),
      ));
	}
   
   public static function getWarehouseFormOutput($nId) {
      $oWarehouseFormOutput = WarehouseFormsOutputs::model()->findByPk($nId);
      
      return $oWarehouseFormOutput;
   }
   
   public static function getWarehouseFormOutputTotalPriceCost($nId) {
      $nTotalPriceCost = 0.00;
      
      $oWarehouseFormOutput = WarehouseFormsOutputs::getWarehouseFormOutput($nId);
      if (!is_null($oWarehouseFormOutput)) {
         $oWarehouseFormOutputArticles = WarehouseFormOutputArticles::getWarehouseFormOutputArticlesByIdFormFK($oWarehouseFormOutput->id);
         
         foreach($oWarehouseFormOutputArticles as $oWarehouseFormOutputArticle) {
            $nTotalPriceCost += WarehouseFormOutputArticles::getWarehouseFormOutputArticleTotalPriceCost($oWarehouseFormOutputArticle->id); 
         }
      }  
      
      return $nTotalPriceCost; 
   }
   
   public static function getWarehouseFormsOutputs($bDataCompleted = null, $nIdUser = null, $sType = null, $nIdArticle = null, $bOnlyIPE = false, $nIdProvider = null, $sProvider = null, $sEmployee = null, $nIdSubcategory = null, $nIdLocation = null, $sStartDate = null, $sEndDate = null, $bOrderByDateASC = false, $bOrderByProviderASC = false) {   
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
      
      if (!FString::isNullOrEmpty($sEmployee)) {
         if ($bCondition) $sSentence = 'employee LIKE \'%' . $sEmployee . '%\' AND ' . $sSentence;
         else $sSentence = 'employee LIKE \'%' . $sEmployee . '%\'' . FString::STRING_SPACE . $sSentence;
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
         if ($bCondition) $sSentence = 'date <= \'' . $sEndDate . '\' AND ' . $sSentence;
         else $sSentence = 'date <= \'' . $sEndDate . '\'' . FString::STRING_SPACE . $sSentence;
      }
      
      if ((!FString::isNullOrEmpty($nIdArticle)) || ($bOnlyIPE) || (!FString::isNullOrEmpty($nIdSubcategory)) || (!FString::isNullOrEmpty($nIdLocation))) {
         if ($bOrderByDateASC) return WarehouseFormsOutputs::model()->with('articles')->orderDateASC()->findAll($sSentence);  
         else if ($bOrderByProviderASC) return WarehouseFormsOutputs::model()->with('articles')->orderProviderASC()->findAll($sSentence);
         else return WarehouseFormsOutputs::model()->with('articles')->orderDateDESC()->findAll($sSentence);  
      }
      else {
         if ($bOrderByDateASC) return WarehouseFormsOutputs::model()->orderDateASC()->findAll($sSentence);
         else if ($bOrderByProviderASC) return WarehouseFormsOutputs::model()->orderProviderASC()->findAll($sSentence);
         else return WarehouseFormsOutputs::model()->orderDateDESC()->findAll($sSentence);     
      }       
   }
   
   public static function getWarehouseFormsOutputsByCode($sCode) {
      return WarehouseFormsOutputs::model()->findAll('data_completed = 1 AND code = \'' . $sCode . '\' ORDER BY date DESC');        
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'][0] = array('date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][1] = array('type', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Yii::t(\'frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '\', \'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_?\')', 'FString::STRING_EMPTY');
      
      $this->oExportSpecifications['columns'] = array('owner', 'date', 'type', 'code', 'comments');
        
      return $this->oExportSpecifications; 
   }
}