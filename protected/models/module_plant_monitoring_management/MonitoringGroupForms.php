<?php

/**
 * This is the model class for table "monitoring_group_forms".
 *
 * The followings are the available columns in table 'monitoring_group_forms':
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 * The followings are the available model relations:
 * @property MonitoringForms[] $monitoringForms
 */
class MonitoringGroupForms extends CExportedActiveRecord {
   public $oCDbConnection;
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return MonitoringGroupForms the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
   /**
    * @return CDbConnection the database connection used for this class
    */
   public function getDbConnection() {
      return Yii::app()->db_rainbow_plantmonitoringmanagement;
   }
   
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'monitoring_group_forms';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('name', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('description', 'length', 'min'=>3, 'max'=>60, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('name', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, description', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'forms'=>array(self::HAS_MANY, 'MonitoringForms', 'id_group_form'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'), 
			'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGGROUPFORMS_FIELD_NAME'),
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGGROUPFORMS_FIELD_DESCRIPTION'),
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
      // Warning: Please modify the following code to remove attributes that
      // should not be searched.
      
      $oCriteria = new CDbCriteria;

      $oCriteria->compare('name', $this->name, true);
      $oCriteria->compare('description', $this->description, true);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}

   public static function getMonitoringGroupForm($nId) {
      $oMonitoringGroupForm = MonitoringGroupForms::model()->findByPk($nId);
      
      return $oMonitoringGroupForm;
   }
   
   public static function getMonitoringGroupFormName($nId) {
      $oMonitoringGroupForm = MonitoringGroupForms::getMonitoringGroupForm($nId);
      $sDescription = FString::STRING_EMPTY;
      if (!is_null($oMonitoringGroupForm)) {
         $sDescription = $oMonitoringGroupForm->name;
      }
      return $sDescription;  
   }
   
   public static function getMonitoringGroupForms() {
      return MonitoringGroupForms::model()->findAll(array('order'=>'name ASC'));   
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('name', 'description');
        
      return $this->oExportSpecifications; 
   }
}