<?php

/**
 * This is the model class for table "digitaldiary_daily_notifications".
 *
 * The followings are the available columns in table 'digitaldiary_sections_notifications':
 * @property integer $id
 * @property string $mail
 *
 * The followings are the available model relations:
 * @property DigitalDiarySections $idSection
 */
class DigitalDiaryDailyNotifications extends CExportedActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SectionsNotifications the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection() {
		return Yii::app()->db_rainbow_digitaldiarymanagement;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'digitaldiary_daily_notifications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('mail', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),

         array('mail', 'length', 'min'=>6, 'max'=>60, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'6'))), 
         array('mail', 'match', 'pattern'=>FRegEx::getMailPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_MAIL')),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mail', 'safe', 'on'=>'search'),
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
			'mail'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYDAILYNOTIFICATIONS_FIELD_MAIL'),
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

      $oCriteria->compare('mail', $this->mail, true);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'mail ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}
   
   public static function getDigitalDiaryDailyNotification($nId) {
      $oDigitalDiaryDailyNotification = DigitalDiaryDailyNotifications::model()->findByPk($nId);
      
      return $oDigitalDiaryDailyNotification;
   }
   
   public static function getDigitalDiaryDailyNotifications() {
      return DigitalDiaryDailyNotifications::model()->findAll(array('order'=>'mail ASC'));     
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('mail');
              
      return $this->oExportSpecifications; 
   }
}