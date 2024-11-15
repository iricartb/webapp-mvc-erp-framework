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
class Businesses extends CExportedActiveRecord {
      
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Businesses the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
   
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'businesses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name, nif', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('id', 'length', 'max'=>12),
			array('name', 'length', 'max'=>96),
			array('nif', 'length', 'max'=>14),
			array('address', 'length', 'max'=>64),
			array('mail', 'length', 'max'=>60),
			array('www', 'length', 'max'=>32),
			array('contact', 'length', 'max'=>38),
         
         array('phone, fax', 'length', 'min'=>9, 'max'=>12, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'9'))),
         
         array('id', 'match', 'pattern'=>FRegEx::getAlphaNumericNoSpacePattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_IDENTIFICATION')), 
         array('phone, fax', 'match', 'pattern'=>FRegEx::getNumericPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_ONLY_NUMERIC')),
         array('mail', 'match', 'pattern'=>FRegEx::getMailPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_MAIL')), 
         
         array('id, name, nif', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
    
         array('name, nif', 'filter', 'filter'=>'strtoupper'),
    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, nif, address, mail, phone, fax, www, contact', 'safe', 'on'=>'search'),
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
			'name'=>Yii::t('rainbow', 'MODEL_BUSINESSES_FIELD_NAME'),
			'nif'=>Yii::t('rainbow', 'MODEL_BUSINESSES_FIELD_NIF'),
			'address'=>Yii::t('rainbow', 'MODEL_BUSINESSES_FIELD_ADDRESS'),
			'mail'=>Yii::t('rainbow', 'MODEL_BUSINESSES_FIELD_MAIL'),
			'phone'=>Yii::t('rainbow', 'MODEL_BUSINESSES_FIELD_PHONE'),
			'fax'=>Yii::t('rainbow', 'MODEL_BUSINESSES_FIELD_FAX'),
			'www'=>Yii::t('rainbow', 'MODEL_BUSINESSES_FIELD_WWW'),
			'contact'=>Yii::t('rainbow', 'MODEL_BUSINESSES_FIELD_CONTACT'),
         'disable'=>Yii::t('rainbow', 'MODEL_BUSINESSES_FIELD_DISABLE'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('nif',$this->nif,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('mail',$this->mail,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('www',$this->www,true);
		$criteria->compare('contact',$this->contact,true);

      return new CActiveDataProvider($this, array(
         'criteria'=>$criteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getBusiness($id) {
      $oBusiness = Businesses::model()->findByPk($id);
      
      return $oBusiness;   
   }
   
   public static function getBusinessByNIF($nif) {
      $oBusiness = Businesses::model()->find('nif = \'' . $nif . '\'');
      
      return $oBusiness;   
   }
   
   public static function getBusinessName($id) {
      $oBusiness = Businesses::getBusiness($id);
      
      if (!is_null($oBusiness)) return $oBusiness->name;
      else return FString::STRING_EMPTY;  
   }
   
   public static function getBusinesses() {
      return Businesses::model()->findAll(array('order'=>'name ASC'));   
   }
   
   public function getExportSpecifications() {
      $this->exportSpecifications['columns'] = array('id', 'name', 'nif', 'contact', 'address', 'phone', 'fax', 'mail', 'www');
        
      $this->exportSpecifications['data'] = array();                                                     
      $this->exportSpecifications['data'][0] = array('name', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'FString::castStrToUpper(\'?\')', 'FString::STRING_EMPTY');
      $this->exportSpecifications['data'][1] = array('nif', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'FString::castStrToUpper(\'?\')', 'FString::STRING_EMPTY');
      $this->exportSpecifications['data'][2] = array('phone', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'FString::castStrToUpper(\'?\')', 'FString::STRING_EMPTY');
      $this->exportSpecifications['data'][3] = array('fax', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'FString::castStrToUpper(\'?\')', 'FString::STRING_EMPTY');

      return $this->exportSpecifications; 
   }
}