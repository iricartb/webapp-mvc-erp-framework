<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/forms_contracting_procedure.png' ?>" />
   </div>                                                                                                                                                                                                                                                                                                   
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_HEADER', array('{1}'=>FDate::getTimeZoneFormattedDate($oModelForm->start_date), '{2}'=>$oModelForm->owner, '{3}'=>$oModelForm->contracting_procedure_expedient))); ?>
   </div>          
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_DESCRIPTION'); ?>
</div>

<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureGeneral', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_GENERAL'); ?>
</div>
<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureMoreInformation', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_MORE_INFORMATION'); ?>
</div>
<div class="tab_button tab_active"> 
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_DOCUMENTATION'); ?>
</div>
<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureRecords', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_RECORDS'); ?>
</div> 
<div class="tab_button" onclick="document.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureNotifications', array('nIdForm'=>$oModelForm->id));?>'">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDURE_TAB_NOTIFICATIONS'); ?>
</div>
<div class="form">
   <?php $formFormContractingProcedureDocument = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-form-contracting-procedure-document-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/createFormContractingProcedureDocument', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>false,
      'enableClientValidation'=>false,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
        
   <div class="form_content container_tab">
      <div class="first_row">
         <div class="cell">
            <?php echo $formFormContractingProcedureDocument->labelEx($oModelFormContractingProcedureDocument, 'type', array('style'=>'width:300px;')); ?>
            <?php echo $formFormContractingProcedureDocument->dropDownList($oModelFormContractingProcedureDocument, 'type', CHtml::listData(PurchasesDocumentsContractingProcedures::getPurchasesDocumentsContractingProcedures(), 'type', 'fullDescription'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'),'style'=>'width:300px;')); ?>
            <?php echo $formFormContractingProcedureDocument->error($oModelFormContractingProcedureDocument, 'type', array('style'=>'width:300px;')); ?>   
         </div>
         <div class="last_cell">
            <?php echo $formFormContractingProcedureDocument->labelEx($oModelFormContractingProcedureDocument, 'name', array('style'=>'width:300px;')); ?>
            <?php echo $formFormContractingProcedureDocument->textField($oModelFormContractingProcedureDocument, 'name', array('style'=>'width:300px;')); ?>
            <?php echo $formFormContractingProcedureDocument->error($oModelFormContractingProcedureDocument, 'name', array('style'=>'width:300px;')); ?>   
         </div>
      </div>
      
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_ADD'), array('class'=>'form_button_submit')); ?>
      </div>
      
      <?php $this->endWidget(); ?>
      
      <?php $formFormContractingProcedureDocument = $this->beginWidget('CActiveForm', array(
         'id'=>'purchases-form-contracting-procedure-document-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedureDocumentation', array('nIdForm'=>$oModelForm->id)),
         'enableAjaxValidation'=>false,
         'enableClientValidation'=>false,
         'clientOptions'=>array(
            'validateOnSubmit'=>true,
         ),
         'htmlOptions'=>array('enctype'=>'multipart/form-data'),
      )); 
      
      $oPurchasesFormsRequestOffersParentDocuments = PurchasesFormsRequestOffersDocuments::getPurchasesFormsRequestOffersParentDocumentsByIdFormFK($oModelForm->id);
      if (count($oPurchasesFormsRequestOffersParentDocuments) > 0) {
         $nCurrentDocument = 1; 
         ?>
         <br/><hr>
         <div class="row">
            <div class="cell_header" style="font-size:12px">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDUREDOCUMENTATION_FORM_HEADER_DOCUMENTS', array('{1}'=>$oModelForm->contracting_procedure_expedient)); ?>
            </div>
         </div>
         
         <?php
         $sFolderExpedient = str_replace('\\', '-', str_replace('/', '-', $oModelForm->contracting_procedure_expedient));
         $sFolderExpedientPath = FApplication::FOLDER_DOCUMENTS_MODULE_PURCHASES_MANAGEMENT . 'expedients/' . $sFolderExpedient;

         foreach($oPurchasesFormsRequestOffersParentDocuments as $oPurchasesFormRequestOfferParentDocument) {
            ?>
            <input type="hidden" name="PurchasesFormsRequestOffersDocuments[ID][<?php echo $nCurrentDocument; ?>]" value="<?php echo $oPurchasesFormRequestOfferParentDocument->id;?>">
            <div class="row">    
               <div class="last_cell">
                  <div style="display:table-row;">
                     <div class="last_cell" style="color:#007a89">
                        <div style="display:table-cell">
                           <b><?php echo $oPurchasesFormRequestOfferParentDocument->type . ' - ' . $oPurchasesFormRequestOfferParentDocument->name; ?></b>
                        </div>
                        <div style="display:table-cell; padding-left:10px">
                           <?php       
                           if ((!FString::isNullOrEmpty($oPurchasesFormRequestOfferParentDocument->document)) && (file_exists($sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferParentDocument->folder . '/' . $oPurchasesFormRequestOfferParentDocument->document))) {
                              if ((strpos($oPurchasesFormRequestOfferParentDocument->document, strtolower(FFile::FILE_PDF_TYPE)) === false) && (strpos($oPurchasesFormRequestOfferParentDocument->document, strtolower(FFile::FILE_DOC_TYPE)) === false) && (strpos($oPurchasesFormRequestOfferParentDocument->document, strtolower(FFile::FILE_DOCX_TYPE)) === false) && (strpos($oPurchasesFormRequestOfferParentDocument->document, strtolower(FFile::FILE_XLS_TYPE)) === false) && (strpos($oPurchasesFormRequestOfferParentDocument->document, strtolower(FFile::FILE_XLSX_TYPE)) === false)) { ?>
                                 <div style="vertical-align:middle;"><a href="<?php echo $sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferParentDocument->folder . '/' . $oPurchasesFormRequestOfferParentDocument->document;?>"><img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'document_download_1.png'; ?>"></img></a></div>
                                 <?php   
                              }
                              else if ((strpos($oPurchasesFormRequestOfferParentDocument->document, strtolower(FFile::FILE_DOC_TYPE)) !== false) || (strpos($oPurchasesFormRequestOfferParentDocument->document, strtolower(FFile::FILE_DOCX_TYPE)) !== false)) { ?>
                                 <div style="vertical-align:middle;"><a href="<?php echo $sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferParentDocument->folder . '/' . $oPurchasesFormRequestOfferParentDocument->document;?>"><img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'document_doc_1.png'; ?>"></img></a></div>
                                 <?php    
                              }
                              else if ((strpos($oPurchasesFormRequestOfferParentDocument->document, strtolower(FFile::FILE_XLS_TYPE)) !== false) || (strpos($oPurchasesFormRequestOfferParentDocument->document, strtolower(FFile::FILE_XLSX_TYPE)) !== false)) { ?>
                                 <div style="vertical-align:middle;"><a href="<?php echo $sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferParentDocument->folder . '/' . $oPurchasesFormRequestOfferParentDocument->document;?>"><img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'document_xls_1.png'; ?>"></img></a></div>
                                 <?php    
                              }
                              else { ?>
                                 <div style="vertical-align:middle;"><a href="<?php echo $sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferParentDocument->folder . '/' . $oPurchasesFormRequestOfferParentDocument->document;?>" rel="fancybox_allowNavigation"><img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'document_pdf_1.png'; ?>"></img></a></div>
                              <?php
                              }   
                           }
                           ?>
                        </div>
                     </div>
                  </div>
                  <div style="display:table-row;">
                     <div class="cell">
                        <?php 
                        if (FModulePurchasesManagement::allowUpdateFormContractingProcedureDocument($oPurchasesFormRequestOfferParentDocument->id)) {
                           echo $formFormContractingProcedureDocument->fileField($oPurchasesFormRequestOfferParentDocument, 'document', array('name'=>'PurchasesFormsRequestOffersDocuments[document][' . $nCurrentDocument . ']', 'style'=>'width:320px;')); 
                        }
                        else {
                           echo $formFormContractingProcedureDocument->fileField($oPurchasesFormRequestOfferParentDocument, 'document', array('name'=>'PurchasesFormsRequestOffersDocuments[document][' . $nCurrentDocument . ']', 'style'=>'width:320px;', 'disabled'=>'disabled')); 
                        }
                        ?>
                     </div>
                     <div class="cell">
                        <?php
                        if (FString::isNullOrEmpty($oPurchasesFormRequestOfferParentDocument->date)) {
                           echo $formFormContractingProcedureDocument->textField($oPurchasesFormRequestOfferParentDocument, 'date', array('name'=>'PurchasesFormsRequestOffersDocuments[date][' . $nCurrentDocument . ']', 'style'=>'width:120px;', 'disabled'=>'disabled'));
                        }
                        else {                                                                                                                                                                                                                                                                                        
                           echo $formFormContractingProcedureDocument->textField($oPurchasesFormRequestOfferParentDocument, 'date', array('name'=>'PurchasesFormsRequestOffersDocuments[date][' . $nCurrentDocument . ']', 'style'=>'width:120px;', 'value'=>FDate::getTimeZoneFormattedDate($oPurchasesFormRequestOfferParentDocument->date, true), 'disabled'=>'disabled'));
                        }
                        ?>
                     </div>
                     <div class="cell">
                        <?php
                        if (FString::isNullOrEmpty($oPurchasesFormRequestOfferParentDocument->id_user)) {
                           echo $formFormContractingProcedureDocument->textField($oPurchasesFormRequestOfferParentDocument, 'date', array('name'=>'PurchasesFormsRequestOffersDocuments[id_user][' . $nCurrentDocument . ']', 'style'=>'width:155px;', 'disabled'=>'disabled'));
                        }
                        else {                                                                                                                                                                                                                                                                                        
                           echo $formFormContractingProcedureDocument->textField($oPurchasesFormRequestOfferParentDocument, 'date', array('name'=>'PurchasesFormsRequestOffersDocuments[id_user][' . $nCurrentDocument . ']', 'style'=>'width:155px;', 'value'=>Users::getUserEmployeeFullName($oPurchasesFormRequestOfferParentDocument->id_user), 'disabled'=>'disabled'));
                        }
                        ?>
                     </div>
                     <div class="cell">
                        <?php
                        if ((!FString::isNullOrEmpty($oPurchasesFormRequestOfferParentDocument->document)) && (file_exists($sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferParentDocument->folder . '/' . $oPurchasesFormRequestOfferParentDocument->document))) {
                           echo CHtml::button('+ ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSDOCUMENTS_FIELD_VERSION', array('{1}'=>FString::STRING_EMPTY)), array('style'=>'font-size:11px; background-color:#007a89; border:0px; color:white; padding-left:6px; padding-right:6px; padding-top:3px; padding-bottom:2px; cursor:pointer', 'onclick'=>'window.location = \'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/createFormContractingProcedureReviewDocument', array('nIdForm'=>$oPurchasesFormRequestOfferParentDocument->id, 'nIdFormParent'=>$oModelForm->id)) . '\''));
                        } ?>
                     </div>
                     <div class="last_cell">
                        <?php
                        if (FModulePurchasesManagement::allowDeleteFormContractingProcedureDocument($oPurchasesFormRequestOfferParentDocument->id)) { ?>
                           <a href="<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/deleteFormContractingProcedureDocument', array('nIdForm'=>$oPurchasesFormRequestOfferParentDocument->id, 'nIdFormParent'=>$oModelForm->id))?>" onclick="return confirm('<?php echo Yii::t('system', 'SYS_DELETE_RECORD_CONFIRMATION');?>')">
                              <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'sign_no_ok_1.png';?>" />
                           </a> 
                        <?php
                        }
                        ?>
                     </div>
                  </div>
               </div>
            </div> 
            
            <?php
            $nCurrentDocument++;
            
            $oPurchasesFormsRequestOffersChildDocuments = PurchasesFormsRequestOffersDocuments::getPurchasesFormsRequestOffersChildDocumentsByIdFormFK($oPurchasesFormRequestOfferParentDocument->id, $oModelForm->id);
            foreach($oPurchasesFormsRequestOffersChildDocuments as $oPurchasesFormRequestOfferChildDocument) {
               ?>               
               <input type="hidden" name="PurchasesFormsRequestOffersDocuments[ID][<?php echo $nCurrentDocument; ?>]" value="<?php echo $oPurchasesFormRequestOfferChildDocument->id;?>">
               <input type="hidden" name="PurchasesFormsRequestOffersDocuments[version][<?php echo $nCurrentDocument; ?>]" value="<?php echo $oPurchasesFormRequestOfferChildDocument->version;?>">
               
               <div class="row" style="padding-left:40px;">    
                  <div class="last_cell">
                     <div style="display:table-row;">
                        <div class="last_cell" style="color:#b90000">
                           <div style="display:table-cell">
                              <b><?php echo '· ' . $oPurchasesFormRequestOfferChildDocument->type . ' - ' . $oPurchasesFormRequestOfferChildDocument->name . ' - ' . Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSDOCUMENTS_FIELD_VERSION_ABBREVIATION', array('{1}'=>$oPurchasesFormRequestOfferChildDocument->version)); ?></b>
                           </div>
                           <div style="display:table-cell; padding-left:10px">
                              <?php       
                              if ((!FString::isNullOrEmpty($oPurchasesFormRequestOfferChildDocument->document)) && (file_exists($sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferChildDocument->folder . '/' . $oPurchasesFormRequestOfferChildDocument->document))) {
                                 if ((strpos($oPurchasesFormRequestOfferChildDocument->document, strtolower(FFile::FILE_PDF_TYPE)) === false) && (strpos($oPurchasesFormRequestOfferChildDocument->document, strtolower(FFile::FILE_DOC_TYPE)) === false) && (strpos($oPurchasesFormRequestOfferChildDocument->document, strtolower(FFile::FILE_DOCX_TYPE)) === false) && (strpos($oPurchasesFormRequestOfferChildDocument->document, strtolower(FFile::FILE_XLS_TYPE)) === false) && (strpos($oPurchasesFormRequestOfferChildDocument->document, strtolower(FFile::FILE_XLSX_TYPE)) === false)) { ?>
                                    <div style="vertical-align:middle;"><a href="<?php echo $sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferChildDocument->folder . '/' . $oPurchasesFormRequestOfferChildDocument->document;?>"><img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'document_download_1.png'; ?>"></img></a></div>
                                    <?php   
                                 }
                                 else if ((strpos($oPurchasesFormRequestOfferChildDocument->document, strtolower(FFile::FILE_DOC_TYPE)) !== false) || (strpos($oPurchasesFormRequestOfferChildDocument->document, strtolower(FFile::FILE_DOCX_TYPE)) !== false)) { ?>
                                    <div style="vertical-align:middle;"><a href="<?php echo $sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferChildDocument->folder . '/' . $oPurchasesFormRequestOfferChildDocument->document;?>"><img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'document_doc_1.png'; ?>"></img></a></div>
                                    <?php    
                                 }
                                 else if ((strpos($oPurchasesFormRequestOfferChildDocument->document, strtolower(FFile::FILE_XLS_TYPE)) !== false) || (strpos($oPurchasesFormRequestOfferChildDocument->document, strtolower(FFile::FILE_XLSX_TYPE)) !== false)) { ?>
                                    <div style="vertical-align:middle;"><a href="<?php echo $sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferChildDocument->folder . '/' . $oPurchasesFormRequestOfferChildDocument->document;?>"><img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'document_xls_1.png'; ?>"></img></a></div>
                                    <?php    
                                 }
                                 else { ?>
                                    <div style="vertical-align:middle;"><a href="<?php echo $sFolderExpedientPath . '/' . $oPurchasesFormRequestOfferChildDocument->folder . '/' . $oPurchasesFormRequestOfferChildDocument->document;?>" rel="fancybox_allowNavigation"><img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'document_pdf_1.png'; ?>"></img></a></div>
                                 <?php
                                 }   
                              }
                              ?>
                           </div>
                        </div>
                     </div>
                     <div style="display:table-row;">
                        <div class="cell">
                           <?php 
                           if (FModulePurchasesManagement::allowUpdateFormContractingProcedureDocument($oPurchasesFormRequestOfferChildDocument->id)) {
                              echo $formFormContractingProcedureDocument->fileField($oPurchasesFormRequestOfferChildDocument, 'document', array('name'=>'PurchasesFormsRequestOffersDocuments[document][' . $nCurrentDocument . ']', 'style'=>'width:320px;')); 
                           }
                           else {
                              echo $formFormContractingProcedureDocument->fileField($oPurchasesFormRequestOfferChildDocument, 'document', array('name'=>'PurchasesFormsRequestOffersDocuments[document][' . $nCurrentDocument . ']', 'style'=>'width:320px;', 'disabled'=>'disabled')); 
                           }
                           ?>
                        </div>
                        <div class="cell">
                           <?php
                           if (FString::isNullOrEmpty($oPurchasesFormRequestOfferChildDocument->date)) {
                              echo $formFormContractingProcedureDocument->textField($oPurchasesFormRequestOfferChildDocument, 'date', array('name'=>'PurchasesFormsRequestOffersDocuments[date][' . $nCurrentDocument . ']', 'style'=>'width:120px;', 'disabled'=>'disabled'));
                           }
                           else {                                                                                                                                                                                                                                                                                        
                              echo $formFormContractingProcedureDocument->textField($oPurchasesFormRequestOfferChildDocument, 'date', array('name'=>'PurchasesFormsRequestOffersDocuments[date][' . $nCurrentDocument . ']', 'style'=>'width:120px;', 'value'=>FDate::getTimeZoneFormattedDate($oPurchasesFormRequestOfferChildDocument->date, true), 'disabled'=>'disabled'));
                           }
                           ?>
                        </div>
                        <div class="cell">
                           <?php
                           if (FString::isNullOrEmpty($oPurchasesFormRequestOfferChildDocument->id_user)) {
                              echo $formFormContractingProcedureDocument->textField($oPurchasesFormRequestOfferChildDocument, 'date', array('name'=>'PurchasesFormsRequestOffersDocuments[id_user][' . $nCurrentDocument . ']', 'style'=>'width:155px;', 'disabled'=>'disabled'));
                           }
                           else {                                                                                                                                                                                                                                                                                        
                              echo $formFormContractingProcedureDocument->textField($oPurchasesFormRequestOfferChildDocument, 'date', array('name'=>'PurchasesFormsRequestOffersDocuments[id_user][' . $nCurrentDocument . ']', 'style'=>'width:155px;', 'value'=>Users::getUserEmployeeFullName($oPurchasesFormRequestOfferChildDocument->id_user), 'disabled'=>'disabled'));
                           }
                           ?>
                        </div>
                        <div class="last_cell">
                           <?php
                           if (FModulePurchasesManagement::allowDeleteFormContractingProcedureDocument($oPurchasesFormRequestOfferChildDocument->id)) { ?>
                              <a href="<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/deleteFormContractingProcedureDocument', array('nIdForm'=>$oPurchasesFormRequestOfferChildDocument->id, 'nIdFormParent'=>$oModelForm->id))?>" onclick="return confirm('<?php echo Yii::t('system', 'SYS_DELETE_RECORD_CONFIRMATION');?>')">
                                 <img src="<?php echo FApplication::FOLDER_IMAGES_GENERIC_16x16 . 'sign_no_ok_1.png';?>" />
                              </a> 
                           <?php
                           }
                           ?>
                        </div>
                     </div>
                  </div>
               </div> 
               <?php
               $nCurrentDocument++;
            }
            ?>
            <br/><hr/>
            <?php
         }
      }
      ?> 
   </div>
   
   <div class="row buttons">
      <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
   </div> 
   
   <?php $this->endWidget(); ?> 
</div>

<?php
if ((Yii::app()->user->hasFlash('success')) || (Yii::app()->user->hasFlash('error'))) { ?>
   <?php if (Yii::app()->user->hasFlash('success')) { ?>
      <div class="flash-success">
         <?php echo Yii::app()->user->getFlash('success'); ?>
      </div> 
   <?php } else if (Yii::app()->user->hasFlash('notice')) { ?>
      <div class="flash-notice">
         <?php echo Yii::app()->user->getFlash('notice'); ?>
      </div>   
   <?php } else { ?>
      <div class="flash-error">
         <?php echo Yii::app()->user->getFlash('error'); ?>
      </div>
   <?php }
}
?>