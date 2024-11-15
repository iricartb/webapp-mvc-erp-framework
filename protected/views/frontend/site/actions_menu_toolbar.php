<?php
if ((!is_null($oUser)) && (!FString::isNullOrEmpty($oUser->def_application))) { ?>
   <div class="app-module">
      <div class="header-text">
         <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_' . strtoupper($oUser->def_application) . '_HEADER')); ?>
      </div>
         <?php
         if ($oUser->def_application == FApplication::MODULE_PURCHASES_MANAGEMENT) { 
            $nSpendFinancialCostLinesAmount = 0;
            $nAvailableFinancialCostLinesAmount = 0;
            $nTotalFinancialCostLinesAmount = 0;
            
            $oPurchasesFinancialCostsLines = array();
            if ((Users::getIsModuleAdmin($oUser->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) || (Users::getIsModuleUser($oUser->id, FApplication::MODULE_PURCHASES_MANAGEMENT))) $oPurchasesFinancialCostsLines = PurchasesFinancialCostsLines::getPurchasesFinancialCostLines(null, date('Y'));
            else {
               $sEmployeeDepartment = FString::STRING_EMPTY;
               if (Users::getIsModuleRestricedUser($oUser->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) { 
                  $oEmployee = Employees::getEmployeeByIdUser($oUser->id);
                  if (!is_null($oEmployee)) {                                           
                     $oEmployeeDepartment = EmployeesDepartments::getEmployeeMainDepartmentByEmployeeIdentification($oEmployee->identification);
                     if (!is_null($oEmployeeDepartment)) {
                        $sEmployeeDepartment = $oEmployeeDepartment->department; 
                        
                        $oPurchasesFinancialCostsLines = PurchasesFinancialCostsLines::getPurchasesFinancialCostLines($sEmployeeDepartment, date('Y'));  
                     }
                  }
               }
            }
            
            foreach($oPurchasesFinancialCostsLines as $oPurchasesFinancialCostLine) {
               $nTotalFinancialCostLinesAmount += $oPurchasesFinancialCostLine->max_price;  
               $nSpendFinancialCostLinesAmount += PurchasesFinancialCostsLines::getPurchasesFinancialCostLineConsumption($oPurchasesFinancialCostLine->id);
            }
            
            $nAvailableFinancialCostLinesAmount = $nTotalFinancialCostLinesAmount - $nSpendFinancialCostLinesAmount; 
            ?>
            <div class="detail-text">
               <div style="display: table-cell; width:33%; color:blue">
                  <?php echo Yii::t('system', 'SYS_MODULE_PURCHASES_MANAGEMENT_ACTIONS_MENU_HEADER_TOTAL_AMOUNT', array('{1}'=>FFormat::getFormatPrice($nTotalFinancialCostLinesAmount))); ?>
               </div>
               <div style="display: table-cell; width:33%; color:red">
                  <?php echo Yii::t('system', 'SYS_MODULE_PURCHASES_MANAGEMENT_ACTIONS_MENU_HEADER_SPEND_AMOUNT', array('{1}'=>FFormat::getFormatPrice($nSpendFinancialCostLinesAmount))); ?>
               </div>
               <div style="display: table-cell; width:33%; color:green">
                  <?php echo Yii::t('system', 'SYS_MODULE_PURCHASES_MANAGEMENT_ACTIONS_MENU_HEADER_AVAILABLE_AMOUNT', array('{1}'=>FFormat::getFormatPrice($nAvailableFinancialCostLinesAmount))); ?>
               </div>
            </div>
         <?php  
         }
         ?>
   </div>
<?php
}
?>

<ul class="nicetree" id="tree">
   <?php
      $oListUserPrivileges = new ListUserPrivileges(Yii::app()->user->id);
      $oUser = Users::getUser(Yii::app()->user->id);
      
      if ((!is_null($oListUserPrivileges)) && (!is_null($oUser))) {
         $oModulePrivileges = $oListUserPrivileges->getModulePrivileges($oUser->def_application);
                        
         foreach ($oModulePrivileges->getHeaders() as $oModuleHeader) { ?>
            <li class="blue">
               <a class="selected" href="#">
                  <?php if (strlen($oModuleHeader->getImage()) > 0) { ?>
                     <div class="nicetree-item-image">
                        <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . 'site/' . $oModuleHeader->getImage();?>" />
                     </div>
                  <?php } ?>
                  <div class="nicetree-item-text">
                     <?php echo Yii::t('system', $oModuleHeader->getTextKeyHeader()); ?>
                  </div>
               </a>
               <?php if (count($oModuleHeader->getHeaderLines()) > 0) { ?> 
                  <ul style="display: none;" class="subsections">
                  <?php foreach ($oModuleHeader->getHeaderLines() as $oModuleHeaderLine) {
                        $bAllowPerformAction = false;
                        if (strlen($oModuleHeaderLine->getDependency()) == 0) $bAllowPerformAction = true;
                        else {
                           $nIdModule = Modules::getIdModuleByName($oModuleHeaderLine->getDependency());
                           if ((!is_null($nIdModule)) && (Modules::getIsValidSerialModule($nIdModule))) $bAllowPerformAction = true;
                        }
                        
                        if ($bAllowPerformAction) { ?>
                        <li>  
                           <a href="<?php echo $this->createUrl('frontend/' . strtolower($oUser->def_application) . '/' . $oModuleHeaderLine->getAction()); ?>">           
                              <div>
                                 <?php if (strlen($oModuleHeaderLine->getImage()) > 0) { ?>
                                    <div class="nicetree-item-image">
                                       <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . 'site/' . $oModuleHeaderLine->getImage();?>" />
                                    </div>
                                 <?php } ?>
                              </div>
                              <div class="nicetree-item-text-line">
                                 <?php echo Yii::t('system', $oModuleHeaderLine->getTextKeyLine()); ?>
                              </div>
                           </a>
                        </li> 
                  <?php }   
                     } ?>
                  </ul>
               <?php } ?>
               
            </li>
            <?php
         }
      }
      ?>
</ul>