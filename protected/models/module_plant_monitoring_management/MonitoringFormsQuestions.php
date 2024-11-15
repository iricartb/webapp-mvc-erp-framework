<?php

/**
 * This is the model class for table "monitoring_forms_questions".
 *
 * The followings are the available columns in table 'monitoring_forms_questions':
 * @property integer $id
 * @property string $description
 * @property string $field_type
 * @property integer $field_required
 * @property string $field_value_default
 * @property string $field_value_options
 * @property string $field_unit
 * @property string $repeat
 * @property integer $repeat_weekly_monday
 * @property integer $repeat_weekly_tuesday
 * @property integer $repeat_weekly_wednesday
 * @property integer $repeat_weekly_thursday
 * @property integer $repeat_weekly_friday
 * @property integer $repeat_weekly_saturday
 * @property integer $repeat_weekly_sunday
 * @property integer $repeat_monthly_day_1
 * @property integer $repeat_monthly_day_2
 * @property integer $repeat_monthly_day_3
 * @property integer $repeat_monthly_day_4
 * @property integer $repeat_monthly_day_5
 * @property integer $repeat_monthly_day_6
 * @property integer $repeat_monthly_day_7
 * @property integer $repeat_monthly_day_8
 * @property integer $repeat_monthly_day_9
 * @property integer $repeat_monthly_day_10
 * @property integer $repeat_monthly_day_11
 * @property integer $repeat_monthly_day_12
 * @property integer $repeat_monthly_day_13
 * @property integer $repeat_monthly_day_14
 * @property integer $repeat_monthly_day_15
 * @property integer $repeat_monthly_day_16
 * @property integer $repeat_monthly_day_17
 * @property integer $repeat_monthly_day_18
 * @property integer $repeat_monthly_day_19
 * @property integer $repeat_monthly_day_20
 * @property integer $repeat_monthly_day_21
 * @property integer $repeat_monthly_day_22
 * @property integer $repeat_monthly_day_23
 * @property integer $repeat_monthly_day_24
 * @property integer $repeat_monthly_day_25
 * @property integer $repeat_monthly_day_26
 * @property integer $repeat_monthly_day_27
 * @property integer $repeat_monthly_day_28
 * @property integer $repeat_monthly_day_29
 * @property integer $repeat_monthly_day_30
 * @property integer $repeat_monthly_day_31
 * @property string $start_hour
 * @property string $end_hour
 * @property integer $id_form
 *
 * The followings are the available model relations:
 * @property MonitoringForms $idForm
 */
