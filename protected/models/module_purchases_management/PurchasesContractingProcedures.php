<?php

/**
 * This is the model class for table "purchases_contracting_procedures".
 *
 * The followings are the available columns in table 'purchases_contracting_procedures':
 * @property integer $id
 * @property string $name
 */
class PurchasesContractingProcedures extends CExportedActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return PurchasesContractingProcedures the static model class
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
		return 'purchases_contracting_procedures';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
			array('name', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('name', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),            
			'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESCONTRACTINGPROCEDURES_FIELD_NAME'),      
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
		$oCriteria->compare('name', $this->name, true);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getPurchasesContractingProcedure($nId) {
      $oPurchasesContractingProcedure = PurchasesContractingProcedures::model()->findByPk($nId);
      
      return $oPurchasesContractingProcedure;
   }
   
   public static function getPurchasesContractingProcedures() {
      $oPurchasesContractingProcedures = PurchasesContractingProcedures::model()->findAll('true ORDER BY name ASC');
      
      return $oPurchasesContractingProcedures; 
   }
        
   public static function getPurchasesContractingProcedureName($nId) {
      $oPurchasesContractingProcedure = PurchasesContractingProcedures::model()->findByPk($nId);
      
      if (!is_null($oPurchasesContractingProcedure)) {
         return $oPurchasesContractingProcedure->name;
      }
      
      return FString::STRING_EMPTY;
   }
                                                       
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('name');
        
      return $this->oExportSpecifications; 
   }
}