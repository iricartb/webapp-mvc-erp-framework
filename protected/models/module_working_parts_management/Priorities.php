<?php

/**
 * This is the model class for table "priorities".
 *
 * The followings are the available columns in table 'priorities':
 * @property integer $id
 * @property string $description
 * @property integer $priority
 */
class Priorities extends CExportedActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Priorities the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection() {
		return Yii::app()->db_rainbow_workingpartsmanagement;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'priorities';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('priority', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('description', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),

         array('priority', 'match', 'pattern'=>FRegEx::getNumericPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_ONLY_NUMERIC')),
         array('priority', 'numerical', 'min'=>1, 'max'=>10, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'1')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>'10'))),
         
         array('description', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('description, priority', 'safe', 'on'=>'search'),
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
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_PRIORITIES_FIELD_DESCRIPTION'),
			'priority'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_PRIORITIES_FIELD_PRIORITY'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('description', $this->description, true);
		$oCriteria->compare('priority', $this->priority);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'priority ASC, description ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}

   public static function getPriority($nId) {
      $oPriority = Priorities::model()->findByPk($nId);
      
      return $oPriority;
   }
   
   public static function getPriorityByDescription($sDescription) {
      $oPriority = Priorities::model()->find('description = \'' . $sDescription . '\'');
      
      return $oPriority;  
   }
   
   public static function getPriorities() {
      return Priorities::model()->findAll(array('order'=>'priority ASC, description ASC'));      
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('description', 'priority');
        
      return $this->oExportSpecifications; 
   }
}