class MonitoringFormsQuestions extends CExportedActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return MonitoringFormsQuestions the static model class
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
		return 'monitoring_forms_questions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('description', 'length', 'min'=>3, 'max'=>192, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('field_value_options', 'length', 'max'=>90),
         array('field_value_default', 'length', 'max'=>10),
         array('field_unit', 'length', 'max'=>20),
         
         array('field_required, repeat_weekly_monday, repeat_weekly_tuesday, repeat_weekly_wednesday, repeat_weekly_thursday, repeat_weekly_friday, repeat_weekly_saturday, repeat_weekly_sunday, repeat_monthly_day_1, repeat_monthly_day_2, repeat_monthly_day_3, repeat_monthly_day_4, repeat_monthly_day_5, repeat_monthly_day_6, repeat_monthly_day_7, repeat_monthly_day_8, repeat_monthly_day_9, repeat_monthly_day_10, repeat_monthly_day_11, repeat_monthly_day_12, repeat_monthly_day_13, repeat_monthly_day_14, repeat_monthly_day_15, repeat_monthly_day_16, repeat_monthly_day_17, repeat_monthly_day_18, repeat_monthly_day_19, repeat_monthly_day_20, repeat_monthly_day_21, repeat_monthly_day_22, repeat_monthly_day_23, repeat_monthly_day_24, repeat_monthly_day_25, repeat_monthly_day_26, repeat_monthly_day_27, repeat_monthly_day_28, repeat_monthly_day_29, repeat_monthly_day_30, repeat_monthly_day_31', 'boolean'),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('description, field_type, field_value_default, field_value_options, field_unit, repeat, id_form', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'form'=>array(self::BELONGS_TO, 'MonitoringForms', 'id_form'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),   
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_DESCRIPTION'),
			'field_type'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_FIELDTYPE'),
			'field_required'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_FIELDREQUIRED'),
			'field_value_default'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_FIELDVALUEDEFAULT'),
			'field_value_options'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_FIELDVALUEOPTIONS'),
         'field_unit'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_FIELDUNIT'),
			'repeat'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEAT'),
			'repeat_weekly_monday'=>Yii::t('system', 'SYS_DAY_ABBREVIATION_MONDAY'),
			'repeat_weekly_tuesday'=>Yii::t('system', 'SYS_DAY_ABBREVIATION_TUESDAY'),
			'repeat_weekly_wednesday'=>Yii::t('system', 'SYS_DAY_ABBREVIATION_WEDNESDAY'),
			'repeat_weekly_thursday'=>Yii::t('system', 'SYS_DAY_ABBREVIATION_THURSDAY'),
			'repeat_weekly_friday'=>Yii::t('system', 'SYS_DAY_ABBREVIATION_FRIDAY'),
			'repeat_weekly_saturday'=>Yii::t('system', 'SYS_DAY_ABBREVIATION_SATURDAY'),
			'repeat_weekly_sunday'=>Yii::t('system', 'SYS_DAY_ABBREVIATION_SUNDAY'),
			'repeat_monthly_day_1'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY1'),
			'repeat_monthly_day_2'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY2'),
			'repeat_monthly_day_3'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY3'),
			'repeat_monthly_day_4'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY4'),
			'repeat_monthly_day_5'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY5'),
			'repeat_monthly_day_6'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY6'),
			'repeat_monthly_day_7'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY7'),
			'repeat_monthly_day_8'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY8'),
			'repeat_monthly_day_9'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY9'),
			'repeat_monthly_day_10'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY10'),
			'repeat_monthly_day_11'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY11'),
			'repeat_monthly_day_12'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY12'),
			'repeat_monthly_day_13'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY13'),
			'repeat_monthly_day_14'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY14'),
			'repeat_monthly_day_15'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY15'),
			'repeat_monthly_day_16'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY16'),
			'repeat_monthly_day_17'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY17'),
			'repeat_monthly_day_18'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY18'),
			'repeat_monthly_day_19'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY19'),
			'repeat_monthly_day_20'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY20'),
			'repeat_monthly_day_21'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY21'),
			'repeat_monthly_day_22'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY22'),
			'repeat_monthly_day_23'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY23'),
			'repeat_monthly_day_24'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY24'),
			'repeat_monthly_day_25'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY25'),
			'repeat_monthly_day_26'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY26'),
			'repeat_monthly_day_27'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY27'),
			'repeat_monthly_day_28'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY28'),
			'repeat_monthly_day_29'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY29'),
			'repeat_monthly_day_30'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY30'),
			'repeat_monthly_day_31'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEATMONTHLYDAY31'),
         'start_hour'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_STARTHOUR'),
         'end_hour'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_ENDHOUR'),
			'id_form'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_IDFORM'),
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

      $oCriteria->with = array('form');
      $oCriteria->together = true;
      
      $oCriteria->compare('t.description', $this->description, true);
      $oCriteria->compare('t.field_type', $this->field_type, true);
      $oCriteria->compare('t.field_value_default', $this->field_value_default, true);
      $oCriteria->compare('t.field_value_options', $this->field_value_options, true);
      $oCriteria->compare('t.field_unit', $this->field_unit, true);
      $oCriteria->compare('t.id_form', $this->id_form);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'t.id ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getMonitoringFormQuestion($nId) {
      $oMonitoringFormQuestion = MonitoringFormsQuestions::model()->findByPk($nId);
      
      return $oMonitoringFormQuestion;
   }
   
   public static function getMonitoringFormsQuestions() {
      return MonitoringFormsQuestions::model()->findAll();      
   }
   
   public static function getFullMonitoringFormQuestionRepeat($oMonitoringFormQuestion) {
      $sWeeklyDays = FString::STRING_EMPTY;
      $sMonthlyDays = FString::STRING_EMPTY;
      $sDays = FString::STRING_EMPTY;
                                                                                                          
      if ($oMonitoringFormQuestion->repeat == FModulePlantMonitoringManagement::TYPE_QUESTION_REPEAT_WEEKLY) {  
         if ($oMonitoringFormQuestion->repeat_weekly_monday) {
            if (strlen($sWeeklyDays) > 0) $sWeeklyDays .= ', ' . Yii::t('system', 'SYS_DAY_ABBREVIATION_MONDAY');
            else $sWeeklyDays = Yii::t('system', 'SYS_DAY_ABBREVIATION_MONDAY');
         }  
         if ($oMonitoringFormQuestion->repeat_weekly_tuesday) {
            if (strlen($sWeeklyDays) > 0) $sWeeklyDays .= ', ' . Yii::t('system', 'SYS_DAY_ABBREVIATION_TUESDAY');
            else $sWeeklyDays = Yii::t('system', 'SYS_DAY_ABBREVIATION_TUESDAY');
         } 
         if ($oMonitoringFormQuestion->repeat_weekly_wednesday) {
            if (strlen($sWeeklyDays) > 0) $sWeeklyDays .= ', ' . Yii::t('system', 'SYS_DAY_ABBREVIATION_WEDNESDAY');
            else $sWeeklyDays = Yii::t('system', 'SYS_DAY_ABBREVIATION_WEDNESDAY');
         } 
         if ($oMonitoringFormQuestion->repeat_weekly_thursday) {
            if (strlen($sWeeklyDays) > 0) $sWeeklyDays .= ', ' . Yii::t('system', 'SYS_DAY_ABBREVIATION_THURSDAY');
            else $sWeeklyDays = Yii::t('system', 'SYS_DAY_ABBREVIATION_THURSDAY');
         } 
         if ($oMonitoringFormQuestion->repeat_weekly_friday) {
            if (strlen($sWeeklyDays) > 0) $sWeeklyDays .= ', ' . Yii::t('system', 'SYS_DAY_ABBREVIATION_FRIDAY');
            else $sWeeklyDays = Yii::t('system', 'SYS_DAY_ABBREVIATION_FRIDAY');
         } 
         if ($oMonitoringFormQuestion->repeat_weekly_saturday) {
            if (strlen($sWeeklyDays) > 0) $sWeeklyDays .= ', ' . Yii::t('system', 'SYS_DAY_ABBREVIATION_SATURDAY');
            else $sWeeklyDays = Yii::t('system', 'SYS_DAY_ABBREVIATION_SATURDAY');
         } 
         if ($oMonitoringFormQuestion->repeat_weekly_sunday) {
            if (strlen($sWeeklyDays) > 0) $sWeeklyDays .= ', ' . Yii::t('system', 'SYS_DAY_ABBREVIATION_SUNDAY');
            else $sWeeklyDays = Yii::t('system', 'SYS_DAY_ABBREVIATION_SUNDAY');
         } 
      }
      else if ($oMonitoringFormQuestion->repeat == FModulePlantMonitoringManagement::TYPE_QUESTION_REPEAT_MONTHLY) {
         if ($oMonitoringFormQuestion->repeat_monthly_day_1) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 1';
            else $sMonthlyDays = '1';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_2) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 2';
            else $sMonthlyDays = '2';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_3) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 3';
            else $sMonthlyDays = '3';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_4) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 4';
            else $sMonthlyDays = '4';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_5) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 5';
            else $sMonthlyDays = '5';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_6) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 6';
            else $sMonthlyDays = '6';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_7) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 7';
            else $sMonthlyDays = '7';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_8) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 8';
            else $sMonthlyDays = '8';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_9) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 9';
            else $sMonthlyDays = '9';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_10) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 10';
            else $sMonthlyDays = '10';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_11) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 11';
            else $sMonthlyDays = '11';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_12) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 12';
            else $sMonthlyDays = '12';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_13) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 13';
            else $sMonthlyDays = '13';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_14) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 14';
            else $sMonthlyDays = '14';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_15) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 15';
            else $sMonthlyDays = '15';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_16) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 16';
            else $sMonthlyDays = '16';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_17) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 17';
            else $sMonthlyDays = '17';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_18) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 18';
            else $sMonthlyDays = '18';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_19) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 19';
            else $sMonthlyDays = '19';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_20) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 20';
            else $sMonthlyDays = '20';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_21) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 21';
            else $sMonthlyDays = '21';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_22) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 22';
            else $sMonthlyDays = '22';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_23) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 23';
            else $sMonthlyDays = '23';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_24) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 24';
            else $sMonthlyDays = '24';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_25) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 25';
            else $sMonthlyDays = '25';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_26) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 26';
            else $sMonthlyDays = '26';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_27) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 27';
            else $sMonthlyDays = '27';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_28) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 28';
            else $sMonthlyDays = '28';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_29) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 29';
            else $sMonthlyDays = '29';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_30) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 30';
            else $sMonthlyDays = '30';
         }
         if ($oMonitoringFormQuestion->repeat_monthly_day_31) {
            if (strlen($sMonthlyDays) > 0) $sMonthlyDays .= ', 31';
            else $sMonthlyDays = '31';
         }
      }
      
      if ((strlen($sWeeklyDays) > 0) || (strlen($sMonthlyDays) > 0)) {
         if (strlen($sWeeklyDays) > 0) $sDays = '(' . $sWeeklyDays . ')';
         else $sDays = '(' . $sMonthlyDays . ')';  
      }
      
      return Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT), 'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEAT_VALUE_' . $oMonitoringFormQuestion->repeat) . FString::STRING_SPACE . $sDays;
   }
   
   public static function getMonitoringFormsQuestionsByIdForm($nIdForm) {
      return MonitoringFormsQuestions::model()->findAll('id_form = ' . $nIdForm);      
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();

      $this->oExportSpecifications['data'][0] = array('field_type', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Yii::t(\'frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '\', \'MODEL_MONITORINGFORMSQUESTIONS_FIELD_FIELDTYPE_VALUE_?\')', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][1] = array('field_required', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');                                                            
      $this->oExportSpecifications['data'][2] = array('repeat', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'Yii::t(\'frontend_' . strtolower(FApplication::MODULE_PLANT_MONITORING_MANAGEMENT) . '\', \'MODEL_MONITORINGFORMSQUESTIONS_FIELD_REPEAT_VALUE_?\')', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][3] = array('repeat_weekly_monday', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][4] = array('repeat_weekly_tuesday', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][5] = array('repeat_weekly_wednesday', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][6] = array('repeat_weekly_thursday', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][7] = array('repeat_weekly_friday', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][8] = array('repeat_weekly_saturday', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][9] = array('repeat_weekly_sunday', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][10] = array('repeat_monthly_day_1', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][11] = array('repeat_monthly_day_2', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][12] = array('repeat_monthly_day_3', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][13] = array('repeat_monthly_day_4', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][14] = array('repeat_monthly_day_5', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][15] = array('repeat_monthly_day_6', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][16] = array('repeat_monthly_day_7', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][17] = array('repeat_monthly_day_8', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][18] = array('repeat_monthly_day_9', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][19] = array('repeat_monthly_day_10', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][20] = array('repeat_monthly_day_11', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][21] = array('repeat_monthly_day_12', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][22] = array('repeat_monthly_day_13', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][23] = array('repeat_monthly_day_14', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][24] = array('repeat_monthly_day_15', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][25] = array('repeat_monthly_day_16', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][26] = array('repeat_monthly_day_17', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][27] = array('repeat_monthly_day_18', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][28] = array('repeat_monthly_day_19', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][29] = array('repeat_monthly_day_20', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][30] = array('repeat_monthly_day_21', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][31] = array('repeat_monthly_day_22', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][32] = array('repeat_monthly_day_23', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][33] = array('repeat_monthly_day_24', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][34] = array('repeat_monthly_day_25', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][35] = array('repeat_monthly_day_26', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][36] = array('repeat_monthly_day_27', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][37] = array('repeat_monthly_day_28', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][38] = array('repeat_monthly_day_29', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][39] = array('repeat_monthly_day_30', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      $this->oExportSpecifications['data'][40] = array('repeat_monthly_day_31', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
      
      $this->oExportSpecifications['columns'] = array('form.name', 'description', 'field_type', 'field_required', 'field_value_default', 'field_value_options', 'field_unit', 'repeat', 'repeat_weekly_monday', 'repeat_weekly_tuesday', 'repeat_weekly_wednesday', 'repeat_weekly_thursday', 'repeat_weekly_friday', 'repeat_weekly_saturday', 'repeat_weekly_sunday', 'repeat_monthly_day_1', 'repeat_monthly_day_2', 'repeat_monthly_day_3', 'repeat_monthly_day_4', 'repeat_monthly_day_5', 'repeat_monthly_day_6', 'repeat_monthly_day_7', 'repeat_monthly_day_8', 'repeat_monthly_day_9', 'repeat_monthly_day_10', 'repeat_monthly_day_11', 'repeat_monthly_day_12', 'repeat_monthly_day_13', 'repeat_monthly_day_14', 'repeat_monthly_day_15', 'repeat_monthly_day_16', 'repeat_monthly_day_17', 'repeat_monthly_day_18', 'repeat_monthly_day_19', 'repeat_monthly_day_20', 'repeat_monthly_day_21', 'repeat_monthly_day_22', 'repeat_monthly_day_23', 'repeat_monthly_day_24', 'repeat_monthly_day_25', 'repeat_monthly_day_26', 'repeat_monthly_day_27', 'repeat_monthly_day_28', 'repeat_monthly_day_29', 'repeat_monthly_day_30', 'repeat_monthly_day_31', 'start_hour', 'end_hour');
      
      return $this->oExportSpecifications; 
   }
}