<?php
require_once('protected/functions/FApplication.class.php');
require_once('protected/functions/FForm.class.php');

class SiteController extends Controller {
   public $bRefreshLayout = true;
   public $bErrorCredentials = false;
    
   // Redeclare init method from parent Controller
   public function init() {
      $oApplication = Application::getApplication();
      if (!is_null($oApplication)) Yii::app()->setLanguage($oApplication->language);
      
      parent::init();
   }
   
	/**
	 * Declares class-based actions.
	 */
	public function actions() {
		return array();
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex($bRefreshLayout = true) { 
      $oLoginForm = new LoginForm;
      $this->bRefreshLayout = $bRefreshLayout;
      $nStatusLogin = 0;
      
      if ((!$oLoginForm->isAuthenticate()) || (Users::getNumAvaliableModulesForUser(Yii::app()->user->id) == 0)) {
         if ($oLoginForm->isAuthenticate()) Yii::app()->user->logout();
          
         FForm::validateAjaxForm('login-form', $oLoginForm);
                
         if (isset($_POST['LoginForm'])) {
            $this->bRefreshLayout = false;
             
            // Get username & password
            $oLoginForm->attributes = $_POST['LoginForm'];
            
            if ($oLoginForm->validate()) {
                $nStatusLogin = $oLoginForm->login();
                if ($nStatusLogin == FApplication::ACCESS_OK) $this->sJsOnLoad = 'jquerySimpleAnimationChangeAllContent(\'' . $this->createUrl(Yii::app()->params['frontEndUrl']) . '\', null, \'document\', \'' . FAjax::TYPE_METHOD_CONTENT_DECORATION_ROLL . '\', 700);';
                else if ($nStatusLogin == FApplication::ACCESS_ERR_USERNAME_OR_PASSWD) $this->bErrorCredentials = true;
                else if ($nStatusLogin == FApplication::ACCESS_ERR_NO_MODULES_AVALIABLES) $this->sJsOnLoad = 'jquerySimpleAnimationChangeAllContent(\'' . $this->createUrl(Yii::app()->params['backEndUrl']) . '\', null, \'document\', \'' . FAjax::TYPE_METHOD_CONTENT_DECORATION_ROLL . '\', 700);';
            }
         }
         else $oLoginForm->bRememberMe = true;
         
		   $this->render('index', array('modelForm'=>$oLoginForm));
      }
      else {
         $this->redirect($this->createUrl(Yii::app()->params['frontEndUrl']));
      }
	}
    
	/**
	 * This is the action to handle external exceptions.
	 */
   public function actionError($sErrTextKey = null) {
      $this->layout = FApplication::LAYOUT_ERROR;
        
		if ($oError = Yii::app()->errorHandler->error) {
         $oError['deleteRecord'] = false;
			if (Yii::app()->request->isAjaxRequest) echo $oError['message'];
			else $this->render('error', $oError);
		}
      else {
         if ($sErrTextKey == 'ERROR_RECORD_NOT_EXIST') {
            $this->render('error', array('code'=>Yii::t('system', 'SYS_APPLICATION_DELETE_RECORD_ERROR_CODE'), 'message'=>Yii::t('error', $sErrTextKey), 'deleteRecord'=>true));    
         }
         else {
            $this->render('error', array('code'=>Yii::t('system', 'SYS_APPLICATION_ERROR_CODE'), 'message'=>Yii::t('error', $sErrTextKey), 'deleteRecord'=>false));
         }
      } 
	}
}