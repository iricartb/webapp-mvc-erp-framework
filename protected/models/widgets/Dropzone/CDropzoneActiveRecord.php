<?php

class CDropzoneActiveRecord extends CActiveRecord {
   protected $oDropzoneElements = array('field_pk'=>FString::STRING_EMPTY, 'field_document'=>FString::STRING_EMPTY, 'path_documents'=>FString::STRING_EMPTY, 'elements'=>array(), 'file_image_resize'=>array(), 'file_image_output_extension'=>'.jpg');
   
   public function isDropzoneAllowAccessRule() { return true; }
   
   public function getDropzoneImageOutputFormat() { return $this->oDropzoneElements; }
   
   public function changeDropzoneImageElements($sIdSource, $sIdDestiny) { }
   
   public function deleteDropzoneImageElement($sId) { }
}