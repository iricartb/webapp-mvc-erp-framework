<?php

class SiteController extends FrontendController {

   /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
   public function accessRules() {
      return array(    
         array('allow', // allow authenticated user and have valid module roles to perform actions
            'actions'=>array('index', 'viewVisitorFields'),
            'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT)',
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
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/main/viewVisits'));
	}
   
   public function actionViewVisitorFields($identification) {
      $this->layout = null;
      $oVisitor = Visitors::getVisitorByIdentification($identification);
      
      $this->render('viewVisitorFields', array('oModelForm'=>$oVisitor));        
   }
}