<?php

/**
 * This is the model class for table "purchases_financial_costs".
 *
 * The followings are the available columns in table 'purchases_financial_costs':
 * @property integer $id
 * @property integer $year
 */
class PurchasesFinancialCosts extends CExportedActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return PurchasesFinancialCosts the static model class
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
		return 'purchases_financial_costs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('year', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
			array('year', 'numerical', 'integerOnly'=>true),
         
         array('year', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, year', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
			'year'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFINANCIALCOSTS_FIELD_YEAR'),
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

		$oCriteria=new CDbCriteria;

		$oCriteria->compare('id', $this->id);
		$oCriteria->compare('year', $this->year);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'year DESC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getPurchasesFinancialCost($nId) {
      $oPurchasesFinancialCost = PurchasesFinancialCosts::model()->findByPk($nId);
      
      return $oPurchasesFinancialCost;
   }
   
   public static function getPurchasesFinancialCostByYear($nYear) {
      $oPurchasesFinancialCost = PurchasesFinancialCosts::model()->find('year = ' . $nYear);
      
      return $oPurchasesFinancialCost;
   }
   
   public static function getPurchasesFinancialCosts() {
      return PurchasesFinancialCosts::model()->findAll(array('order'=>'year DESC'));   
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('year');
        
      return $this->oExportSpecifications; 
   }
}