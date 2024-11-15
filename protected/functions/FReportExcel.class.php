<?php      
class FReportExcel {
    const BORDER_STYLE_SOLID_ALL = 'BORDER_STYLE_SOLID_ALL';
    const BORDER_STYLE_SOLID_ALL_MEDIUM = 'BORDER_STYLE_SOLID_ALL_MEDIUM';
    const BORDER_STYLE_SOLID_TOP = 'BORDER_STYLE_SOLID_TOP';
    const BORDER_STYLE_SOLID_BOTTOM = 'BORDER_STYLE_SOLID_BOTTOM';
    const BORDER_STYLE_SOLID_LEFT = 'BORDER_STYLE_SOLID_LEFT';
    const BORDER_STYLE_SOLID_RIGHT = 'BORDER_STYLE_SOLID_RIGHT';
    
    const BORDER_STYLE_DOTTED_ALL = 'BORDER_STYLE_DOTTED_ALL';
    const BORDER_STYLE_DOTTED_TOP = 'BORDER_STYLE_DOTTED_TOP';
    const BORDER_STYLE_DOTTED_BOTTOM = 'BORDER_STYLE_DOTTED_BOTTOM';
    const BORDER_STYLE_DOTTED_LEFT = 'BORDER_STYLE_DOTTED_LEFT';
    const BORDER_STYLE_DOTTED_RIGHT = 'BORDER_STYLE_DOTTED_RIGHT';
    
    const BORDER_STYLE_NONE = 'BORDER_STYLE_NONE';
    const BLANK_SHEET_NAME = 'blank';
    
    public static function getInstance($sTitle, $sCreator, $bRemoveSheet = true) {
        $oPHPExcel = new PHPExcel();
        
        $oPHPExcel->getProperties()->setCreator($sCreator);
        $oPHPExcel->getProperties()->setLastModifiedBy($sCreator);
        $oPHPExcel->getProperties()->setTitle($sTitle);
        $oPHPExcel->getProperties()->setSubject($sTitle);
        
        if ($bRemoveSheet) $oPHPExcel->removeSheetByIndex(0);
        
        return $oPHPExcel;       
    }
    
    public static function addSheet($oPHPExcel, $sTitleSheet) {
        $oPHPExcel->createSheet();
        $oPHPExcel->setActiveSheetIndex(count($oPHPExcel->getAllSheets()) - 1);
             
        $oPHPExcel->getActiveSheet()->setTitle($sTitleSheet);    
    }
    
    public static function setHorizontalMargin($oPHPExcel, $nLeft, $nRight) {
       $oPHPExcel->getActiveSheet()->getPageMargins()->setLeft($nLeft / 2.54);
       $oPHPExcel->getActiveSheet()->getPageMargins()->setRight($nRight / 2.54);
    }
    
    public static function setVerticalMargin($oPHPExcel, $nTop, $nBottom) {
       $oPHPExcel->getActiveSheet()->getPageMargins()->setTop($nTop / 2.54);
       $oPHPExcel->getActiveSheet()->getPageMargins()->setBottom($nBottom / 2.54);
    }
    
    public static function setCellValue($oPHPExcel, $sCell, $sValue, $sHorizontalAlignment = null, $sVerticalAlignment = null, $sFont = null, $nSize = null, $bBold = null, $sColor = null, $bWrapText = null) {
       $oPHPExcel->getActiveSheet()->SetCellValue($sCell, $sValue);
       
       if (!is_null($sHorizontalAlignment)) $oPHPExcel->getActiveSheet()->getStyle($sCell)->getAlignment()->setHorizontal($sHorizontalAlignment);
       if (!is_null($sVerticalAlignment)) $oPHPExcel->getActiveSheet()->getStyle($sCell)->getAlignment()->setVertical($sVerticalAlignment);
       if (!is_null($sFont)) $oPHPExcel->getActiveSheet()->getStyle($sCell)->getFont()->setName($sFont);
       if ((!is_null($nSize)) && (is_numeric($nSize))) $oPHPExcel->getActiveSheet()->getStyle($sCell)->getFont()->setSize($nSize);
       if (!is_null($bBold)) $oPHPExcel->getActiveSheet()->getStyle($sCell)->getFont()->setBold($bBold);
       if (!is_null($sColor)) $oPHPExcel->getActiveSheet()->getStyle($sCell)->getFont()->getColor()->setARGB($sColor);
       if (!is_null($bWrapText)) $oPHPExcel->getActiveSheet()->getStyle($sCell)->getAlignment()->setWrapText($bWrapText);    
    }
    
    public static function setBorderByRange($oPHPExcel, $sRowStart, $sColumnStart, $sRowEnd = null, $sColumnEnd = null, $bMerge = false, $sBorder = FReportExcel::BORDER_STYLE_SOLID_ALL) {
       $oBorderStyle = array();
       
       if (is_null($sRowEnd)) $sRowEnd = $sRowStart;
       if (is_null($sColumnEnd)) $sColumnEnd = $sColumnStart;
       
       if ($sBorder == FReportExcel::BORDER_STYLE_SOLID_ALL) $oBorderStyle = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN))); 
       else if ($sBorder == FReportExcel::BORDER_STYLE_SOLID_TOP) $oBorderStyle = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));  
       else if ($sBorder == FReportExcel::BORDER_STYLE_SOLID_BOTTOM) $oBorderStyle = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));  
       else if ($sBorder == FReportExcel::BORDER_STYLE_SOLID_LEFT) $oBorderStyle = array('borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))); 
       else if ($sBorder == FReportExcel::BORDER_STYLE_SOLID_RIGHT) $oBorderStyle = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN))); 
       else if ($sBorder == FReportExcel::BORDER_STYLE_SOLID_ALL_MEDIUM) $oBorderStyle = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)));
       
       else if ($sBorder == FReportExcel::BORDER_STYLE_DOTTED_ALL) $oBorderStyle = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED))); 
       else if ($sBorder == FReportExcel::BORDER_STYLE_DOTTED_TOP) $oBorderStyle = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED)));  
       else if ($sBorder == FReportExcel::BORDER_STYLE_DOTTED_BOTTOM) $oBorderStyle = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED)));  
       else if ($sBorder == FReportExcel::BORDER_STYLE_DOTTED_LEFT) $oBorderStyle = array('borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED))); 
       else if ($sBorder == FReportExcel::BORDER_STYLE_DOTTED_RIGHT) $oBorderStyle = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED))); 
       
       else if ($sBorder == FReportExcel::BORDER_STYLE_NONE) $oBorderStyle = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_NONE)));  

       if (!$bMerge) {
          for($i = $sRowStart; $i <= $sRowEnd; $i++) {
             for($j = ord($sColumnStart); $j <= ord($sColumnEnd); $j++) {
                $oPHPExcel->getActiveSheet()->getStyle(chr($j) . $i)->applyFromArray($oBorderStyle);
             }
          }
       }
       else {
          $oPHPExcel->getActiveSheet()->getStyle($sColumnStart . $sRowStart . ':' . $sColumnEnd . $sRowEnd)->applyFromArray($oBorderStyle);      
       }
    }
}
?>