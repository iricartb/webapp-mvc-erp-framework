<?php

/**
 * This is the model class for table "monitoring_forms_turn_round_forms".
 *
 * The followings are the available columns in table 'monitoring_forms_turn_round_forms':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 * @property string $comments
 * @property string $status
 * @property integer $id_form_turn_round_group_form
 *
 * The followings are the available model relations:
 * @property MonitoringFormsTurnRoundsGroupForms $idFormTurnRoundGroupForm
 * @property MonitoringFormsTurnRoundsFormsQuestions[] $monitoringFormsTurnRoundsFormsQuestions
 */
class MonitoringFormsTurnRoundForms extends CActiveRecord {
   public $oCDbConnection;
   
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
		return 'monitoring_forms_turn_round_forms';
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
         array('start_date', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('status', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_turn_round_group_form', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('comments', 'length', 'max'=>512),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, description, start_date, end_date, status, id_form_turn_round_group_form', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'formTurnRoundGroupForm'=>array(self::BELONGS_TO, 'MonitoringFormsTurnRoundGroupForms', 'id_form_turn_round_group_form'),
			'formsTurnRoundFormsQuestions'=>array(self::HAS_MANY, 'MonitoringFormsTurnRoundFormsQuestions', 'id_form_turn_round_form'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),   
			'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDSFORMS_FIELD_NAME'),
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDSFORMS_FIELD_DESCRIPTION'),
			'start_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDSFORMS_FIELD_STARTDATE'),
			'end_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDSFORMS_FIELD_ENDDATE'),
			'status'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDSFORMS_FIELD_STATUS'),
         'comments'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDSFORMS_FIELD_COMMENTS'),
			'id_form_turn_round_group_form'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDSFORMS_FIELD_IDFORMTURNROUNDGROUPFORM'),
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

      $oCriteria->with = array('formTurnRoundGroupForm');
      $oCriteria->together = true;
      
      $oCriteria->compare('name', $this->name, true);
      $oCriteria->compare('description', $this->description, true);
      $oCriteria->compare('start_date', $this->start_date, true);
      $oCriteria->compare('end_date', $this->end_date, true);
      $oCriteria->compare('status', $this->status, true);
      $oCriteria->compare('id_form_turn_round_group_form', $this->id_form_turn_round_group_form);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'formTurnRoundGroupForm.name ASC, t.name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}
   
   public static function getMonitoringFormsTurnRoundForm($nId) {
      $oMonitoringFormsTurnRoundForm = MonitoringFormsTurnRoundForms::model()->findByPk($nId);
      
      return $oMonitoringFormsTurnRoundForm;
   }
   
   public static function getMonitoringFormsTurnRoundForms() {
      return MonitoringFormsTurnRoundForms::model()->with('formTurnRoundGroupForm')->findAll(array('order'=>'formTurnRoundGroupForm.name ASC, t.name ASC'));   
   }
   
   public static function getFullMonitoringFormsTurnRoundForms() {
      $oMonitoringFormsTurnRoundForms = MonitoringFormsTurnRoundForms::model()->with('formTurnRoundGroupForm')->findAll(array('order'=>'formTurnRoundGroupForm.name ASC, t.name ASC'));   
               
      foreach ($oMonitoringFormsTurnRoundForms as $oMonitoringFormsTurnRoundForm) {
         $oMonitoringFormsTurnRoundForm->name = MonitoringFormsTurnRoundForms::getFullMonitoringFormsTurnRoundForm($oMonitoringFormsTurnRoundForm);
      }
      return $oMonitoringFormsTurnRoundForms;   
   }
   
   public static function getFullMonitoringFormsTurnRoundForm($oMonitoringFormsTurnRoundForm) {
      return $oMonitoringFormsTurnRoundForm->formTurnRoundGroupForm->name . '/' . $oMonitoringFormsTurnRoundForm->name;      
   }
   
   public static function getMonitoringFormsTurnRoundFormsByIdFormFK($nIdFormFK, $bOrderEndDateASC = false) {
      if (!$bOrderEndDateASC) return MonitoringFormsTurnRoundForms::model()->findAll('id_form_turn_round_group_form = ' . $nIdFormFK); 
      else return MonitoringFormsTurnRoundForms::model()->findAll('id_form_turn_round_group_form = ' . $nIdFormFK . ' ORDER BY end_date ASC');            
   }
}