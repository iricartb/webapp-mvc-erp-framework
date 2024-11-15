<?php

/**
 * This is the model class for table "accesscontrol_incidences".
 *
 * The followings are the available columns in table 'incidences':
 * @property integer $id
 * @property string $code
 * @property string $description
 */
class AccessControlIncidences extends CExportedActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Incidences the static model class
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
		return 'accesscontrol_incidences';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('code', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('code', 'length', 'max'=>20),
         array('description', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('code', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         array('code', 'match', 'pattern'=>FRegEx::getCsvFieldPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_FIELD_CSV')),
         
         array('description','filter','filter'=>'strtolower'),
         array('description','filter','filter'=>'ucwords'),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('code, description', 'safe', 'on'=>'search'),
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
         'code'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLINCIDENCES_FIELD_CODE'),
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLINCIDENCES_FIELD_DESCRIPTION'),
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

		$oCriteria->compare('code', $this->code, true);
		$oCriteria->compare('description', $this->description, true);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'id ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}
   
   public static function getAccessControlIncidence($nId) {
      $oAccessControlIncidence = AccessControlIncidences::model()->findByPk($nId);
        
      return $oAccessControlIncidence;
   }
   
   public static function getAccessControlIncidences() {
      return AccessControlIncidences::model()->findAll();   
   }
   
   public static function getAccessControlIncidenceByCode($sCode) {
      $oAccessControlIncidence = AccessControlIncidences::model()->find('code = \'' . $sCode . '\'');
        
      return $oAccessControlIncidence;
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('code', 'description');
        
      return $this->oExportSpecifications; 
   } 
}