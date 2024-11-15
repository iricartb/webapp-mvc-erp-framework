<?php

/**
 * This is the model class for table "warehouse_articles_subcategories".
 *
 * The followings are the available columns in table 'warehouse_articles_subcategories':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $id_category
 *
 * The followings are the available model relations:
 * @property WarehouseArticlesCategoriesSubcategories[] $warehouseArticlesCategoriesSubcategories
 */
class WarehouseArticlesSubcategories extends CExportedActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return ArticlesSubcategories the static model class
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
		return 'db_rainbow_warehousemanagement.warehouse_articles_subcategories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_category', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('name', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('description', 'length', 'min'=>3, 'max'=>128, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
          
         array('name', 'UniqueAttributesValidator', 'with'=>'id_category', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, description, id_category', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
         'category'=>array(self::BELONGS_TO, 'WarehouseArticlesCategories', 'id_category'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),
			'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEARTICLESSUBCATEGORIES_FIELD_NAME'),
         'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEARTICLESSUBCATEGORIES_FIELD_DESCRIPTION'),
		   'id_category'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEARTICLESSUBCATEGORIES_FIELD_IDCATEGORY'),
         'category.name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEARTICLESSUBCATEGORIES_FIELD_CATEGORYNAME'),
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

		$oCriteria->compare('name', $this->name, true);
      $oCriteria->compare('description', $this->description, true);
      $oCriteria->compare('id_category', $this->id_category);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}

   public static function getWarehouseArticleSubcategory($nId) {
      $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::model()->findByPk($nId);
      
      return $oWarehouseArticleSubcategory;
   }
                                        
   public static function getWarehouseArticleSubcategoryName($nId) {
      $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::getWarehouseArticleSubcategory($nId);
      if (!is_null($oWarehouseArticleSubcategory)) {
         return $oWarehouseArticleSubcategory->name;      
      }  
      return FString::STRING_EMPTY;
   }
      
   public static function getWarehouseArticlesSubcategoriesByIdCategory($nIdCategory) {
      return WarehouseArticlesSubcategories::model()->findAll('id_category = ' . $nIdCategory);      
   }
   
   public static function getWarehouseArticlesSubcategories() {
      return WarehouseArticlesSubcategories::model()->findAll(array('order'=>'name ASC'));   
   }
   
   public static function getWarehouseArticleSubcategoryByName($sName) {
      return WarehouseArticlesSubcategories::model()->find('name = \'' . $sName . '\'');      
   }
  
   public static function getWarehouseArticleSubcategoryByPartialName($sName) {
      return WarehouseArticlesSubcategories::model()->find('name LIKE \'%' . $sName . '%\'');      
   }
    
   public static function getFullWarehouseArticlesSubcategories() {
      $oWarehouseArticlesSubcategories = WarehouseArticlesSubcategories::model()->with('category')->findAll(array('order'=>'category.name ASC, t.name ASC'));
      
      foreach ($oWarehouseArticlesSubcategories as $oWarehouseArticleSubcategory) {
         $oWarehouseArticleSubcategory->name = WarehouseArticlesSubcategories::getFullWarehouseArticleSubcategory($oWarehouseArticleSubcategory->id);
      }
      return $oWarehouseArticlesSubcategories;   
   }
   
   public static function getFullWarehouseArticleSubcategory($nIdSubcategory) {
      $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::getWarehouseArticleSubcategory($nIdSubcategory);
      $sName = FString::STRING_EMPTY;
      if (!is_null($oWarehouseArticleSubcategory)) {
         if (!FString::isNullOrEmpty($oWarehouseArticleSubcategory->description)) $sName = $oWarehouseArticleSubcategory->category->name . '/' . $oWarehouseArticleSubcategory->name . ' - ' . $oWarehouseArticleSubcategory->description;
         else $sName = $oWarehouseArticleSubcategory->category->name . '/' . $oWarehouseArticleSubcategory->name;
      }
      return $sName;  
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('category.name', 'name', 'description');
        
      return $this->oExportSpecifications; 
   }
}
