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
            'actions'=>array('index'),
            'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)',
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
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/viewFormsWorkingParts'));     
	}
}