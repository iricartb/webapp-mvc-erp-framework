<?php

/**
 * This is the model class for table "purchases_financial_costs_lines".
 *
 * The followings are the available columns in table 'purchases_financial_costs_lines':
 * @property integer $id
 * @property string $group
 * @property string $concept
 * @property string $department
 * @property integer $max_price
 * @property integer $id_financial_cost
 *
 * The followings are the available model relations:
 * @property PurchasesFinancialCosts $idFinancialCost
 */
class PurchasesFinancialCostsLines extends CExportedActiveRecord {
   public $consumption;
    
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return PurchasesFinancialCostsLines the static model class
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
		return 'purchases_financial_costs_lines';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('group', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
			array('concept', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('department', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('max_price', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_financial_cost', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('group', 'length', 'min'=>3, 'max'=>64, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('concept', 'length', 'min'=>3, 'max'=>64, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('max_price', 'length', 'max'=>14),
         array('max_price', 'numerical', 'min'=>0, 'max'=>9999999999.99, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'0')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>'9999999999.99'))),
        
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, concept, department, max_price, id_financial_cost', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'financial_cost'=>array(self::BELONGS_TO, 'PurchasesFinancialCosts', 'id_financial_cost'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
         'group'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFINANCIALCOSTSLINES_FIELD_GROUP'),
			'concept'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFINANCIALCOSTSLINES_FIELD_CONCEPT'),
         'department'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFINANCIALCOSTSLINES_FIELD_DEPARTMENT'),
			'max_price'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFINANCIALCOSTSLINES_FIELD_MAXPRICE'), 
         'consumption'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFINANCIALCOSTSLINES_FIELD_CONSUMPTION'),
			'id_financial_cost'=>Yii::t('system', 'SYS_MODEL_FIELD_FK'),
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
		$oCriteria->compare('id_financial_cost',$this->id_financial_cost);

      if (!is_null($nIdFormFK)) $oCriteria->compare('id_financial_cost', $nIdFormFK);
       
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'`group` ASC, concept ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}

   public static function getPurchasesFinancialCostLine($nId) {
      $oPurchasesFinancialCostLine = PurchasesFinancialCostsLines::model()->findByPk($nId);
      
      return $oPurchasesFinancialCostLine;
   }
   
   public static function getPurchasesFinancialCostLines($sDepartment = null, $nYear = null) {
      $oCriteria = new CDbCriteria;
      $oCriteria->order = 't.id_financial_cost DESC, t.group ASC, t.concept ASC';
      
      if (!FString::isNullOrEmpty($nYear)) {
         $oCriteria->with = array('financial_cost');
         $oCriteria->together = true;
         
         $oCriteria->addCondition('financial_cost.year = ' . $nYear);  
      }
      
      if (!FString::isNullOrEmpty($sDepartment)) {
         $oCriteria->addCondition('t.department = \'' . $sDepartment . '\'');
      }
     
      return PurchasesFinancialCostsLines::model()->findAll($oCriteria);   
   }
   
   public static function getPurchasesFinancialCostLineConcept($nId) {
      $sPurchasesFinancialCostLineConcept = FString::STRING_EMPTY;
      
      $oPurchasesFinancialCostLine = PurchasesFinancialCostsLines::model()->findByPk($nId);
      if (!is_null($oPurchasesFinancialCostLine)) {
         $sPurchasesFinancialCostLineConcept = $oPurchasesFinancialCostLine->concept;   
      }
      
      return $sPurchasesFinancialCostLineConcept;
   }
   
   public static function getPurchasesFinancialCostsLinesByIdFormFK($nIdFormFK) {
      return PurchasesFinancialCostsLines::model()->findAll('id_financial_cost = ' . $nIdFormFK . ' ORDER BY `group` ASC, concept ASC');   
   }
   
   public static function getPurchasesFinancialCostLinesByYear($nYear) {
      $oCriteria = new CDbCriteria;
      
      $oCriteria->with = array('financial_cost');
      $oCriteria->addCondition('financial_cost.year = ' . $nYear);
      $oCriteria->order = '`group` ASC, concept ASC';
      
      return PurchasesFinancialCostsLines::model()->findAll($oCriteria);  
   }
   
   public static function getPurchasesFinancialCostLineConsumption($nId) {
      $nConsumption = 0;
      
      $oPurchasesFinancialCostLine = PurchasesFinancialCostsLines::getPurchasesFinancialCostLine($nId);
      if (!is_null($oPurchasesFinancialCostLine)) {
         $oPurchasesFormsPurchaseOrders = PurchasesFormsPurchaseOrders::getPurchasesFormsPurchaseOrders(null, $oPurchasesFinancialCostLine->id);
         foreach($oPurchasesFormsPurchaseOrders as $oPurchasesFormPurchaseOrder) {
            $nConsumption += PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrderConsumption($oPurchasesFormPurchaseOrder->id); 
         } 
      }
        
      return $nConsumption;
   }
   
   public static function getPurchasesFinancialCostLineFullDescription($nId, $bShowPrice = true) {
      $sPurchasesFinancialCostLineFullDescription = FString::STRING_EMPTY;
      
      $oPurchasesFinancialCostLine = PurchasesFinancialCostsLines::getPurchasesFinancialCostLine($nId);
      if (!is_null($oPurchasesFinancialCostLine)) {
         $sPurchasesFinancialCostLineFullDescription = $oPurchasesFinancialCostLine->financial_cost->year . ' - ' . $oPurchasesFinancialCostLine->group . '/' . $oPurchasesFinancialCostLine->concept;
         
         if ($bShowPrice) {
            $sPurchasesFinancialCostLineFullDescription .= ' (' . FFormat::getFormatPrice($oPurchasesFinancialCostLine->max_price - PurchasesFinancialCostsLines::getPurchasesFinancialCostLineConsumption($oPurchasesFinancialCostLine->id)) . FString::STRING_SPACE . Yii::t('system', 'SYS_EUR') . ')';        
         }
      }
      
      return $sPurchasesFinancialCostLineFullDescription;
   }
   
   public function getFullDescription() {
      return PurchasesFinancialCostsLines::getPurchasesFinancialCostLineFullDescription($this->id, true);
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('consumption', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, '?', 'PurchasesFinancialCostsLines::getPurchasesFinancialCostLineConsumption($oArrayData[$i][\'id\'])');
      
      $this->oExportSpecifications['columns'] = array('group', 'concept', 'max_price', 'consumption');
        
      return $this->oExportSpecifications; 
   }
}