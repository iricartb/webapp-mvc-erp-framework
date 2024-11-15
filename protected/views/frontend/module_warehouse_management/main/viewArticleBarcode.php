<?php   
if ((!is_null($oModelForm)) && (!FString::isNullOrEmpty($oModelForm->code_barcode))) {
   $sIdBarcode = 'id_barcode_' . $oModelForm->id;
   
   echo '<div style="width:240px; margin-bottom:30px; padding:10px;">';
   
   echo '<div style="margin-left:25px"><div id="' . $sIdBarcode . '"></div></div>';
   
   $this->widget('ext.BarcodeGenerator.Barcode', array('elementId'=>$sIdBarcode, 'value'=>$oModelForm->code_barcode, 'type'=>'code128', 'settings'=>array('barWidth'=>1, 'barHeight'=>60))); 
            
   echo '<div style="margin-top:10px; font-family: verdana; font-size:9px; text-align:center">' . $oModelForm->getFullName() . '</div>';
   
   echo '</div>';
}
?>

<script type="text/javascript">
   window.print();
</script>