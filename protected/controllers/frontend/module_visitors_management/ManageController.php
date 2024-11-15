<?php

class ManageController extends FrontendController {
    
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(    
            array('allow', // allow admin user to perform actions
                'actions'=>array('viewVisitorsCards', 'viewDetailVisitorCard', 'updateVisitorCard', 'deleteVisitorCard', 'viewVisitors', 'viewDetailVisitor', 'updateVisitor', 'deleteVisitor'),
                'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT)) && (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT)))',
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    
    
    public function actionViewVisitorsCards() {
       $oVisitorCard = new VisitorsCards();
       $oVisitorCardFilters = new VisitorsCards();
       $oVisitorCardFilters->unsetAttributes();
       
       // Ajax validation request=>Unique validator
       FForm::validateAjaxForm('visitor-card-form', $oVisitorCard);
        
       if (isset($_POST['VisitorsCards'])) {
          $oVisitorCard->attributes = $_POST['VisitorsCards'];
            
          $oVisitorCard->save();
       }
       else { 
          // Filters Grid Get Parameters
          if (isset($_GET['VisitorsCards'])) $oVisitorCardFilters->attributes = $_GET['VisitorsCards'];
       }
        
       $oVisitorCard->unsetAttributes();
       $this->render('viewVisitorsCards', array('oModelForm'=>$oVisitorCard, 'oModelFormFilters'=>$oVisitorCardFilters));     
    } 
    public function actionViewVisitors() {
       $oVisitor = new Visitors();
       $oVisitorFilters = new Visitors();
       $oVisitorFilters->unsetAttributes();
       
       // Ajax validation request=>Unique validator
       FForm::validateAjaxForm('visitor-form', $oVisitor);
          
       if (isset($_POST['Visitors'])) {
          $oVisitor->attributes = $_POST['Visitors'];
                
          $oVisitor->save();
       }
       else { 
          // Filters Grid Get Parameters
          if (isset($_GET['Visitors'])) $oVisitorFilters->attributes = $_GET['Visitors'];
       }
        
       $oVisitor->unsetAttributes();
       $this->render('viewVisitors', array('oModelForm'=>$oVisitor, 'oModelFormFilters'=>$oVisitorFilters));  
    }
    
     
    public function actionViewDetailVisitorCard($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oVisitorCard = VisitorsCards::getVisitorCard($nIdForm);
        
       if (!is_null($oVisitorCard)) $this->render('viewDetailVisitorCard', array('oModelForm'=>$oVisitorCard));
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
    }
    public function actionViewDetailVisitor($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oVisitor = Visitors::getVisitor($nIdForm);
        
       if (!is_null($oVisitor)) $this->render('viewDetailVisitor', array('oModelForm'=>$oVisitor));
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));         
    }
    
    
    public function actionUpdateVisitorCard($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oVisitorCard = VisitorsCards::getVisitorCard($nIdForm);
        
       if (!is_null($oVisitorCard)) {
          // Ajax validation request=>Unique validator
          FForm::validateAjaxForm('visitor-card-form', $oVisitorCard);
          
          if (isset($_POST['VisitorsCards'])) {
             $oVisitorCard->attributes = $_POST['VisitorsCards'];
               
             $oVisitorCard->save();
               
             $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/manage/viewDetailVisitorCard', array('nIdForm'=>$nIdForm)));
          }
          else $this->render('updateVisitorCard', array('oModelForm'=>$oVisitorCard));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
    }
    public function actionUpdateVisitor($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oVisitor = Visitors::getVisitor($nIdForm);
        
       if (!is_null($oVisitor)) {
          // Ajax validation request=>Unique validator
          FForm::validateAjaxForm('visitor-form', $oVisitor);
             
          if (isset($_POST['Visitors'])) {
             $oVisitor->attributes = $_POST['Visitors'];
             if (strlen($oVisitor->last_name) > 0) $oVisitor->full_name = $oVisitor->first_name . FString::STRING_SPACE . $oVisitor->middle_name . FString::STRING_SPACE . $oVisitor->last_name;
             else $oVisitor->full_name = $oVisitor->first_name . FString::STRING_SPACE . $oVisitor->middle_name;
            
             $oVisitor->save();
               
             $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/manage/viewDetailVisitor', array('nIdForm'=>$nIdForm)));
          }
          else $this->render('updateVisitor', array('oModelForm'=>$oVisitor));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
    }

    
    public function actionDeleteVisitorCard($nIdForm) {
        $oVisitorCard = VisitorsCards::getVisitorCard($nIdForm);
        if (!is_null($oVisitorCard)) $oVisitorCard->delete();

        $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/manage/viewVisitorsCards'));
    }
    public function actionDeleteVisitor($nIdForm) {
        $oVisitor = Visitors::getVisitor($nIdForm);
        if (!is_null($oVisitor)) $oVisitor->delete();
 
        $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/manage/viewVisitors'));
    }
}