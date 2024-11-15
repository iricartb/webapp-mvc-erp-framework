<?php

/**
 * This is the model class for table "employees".
 *
 * The followings are the available columns in table 'employees':
 * @property string $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $full_name
 * @property string $identification
 * @property integer $num_employee
 * @property string $start_date
 * @property string $end_date
 * @property string $type
 * @property string $access_code
 * @property string $access_code_FIR
 * @property string $access_code_FIR_2
 * @property integer $access_process_delay
 * @property integer $access_tolerance
 * @property string $access_information
 * @property integer $active
 * @property integer $inside
 * @property integer $show_visual_presence
 * @property string $image
 * @property integer $id_user
 * @property integer $id_business
 * @property integer $id_group_device
 * @property integer $pending_synchronize
 * @property string $pending_synchronize_action
 * @property integer $pending_synchronize_id_group_device
 */
class RemoteEmployees extends CActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormsTurnEvents the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

   /**
    * @return CDbConnection database connection
    */
   public function getDbConnection() {
      return Yii::app()->db_rainbow_remote;
   }

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'employees';
	}

   /**
    * @return array relational rules.
    */
   public function relations() {
      // NOTE: you may need to adjust the relation name and the related
      // class name for the relations automatically generated below.
      return array(
         'business'=>array(self::BELONGS_TO, 'RemoteBusinesses', 'id_business'),
      );
   }
   
   public static function getInsideDataProviderEmployees() {          
      $oCriteria = new CDbCriteria();
      
      $oCriteria->compare('inside', '1');
                    
      return new CActiveDataProvider(RemoteEmployees::model(), array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'id_business ASC, full_name ASC',
         ),
         'pagination'=>false,
      ));   
   }
}