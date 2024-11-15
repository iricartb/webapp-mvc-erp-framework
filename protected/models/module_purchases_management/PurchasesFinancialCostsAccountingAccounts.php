<?php

/**
 * This is the model class for table "purchases_financial_costs_accounting_accounts".
 *
 * The followings are the available columns in table 'purchases_financial_costs_accounting_accounts':
 * @property integer $id
 * @property string $account
 * @property string $description
 * @property integer $id_financial_cost_line
 *
 * The followings are the available model relations:
 * @property PurchasesFinancialCosts $idFinancialCost
 */
class PurchasesFinancialCostsAccountingAccounts extends CExportedActiveRecord {
    
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
		return 'purchases_financial_costs_accounting_accounts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('account', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
			array('description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_financial_cost_line', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('description', 'length', 'min'=>3, 'max'=>64, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account, description, id_financial_cost_line', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'financial_cost_line'=>array(self::BELONGS_TO, 'PurchasesFinancialCostsLines', 'id_financial_cost_line'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
         'account'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFINANCIALCOSTSACCOUNTINGACCOUNTS_FIELD_ACCOUNT'),
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFINANCIALCOSTSACCOUNTINGACCOUNTS_FIELD_DESCRIPTION'),
			'id_financial_cost_line'=>Yii::t('system', 'SYS_MODEL_FIELD_FK'),
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
		$oCriteria->compare('id_financial_cost_line', $this->id_financial_cost_line);

      if (!is_null($nIdFormFK)) $oCriteria->compare('id_financial_cost_line', $nIdFormFK);
       
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'account ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}

   public static function getPurchasesFinancialCostAccountingAccount($nId) {
      $oPurchasesFinancialCostAccountingAccount = PurchasesFinancialCostsAccountingAccounts::model()->findByPk($nId);
      
      return $oPurchasesFinancialCostAccountingAccount;
   }
   
   public static function getPurchasesFinancialCostAccountingAccounts() {
      return PurchasesFinancialCostsAccountingAccounts::model()->findAll('true ORDER BY id_financial_cost_line DESC, account ASC');   
   }
   
   public static function getPurchasesFinancialCostsAccountingAccountsByIdFormFK($nIdFormFK) {
      return PurchasesFinancialCostsAccountingAccounts::model()->findAll('id_financial_cost_line = ' . $nIdFormFK . ' ORDER BY account ASC');   
   }

   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('account', 'description');
        
      return $this->oExportSpecifications; 
   }
}