<?php

/**
 * This is the model class for table "monitoring_forms_turn_round_forms_questions".
 *
 * The followings are the available columns in table 'monitoring_forms_turn_round_forms_questions':
 * @property integer $id
 * @property string $description
 * @property string $field_type
 * @property integer $field_required
 * @property string $field_value_default
 * @property string $field_value_options
 * @property string $field_value   
 * @property string $field_unit
 * @property integer $id_form_turn_round_form
 *
 * The followings are the available model relations:
 * @property MonitoringFormsTurnRoundForms $idFormTurnRoundForm
 */
class MonitoringFormsTurnRoundFormsQuestions extends CActiveRecord {
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
		return 'monitoring_forms_turn_round_forms_questions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_turn_round_form', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
          
         array('field_value', 'length', 'max'=>10),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('description, field_type, field_value_default, field_value_options, field_value, field_unit, id_form_turn_round_form', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'formTurnRoundForm'=>array(self::BELONGS_TO, 'MonitoringFormsTurnRoundForms', 'id_form_turn_round_form'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),   
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDFORMSQUESTIONS_FIELD_DESCRIPTION'),
			'field_type'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDFORMSQUESTIONS_FIELD_FIELDTYPE'),
			'field_required'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDFORMSQUESTIONS_FIELD_FIELDREQUIRED'),
			'field_value_default'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDFORMSQUESTIONS_FIELD_FIELDVALUEDEFAULT'),
			'field_value_options'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDFORMSQUESTIONS_FIELD_FIELDVALUEOPTIONS'),
			'field_value'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDFORMSQUESTIONS_FIELD_FIELDVALUE'),
			'field_unit'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDFORMSQUESTIONS_FIELD_FIELDUNIT'),
         'id_form_turn_round_form'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSTURNROUNDFORMSQUESTIONS_FIELD_IDFORMTURNROUNDFORM'),
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
	public function search($nIdFormTurnRoundForm = null) {
		// @todo Please modify the following code to remove attributes that should not be searched.

      $oCriteria = new CDbCriteria;

      $oCriteria->with = array('formTurnRoundForm');
      $oCriteria->together = true;
      
      $oCriteria->compare('t.description', $this->description, true);
      $oCriteria->compare('t.field_value_default', $this->field_value_default, true);
      $oCriteria->compare('t.field_value_options', $this->field_value_options, true);
      $oCriteria->compare('t.field_value', $this->field_value, true);
      $oCriteria->compare('t.field_unit', $this->field_unit, true);
      
      if (!is_null($nIdFormTurnRoundForm)) $oCriteria->compare('t.id_form_turn_round_form', $nIdFormTurnRoundForm);
      else $oCriteria->compare('t.id_form_turn_round_form', $this->id_form_turn_round_form);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'formTurnRoundForm.name ASC, t.id ASC',
         ),
         'pagination'=>false,
      ));
	}
   
   public static function getMonitoringFormsTurnRoundFormQuestion($nId) {
      $oMonitoringFormTurnRoundFormQuestion = MonitoringFormsTurnRoundFormsQuestions::model()->findByPk($nId);
      
      return $oMonitoringFormTurnRoundFormQuestion;
   }
   
   public static function getMonitoringFormsTurnRoundFormsQuestionsByIdFormFK($nIdFormFK) {
      return MonitoringFormsTurnRoundFormsQuestions::model()->findAll('id_form_turn_round_form = ' . $nIdFormFK);      
   }
}
