<?php

class ListUserPrivileges {
    private $nId;
    private $sName;
    private $sRole;
    private $oModulesPrivileges;
    
    public function __construct($nId) {
        $this->oModulesPrivileges = array();
        
        $oUserModel = Users::getUser($nId);
        if (!is_null($oUserModel)) {
            $this->nId = $oUserModel->id;                                         
            $this->sName = $oUserModel->full_name;
            $this->sRole = $oUserModel->role;

            $oModules = Modules::getAvaliableModules();
            foreach ($oModules as $oModule) {
                
                if ((Users::getIsMaster($this->nId)) || (Users::getIsAdmin($this->nId))) {
                   $this->oModulesPrivileges[count($this->oModulesPrivileges)] = new ListUserModulePrivileges($oModule->name, FApplication::ROLE_MODULE_ADMIN, 'SYS_' . strtoupper($oModule->name) . '_HEADER', 'SYS_' . strtoupper($oModule->name) . '_DESCRIPTION', strtolower($oModule->name) . '.png');            
                }
                else {
                   $oUserModulePrivileges = UsersModulesPrivileges::getAvaliableUserModulePrivileges($oModule->name, $this->nId);
                   if (!is_null($oUserModulePrivileges)) $this->oModulesPrivileges[count($this->oModulesPrivileges)] = new ListUserModulePrivileges($oModule->name, $oUserModulePrivileges->role, 'SYS_' . strtoupper($oModule->name) . '_HEADER', 'SYS_' . strtoupper($oModule->name) . '_DESCRIPTION', strtolower($oModule->name) . '.png');   
                }
            }
        }
    }
    
    public function getId() { return $this->nId; }
    public function getFullName() { return $this->sName; }
    public function getRole() { return $this->sRole; }

    public function getModulesPrivileges() { return $this->oModulesPrivileges; }
    public function getModulePrivileges($sModuleName) {
       foreach ($this->oModulesPrivileges as $oModulePrivileges) {
          if ($oModulePrivileges->getName() == $sModuleName) return $oModulePrivileges;
       }
       return null;   
    }
}
?>