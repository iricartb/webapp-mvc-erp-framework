<?php

/**
 * This is the model class for table "visitors_visits".
 *
 * The followings are the available columns in table 'visitors_visits':
 * @property integer $id
 * @property integer $card_id
 * @property string $card_code
 * @property string $card_information
 * @property string $employee
 * @property string $employee_identification
 * @property string $employee_comments
 * @property string $visitor_first_name
 * @property string $visitor_middle_name
 * @property string $visitor_last_name
 * @property string $visitor_full_name
 * @property string $visitor_identification
 * @property string $visitor_business
 * @property integer $visitor_vehicle
 * @property string $visitor_vehicle_plate
 * @property string $visitor_destiny_vehicle
 * @property string $visitor_comments
 * @property string $visitor_signature
 * @property string $reason
 * @property string $type
 * @property integer $status
 * @property string $start_date
 * @property string $end_date
 */
class RemoteVisitorsVisits extends CActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormsTurnEvents the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

   /**
    * @return CDbConnection the database connection used for this class
    */
   public function getDbConnection() {
      return Yii::app()->db_rainbow_visitorsmanagement_remote;
   }

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'visitors_visits';
	}

   public static function getInsideDataProviderVisitorsVisits() {
      $oCriteria = new CDbCriteria();
      
      $oCriteria->compare('status', FModuleVisitorsManagement::STATUS_INSIDE);
      
      return new CActiveDataProvider(RemoteVisitorsVisits::model(), array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'visitor_business ASC, visitor_full_name ASC',
         ),
         'pagination'=>false,
      ));
   }
}