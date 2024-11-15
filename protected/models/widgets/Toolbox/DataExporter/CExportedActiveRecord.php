<?php

class CExportedActiveRecord extends CActiveRecord {
   protected $oExportSpecifications = array('data'=>array(), 'columns'=>array());
   
   public function getExportSpecifications() { return $this->oExportSpecifications; }
}