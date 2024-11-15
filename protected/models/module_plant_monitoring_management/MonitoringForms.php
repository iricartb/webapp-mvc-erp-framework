<?php

/**
 * This is the model class for table "monitoring_forms".
 *
 * The followings are the available columns in table 'monitoring_forms':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $id_group_form
 *
 * The followings are the available model relations:
 * @property MonitoringGroupForms $idGroupForm
 * @property MonitoringFormsQuestions[] $monitoringFormsQuestions
 */
class MonitoringForms extends CExportedActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return MonitoringForms the static model class
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
		return 'monitoring_forms';
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
         array('id_group_form', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('name', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('description', 'length', 'min'=>3, 'max'=>60, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('name', 'UniqueAttributesValidator', 'with'=>'id_group_form', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, description, id_group_form', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'groupForm'=>array(self::BELONGS_TO, 'MonitoringGroupForms', 'id_group_form'),
			'formsQuestions'=>array(self::HAS_MANY, 'MonitoringFormsQuestions', 'id_form'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),   
			'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMS_FIELD_NAME'),
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMS_FIELD_DESCRIPTION'),
			'id_group_form'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMS_FIELD_IDGROUPFORM'),
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

      $oCriteria->with = array('groupForm');
      $oCriteria->together = true;
      
      $oCriteria->compare('id_group_form', $this->id_group_form);
      $oCriteria->compare('name', $this->name, true);
      $oCriteria->compare('description', $this->description, true);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'groupForm.name ASC, t.name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}

   public static function getMonitoringForm($nId) {
      $oMonitoringForm = MonitoringForms::model()->findByPk($nId);
      
      return $oMonitoringForm;
   }
   
   public static function getMonitoringForms() {
      return MonitoringForms::model()->with('groupForm')->findAll(array('order'=>'groupForm.name ASC, t.name ASC'));   
   }
   
   public static function getFullMonitoringForms() {
      $oMonitoringForms = MonitoringForms::model()->with('groupForm')->findAll(array('order'=>'groupForm.name ASC, t.name ASC'));   
               
      foreach ($oMonitoringForms as $oMonitoringForm) {
         $oMonitoringForm->name = MonitoringForms::getFullMonitoringForm($oMonitoringForm);
      }
      return $oMonitoringForms;   
   }
   
   public static function getFullMonitoringForm($oMonitoringForm) {
      return $oMonitoringForm->groupForm->name . '/' . $oMonitoringForm->name;      
   }
   
   public static function getMonitoringFormsByIdGroupForm($nIdGroupForm) {
      return MonitoringForms::model()->findAll('id_group_form = ' . $nIdGroupForm);      
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('groupForm.name', 'name', 'description');
      
      return $this->oExportSpecifications; 
   }
}