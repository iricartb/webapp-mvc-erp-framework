<?php

/**
 * This is the model class for table "purchases_module_parameters".
 *
 * The followings are the available columns in table 'purchases_module_parameters':
 * @property integer $database_providers_synchronization
 * @property string $database_providers_connection_string
 * @property string $database_providers_user
 * @property string $database_providers_passwd
 * @property string $database_providers_table
 * @property string $database_provider_where_condition
 * @property string $database_providers_table_column_nif
 * @property string $database_providers_table_columns_match
 * @property integer $range_price_without_authorization
 * @property integer $range_price_provider_year
 * @property integer $range_price_three_offers
 * @property integer $range_price_tendering    
 * @property string $folder_contracting_procedure
 * @property string $notify_smtp_mail
 * @property string $notify_smtp_host
 * @property integer $notify_smtp_port
 * @property string $notify_smtp_user
 * @property string $notify_smtp_passwd
 * @property integer $notify_smtp_ssl
 * @property integer $allow_update_purchases_forms_purchase_orders
 */
class PurchasesModuleParameters extends CActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return PurchasesModuleParameters the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
   /**
    * @return CDbConnection the database connection used for this class
    */
   public function getDbConnection() {
      return Yii::app()->db_rainbow_purchasesmanagement;
   }

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'purchases_module_parameters';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('range_price_without_authorization, range_price_provider_year, range_price_three_offers, range_price_tendering, database_providers_connection_string, database_providers_user, database_providers_table, database_providers_table_column_nif, database_providers_table_columns_match', 'required'),
			
         array('notify_smtp_mail, notify_smtp_host, notify_smtp_port, notify_smtp_user, notify_smtp_passwd', 'required'),
         
         array('database_providers_synchronization', 'numerical', 'integerOnly'=>true),
         array('database_providers_connection_string, database_provider_where_condition', 'length', 'max'=>255),
			array('database_providers_table, database_providers_table_column_nif', 'length', 'max'=>40),
			array('database_providers_user', 'length', 'max'=>12),
			array('database_providers_passwd', 'length', 'max'=>32),
         array('notify_smtp_mail, notify_smtp_host, notify_smtp_user', 'length', 'max'=>30),
         array('notify_smtp_passwd', 'length', 'max'=>20),
         
         array('range_price_without_authorization, range_price_provider_year, range_price_three_offers, range_price_tendering', 'length', 'max'=>14),
         array('range_price_without_authorization, range_price_provider_year, range_price_three_offers, range_price_tendering', 'numerical', 'min'=>0, 'max'=>9999999999.99, 'tooSmall'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_SMALL', array('{1}'=>'0')), 'tooBig'=>Yii::t('system', 'SYS_MODEL_ERROR_NUMERIC_TOO_BIG', array('{1}'=>'9999999999.99'))),
                  
         array('notify_smtp_ssl, database_providers_synchronization, allow_update_purchases_forms_purchase_orders', 'boolean'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('database_providers_synchronization, database_providers_connection_string, database_providers_user, database_providers_passwd, database_providers_table, database_providers_table_column_nif, database_providers_table_columns_match, notify_smtp_mail, notify_smtp_host, notify_smtp_port, notify_smtp_user, notify_smtp_passwd, notify_smtp_ssl, allow_update_purchases_forms_purchase_orders', 'safe', 'on'=>'search'),
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
			'database_providers_synchronization' => 'Database Providers Synchronization',
			'database_providers_connection_string' => 'Database Providers Connection String',
			'database_providers_user' => 'Database Providers User',
			'database_providers_passwd' => 'Database Providers Passwd',
			'database_providers_table' => 'Database Providers Table',
         'database_provider_where_condition' => 'Database Providers Where Condition',
         'database_providers_table_column_nif' => 'Database Providers Table Column Nif',
			'database_providers_table_columns_match' => 'Database Providers Table Columns Match',
         'range_price_without_authorization'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESMODULEPARAMETERS_FIELD_RANGEPRICEWITHOUTAUTHORIZATION'),
         'range_price_provider_year'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESMODULEPARAMETERS_FIELD_RANGEPRICEPROVIDERYEAR'),
         'range_price_three_offers'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESMODULEPARAMETERS_FIELD_RANGEPRICETHREEOFFERS'),
         'range_price_tendering'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESMODULEPARAMETERS_FIELD_RANGEPRICETENDERING'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('database_providers_synchronization',$this->database_providers_synchronization);
		$criteria->compare('database_providers_connection_string',$this->database_providers_connection_string,true);
		$criteria->compare('database_providers_user',$this->database_providers_user,true);
		$criteria->compare('database_providers_passwd',$this->database_providers_passwd,true);
		$criteria->compare('database_providers_table',$this->database_providers_table,true);
      $criteria->compare('database_providers_table_column_nif',$this->database_providers_table_column_nif,true);
		$criteria->compare('database_providers_table_columns_match',$this->database_providers_table_columns_match,true);
      
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

   public static function getPurchasesModuleParameters() {
      $oPurchasesModuleParameters = PurchasesModuleParameters::model()->find();
       
      return $oPurchasesModuleParameters;
   }
}