<?php

/**
 * This is the model class for table "accesscontrol_chronograms".
 *
 * The followings are the available columns in table 'accesscontrol_chronograms':
 * @property integer $id
 * @property string $type
 * @property string $employee_identification
 * @property integer $employee_tolerance
 * @property integer $employee_process_delay
 * @property string $timetable_name
 * @property string $timetable_abbreviation
 * @property string $timetable_type
 * @property string $timetable_hour1_t1
 * @property string $timetable_hour2_t1
 * @property string $timetable_hour1_t2
 * @property string $timetable_hour2_t2
 * @property integer $timetable_tolerance
 * @property string $date
 */
class AccessControlChronograms extends CActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Chronograms the static model class
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
		return 'accesscontrol_chronograms';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, date', 'required'),
			array('employee_tolerance, timetable_tolerance', 'numerical', 'integerOnly'=>true),
			array('timetable_name, timetable_type', 'length', 'max'=>20),
         array('type', 'length', 'max'=>30),
         array('timetable_abbreviation', 'length', 'max'=>6),
			array('employee_identification', 'length', 'max'=>12),
			array('timetable_hour1_t1, timetable_hour2_t1, timetable_hour1_t2, timetable_hour2_t2', 'length', 'max'=>5),
			
         array('employee_process_delay', 'boolean'),
         
         // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, employee_identification, employee_tolerance, timetable_name, timetable_abbreviation, timetable_type, timetable_hour1_t1, timetable_hour2_t1, timetable_hour1_t2, timetable_hour2_t2, timetable_tolerance, date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'employee_identification' => 'Employee Identification',
			'employee_tolerance' => 'Employee Tolerance',
         'employee_process_delay' => 'Employee Process Delay',
			'timetable_name' => 'Timetable Name',
         'timetable_abbreviation' => 'Timetable Abbreviation',
         'timetable_type' => 'Timetable Type',
			'timetable_hour1_t1' => 'Timetable Hour1 T1',
			'timetable_hour2_t1' => 'Timetable Hour2 T1',
			'timetable_hour1_t2' => 'Timetable Hour1 T2',
			'timetable_hour2_t2' => 'Timetable Hour2 T2',
			'timetable_tolerance' => 'Timetable Tolerance',
			'date' => 'Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
         
		$oCriteria=new CDbCriteria;

		$oCriteria->compare('id',$this->id);
		$oCriteria->compare('type',$this->type,true);
		$oCriteria->compare('employee_identification',$this->employee_identification,true);
		$oCriteria->compare('employee_tolerance',$this->employee_tolerance);
		$oCriteria->compare('timetable_name',$this->timetable_name,true);
      $oCriteria->compare('timetable_abbreviation',$this->timetable_abbreviation,true);
      $oCriteria->compare('timetable_type',$this->timetable_type,true);
		$oCriteria->compare('timetable_hour1_t1',$this->timetable_hour1_t1,true);
		$oCriteria->compare('timetable_hour2_t1',$this->timetable_hour2_t1,true);
		$oCriteria->compare('timetable_hour1_t2',$this->timetable_hour1_t2,true);
		$oCriteria->compare('timetable_hour2_t2',$this->timetable_hour2_t2,true);
		$oCriteria->compare('timetable_tolerance',$this->timetable_tolerance);
		$oCriteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
		));
	}
   
   public static function getAccessControlHolidayChronogramsByYearMonth($nYear, $nMonth) {
      $oAccessControlChronograms = AccessControlChronograms::model()->findAll('type = \'' . FModuleAccessControlManagement::TYPE_CHRONOGRAM_HOLIDAY . '\' AND year(date) = ' . $nYear . ' AND month(date) = ' . $nMonth . ' ORDER BY date ASC');
      
      return $oAccessControlChronograms;   
   }

   public static function getAccessControlHolidayChronogramByDate($sDate) {
      $oAccessControlChronogram = AccessControlChronograms::model()->find('type = \'' . FModuleAccessControlManagement::TYPE_CHRONOGRAM_HOLIDAY . '\' AND date = \'' . $sDate . '\'');
      
      return $oAccessControlChronogram;   
   }
   
   public static function getAccessControlChronogramsByEmployeeYearMonth($sType, $sEmployeeIdentification, $nYear, $nMonth) {
      $oAccessControlChronograms = AccessControlChronograms::model()->findAll('type = \'' . $sType . '\' AND employee_identification = \'' . $sEmployeeIdentification . '\' AND year(date) = ' . $nYear . ' AND month(date) = ' . $nMonth . ' ORDER BY date ASC');
      
      return $oAccessControlChronograms;   
   }
   
   public static function getAccessControlChronogramByEmployeeDate($sType, $sEmployeeIdentification, $sDate) {
      $oAccessControlChronogram = AccessControlChronograms::model()->find('type = \'' . $sType . '\' AND employee_identification = \'' . $sEmployeeIdentification . '\' AND date = \'' . $sDate . '\'');
      
      return $oAccessControlChronogram;   
   }
   
   public static function getAccessControlAbsenceChronogramsByEmployeeDate($sEmployeeIdentification, $sDate) {
      $oAccessControlChronograms = AccessControlChronograms::model()->findAll('type <> \'' . FModuleAccessControlManagement::TYPE_CHRONOGRAM_HOLIDAY . '\' AND type <> \'' . FModuleAccessControlManagement::TYPE_CHRONOGRAM_PAUSE . '\' AND type <> \'' . FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING . '\' AND employee_identification = \'' . $sEmployeeIdentification . '\' AND date = \'' . $sDate . '\'');
      
      return $oAccessControlChronograms;   
   }
   
   public static function getAccessControlChronogram($nId) {
      $oAccessControlChronogram = AccessControlChronograms::model()->findByPk($nId);
        
      return $oAccessControlChronogram;
   }
   
   public static function isAccessControlChronogamNightTurn($oAccessControlChronogram) {
      if ($oAccessControlChronogram->type == FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING) {
         if ($oAccessControlChronogram->timetable_type == FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS) {
            return FDate::isDateMajor($oAccessControlChronogram->timetable_hour1_t1, $oAccessControlChronogram->timetable_hour2_t1);
         }
         else {
            return FDate::isDateMajor($oAccessControlChronogram->timetable_hour1_t2, $oAccessControlChronogram->timetable_hour2_t2);   
         }     
      }
      return false;     
   }
   
   public static function getAccessControlMinutesOfLastTurn($oAccessControlChronogram) {
      if ($oAccessControlChronogram->type == FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING) {
         if ($oAccessControlChronogram->timetable_type == FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS) {
            $nt1_hour2 = (int) FDate::getHour($oAccessControlChronogram->timetable_hour2_t1);
            $nt1_min2 = (int) FDate::getMinutes($oAccessControlChronogram->timetable_hour2_t1);
            
            return ($nt1_hour2 * 60) + $nt1_min2;
         }
         else {
            $nt2_hour2 = (int) FDate::getHour($oYesterdayWorkingChronogram->timetable_hour2_t2);
            $nt2_min2 = (int) FDate::getMinutes($oYesterdayWorkingChronogram->timetable_hour2_t2);
                
            return ($nt2_hour2 * 60) + $nt2_min2;
         }
      }

      return 0;   
   }
   
   public static function getAccessControlTimeTurn($oAccessControlChronogram, $bStart = true, $bFirstTurn = true) {
      if ($oAccessControlChronogram->type == FModuleAccessControlManagement::TYPE_CHRONOGRAM_WORKING) {
         if ($oAccessControlChronogram->timetable_type == FModuleAccessControlManagement::TYPE_TIMETABLE_CONTINUOUS) {
            if ($bStart) return array((int) FDate::getHour($oAccessControlChronogram->timetable_hour1_t1), (int) FDate::getMinutes($oAccessControlChronogram->timetable_hour1_t1));
            else return array((int) FDate::getHour($oAccessControlChronogram->timetable_hour2_t1), (int) FDate::getMinutes($oAccessControlChronogram->timetable_hour2_t1));
         }
         else {
            if ($bFirstTurn) {
               if ($bStart) return array((int) FDate::getHour($oAccessControlChronogram->timetable_hour1_t1), (int) FDate::getMinutes($oAccessControlChronogram->timetable_hour1_t1));
               else return array((int) FDate::getHour($oAccessControlChronogram->timetable_hour2_t1), (int) FDate::getMinutes($oAccessControlChronogram->timetable_hour2_t1));      
            }
            else {
               if ($bStart) return array((int) FDate::getHour($oAccessControlChronogram->timetable_hour1_t2), (int) FDate::getMinutes($oAccessControlChronogram->timetable_hour1_t2));
               else return array((int) FDate::getHour($oAccessControlChronogram->timetable_hour2_t2), (int) FDate::getMinutes($oAccessControlChronogram->timetable_hour2_t2));   
            }
         }
      }
      
      return array(); 
   }
}