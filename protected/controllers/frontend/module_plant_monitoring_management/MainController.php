<?php

class MainController extends FrontendController {

   /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
   public function accessRules() {
      return array(    
         array('allow', // allow authenticated user and have valid module roles to perform actions
            'actions'=>array('viewFormsTurnRounds', 'viewDetailFormTurnRound'),
            'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MONITORING_MANAGEMENT)',
         ), 
         array('allow', // allow authenticated user
            'actions'=>array('viewDetailFormTurnRound'),
            'users'=>array('@'),
         ),  
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }

   
   public function actionViewFormsTurnRounds() {
      $oMonitoringFormTurnRoundFilters = new MonitoringFormsTurnRounds();
      $oMonitoringFormTurnRoundFilters->unsetAttributes();
      
      // Filters Grid Get Parameters
      if (isset($_GET['MonitoringFormsTurnRounds'])) {
         $oMonitoringFormTurnRoundFilters->attributes = $_GET['MonitoringFormsTurnRounds'];
         if (isset($_GET['MonitoringFormsTurnRounds']['end_date'])) $oMonitoringFormTurnRoundFilters->end_date = $_GET['MonitoringFormsTurnRounds']['end_date'];  
      }
      
      $this->render('viewFormsTurnRounds', array('oModelFormFilters'=>$oMonitoringFormTurnRoundFilters)); 
   } 
   
   public function actionViewDetailFormTurnRound($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oMonitoringFormTurnRound = MonitoringFormsTurnRounds::getMonitoringFormTurnRound($nIdForm);
       
      if (!is_null($oMonitoringFormTurnRound)) $this->render('viewDetailFormTurnRound', array('oModelForm'=>$oMonitoringFormTurnRound));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
   }
}