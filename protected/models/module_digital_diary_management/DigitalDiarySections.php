<?php

/**
 * This is the model class for table "digitaldiary_sections".
 *
 * The followings are the available columns in table 'digitaldiary_sections':
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 * The followings are the available model relations:
 * @property DigitalDiarySectionsNotifications[] $sectionsNotifications
 */
class DigitalDiarySections extends CExportedActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Sections the static model class
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
		return 'digitaldiary_sections';
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
         
         array('name', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('description', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('name', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
          
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
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
			'notifications'=>array(self::HAS_MANY, 'DigitalDiarySectionsNotifications', 'id_section'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'), 
			'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYSECTIONS_FIELD_NAME'),
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYSECTIONS_FIELD_DESCRIPTION'),
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
      $oCriteria->compare('description', $this->description, true);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}
   
   public static function getDigitalDiarySection($nId) {
      $oDigitalDiarySection = DigitalDiarySections::model()->findByPk($nId);
      
      return $oDigitalDiarySection;
   }
   
   public static function getDigitalDiarySectionName($nId) {
      $oDigitalDiarySection = DigitalDiarySections::getDigitalDiarySection($nId);
      $sDescription = FString::STRING_EMPTY;
      if (!is_null($oDigitalDiarySection)) {
         $sDescription = $oDigitalDiarySection->name;
      }
      return $sDescription;  
   }
   
   public static function getDigitalDiarySections() {
      return DigitalDiarySections::model()->findAll(array('order'=>'name ASC'));   
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('name', 'description');
        
      return $this->oExportSpecifications; 
   }
}