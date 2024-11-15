<?php

/**
 * This is the model class for table "visitors".
 *
 * The followings are the available columns in table 'visitors':
 * @property integer $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $full_name
 * @property string $identification
 * @property string $business
 * @property string $comments
 */
class Visitors extends CExportedActiveRecord {
 
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Visitors the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection() {
		return Yii::app()->db_rainbow_visitorsmanagement;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'visitors';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('first_name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('middle_name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('identification', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            
         array('first_name', 'length', 'min'=>2, 'max'=>12, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'2'))),
         array('middle_name', 'length', 'min'=>2, 'max'=>12, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'2'))),
         array('last_name', 'length', 'min'=>2, 'max'=>12, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'2'))),
         array('identification', 'length', 'min'=>5, 'max'=>12, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'5'))),
         array('business', 'length', 'min'=>3, 'max'=>32, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('comments', 'length', 'min'=>3, 'max'=>64, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
            
         array('identification', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
            
         array('first_name', 'match', 'pattern'=>FRegEx::getNamePattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_NAME')),
         array('middle_name', 'match', 'pattern'=>FRegEx::getNamePattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_NAME')),
         array('last_name', 'match', 'pattern'=>FRegEx::getNamePattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_NAME')),
         array('business', 'match', 'pattern'=>FRegEx::getBusinessPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_BUSINESS')),
         array('identification', 'match', 'pattern'=>FRegEx::getIdentificationPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_IDENTIFICATION')),
         
         array('full_name', 'filter', 'filter'=>array($this, 'strcpy_fullname')),
            
         array('identification', 'filter', 'filter'=>'strtoupper'),
         array('business', 'filter', 'filter'=>'strtoupper'),
            
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
		   array('full_name, identification, business, comments', 'safe', 'on'=>'search'),
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
         'first_name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORS_FIELD_FIRSTNAME'),
         'middle_name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORS_FIELD_MIDDLENAME'),
         'last_name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORS_FIELD_LASTNAME'),
         'full_name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORS_FIELD_FULLNAME'),
         'identification'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORS_FIELD_IDENTIFICATION'),
         'business'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORS_FIELD_BUSINESS'),
         'comments'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORS_FIELD_COMMENTS'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('full_name', $this->full_name, true);
		$criteria->compare('identification', $this->identification, true);
		$criteria->compare('business', $this->business, true);
		$criteria->compare('comments', $this->comments, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
         'sort'=>array(
            'defaultOrder'=>'full_name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
		));
	}
   
   public static function getVisitor($nId) {
      $oVisitor = Visitors::model()->findByPk($nId);
        
      return $oVisitor;
   }
   
   public static function getVisitorByIdentification($sIdentification) {
      $oVisitor = Visitors::model()->find('identification = ?', array($sIdentification));
      
      return $oVisitor;   
   } 
   
   public function strcpy_fullname() {
      if (strlen($this->last_name) > 0) $this->full_name = $this->first_name . FString::STRING_SPACE . $this->middle_name . FString::STRING_SPACE . $this->last_name;
      else $this->full_name = $this->first_name . FString::STRING_SPACE . $this->middle_name;
      
      return $this->full_name;  
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('full_name', 'identification', 'business', 'comments');
        
      return $this->oExportSpecifications; 
   }
}