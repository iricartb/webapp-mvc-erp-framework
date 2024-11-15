<?php

/**
 * This is the model class for table "accesscontrol_timetables".
 *
 * The followings are the available columns in table 'timetables':
 * @property integer $id
 * @property string $name
 * @property string $abbreviation
 * @property string $type
 * @property string $hour1_t1
 * @property string $hour2_t1
 * @property string $hour1_t2
 * @property string $hour2_t2
 * @property integer $tolerance
 */
class AccessControlTimetables extends CExportedActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Timetables the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection() {
		return Yii::app()->db_rainbow_accesscontrolmanagement;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'accesscontrol_timetables';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('abbreviation', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('type', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('hour1_t1', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('hour2_t1', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('type', 'YiiConditionalValidator',
            'if'=>array(
               array('type', 'compare', 'compareValue'=>FModuleAccessControlManagement::TYPE_TIMETABLE_SHIFT),
            ),
            'then'=>array(
               array('hour1_t2, hour2_t2', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),

         array('name', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('abbreviation', 'length', 'max'=>6),
         array('type', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('hour1_t1', 'length', 'min'=>5, 'max'=>5, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'5'))),
         array('hour2_t1', 'length', 'min'=>5, 'max'=>5, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'5'))),
         array('hour1_t2', 'length', 'min'=>5, 'max'=>5, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'5'))),
         array('hour2_t2', 'length', 'min'=>5, 'max'=>5, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'5'))),
         
         array('name', 'match', 'pattern'=>FRegEx::getAlphaPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_ALPHA')),
         array('tolerance', 'match', 'pattern'=>FRegEx::getNumericPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_ONLY_NUMERIC')),
         array('tolerance', 'numerical', 'min'=>0, 'max'=>FModuleAccessControlManagement::TIMETABLE_MAX_TOLERANCE, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'1')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>FModuleAccessControlManagement::TIMETABLE_MAX_TOLERANCE))),
            
         array('name', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
         array('name', 'filter', 'filter'=>'strtoupper'),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, hour1_t1, hour2_t1, hour1_t2, hour2_t2, tolerance', 'safe', 'on'=>'search'),
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
			'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLTIMETABLES_FIELD_NAME'),
         'abbreviation'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLTIMETABLES_FIELD_ABBREVIATION'),
			'type'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLTIMETABLES_FIELD_TYPE'),
			'hour1_t1'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLTIMETABLES_FIELD_HOUR1T1'),
			'hour2_t1'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLTIMETABLES_FIELD_HOUR2T1'),
			'hour1_t2'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLTIMETABLES_FIELD_HOUR1T2'),
			'hour2_t2'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLTIMETABLES_FIELD_HOUR2T2'),
			'tolerance'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLTIMETABLES_FIELD_TOLERANCE'),
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

		$oCriteria->compare('name', $this->name, true);
		$oCriteria->compare('hour1_t1', $this->hour1_t1, true);
		$oCriteria->compare('hour2_t1', $this->hour2_t1, true);
		$oCriteria->compare('hour1_t2', $this->hour1_t2, true);
		$oCriteria->compare('hour2_t2', $this->hour2_t2, true);
		$oCriteria->compare('tolerance', $this->tolerance);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}
   
   public static function getAccessControlTimetables() {
      $oAccessControlTimetables = AccessControlTimetables::model()->findAll();
      
      return $oAccessControlTimetables;  
   } 
   
   public static function getAccessControlTimetable($nId) {
      $oAccessControlTimetable = AccessControlTimetables::model()->findByPk($nId);
        
      return $oAccessControlTimetable;
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('name', 'hour1_t1', 'hour2_t1', 'hour1_t2', 'hour2_t2', 'tolerance');
        
      return $this->oExportSpecifications; 
   } 
}