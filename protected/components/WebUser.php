<?php

// this file must be stored in:
// protected/components/WebUser.php
 
class WebUser extends CWebUser {
 
   // Store model to not repeat query.
   private $_model;
   
   // Return name.
   // access it by Yii::app()->user->name
   function getName() {
      return Users::getFullName(Yii::app()->user->id);
   }
 
   // Return identification.
   // access it by Yii::app()->user->identification
   function getIdentification() {
      return Users::getIdentification(Yii::app()->user->id);
   }
  
   // This is a function that checks the field 'role'
   // access it by Yii::app()->user->isMaster
   function getIsMaster() {
      return Users::getIsMaster(Yii::app()->user->id);
   }
  
   // This is a function that checks the field 'role'
   // access it by Yii::app()->user->isUser
   function getIsUser() {
      return Users::getIsUser(Yii::app()->user->id);
   }
   
   // This is a function that checks the field 'role' of module parameter
   // access it by Yii::app()->user->isModuleAdmin($sModule)
   function getIsModuleAdmin($sModule) {
      return Users::getIsModuleAdmin(Yii::app()->user->id, $sModule);
   }
  
   // This is a function that checks the field 'role' of module parameter
   // access it by Yii::app()->user->isModuleUser($sModule)
   function getIsModuleUser($sModule) {
      return Users::getIsModuleUser(Yii::app()->user->id, $sModule);
   }
   
   // This is a function that checks the field 'role' of module parameter
   // access it by Yii::app()->user->isModuleRestricedUser($sModule)
   function getIsModuleRestricedUser($sModule) {
      return Users::getIsModuleRestricedUser(Yii::app()->user->id, $sModule);   
   }
}
?>