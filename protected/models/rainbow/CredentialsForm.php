<?php

/**
 * CredentialsForm class.
 * CredentialsForm is the data structure for keeping
 */
class CredentialsForm extends Users {
	public $sNewPasswd1;
   public $sNewPasswd2;

   /**
    * @return array validation rules for model attributes.
    */
	public function rules() {
      // NOTE: you should only define rules for those attributes that
      // will receive user inputs.
      $oCurrentRules = array(
         array('sNewPasswd1', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('sNewPasswd2', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('sNewPasswd1', 'length', 'min'=>6, 'max'=>32, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'6'))),
         array('sNewPasswd2', 'length', 'min'=>6, 'max'=>32, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'6'))),
         
         array('passwd', 'match', 'pattern'=>FRegEx::getPasswdPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_GENERIC')),
         array('sNewPasswd1', 'match', 'pattern'=>FRegEx::getPasswdPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_GENERIC')),
         array('sNewPasswd2', 'match', 'pattern'=>FRegEx::getPasswdPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_GENERIC')),
    
         array('sNewPasswd2', 'compare', 'compareAttribute'=>'sNewPasswd1', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_NOT_EQUAL')),
      );
        
      return array_merge($oCurrentRules, parent::rules());
	}

   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      $oCurrentAttributeLabels = array(
         'passwd'=>Yii::t('rainbow', 'MODEL_CREDENTIALSFORM_FIELD_PASSWD'),
         'sNewPasswd1'=>Yii::t('rainbow', 'MODEL_CREDENTIALSFORM_FIELD_NEWPASSWD1'),
         'sNewPasswd2'=>Yii::t('rainbow', 'MODEL_CREDENTIALSFORM_FIELD_NEWPASSWD2'),
      );
        
      return array_merge(parent::attributeLabels(), $oCurrentAttributeLabels);
   }

   public static function getCredentialForm($nId) {
      $oUser = CredentialsForm::model()->findByPk($nId);
 
      if (!is_null($oUser)) {
         $oCredentialForm = new CredentialsForm();
         
         $oCredentialForm->id = $oUser->id;
         $oCredentialForm->attributes = $oUser->attributes;
         
         return $oCredentialForm;     
      }
      else return null;
   }
}
