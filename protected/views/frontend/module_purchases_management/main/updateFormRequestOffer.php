<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/forms_request_offers.png' ?>" />
   </div>                                                                                                                                                                                                                                                                                                   
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_HEADER', array('{1}'=>FDate::getTimeZoneFormattedDate($oModelForm->start_date), '{2}'=>$oModelForm->owner))); ?>
   </div>          
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formFormRequestOffer = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-form-request-offer-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormRequestOffer', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
        
   <div class="form_content">
      <div class="first_row">
         <?php
         $sEmployeeDepartment = FString::STRING_EMPTY;
         if (Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)) { 
            $oEmployee = Employees::getEmployeeByIdUser(Yii::app()->user->id);
            if (!is_null($oEmployee)) {                                           
               $oEmployeeDepartment = EmployeesDepartments::getEmployeeMainDepartmentByEmployeeIdentification($oEmployee->identification);
               if (!is_null($oEmployeeDepartment)) {
                  $sEmployeeDepartment = $oEmployeeDepartment->department;   
               }
            }
         }  
         ?>
         
         <div class="last_cell">
            <?php echo $formFormRequestOffer->labelEx($oModelForm, 'id_financial_cost_line', array('style'=>'width:630px;')); ?>
            <?php echo $formFormRequestOffer->dropDownList($oModelForm, 'id_financial_cost_line', CHtml::listData(PurchasesFinancialCostsLines::getPurchasesFinancialCostLines($sEmployeeDepartment), 'id', 'fullDescription'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:630px;')); ?>
            <?php echo $formFormRequestOffer->error($oModelForm, 'id_financial_cost_line', array('style'=>'width:630px;')); ?>
         </div>       
      </div>
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormRequestOffer->labelEx($oModelForm, 'description', array('style'=>'width:625px;')); ?>  
            <?php echo $formFormRequestOffer->textArea($oModelForm, 'description', array('style'=>'width:625px; height:100px')); ?>
            <?php echo $formFormRequestOffer->error($oModelForm, 'description', array('style'=>'width:625px;')); ?>
         </div>
      </div>
   </div> 
   <div class="row buttons">
      <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
   </div>     
     
   <?php $this->endWidget(); ?>
</div>

<?php
if ($oModelForm->data_completed) { ?>
   <br/><br/>

   <?php
   if ($oModelForm->status == FModulePurchasesManagement::STATUS_CREATED) { ?>   
      <div class="form">
         <?php $formFormRequestOfferArticle = $this->beginWidget('CActiveForm', array(
            'id'=>'purchases-form-request-offer-article-form',
            'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormRequestOffer', array('nIdForm'=>$oModelForm->id)),
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
               'validateOnSubmit'=>true,
            ),
         )); ?>
         
         <div class="form_expand_collapse" >
            <div id="id_form_expand_collapse_image_article" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image_article'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse_article');" >
            </div>
            <div class="form_expand_collapse_text">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_FORM_NEW_ARTICLE_BTN_DESCRIPTION'); ?>
            </div>   
         </div>
         <div id="id_form_content_expand_collapse_article" class="form_content_expand_collapse">
            <div class="form_header">
               <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_FORM_NEW_ARTICLE_DESCRIPTION'); ?>
            </div>
            <div class="form_content">
               <div class="first_row">
                  <div class="cell">
                     <?php echo $formFormRequestOfferArticle->labelEx($oModelFormRequestOfferArticle, 'quantity', array('style'=>'width:60px;')); ?>
                     <?php echo $formFormRequestOfferArticle->textField($oModelFormRequestOfferArticle, 'quantity', array('style'=>'width:60px;')); ?>
                     <?php echo $formFormRequestOfferArticle->error($oModelFormRequestOfferArticle, 'quantity', array('style'=>'width:60px;')); ?>   
                  </div>
                  <div class="cell">
                     <?php echo $formFormRequestOfferArticle->labelEx($oModelFormRequestOfferArticle, 'description', array('style'=>'width:480px;')); ?>
                     <?php echo FForm::textFieldAutoComplete($oModelFormRequestOfferArticle, 'description', CHtml::listData(Articles::getArticles(), 'name', 'fullNameWithStock'), array('style'=>'width:480px;'), false, true); ?>
                     <?php echo $formFormRequestOfferArticle->error($oModelFormRequestOfferArticle, 'description', array('style'=>'width:480px;')); ?>   
                  </div>
                  <div class="cell">
                     <?php echo $formFormRequestOfferArticle->labelEx($oModelFormRequestOfferArticle, 'requirements_date', array('style'=>'width:140px;')); ?>
                     <?php $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelFormRequestOfferArticle, 'requirements_date', false, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '140px')); ?>
                     <?php echo $formFormRequestOfferArticle->error($oModelFormRequestOfferArticle, 'requirements_date', array('style'=>'width:140px;')); ?>
                  </div>
                  <div class="last_cell">
                     <?php echo $formFormRequestOfferArticle->labelEx($oModelFormRequestOfferArticle, 'service', array('style'=>'width:60px;')); ?>
                     <?php echo $formFormRequestOfferArticle->checkBox($oModelFormRequestOfferArticle, 'service', array('style'=>'width:10px;')); ?>
                     <?php echo $formFormRequestOfferArticle->error($oModelFormRequestOfferArticle, 'service', array('style'=>'width:60px;')); ?>  
                  </div>
               </div>
            </div> 
            <div class="row buttons">
               <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
            </div>     
         </div>
           
         <?php $this->endWidget(); ?>
      </div>
   <?php
   }
   ?>
   
   <div class="toolbox_table">
      <div class="toolbox_table_cell_description">      
         <div class="item-description-italic">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_ARTICLE_GRID_DESCRIPTION'); ?>
         </div>
      </div>
   </div>

   <?php                         
   $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'id_CGridView',
      'template'=>'{items} {pager}',
      'ajaxUpdate'=>false,
      'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
      'pager'=>FGrid::getNavigationButtons(),
      'dataProvider'=>$oModelFormRequestOfferArticleFilters->search($oModelForm->id),
      'columns'=>array(
         array(
            'name'=>'quantity',
            'htmlOptions'=>array('width'=>100, 'style'=>'text-align:center'),
         ),
         array(
            'name'=>'description',
            'htmlOptions'=>array('width'=>450),
         ), 
         array(
            'name'=>'requirements_date',
            'value'=>'(!FString::isNullOrEmpty($data->requirements_date)) ? FDate::getTimeZoneFormattedDate($data->requirements_date) : FString::STRING_EMPTY',
            'htmlOptions'=>array('width'=>90),
         ),  
         array(
            'name'=>'service',
            'value'=>'($data->service) ? Yii::t(\'system\', \'SYS_YES\') : Yii::t(\'system\', \'SYS_NO\')',
            'htmlOptions'=>array('width'=>80, 'style'=>'text-align:center'),
         ),                              
         FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormRequestOfferArticle", array("nIdForm"=>$data->primaryKey))', 'FModulePurchasesManagement::allowUpdateFormRequestOfferArticle($data->primaryKey)', FString::STRING_BOOLEAN_TRUE),                                                                                                                                                                                                                                       
         FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFormRequestOfferArticle", array("nIdForm"=>$data->primaryKey))'),
         FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormRequestOfferArticle", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_request_offer))', 'FModulePurchasesManagement::allowDeleteFormRequestOfferArticle($data->primaryKey)'),
      ),
      'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
   ));
   ?>
   
   <br/><br/>
   <div class="form">
      <?php $formFormRequestOfferLine = $this->beginWidget('CActiveForm', array(
         'id'=>'purchases-form-request-offer-line-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormRequestOffer', array('nIdForm'=>$oModelForm->id)),
         'enableAjaxValidation'=>true,
         'enableClientValidation'=>true,
         'clientOptions'=>array(
            'validateOnSubmit'=>true,
         ),
      )); ?>
           
      <div class="form_expand_collapse" >
         <div id="id_form_expand_collapse_image_line" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image_line'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse_line');" >
         </div>
         <div class="form_expand_collapse_text">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_FORM_NEW_LINE_BTN_DESCRIPTION'); ?>
         </div>   
      </div>
       
      <div id="id_form_content_expand_collapse_line" class="form_content_expand_collapse">
         <div class="form_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_FORM_NEW_LINE_DESCRIPTION'); ?>
         </div>
         <div class="form_content">
            <div class="first_row">
               <div class="last_cell">
                  <?php echo $formFormRequestOfferLine->labelEx($oModelFormRequestOfferLine, 'id_provider', array('style'=>'width:400px;')); ?>
                  <?php echo FForm::textFieldAutoComplete($oModelFormRequestOfferLine, 'id_provider', CHtml::listData(Providers::getProviders(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:400px;')); ?>
                  <?php echo $formFormRequestOfferLine->error($oModelFormRequestOfferLine, 'id_provider', array('style'=>'width:400px;')); ?>   
               </div>
            </div>
         </div> 
         <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
         </div>     
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
   
   <div class="toolbox_table">
      <div class="toolbox_table_cell_description">      
         <div class="item-description-italic">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFER_LINE_GRID_DESCRIPTION'); ?>
         </div>
      </div>
   </div>

   <?php 
   $oPurchasesModuleParameters = PurchasesModuleParameters::getPurchasesModuleParameters();
                           
   $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'id_CGridView_2',
      'template'=>'{items} {pager}',
      'ajaxUpdate'=>false,
      'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
      'pager'=>FGrid::getNavigationButtons(),
      'dataProvider'=>$oModelFormRequestOfferLineFilters->search($oModelForm->id),
      'rowCssClassExpression'=>'(!FString::isNullOrEmpty($data->offer)) ? (($data->selected) ? \'completed\' :  \'pending\') : \'no_completed\'',
      'columns'=>array(
         array(
            'name'=>'id',
            'htmlOptions'=>array('width'=>60),
         ),
         array(
            'name'=>'id_provider',
            'value'=>'Providers::getProviderName($data->id_provider)',
            'htmlOptions'=>array('width'=>270),
         ),
         array(
            'name'=>'price',
            'value'=>'($data->price >= 0) ? FFormat::getFormatPrice($data->price) . FString::STRING_SPACE . Yii::t(\'system\', \'SYS_EUR\') : FString::STRING_EMPTY',
            'htmlOptions'=>array('width'=>120, 'style'=>'text-align:right'),
         ),
         array(
            'name'=>'notify_date',
            'value'=>'(!is_null($data->notify_date)) ? FDate::getTimeZoneFormattedDate($data->notify_date, true) : FString::STRING_EMPTY',
            'htmlOptions'=>array('width'=>120),
         ),
         array(                                                                               
            'name'=>'nConsumption',
            'header'=>Yii::t('rainbow', 'MODEL_PROVIDERS_FIELD_CONSUMPTION') . FString::STRING_SPACE . $oModelForm->financial_cost_line->financial_cost->year,
            'value'=>'FFormat::getFormatPrice(Providers::getProviderConsumptionByYear($data->id_provider, $data->form_request_offer->financial_cost_line->financial_cost->year, false)) . FString::STRING_SPACE . Yii::t(\'system\', \'SYS_EUR\')',
            'htmlOptions'=>array('width'=>120, 'style'=>'text-align:right'),
         ),    
         FGrid::getInformationButton('PROVIDER_YEAR_OVERPRICE', '(Providers::getProviderConsumptionByYear($data->id_provider, $data->form_request_offer->financial_cost_line->financial_cost->year, false) + $data->price) >= ' . $oPurchasesModuleParameters->range_price_provider_year),                                                                                                                                                                                                                                                                    
         FGrid::getSelectorButton('Yii::app()->controller->createUrl("selectFormRequestOfferLine", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_request_offer))', 'FModulePurchasesManagement::allowSelectFormRequestOfferLine($data->primaryKey)'),
         FGrid::getSendButton('Yii::app()->controller->createUrl("notifyFormRequestOfferLine", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_request_offer))', 'true'),
         FGrid::getAttachmentButton('Yii::app()->controller->createUrl("viewAttachmentFormRequestOfferLine", array("nIdForm"=>$data->primaryKey))', '((!FString::isNullOrEmpty($data->offer)) && (file_exists(FApplication::FOLDER_PROTECTED_DOCUMENTS_MODULE_PURCHASES_OFFERS . $data->offer)))'),
         FGrid::getEditButton('Yii::app()->controller->createUrl("updateFormRequestOfferLine", array("nIdForm"=>$data->primaryKey))', 'FModulePurchasesManagement::allowUpdateFormRequestOfferLine($data->primaryKey)', FString::STRING_BOOLEAN_TRUE, false, 'attachment_clip_4.png'),
         FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailFormRequestOfferLine", array("nIdForm"=>$data->primaryKey))'),
         FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormRequestOfferLine", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>$data->id_form_request_offer))', 'FModulePurchasesManagement::allowDeleteFormRequestOfferLine($data->primaryKey)'),
      ),
      'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
   ));
   ?>

   <?php
   if ((Yii::app()->user->hasFlash('success-generic')) || (Yii::app()->user->hasFlash('notice-generic')) || (Yii::app()->user->hasFlash('error-generic'))) { ?>
      <?php if (Yii::app()->user->hasFlash('success-generic')) { ?>
         <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('success-generic'); ?>
         </div> 
      <?php } else if (Yii::app()->user->hasFlash('notice-generic')) { ?>
         <div class="flash-notice">
            <?php echo Yii::app()->user->getFlash('notice-generic'); ?>
         </div>   
      <?php } else { ?>
         <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('error-generic'); ?>
         </div>
      <?php }
   }
   ?>
   
   <div class="row">
      <div class="cell">
         <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_DISCARDED;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINES_FIELD_STATUS_VALUE_CREATED');?>
      </div>
      
      <div class="cell">
         <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_PENDING;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINES_FIELD_STATUS_VALUE_PENDING');?>
      </div>

      <div class="last_cell">
         <input type="text" style="height:10px; width:25px; border:1px solid transparent; background-color:<?php echo FModulePurchasesManagement::COLOR_GRID_STATUS_RUNNING;?>; cursor:default;" readonly/>&nbsp<?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'MODEL_PURCHASESFORMSREQUESTOFFERSLINES_FIELD_STATUS_VALUE_SELECTED');?>
      </div>
   </div>

   <div class="form">
      <div class="row buttons">
         <?php echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_BACK'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('viewFormsRequestOffers') . '\'')); ?>
      </div>
   </div>
<?php
} 
?>