<?php

/**
 * This is the model class for table "check_in_manual".
 *
 * The followings are the available columns in table 'check_in_manual':
 * @property integer $id
 * @property string $date
 * @property string $employee_identification
 * @property integer $type
 */
class AccessControlCheckInManual extends CActiveRecord {
   public $id_device = null;
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccessControlCheckInManual the static model class
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
		return 'accesscontrol_check_in_manual';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, employee_identification', 'required'),
			array('employee_identification', 'length', 'max'=>12),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date, employee_identification, type', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'date' => 'Date',
			'employee_identification' => 'Employee Identification',
			'type' => 'Type',
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

		$oCriteria->compare('id', $this->id);
		$oCriteria->compare('date', $this->date, true);
		$oCriteria->compare('employee_identification', $this->employee_identification, true);
		$oCriteria->compare('type', $this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
		));
	}
   
   public static function getLastAccessControlCheckinByEmployee($employee) {
      $oAccessControlCheckin = AccessControlCheckInManual::model()->find('employee_identification = \'' . $employee . '\' ORDER BY date DESC');
      
      return $oAccessControlCheckin;      
   }
   
   public static function getAccessControlCheckinByEmployeeDate($employee, $date) {
      $oAccessControlCheckin = AccessControlCheckInManual::model()->findAll('employee_identification = \'' . $employee . '\' AND date >= \'' . $date . ' 00:00:00\' AND date <= \'' . $date . ' 23:59:59\' ORDER BY date ASC');
      
      return $oAccessControlCheckin;
   }
   
   public static function getAccessControlCheckinByEmployeeDateHour($employee, $date, $hour, $min) {
      $oAccessControlCheckin = AccessControlCheckInManual::model()->findAll('employee_identification = \'' . $employee . '\' AND DATE(date) = \'' . FString::getFirstToken($date, FString::STRING_SPACE) . '\' AND ((HOUR(date) > ' . $hour . ') OR ((HOUR(date) = ' . $hour . ') AND (MINUTE(date) > ' . $min . '))) ORDER BY date ASC');
               
      return $oAccessControlCheckin;
   }
}