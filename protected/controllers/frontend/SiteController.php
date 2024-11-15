<?php
require_once('protected/functions/FApplication.class.php');
require_once('protected/functions/FForm.class.php');

class SiteController extends FrontendController {

   /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
   public function accessRules() {
      return array(    
         array('allow', // allow authenticated user and have valid module roles to perform actions
            'actions'=>array('index', 'setCurrentApplication', 'logout', 'viewEventsNotifications', 'updateCredentials', 'changeLanguage', 'changeStateEventsNotification', 'checkPendingEvents'),
            'expression'=>'(Users::getNumAvaliableModulesForUser(Yii::app()->user->id) > 0)',
         ),
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }    

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex() {
      // Redirect user to default application index page
      $oUser = Users::getUser(Yii::app()->user->id);
      if (!is_null($oUser)) {
         $this->redirect($this->createUrl('frontend/' . strtolower($oUser->def_application) . '/site/index'));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_USER_UNKNOWN')));
	}
   
   
   public function actionViewEventsNotifications() {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oEvent = new Events();
   
      $oEventsUser = EventsUsers::getEventsUsers(Yii::app()->user->id);
      foreach($oEventsUser as $oEventUser) {
         $oEventUser->read_event = true;
         $oEventUser->save();   
      }
      
      $this->render('viewEventsNotifications', array('oModelForm'=>$oEvent));      
   }
   
   
   public function actionChangeLanguage($sLanguage) {
      if (($sLanguage == FApplication::LANGUAGE_ES) || ($sLanguage == FApplication::LANGUAGE_CA)) {
         $oUser = Users::getUser(Yii::app()->user->id);
         if (!is_null($oUser)) {
            $oUser->language = $sLanguage;
            $oUser->save();   
         }
      }   
      $this->redirect($this->createUrl('frontend/' . strtolower($oUser->def_application) . '/site/index'));
   }
   public function actionChangeStateEventsNotification() {
      $oUser = Users::getUser(Yii::app()->user->id);
      if (!is_null($oUser)) {
         $oUser->notify_events = !$oUser->notify_events;
         $oUser->save();   
      }
      $this->redirect($this->createUrl('frontend/' . strtolower($oUser->def_application) . '/site/index'));      
   }
   
   
   public function actionSetCurrentApplication($sAppName) {
      if (Users::getIsAvaliableModuleForUser(Yii::app()->user->id, $sAppName)) {
         $oUser = Users::getUser(Yii::app()->user->id);
         if (!is_null($oUser)) {
            $oUser->def_application = $sAppName;
            $oUser->save();
             
            $this->redirect($this->createUrl('frontend/' . strtolower($sAppName) . '/site/index'));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_USER_UNKNOWN')));          
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_APPLICATION_NOT_DEFINED_OR_NOT_ASSIGNED')));    
   }
   
   
   public function actionUpdateCredentials() {
      $this->layout = FApplication::LAYOUT_POPUP_SIMPLE;
      $oCredentialForm = CredentialsForm::getCredentialForm(Yii::app()->user->id);
                                
      if (!is_null($oCredentialForm)) {
         if (isset($_POST['CredentialsForm'])) {              
            if ($oCredentialForm->passwd == md5($_POST['CredentialsForm']['passwd'])) {   
               $oUser = Users::getUser(Yii::app()->user->id);
               if (!is_null($oUser)) {
                  $this->sJsOnLoad = 'parent.$.fancybox.close();';
                  $oUser->passwd = md5($_POST['CredentialsForm']['sNewPasswd1']);  
                  $oUser->save(); 
               } 
            }
            else {
               $oCredentialForm->newPasswd1 = $_POST['CredentialsForm']['sNewPasswd1'];
               $oCredentialForm->newPasswd2 = $_POST['CredentialsForm']['sNewPasswd2'];
               $oCredentialForm->addError('passwd', Yii::t('frontend', 'PAGE_UPDATECREDENTIALS_FORM_SUBMIT_ERROR_INCORRECT_PASSWD'));
            }
         }
         $this->render('updateCredentials', array('modelForm'=>$oCredentialForm));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));   
   }
   
   
   public function actionCheckPendingEvents() {
      $this->layout = null;
      $sContent = FString::STRING_EMPTY;
      
      $oUser = Users::getUser(Yii::app()->user->id);
      if (!is_null($oUser)) {
         $sMinDate = date('Y-m-d', strtotime('-' . Yii::app()->params['paramEventsRequestMaxLastDays'] . ' days', strtotime(date('Y-m-d'))));

         $oEventsUser = EventsUsers::getEventsUsers($oUser->id, false, false, $sMinDate);
         if (count($oEventsUser) > 0) {
            $oEventUser = $oEventsUser[0];
            $oEvent = Events::getEvent($oEventUser->id_event);
            if (!is_null($oEvent)) {
               $sContent = '<div class="box_event">'; 
               $sContent .= '<div class="box_event_image"><img src="' . FApplication::FOLDER_IMAGES_APPLICATION_EVENTS . 'bell.png" /></div>';
               $sContent .= '<div class="box_event_message">';
               $sContent .= '<div class="box_event_message_header">';
               
               $sContent .= '<div class="box_event_message_header_box_title">';
               $sContent .= '<div class="box_event_message_header_title">';
               if ($oEvent->translate) $sContent .= Yii::t('rainbow', $oEvent->title);
               else $sContent .= $oEvent->title;
               $sContent .= '</div>';
               
               $sContent .= '<div class="box_event_message_header_date">';
               $sContent .= FDate::getTimeZoneFormattedDate($oEvent->send_date, true);
               $sContent .= '</div>';
               
               if (!$oEvent->system) {
                  if (!is_null($oEvent->id_user)) {
                     $sContent .= '<div class="box_event_message_header_owner">';
                     $sContent .= Users::getFullName($oEvent->id_user);
                     $sContent .= '</div>';
                  }
               }
               $sContent .= '</div>'; 
               
               $sContent .= '<div class="box_event_message_header_box_pagination">';
               $sContent .= '<div class="box_event_message_header_pagination">';
               $sContent .= count($oEventsUser);
               $sContent .= '</div>';
               $sContent .= '</div>';
               
               $sContent .= '</div>';     
               $sContent .= '<div class="box_event_message_body">';
               if ($oEvent->translate) {
                  if (is_null($oEvent->message_parameter)) $sContent .= Yii::t('rainbow', $oEvent->message);
                  else $sContent .= Yii::t('rainbow', $oEvent->message, array('{1}'=>$oEvent->message_parameter)); 
               }
               else $sContent .= $oEvent->message;
               $sContent .= '</div>';  
               $sContent .= '</div></div>';   
               
               $oEventUser->notify_event = true;
               $oEventUser->save();  
               
               if (!$oUser->notify_events) $sContent = FAjax::STATUS_RESPONSE_NO_REPLACE_NO_AFTERACTION_YES_AFTERACTION_ALTERNATIVE; 
            }  
            else $sContent = FAjax::STATUS_RESPONSE_NO_REPLACE_NO_AFTERACTION_YES_AFTERACTION_ALTERNATIVE;    
         }
         else $sContent = FAjax::STATUS_RESPONSE_NO_REPLACE_NO_AFTERACTION_YES_AFTERACTION_ALTERNATIVE;
      }
      else $sContent = FAjax::STATUS_RESPONSE_NO_REPLACE_NO_AFTERACTION_YES_AFTERACTION_ALTERNATIVE;
        
      $this->renderText($sContent);
   }
   
   
   public function actionLogout() {
      $this->sJsOnLoad = 'jquerySimpleAnimationChangeAllContent(\'' . $this->createUrl(Yii::app()->params['loginUrl']) . '\', null, \'document\', \'' . FAjax::TYPE_METHOD_CONTENT_DECORATION_ROLL . '\', 700);';
      
      Yii::app()->user->logout();
                             
      $this->render('index');    
   }
}