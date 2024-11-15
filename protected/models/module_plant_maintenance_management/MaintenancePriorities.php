<?php

/**
 * This is the model class for table "maintenance_priorities".
 *
 * The followings are the available columns in table 'maintenance_priorities':
 * @property integer $id
 * @property string $description
 * @property integer $priority
 */
class MaintenancePriorities extends CExportedActiveRecord {
   
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
		return Yii::app()->db_rainbow_plantmaintenancemanagement;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'maintenance_priorities';
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
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEPRIORITIES_FIELD_DESCRIPTION'),
			'priority'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'MODEL_MAINTENANCEPRIORITIES_FIELD_PRIORITY'),
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

   public static function getMaintenancePriority($nId) {
      $oMaintenancePriority = MaintenancePriorities::model()->findByPk($nId);
      
      return $oMaintenancePriority;
   }
   
   public static function getMaintenancePriorityByDescription($sDescription) {
      $oMaintenancePriority = MaintenancePriorities::model()->find('description = \'' . $sDescription . '\'');
      
      return $oMaintenancePriority;  
   }
   
   public static function getMaintenancePriorities() {
      return MaintenancePriorities::model()->findAll(array('order'=>'priority ASC, description ASC'));      
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('description', 'priority');
        
      return $this->oExportSpecifications; 
   }
}