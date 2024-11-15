<?php

class ListModuleHeaderLine {
    private $sTextKeyLine;
    private $sImage;
    private $sAction;
    private $sDependency;
    
    public function __construct($sTextKeyLine, $sDependency, $sImage, $sAction) {
        $this->sTextKeyLine = $sTextKeyLine;
        $this->sImage = $sImage;
        $this->sAction = $sAction;
        $this->sDependency = $sDependency;
    }
    
    public function getTextKeyLine() { return $this->sTextKeyLine; }
    public function getDependency() { return $this->sDependency; }
    public function getImage() { return $this->sImage; }
    public function getAction() { return $this->sAction; }
}
?>