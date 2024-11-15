<?php

/**
 * This is the model class for table "purchases_documents_contracting_procedures".
 *
 * The followings are the available columns in table 'purchases_documents_contracting_procedures':
 * @property integer $id
 * @property string $type
 * @property string $description
 * @property string $folder
 */
class PurchasesDocumentsContractingProcedures extends CExportedActiveRecord {
  
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return PurchasesDocumentsContractingProcedures the static model class
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
		return 'purchases_documents_contracting_procedures';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
			array('folder', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),

         array('description', 'length', 'min'=>3, 'max'=>64, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('folder', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('folder', 'match', 'pattern'=>FRegEx::getFolderPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_FOLDER')), 
         
         array('type', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, description, folder', 'safe', 'on'=>'search'),
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
			'type'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESDOCUMENTSCONTRACTINGPROCEDURES_FIELD_TYPE'),      
         'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESDOCUMENTSCONTRACTINGPROCEDURES_FIELD_DESCRIPTION'), 
			'folder'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESDOCUMENTSCONTRACTINGPROCEDURES_FIELD_FOLDER'),    
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
      $oCriteria->compare('description', $this->description, true);
      $oCriteria->compare('folder', $this->folder, true);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'type ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getPurchasesDocumentContractingProcedure($nId) {
      $oPurchasesDocumentContractingProcedure = PurchasesDocumentsContractingProcedures::model()->findByPk($nId);
      
      return $oPurchasesDocumentContractingProcedure;
   }
   
   public static function getPurchasesDocumentsContractingProcedures() {
      $oPurchasesDocumentsContractingProcedures = PurchasesDocumentsContractingProcedures::model()->findAll('true ORDER BY type ASC');
      
      return $oPurchasesDocumentsContractingProcedures;
   }
   
   public static function getPurchasesDocumentContractingProcedureDescription($nId) {
      $oPurchasesDocumentContractingProcedure = PurchasesDocumentsContractingProcedures::getPurchasesDocumentContractingProcedure($nId);
      if (!is_null($oPurchasesDocumentContractingProcedure)) {
         return $oPurchasesDocumentContractingProcedure->description;      
      }  
      return FString::STRING_EMPTY;
   }
  
   public static function getPurchasesDocumentContractingProcedureByType($sType) {
      $oPurchasesDocumentContractingProcedure = PurchasesDocumentsContractingProcedures::model()->find('type = \'' . $sType . '\'');
      
      return $oPurchasesDocumentContractingProcedure;
   }
    
   public function getFullDescription() {
      return FString::castStrToUpper($this->type . ' - ' . $this->description);   
   }
                                                            
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('type', 'description', 'folder');
        
      return $this->oExportSpecifications; 
   }
}