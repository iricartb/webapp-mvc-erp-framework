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
                'actions'=>array('viewControllers', 'viewDetailController', 'updateController', 'deleteController', 'viewDevices', 'viewDetailDevice', 'updateDevice', 'deleteDevice', 'viewGroupsDevices', 'viewDetailGroupDevice', 'updateGroupDevice', 'deleteGroupDevice', 'viewDetailDeviceGroupDevice', 'deleteDeviceGroupDevice', 'viewCommands', 'updateCommandDateTime', 'updateCommandLockDoors', 'updateCommandUnlockDoors', 'updateCommandOpenDoors', 'updateCommandFreeOut', 'updateCommandUnfreeOut'),
                'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)) && (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT)))',
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    
      
    public function actionViewControllers() {
       $oAccessControlController = new AccessControlControllers();
       $oAccessControlControllerFilters = new AccessControlControllers();
       $oAccessControlControllerFilters->unsetAttributes();
       
       // Ajax validation request=>Unique validator
       FForm::validateAjaxForm('access-control-controller-form', $oAccessControlController);
       
       if (isset($_POST['AccessControlControllers'])) {
          $oAccessControlController->attributes = $_POST['AccessControlControllers'];
          
          if (FSocket::ping($oAccessControlController->ipv4) != false) $oAccessControlController->status = FModuleAccessControlManagement::STATUS_DEVICE_ONLINE; 
          else $oAccessControlController->status = FModuleAccessControlManagement::STATUS_DEVICE_OFFLINE;
            
          $oAccessControlController->save(false);
       }
       else { 
          // Filters Grid Get Parameters
          if (isset($_GET['AccessControlControllers'])) $oAccessControlControllerFilters->attributes = $_GET['AccessControlControllers'];
          else {
             // Actualize all status devices
             $oAccessControlControllers = AccessControlControllers::getAccessControlControllers();
             foreach($oAccessControlControllers as $oAccessControlController) {
                if (FSocket::ping($oAccessControlController->ipv4) != false) $oAccessControlController->status = FModuleAccessControlManagement::STATUS_DEVICE_ONLINE; 
                else $oAccessControlController->status = FModuleAccessControlManagement::STATUS_DEVICE_OFFLINE;
                  
                $oAccessControlController->save(false); 
             }
          }
       }
       
       $oAccessControlController->unsetAttributes(); 
       $this->render('viewControllers', array('oModelForm'=>$oAccessControlController, 'oModelFormFilters'=>$oAccessControlControllerFilters));     
    }
    public function actionViewDevices() {
       $oAccessControlDevice = new AccessControlDevices();
       $oAccessControlDeviceFilters = new AccessControlDevices();
       $oAccessControlDeviceFilters->unsetAttributes();
       
       // Ajax validation request=>Unique validator
       FForm::validateAjaxForm('access-control-device-form', $oAccessControlDevice);
       
       if (isset($_POST['AccessControlDevices'])) {
          $oAccessControlDevice->attributes = $_POST['AccessControlDevices'];
          
          $oAccessControlDevice->type = $_POST['AccessControlDevices']['type'];
          
          if ($oAccessControlDevice->type == FModuleAccessControlManagement::TYPE_INPUT_OUTPUT) {
             $oAccessControlDevice->type = null;   
          }
          
          if (FSocket::ping($oAccessControlDevice->ipv4) != false) $oAccessControlDevice->status = FModuleAccessControlManagement::STATUS_DEVICE_ONLINE; 
          else $oAccessControlDevice->status = FModuleAccessControlManagement::STATUS_DEVICE_OFFLINE;
            
          $oAccessControlDevice->save(false);
       }
       else { 
          // Filters Grid Get Parameters
          if (isset($_GET['AccessControlDevices'])) $oAccessControlDeviceFilters->attributes = $_GET['AccessControlDevices'];
          else {
             // Actualize all status devices
             $oAccessControlDevices = AccessControlDevices::getAccessControlDevices();
             foreach($oAccessControlDevices as $oAccessControlDevice) {
                if (!$oAccessControlDevice->disabled) {
                   if (FSocket::ping($oAccessControlDevice->ipv4) != false) $oAccessControlDevice->status = FModuleAccessControlManagement::STATUS_DEVICE_ONLINE; 
                   else $oAccessControlDevice->status = FModuleAccessControlManagement::STATUS_DEVICE_OFFLINE;
                }
                  
                $oAccessControlDevice->save(false); 
             }
          }
       }
       
       $oAccessControlDevice->unsetAttributes(); 
       $this->render('viewDevices', array('oModelForm'=>$oAccessControlDevice, 'oModelFormFilters'=>$oAccessControlDeviceFilters));     
    } 
    public function actionViewGroupsDevices() {
      $oAccessControlGroupDevice = new AccessControlGroupsDevices();
      $oAccessControlDeviceGroupDevice = new AccessControlDevicesGroupsDevices();
      $oAccessControlGroupDeviceFilters = new AccessControlGroupsDevices();
      $oAccessControlGroupDeviceFilters->unsetAttributes();
      $oAccessControlDeviceGroupDeviceFilters = new AccessControlDevicesGroupsDevices();
      $oAccessControlDeviceGroupDeviceFilters->unsetAttributes();
      
      if (isset($_POST['AccessControlGroupsDevices'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('access-control-group-device-form', $oAccessControlGroupDevice);
      
         $oAccessControlGroupDevice->attributes = $_POST['AccessControlGroupsDevices'];

         $oAccessControlGroupDevice->save();
      }
      else {    
         if (isset($_POST['AccessControlDevicesGroupsDevices'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('access-control-device-group-device-form', $oAccessControlDeviceGroupDevice);
            
            try {
               $bErrorTransaction = false;
               $oTransaction = Yii::app()->db_rainbow_accesscontrolmanagement->beginTransaction();
               
               $oAccessControlDeviceGroupDevice->attributes = $_POST['AccessControlDevicesGroupsDevices'];
          
               if ($oAccessControlDeviceGroupDevice->save()) {  
                  if (AccessControlGroupsDevices::isAccessControlGroupDeviceLocked($oAccessControlDeviceGroupDevice->id_group_device)) {
                     $bErrorTransaction = !FModuleAccessControlManagement::enrollEmployeesByIdGroupDeviceAndIdDevice($oAccessControlDeviceGroupDevice->id_group_device, $oAccessControlDeviceGroupDevice->id_device);
                  } 
               }
               
               if (!$bErrorTransaction) { 
                  $oTransaction->commit();  
               }
               else $oTransaction->rollback();
            } catch (Exception $e) { if (!is_null($oTransaction)) $oTransaction->rollback(); }         
         }
         else {
            // Filters Grid Get Parameters
            if (isset($_GET['AccessControlGroupsDevices'])) $oAccessControlGroupDeviceFilters->attributes = $_GET['AccessControlGroupsDevices'];
              
            // Filters Grid Get Parameters
            if (isset($_GET['AccessControlDevicesGroupsDevices'])) $oAccessControlDeviceGroupDeviceFilters->attributes = $_GET['AccessControlDevicesGroupsDevices'];   
         }   
      }

      $oAccessControlGroupDevice->unsetAttributes();
      $oAccessControlDeviceGroupDevice->unsetAttributes();
      $this->render('viewGroupsDevices', array('oModelForm'=>$oAccessControlGroupDevice, 'oModelFormFilters'=>$oAccessControlGroupDeviceFilters, 'oModelFormAssociation'=>$oAccessControlDeviceGroupDevice, 'oModelFormAssociationFilters'=>$oAccessControlDeviceGroupDeviceFilters)); 
    }
    public function actionViewCommands() {
       $this->render('viewCommands');     
    } 
    
    
    public function actionViewDetailController($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oAccessControlController = AccessControlControllers::getAccessControlController($nIdForm);
        
       if (!is_null($oAccessControlController)) $this->render('viewDetailController', array('oModelForm'=>$oAccessControlController));
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
    }
    public function actionViewDetailDevice($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oAccessControlDevice = AccessControlDevices::getAccessControlDevice($nIdForm);
        
       if (!is_null($oAccessControlDevice)) $this->render('viewDetailDevice', array('oModelForm'=>$oAccessControlDevice));
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
    }
    public function actionViewDetailGroupDevice($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oAccessControlGroupDevice = AccessControlGroupsDevices::getAccessControlGroupDevice($nIdForm);
        
       if (!is_null($oAccessControlGroupDevice)) $this->render('viewDetailGroupDevice', array('oModelForm'=>$oAccessControlGroupDevice));
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
    }
    public function actionViewDetailDeviceGroupDevice($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       $oAccessControlDeviceGroupDevice = AccessControlDevicesGroupsDevices::getAccessControlDeviceGroupDevice($nIdForm);
        
       if (!is_null($oAccessControlDeviceGroupDevice)) $this->render('viewDetailDeviceGroupDevice', array('oModelForm'=>$oAccessControlDeviceGroupDevice));
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
    }
     
     
    public function actionUpdateController($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       
       $oAccessControlController = AccessControlControllers::getAccessControlController($nIdForm);
                                
       if (!is_null($oAccessControlController)) {
          // Ajax validation request=>Unique validator
          FForm::validateAjaxForm('access-control-controller-form', $oAccessControlController);
       
          if (isset($_POST['AccessControlControllers'])) {
             $oAccessControlController->attributes = $_POST['AccessControlControllers'];
             
             if (FSocket::ping($oAccessControlController->ipv4) != false) $oAccessControlController->status = FModuleAccessControlManagement::STATUS_DEVICE_ONLINE; 
             else $oAccessControlController->status = FModuleAccessControlManagement::STATUS_DEVICE_OFFLINE;
           
             $oAccessControlController->save();

             $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/viewDetailController', array('nIdForm'=>$oAccessControlController->id)));
          }
          else $this->render('updateController', array('oModelForm'=>$oAccessControlController));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
    }
    public function actionUpdateDevice($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       
       $oAccessControlDevice = AccessControlDevices::getAccessControlDevice($nIdForm);
                                
       if (!is_null($oAccessControlDevice)) {
          if (is_null($oAccessControlDevice->type)) $oAccessControlDevice->type = FModuleAccessControlManagement::TYPE_INPUT_OUTPUT;

          // Ajax validation request=>Unique validator
          FForm::validateAjaxForm('access-control-device-form', $oAccessControlDevice);
       
          if (isset($_POST['AccessControlDevices'])) {
             $oAccessControlDevice->attributes = $_POST['AccessControlDevices'];
             
             $oAccessControlDevice->disabled = $_POST['AccessControlDevices']['disabled'];
             
             if ($oAccessControlDevice->type == FModuleAccessControlManagement::TYPE_INPUT_OUTPUT) {
                $oAccessControlDevice->type = null;   
             }
          
             if (!$oAccessControlDevice->disabled) {
                if (FSocket::ping($oAccessControlDevice->ipv4) != false) $oAccessControlDevice->status = FModuleAccessControlManagement::STATUS_DEVICE_ONLINE; 
                else $oAccessControlDevice->status = FModuleAccessControlManagement::STATUS_DEVICE_OFFLINE;
             }
             else $oAccessControlDevice->status = FModuleAccessControlManagement::STATUS_DEVICE_DISABLED;
             
             if (!$oAccessControlDevice->save()) throw new CHttpException(404, $oAccessControlDevice->getErrors());
               
             $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/viewDetailDevice', array('nIdForm'=>$oAccessControlDevice->id)));
          }
          else $this->render('updateDevice', array('oModelForm'=>$oAccessControlDevice));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
    }
    public function actionUpdateGroupDevice($nIdForm) {
       $this->layout = FApplication::LAYOUT_POPUP;
       
       $oAccessControlGroupDevice = AccessControlGroupsDevices::getAccessControlGroupDevice($nIdForm);
                                
       if (!is_null($oAccessControlGroupDevice)) {
          // Ajax validation request=>Unique validator
          FForm::validateAjaxForm('access-control-group-device-form', $oAccessControlGroupDevice);
       
          if (isset($_POST['AccessControlGroupsDevices'])) {
             $oAccessControlGroupDevice->attributes = $_POST['AccessControlGroupsDevices'];
             
             $oAccessControlGroupDevice->save();
               
             $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/viewDetailGroupDevice', array('nIdForm'=>$oAccessControlGroupDevice->id)));
          }
          else $this->render('updateGroupDevice', array('oModelForm'=>$oAccessControlGroupDevice));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
    }   
    public function actionUpdateCommandDateTime() {
       FModuleAccessControlManagement::commandDateTime();
       
       $this->render('viewCommands');         
    }
    public function actionUpdateCommandLockDoors() {
       FModuleAccessControlManagement::commandLockDoors();
       
       $this->render('viewCommands');   
    }
    public function actionUpdateCommandUnlockDoors() {
       FModuleAccessControlManagement::commandUnlockDoors();
       
       $this->render('viewCommands');  
    }
    public function actionUpdateCommandOpenDoors() {
       FModuleAccessControlManagement::commandOpenDoors();
       
       $this->render('viewCommands');  
    }
    public function actionUpdateCommandFreeOut() {
       FModuleAccessControlManagement::commandFreeOut();
       
       $this->render('viewCommands');  
    }
    public function actionUpdateCommandUnfreeOut() {
       FModuleAccessControlManagement::commandUnfreeOut();
       
       $this->render('viewCommands');  
    }
     
    
    public function actionDeleteController($nIdForm) {
       $oAccessControlController = AccessControlControllers::getAccessControlController($nIdForm);
       if (!is_null($oAccessControlController)) $oAccessControlController->delete();

       $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/viewControllers'));
    }
    public function actionDeleteDevice($nIdForm) {
       if (!AccessControlDevices::isAccessControlDeviceLocked($nIdForm)) {
          $oAccessControlDevice = AccessControlDevices::getAccessControlDevice($nIdForm);
          if (!is_null($oAccessControlDevice)) $oAccessControlDevice->delete();

          $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/viewDevices'));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
    }
    public function actionDeleteGroupDevice($nIdForm) {
       if (!AccessControlGroupsDevices::isAccessControlGroupDeviceLocked($nIdForm)) {
          $oAccessControlGroupDevice = AccessControlGroupsDevices::getAccessControlGroupDevice($nIdForm);
          if (!is_null($oAccessControlGroupDevice)) $oAccessControlGroupDevice->delete();

          $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/viewGroupsDevices'));
       }
       else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
    } 
    public function actionDeleteDeviceGroupDevice($nIdForm) {
       try {
          $bErrorTransaction = false;
          $oTransaction = Yii::app()->db_rainbow_accesscontrolmanagement->beginTransaction();
         
          $oAccessControlDeviceGroupDevice = AccessControlDevicesGroupsDevices::getAccessControlDeviceGroupDevice($nIdForm);
          if (!is_null($oAccessControlDeviceGroupDevice)) {
             if (AccessControlGroupsDevices::isAccessControlGroupDeviceLocked($oAccessControlDeviceGroupDevice->id_group_device)) {
                $bErrorTransaction = !FModuleAccessControlManagement::disenrollEmployeesByIdGroupDeviceAndIdDevice($oAccessControlDeviceGroupDevice->id_group_device, $oAccessControlDeviceGroupDevice->id_device);
             }   

             if (!$bErrorTransaction) $oAccessControlDeviceGroupDevice->delete();
          }
         
          if (!$bErrorTransaction) { 
             $oTransaction->commit();  
          }
          else $oTransaction->rollback();
       } catch (Exception $e) { if (!is_null($oTransaction)) $oTransaction->rollback(); }  
            
       $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/manage/viewGroupsDevices'));
    }
}