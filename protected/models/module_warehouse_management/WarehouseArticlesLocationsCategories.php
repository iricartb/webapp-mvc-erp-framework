<?php

/**
 * This is the model class for table "warehouse_articles_locations_categories".
 *
 * The followings are the available columns in table 'warehouse_articles_locations_categories':
 * @property integer $id
 * @property string $name
 *
 */
class WarehouseArticlesLocationsCategories extends CExportedActiveRecord {
   
   /**
    * @return CDbConnection the database connection used for this class
    */
   public function getDbConnection() {
      return Yii::app()->db_rainbow_warehousemanagement;
   }

   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return ArticlesCategories the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'warehouse_articles_locations_categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('name', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
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
			'subcategories'=>array(self::HAS_MANY, 'WarehouseArticlesLocationsSubcategories', 'id_location_category'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'), 
         'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEARTICLESLOCATIONSCATEGORIES_FIELD_NAME'),
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
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
   }
   
   public static function getWarehouseArticleLocationCategory($nId) {
      $oWarehouseArticleLocationCategory = WarehouseArticlesLocationsCategories::model()->findByPk($nId);
      
      return $oWarehouseArticleLocationCategory;
   }
   
   public static function getWarehouseArticleLocationCategoryName($nId) {
      $oWarehouseArticleLocationCategory = WarehouseArticlesLocationsCategories::getWarehouseArticleLocationCategory($nId);
      if (!is_null($oWarehouseArticleLocationCategory)) {
         return $oWarehouseArticleLocationCategory->name;      
      }  
      return FString::STRING_EMPTY;
   }
   
   public static function getWarehouseArticleLocationCategoryByName($sName) {
      $oWarehouseArticleLocationCategory = WarehouseArticlesLocationsCategories::model()->find('name = \'' . $sName . '\'');
      
      return $oWarehouseArticleLocationCategory;   
   }

   public static function getWarehouseArticlesLocationsCategories() {
      return WarehouseArticlesLocationsCategories::model()->findAll(array('order'=>'name ASC'));   
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('name');
        
      return $this->oExportSpecifications; 
   }        
}