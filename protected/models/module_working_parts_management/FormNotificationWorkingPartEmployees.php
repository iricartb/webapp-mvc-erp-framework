<?php

/**
 * This is the model class for table "form_notification_working_part_employees".
 *
 * The followings are the available columns in table 'form_notification_working_part_employees':
 * @property integer $id
 * @property string $name
 * @property string $business
 * @property integer $id_form_notification_working_part
 *
 * The followings are the available model relations:
 * @property FormsNotificationWorkingParts $idFormNotificationWorkingPart
 */
class FormNotificationWorkingPartEmployees extends CActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return FormNotificationWorkingPartEmployees the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
   /**
    * @return CDbConnection the database connection used for this class
    */
   public function getDbConnection() {
      return Yii::app()->db_rainbow_workingpartsmanagement;
   }

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'form_notification_working_part_employees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('business', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_notification_working_part', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),  
         
         array('name', 'length', 'min'=>3, 'max'=>38, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('business', 'length', 'min'=>3, 'max'=>32, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('name', 'match', 'pattern'=>FRegEx::getNamePattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_NAME')),
         array('business', 'match', 'pattern'=>FRegEx::getBusinessPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_BUSINESS')),
         
         array('name', 'filter', 'filter'=>'strtolower'),
         array('name', 'filter', 'filter'=>'ucwords'),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, business, id_form_notification_working_part', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'form_notification_working_part'=>array(self::BELONGS_TO, 'FormsNotificationWorkingParts', 'id_form_notification_working_part'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),    
			'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMNOTIFICATIONWORKINGPARTEMPLOYEES_FIELD_NAME'),
			'business'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMNOTIFICATIONWORKINGPARTEMPLOYEES_FIELD_BUSINESS'),
			'id_form_notification_working_part'=>Yii::t('system', 'SYS_MODEL_FIELD_FK'),
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
	public function search($nIdFormFK = null) {
      // Warning: Please modify the following code to remove attributes that
      // should not be searched.
      
      $oCriteria = new CDbCriteria;

      $oCriteria->compare('name', $this->name, true);
      $oCriteria->compare('business', $this->business, true);
      if (!is_null($nIdFormFK)) $oCriteria->compare('id_form_notification_working_part', $nIdFormFK);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'business ASC, name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}
   
   public static function getFormNotificationWorkingPartEmployee($nId) {
      $oFormNotificationWorkingPartEmployee = FormNotificationWorkingPartEmployees::model()->findByPk($nId);
      
      return $oFormNotificationWorkingPartEmployee;
   }
   
   public static function getFormNotificationWorkingPartEmployeesByIdFormFK($nIdFormFK) {
      return FormNotificationWorkingPartEmployees::model()->findAll('id_form_notification_working_part = ' . $nIdFormFK . ' ORDER BY business ASC, name ASC');   
   }
}