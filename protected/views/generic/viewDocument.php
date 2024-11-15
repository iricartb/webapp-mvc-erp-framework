<?php                               
   header('Content-type: ' . $oModelForm->getMimeType());
   header('Content-disposition: ' . $oModelForm->getContentDisposition() . ';filename=' . $oModelForm->getName() . $oModelForm->getExtension());
           
   for($level=ob_get_level(); $level>0; --$level) {
      @ob_end_clean();
   }
   
   echo $oModelForm->getDataContent(); 

   exit;
?>