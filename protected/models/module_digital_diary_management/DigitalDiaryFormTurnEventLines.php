<?php

/**
 * This is the model class for table "digitaldiary_form_turn_event_lines".
 *
 * The followings are the available columns in table 'digitaldiary_form_turn_event_lines':
 * @property integer $id
 * @property string $hour
 * @property string $section_name
 * @property string $id_zone
 * @property string $zone
 * @property string $id_region
 * @property string $region
 * @property string $id_equipment
 * @property string $equipment
 * @property string $description
 * @property integer $urgent
 * @property integer $send
 * @property integer $id_form_turn_event
 *
 * The followings are the available model relations:
 * @property DigitalDiaryFormsTurnEvents $idFormTurnEvent
 */
class DigitalDiaryFormTurnEventLines extends CExportedActiveRecord  {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormTurnEventLines the static model class
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
		return 'digitaldiary_form_turn_event_lines';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('hour', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('section_name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_zone', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('zone', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_region', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('region', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_equipment', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_turn_event', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
			array('hour', 'length', 'max'=>5),
			array('section_name', 'length', 'max'=>20),
			array('region, equipment', 'length', 'max'=>40),
         
         array('hour', 'length', 'min'=>5, 'max'=>5, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'5'))),
         array('equipment', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
            
         array('urgent, send', 'boolean'),

         array('equipment', 'YiiConditionalValidator',
            'if'=>array(
               array('id_equipment', 'compare', 'compareValue'=>FApplication::EQUIPMENT_OTHERS),
            ),
            'then'=>array(
               array('equipment', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hour, section_name, zone, region, equipment, description, id_form_turn_event', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'formTurnEvent'=>array(self::BELONGS_TO, 'DigitalDiaryFormsTurnEvents', 'id_form_turn_event'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
			'hour'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_HOUR'),
			'section_name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_SECTIONNAME'),
         'id_zone'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_IDZONE'),
			'zone'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_ZONE'),
         'id_region'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_IDREGION'),
         'region'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_REGION'),
         'id_equipment'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_IDEQUIPMENT'),
			'equipment'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_EQUIPMENT'),
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_DESCRIPTION'),
         'urgent'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_URGENT'),
			'send'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_DIGITAL_DIARY_MANAGEMENT), 'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_SEND'),
			'id_form_turn_event'=>Yii::t('system', 'SYS_MODEL_FIELD_FK'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($nIdFormFK = null, $sSection = null) {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('hour', $this->hour, true);
      $oCriteria->compare('zone', $this->zone, true);
		$oCriteria->compare('region', $this->region, true);
		$oCriteria->compare('equipment', $this->equipment, true);
		$oCriteria->compare('description', $this->description, true);
      
      if (!is_null($nIdFormFK)) $oCriteria->compare('id_form_turn_event', $nIdFormFK);
      if (!is_null($sSection)) $oCriteria->compare('section_name', $sSection);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'id ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getDigitalDiaryFormTurnEventLine($nId) {
      $oDigitalDiaryFormTurnEventLine = DigitalDiaryFormTurnEventLines::model()->findByPk($nId);
      
      return $oDigitalDiaryFormTurnEventLine;
   }
   
   public static function getDigitalDiaryFormTurnEventLinesByIdFormFK($nIdFormFK) {
      return DigitalDiaryFormTurnEventLines::model()->findAll('id_form_turn_event = ' . $nIdFormFK . ' ORDER BY id ASC');   
   }
   
   public static function getDigitalDiaryFormTurnEventLinesBySectionNameAndIdFormFK($sSectionName, $nIdFormFK) {
      return DigitalDiaryFormTurnEventLines::model()->findAll('section_name = \'' . $sSectionName . '\' AND id_form_turn_event = ' . $nIdFormFK . ' ORDER BY id ASC');         
   }
   
   public static function getDigitalDiaryFormsTurnEventLines($sEmployee = null, $sStartDate = null, $sEndDate = null) {
      $sSentence = FString::STRING_EMPTY; 
      $bCondition = false;
       
      if (!FString::isNullOrEmpty($sEmployee)) {
         $sSentence = 'formTurnEvent.owner = \'' . $sEmployee . '\' ' . $sSentence; 
         $bCondition = true;  
      } 
      
      if (!FString::isNullOrEmpty($sStartDate)) {
         if ($bCondition) $sSentence = 'formTurnEvent.date >= \'' . FDate::getEnglishDate($sStartDate) . '\' AND ' . $sSentence; 
         else $sSentence = 'formTurnEvent.date >= \'' . FDate::getEnglishDate($sStartDate) . '\'' . FString::STRING_SPACE . $sSentence; 
         $bCondition = true;  
      } 
      
      if (!FString::isNullOrEmpty($sEndDate)) {
         if ($bCondition) $sSentence = 'formTurnEvent.date <= \'' . FDate::getEnglishDate($sEndDate) . '\' AND ' . $sSentence; 
         else $sSentence = 'formTurnEvent.date <= \'' . FDate::getEnglishDate($sEndDate) . '\'' . FString::STRING_SPACE . $sSentence; 
         $bCondition = true;  
      }    
      
      return DigitalDiaryFormTurnEventLines::model()->with('formTurnEvent')->findAll(array('condition'=>$sSentence, 'order'=>'formTurnEvent.date ASC, t.id ASC'));
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'][0] = array('urgent', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');
            
      $this->oExportSpecifications['columns'] = array('hour', 'section_name', 'zone', 'region', 'equipment', 'description', 'urgent');
        
      return $this->oExportSpecifications; 
   }
}