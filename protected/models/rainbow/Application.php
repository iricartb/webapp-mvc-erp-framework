<?php

/**
 * This is the model class for table "application".
 *
 * The followings are the available columns in table 'application':
 * @property string $language
 * @property integer $login_show_browsers
 * @property string $business_name
 * @property string $business_application_text
 * @property string $business_application_text_detail
 * @property string $business_nif
 * @property string $business_address
 * @property string $business_zipcode
 * @property string $business_province
 * @property string $business_post_address
 * @property string $business_post_zipcode
 * @property string $business_post_province
 * @property string $business_phone
 * @property string $business_fax
 * @property string $business_application_logo
 * @property string $business_logo
 */
class Application extends CActiveRecord {
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Application the static model class
	 */
   public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'application';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('language', 'length', 'max'=>3),
         
         array('login_show_browsers', 'boolean'),
            
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('language', 'safe', 'on'=>'search'),
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
			'language'=>'Language',
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

		$oCriteria->compare('language', $this->language, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
	   ));  
	}
   
    public static function getApplication() {
       $oApplication = Application::model()->find();
       if (!is_null($oApplication)) return $oApplication;
       return null;
    }
    
    public static function getBusinessLogoImage() {
       $oApplication = Application::getApplication();
       
       if (!is_null($oApplication)) {
          if (!is_null($oApplication->business_logo)) return (FApplication::FOLDER_IMAGES_APPLICATION_BUSINESS . $oApplication->business_logo);
       }  
       return null; 
    }
    
    public static function getAppBusinessLogoImage() {
       $oApplication = Application::getApplication();
       
       if (!is_null($oApplication)) {
          if (!is_null($oApplication->business_application_logo)) return (FApplication::FOLDER_IMAGES_APPLICATION_BUSINESS . $oApplication->business_application_logo);
       }  
       return null; 
    }
    
    public static function getBusinessName() {
       $oApplication = Application::getApplication();
       
       if (!is_null($oApplication)) return $oApplication->business_name;
       else return FString::STRING_EMPTY; 
    }
    
    public static function getAppBusinessText() {
       $oApplication = Application::getApplication();
       
       if (!is_null($oApplication)) {
          if (!is_null($oApplication->business_application_text)) return (FString::castStrToUpper($oApplication->business_application_text));
       }  
       return FString::STRING_EMPTY; 
    }
    
    public static function getAppBusinessTextDetail() {
       $oApplication = Application::getApplication();
       
       if (!is_null($oApplication)) {
          if (!is_null($oApplication->business_application_text_detail)) return ($oApplication->business_application_text_detail);
       }  
       return FString::STRING_EMPTY; 
    }
           
    public static function showBrowsersLogin() {
       $oApplication = Application::getApplication();
       
       if (!is_null($oApplication)) {
          return $oApplication->login_show_browsers;
       }  
       return false;
    }
}