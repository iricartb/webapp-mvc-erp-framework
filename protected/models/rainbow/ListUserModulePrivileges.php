<?php

class ListUserModulePrivileges {
    private $sName;
    private $sRole;
    private $sTextKeyHeader;
    private $sTextKeyDescription;
    private $sImage;
    private $oHeaders;
    
    public function __construct($sName, $sRole, $sTextKeyHeader, $sTextKeyDescription, $sImage) {
        $this->oHeaders = array();
        
        $this->sName = $sName;
        $this->sRole = $sRole;
        $this->sTextKeyHeader = $sTextKeyHeader;
        $this->sTextKeyDescription = $sTextKeyDescription;
        $this->sImage = $sImage;
                                                      
        $oModuleHeaders = ModulesHeaders::getModuleHeaders($sName, $sRole); 
        foreach ($oModuleHeaders as $oModuleHeader) {
           $this->oHeaders[count($this->oHeaders)] = new ListModuleHeader($this->sName, $oModuleHeader->id, $oModuleHeader->role, 'SYS_' . strtoupper($this->sName) . '_HEADER_' . strtoupper($oModuleHeader->name), strtolower($this->sName) . '_header_' . strtolower($oModuleHeader->name) . '.png');            
        }
    }
    
    public function getName() { return $this->sName; }
    public function getRole() { return $this->sRole; }
    public function getTextKeyHeader() { return $this->sTextKeyHeader; }
    public function getTextKeyDescription() { return $this->sTextKeyDescription; }
    public function getImage() { return $this->sImage; }
    public function getHeaders() { return $this->oHeaders; }
}
?>