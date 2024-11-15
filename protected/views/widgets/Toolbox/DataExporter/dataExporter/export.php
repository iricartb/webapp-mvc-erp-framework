<?php
$oFactory = new CWidgetFactory();
    
if ($sFormat == FFile::FILE_XLS_TYPE) $sFormat = 'Excel5';
else if ($sFormat == FFile::FILE_XLSX_TYPE) $sFormat = 'Excel2007';

$oWidget = $oFactory->createWidget($this, 'EExcelView', array(
   'dataProvider'=>$oModelDataProvider,
   'grid_mode'=>'export',
   'filename'=>date("YmdHis"),
   'stream'=>true,
   'exportType'=>$sFormat,
   'columns'=>$oModelForm->getExportSpecifications()['columns']
));

$oWidget->init();
$oWidget->run();
?>