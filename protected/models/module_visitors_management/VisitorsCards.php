<?php

/**
 * This is the model class for table "visitors_cards".
 *
 * The followings are the available columns in table 'visitors_cards':
 * @property integer $id
 * @property string $code
 * @property integer $assigned
 */
class VisitorsCards extends CExportedActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VisitorsCards the static model class
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
		return 'visitors_cards';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('assigned', 'boolean'),
         
         array('code', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('code', 'length', 'min'=>3, 'max'=>20, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),

         array('code', 'match', 'pattern'=>FRegEx::getNumericPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_ONLY_NUMERIC')),
                  
         array('code', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('code', 'safe', 'on'=>'search'),
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
			'code'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSCARDS_FIELD_CODE'),
			'assigned'=>'Assigned',
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

		$criteria->compare('code', $this->code, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
         'sort'=>array(
            'defaultOrder'=>'code ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
		));
	}
   
   public static function getVisitorCard($nId) {
      $oVisitorCard = VisitorsCards::model()->findByPk($nId);
        
      return $oVisitorCard;
   }
   
   public static function getFirstFreeVisitorCard() {
      $oVisitorCard = VisitorsCards::model()->find('assigned = 0 ORDER BY code ASC');
      
      return $oVisitorCard;    
   }
   
   public static function getFreeVisitorsCards($nCurrentCardId = null) {
      if (!is_null($nCurrentCardId)) $oVisitorCards = VisitorsCards::model()->findAll('id = ' . $nCurrentCardId . ' OR assigned = 0 ORDER BY code ASC');
      else $oVisitorCards = VisitorsCards::model()->findAll('assigned = 0 ORDER BY code ASC');
      
      return $oVisitorCards;    
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('code');
        
      return $this->oExportSpecifications; 
   }
}