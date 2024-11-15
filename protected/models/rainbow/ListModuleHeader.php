<?php

class ListModuleHeader {
    private $nId;
    private $sRole;
    private $sTextKeyHeader;
    private $sImage;
    private $oLines;
    
    public function __construct($sModule, $nId, $sRole, $sTextKeyHeader, $sImage) {
        $this->oLines = array();
        
        $this->nId = $nId;
        $this->sRole = $sRole;
        $this->sTextKeyHeader = $sTextKeyHeader;
        $this->sImage = $sImage;
                                                      
        $oModuleHeaderLines = ModulesHeadersLines::getModuleHeaderLines($nId);
        foreach ($oModuleHeaderLines as $oModuleHeaderLine) {
           $this->oLines[count($this->oLines)] = new ListModuleHeaderLine('SYS_' . strtoupper($sModule) . '_HEADER_LINE_' . strtoupper($oModuleHeaderLine->name), $oModuleHeaderLine->dependency, strtolower($sModule) . '_header_line_' . strtolower($oModuleHeaderLine->name) . '.png', $oModuleHeaderLine->action);            
        }
    }
    
    public function getId() { return $this->nId; }
    public function getRole() { return $this->sRole; }
    public function getTextKeyHeader() { return $this->sTextKeyHeader; }
    public function getImage() { return $this->sImage; }
    public function getHeaderLines() { return $this->oLines; }
}
?>