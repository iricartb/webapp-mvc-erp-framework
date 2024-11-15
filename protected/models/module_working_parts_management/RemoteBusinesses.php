<?php

/**
 * This is the model class for table "businesses".
 *
 * The followings are the available columns in table 'businesses':
 * @property integer $id
 * @property string $name
 * @property string $nif
 * @property string $address
 * @property string $mail
 * @property string $phone
 * @property string $fax
 * @property string $www
 * @property string $contact
 */
class RemoteBusinesses extends CActiveRecord {

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
      return Yii::app()->db_rainbow_remote; 
   }

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'businesses';
	}
}