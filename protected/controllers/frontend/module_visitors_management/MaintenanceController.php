<?php

class MaintenanceController extends FrontendController {
    
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(    
            array('allow', // allow authenticated user and have valid module roles to perform actions
                'actions'=>array('viewPlates', 'viewDetailPlate', 'updatePlate', 'deletePlate'),
                'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT)) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT)))',
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    
    
    public function actionViewPlates() {
       $oVisitorsPlate = new VisitorsPlates();
       $oVisitorsPlateFilters = new VisitorsPlates();
       $oVisitorsPlateFilters->unsetAttributes();
       
       // Ajax validation request=>Unique validator
       FForm::validateAjaxForm('visitors-plate-form', $oVisitorsPlate);
          
       if (isset($_POST['VisitorsPlates'])) {
          $oEmployee = Employees::getEmployeeByIdentification($_POST['VisitorsPlates']['employee_identification']);
          
          if (!is_null($oEmployee)) {
             $oVisitorsPlate->attributes = $_POST['VisitorsPlates'];
             
             $oVisitorsPlate->employee = $oEmployee->full_name;   
             $oVisitorsPlate->save();
          }
          else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST'))); 
       }
       else {
          // Filters Grid Get Parameters
          if (isset($_GET['VisitorsPlates'])) $oVisitorsPlateFilters->attributes = $_GET['VisitorsPlates'];
       }
       
       $oVisitorsPlate->unsetAttributes(); 
       $this->render('viewPlates', array('oModelForm'=>$oVisitorsPlate, 'oModelFormFilters'=>$oVisitorsPlateFilters));  
    }

    
    public function actionViewDetailPlate($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oVisitorsPlate = VisitorsPlates::getVisitorsPlate($nIdForm);
        
       if (!is_null($oVisitorsPlate)) $this->render('viewDetailPlate', array('oModelForm'=>$oVisitorsPlate));
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
    }
    
    
    public function actionUpdatePlate($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oVisitorsPlate = VisitorsPlates::getVisitorsPlate($nIdForm);
        
       if (!is_null($oVisitorsPlate)) {
          // Ajax validation request=>Unique validator
          FForm::validateAjaxForm('visitors-plate-form', $oVisitorsPlate);
             
          if (isset($_POST['VisitorsPlates'])) {
             $oVisitorsPlate->attributes = $_POST['VisitorsPlates'];

             $oVisitorsPlate->save();
               
             $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/maintenance/viewDetailPlate', array('nIdForm'=>$nIdForm)));
          }
          else $this->render('updatePlate', array('oModelForm'=>$oVisitorsPlate));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
    }

    
    public function actionDeletePlate($nIdForm) {
        $oVisitorsPlate = VisitorsPlates::getVisitorsPlate($nIdForm);
        if (!is_null($oVisitorsPlate)) $oVisitorsPlate->delete();

        $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/maintenance/viewPlates'));
    }
}