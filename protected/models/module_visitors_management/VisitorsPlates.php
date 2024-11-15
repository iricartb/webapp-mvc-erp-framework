<?php

/**
 * This is the model class for table "visitors_plates".
 *
 * The followings are the available columns in table 'visitors_plates':
 * @property integer $id
 * @property string $plate
 * @property string $employee
 * @property string $employee_identification
 * @property string $comments
 */
class VisitorsPlates extends CExportedActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Plates the static model class
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
		return 'visitors_plates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(                    
         array('plate', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('employee', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('employee_identification', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('plate', 'length', 'min'=>3, 'max'=>11, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('comments', 'length', 'min'=>3, 'max'=>60, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('employee_identification', 'UniqueAttributesValidator', 'with'=>'plate', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MF', array('{1}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_PLATES_FIELD_EMPLOYEE'), '{2}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_PLATES_FIELD_PLATE')))),
         array('plate', 'UniqueAttributesValidator', 'with'=>'employee_identification', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MF', array('{1}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_PLATES_FIELD_EMPLOYEE'), '{2}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_PLATES_FIELD_PLATE')))),
                      
         array('plate', 'match', 'pattern'=>FRegEx::getPlatePattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_PLATE')),
         
         array('plate','filter','filter'=>'strtoupper'),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('plate, comments, employee, employee_identification', 'safe', 'on'=>'search'),
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
			'plate'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSPLATES_FIELD_PLATE'),
			'employee'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSPLATES_FIELD_EMPLOYEE'),
         'employee_identification'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSPLATES_FIELD_EMPLOYEEIDENTIFICATION'),
			'comments'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSPLATES_FIELD_COMMENTS'),
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

		$oCriteria->compare('plate', $this->plate, true);
		$oCriteria->compare('comments', $this->comments, true);
      $oCriteria->compare('employee', $this->employee, true);
      $oCriteria->compare('employee_identification', $this->employee_identification, true);
      
		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'employee ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
		));
	}
     
   public static function getVisitorsPlate($nId) {
      $oVisitorsPlate = VisitorsPlates::model()->findByPk($nId);
        
      return $oVisitorsPlate;
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('plate', 'employee', 'employee_identification', 'comments');
        
      return $this->oExportSpecifications; 
   }
}