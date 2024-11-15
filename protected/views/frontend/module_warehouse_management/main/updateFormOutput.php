<script type="text/javascript">
   function submit_article_form(form, data, hasError) {
      if (!hasError) {
         var oData = $('#warehouse-form-output-article-form').serialize();
         var sAfterAction = 'refreshAllCGridViews(); $("#WarehouseFormOutputArticles_id_subcategory").val(""); $("#WarehouseFormOutputArticles_id_article").val(""); $("#WarehouseFormOutputArticles_location_subcategory").val(""); $("#WarehouseFormOutputArticles_price_cost").val("0.000"); $("#WarehouseFormOutputArticles_quantity").val("1");';
    
         aj('<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/updateFormOutputArticle') . '&nIdForm=' . $oModelForm->id ?>', oData, 'id_error_not_available_articles', null, null, sAfterAction, null, '<?php echo FAjax::TYPE_METHOD_CONTENT_REPLACE;?>', '<?php echo FAjax::TYPE_METHOD_CONTENT_DECORATION_NONE;?>', 0); 
      }
   }

   function refresh_information(type) {
      if (type == '<?php echo FModuleWarehouseManagement::TYPE_OUTPUT_PLANT; ?>') {
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_employee', true, 1.0, 1000);  
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_employee_department', true, 1.0, 1000);
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_provider', false, 1.0, 1000);    
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_working_part', true, 1.0, 1000);  
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_reference_code', false, 1.0, 1000); 
      }
      else if (type == '<?php echo FModuleWarehouseManagement::TYPE_OUTPUT_DEVOLUTION; ?>') {
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_employee', false, 1.0, 1000);  
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_employee_department', false, 1.0, 1000); 
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_provider', false, 1.0, 1000);   
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_working_part', false, 1.0, 1000);  
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_reference_code', true, 1.0, 1000);  
      }
      else if ((type == '<?php echo FModuleWarehouseManagement::TYPE_OUTPUT_REPAIR; ?>') || (type == '<?php echo FModuleWarehouseManagement::TYPE_OUTPUT_BENEFIT; ?>')) {
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_employee', false, 1.0, 1000);  
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_employee_department', false, 1.0, 1000); 
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_provider', true, 1.0, 1000);   
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_working_part', false, 1.0, 1000);  
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_reference_code', false, 1.0, 1000);  
      }
      else {
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_employee', false, 1.0, 1000);  
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_employee_department', false, 1.0, 1000);
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_provider', false, 1.0, 1000);     
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_working_part', false, 1.0, 1000);  
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_reference_code', false, 1.0, 1000);      
      }
   }
   
   $(document).ready(function() {
      if ('<?php echo $oModelForm->type; ?>' == '<?php echo FModuleWarehouseManagement::TYPE_OUTPUT_PLANT;?>') {
         $('#id_employee').css('display', 'table-cell');   
         $('#id_employee_department').css('display', 'table-cell'); 
         $('#id_provider').css('display', 'none');        
         $('#id_working_part').css('display', 'table-cell');     
         $('#id_reference_code').css('display', 'none');     
      }
      else if ('<?php echo $oModelForm->type; ?>' == '<?php echo FModuleWarehouseManagement::TYPE_OUTPUT_DEVOLUTION;?>') {
         $('#id_employee').css('display', 'none');   
         $('#id_employee_department').css('display', 'none');   
         $('#id_provider').css('display', 'none');  
         $('#id_working_part').css('display', 'none'); 
         $('#id_reference_code').css('display', 'table-cell');          
      }  
      else if (('<?php echo $oModelForm->type; ?>' == '<?php echo FModuleWarehouseManagement::TYPE_OUTPUT_REPAIR;?>') || ('<?php echo $oModelForm->type; ?>' == '<?php echo FModuleWarehouseManagement::TYPE_OUTPUT_BENEFIT;?>')) {
         $('#id_employee').css('display', 'none');   
         $('#id_employee_department').css('display', 'none');   
         $('#id_provider').css('display', 'table-cell');  
         $('#id_working_part').css('display', 'none'); 
         $('#id_reference_code').css('display', 'none');          
      }
      else {
         $('#id_employee').css('display', 'none');   
         $('#id_employee_department').css('display', 'none');    
         $('#id_provider').css('display', 'none');  
         $('#id_working_part').css('display', 'none'); 
         $('#id_reference_code').css('display', 'none'); 
      }
   });
</script>

<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/forms_outputs.png' ?>" />
   </div>
   <div class="item-header-text">  
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMOUTPUT_HEADER', array('{1}'=>$oModelForm->id))); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMOUTPUT_DESCRIPTION'); ?>
</div>

<?php $sRefreshArticlesUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormOutputArticles') . '&nIdForm=' . $oModelForm->id; 
      $sRefreshEmployeeDepartmentUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormOutputEmployeeDepartment');
?>
     
<div class="form">
   <div class="form_content">       
      <?php $formFormOutput = $this->beginWidget('CActiveForm', array(
         'id'=>'warehouse-form-output-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/updateFormOutput', array('nIdForm'=>$oModelForm->id)),
         'enableAjaxValidation'=>true,
         'enableClientValidation'=>true,
         'clientOptions'=>array(
            'validateOnSubmit'=>true,    
         ),
      )); ?>
                      
      <div class="first_row">
         <div class="cell_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMOUTPUT_FORM_HEADER_MAIN'); ?>
         </div>
      </div>
      <div class="row">
         <div class="last_cell">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_OWNER') . ':' . FString::STRING_SPACE . $oModelForm->owner; ?>
         </div>
      </div>
      <div class="row">
         <div class="cell">
            <?php echo $formFormOutput->labelEx($oModelForm, 'type', array('style'=>'width:250px;')); ?>
            <?php echo $formFormOutput->dropDownList($oModelForm, 'type', array(FModuleWarehouseManagement::TYPE_OUTPUT_PLANT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_PLANT'), FModuleWarehouseManagement::TYPE_OUTPUT_DEVOLUTION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_DEVOLUTION'), FModuleWarehouseManagement::TYPE_OUTPUT_BENEFIT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_BENEFIT'), FModuleWarehouseManagement::TYPE_OUTPUT_REPAIR=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_REPAIR'), FModuleWarehouseManagement::TYPE_OUTPUT_REGULARIZATION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSOUTPUTS_FIELD_TYPE_VALUE_REGULARIZATION')), array('style'=>'width:250px;', 'onchange'=>'refresh_information(this.value);')); ?>
            <?php echo $formFormOutput->error($oModelForm, 'type', array('style'=>'width:250px;')); ?>
         </div>
         <div id="id_reference_code" class="last_cell" style="display:none">
            <?php echo $formFormOutput->labelEx($oModelForm, 'code', array('style'=>'width:250px;')); ?>
            <?php echo $formFormOutput->textField($oModelForm, 'code', array('style'=>'width:250px')); ?>
            <?php echo $formFormOutput->error($oModelForm, 'code', array('style'=>'width:250px;')); ?>
         </div>
      </div>  
      <div class="row"> 
         <div id="id_provider" class="last_cell" style="display:none">
            <?php echo $formFormOutput->labelEx($oModelForm, 'id_provider', array('style'=>'width:530px;')); ?>
            <?php echo $formFormOutput->dropDownList($oModelForm, 'id_provider', CHtml::listData(Providers::getProviders(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:530px;')); ?>
            <?php echo $formFormOutput->error($oModelForm, 'id_provider', array('style'=>'width:530px;')); ?>   
         </div>
      </div> 
      <div class="row">
         <div id="id_employee" class="cell">
            <?php echo $formFormOutput->labelEx($oModelForm, 'id_employee', array('style'=>'width:320px;')); ?>
            <?php echo $formFormOutput->dropDownList($oModelForm, 'id_employee', CHtml::listData(Employees::getEmployees(array(FApplication::EMPLOYEE_BUSINESS), null, null, true), 'id', 'full_name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:320px;', 'onchange'=>'aj(\'' . $sRefreshEmployeeDepartmentUrl . '&nIdForm=\' + this.value, null, \'id_employee_department_field\');')); ?>
            <?php echo $formFormOutput->error($oModelForm, 'id_employee', array('style'=>'width:320px;')); ?>
         </div>
         <div id="id_employee_department" class="last_cell">
            <?php echo $formFormOutput->labelEx($oModelForm, 'employee_department', array('style'=>'width:180px;')); ?>
            <div id="id_employee_department_field">  
               <?php 
               if (!FString::isNullOrEmpty($oModelForm->employee_department)) { 
                  echo $formFormOutput->textField($oModelForm, 'employee_department', array('style'=>'width:180px', 'disabled'=>'disabled', 'value'=>Yii::t('rainbow', 'MODEL_EMPLOYEES_FIELD_DEPARTMENT_VALUE_' . $oModelForm->employee_department))); 
               }
               else {
                  echo $formFormOutput->textField($oModelForm, 'employee_department', array('style'=>'width:180px', 'disabled'=>'disabled'));
               } ?>
            </div>                                                                                                                                   
            <?php echo $formFormOutput->error($oModelForm, 'employee_department', array('style'=>'width:180px;')); ?>
         </div>
      </div> 
      <div class="row">
         <div id="id_working_part" class="last_cell">
            <?php echo $formFormOutput->labelEx($oModelForm, 'id_form_working_part', array('style'=>'width:530px;')); ?>
            
            <?php 
            if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) {
               echo $formFormOutput->dropDownList($oModelForm, 'id_form_working_part', FModuleWorkingPartsManagement::getRunningFormsWorkingParts(), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:530px'));    
            }
            else {
               echo $formFormOutput->textField($oModelForm, 'id_form_working_part', array('style'=>'width:530px')); 
            }
            ?>
            
            <?php echo $formFormOutput->error($oModelForm, 'id_form_working_part', array('style'=>'width:530px;')); ?>
         </div>
      </div>
      <div class="row"> 
         <div class="last_cell">
            <?php echo $formFormOutput->labelEx($oModelForm, 'comments', array('style'=>'width:530px;')); ?>
            <?php echo $formFormOutput->textArea($oModelForm, 'comments', array('style'=>'width:530px; height:60px; overflow:auto; resize:none', 'onchange'=>$sJsRefreshInformation)); ?>
            <?php echo $formFormOutput->error($oModelForm, 'comments', array('style'=>'width:530px;')); ?>
         </div>
      </div> 
   
      <?php $this->endWidget(); ?>
   
      <?php $formFormOutputArticle = $this->beginWidget('CActiveForm', array(
         'id'=>'warehouse-form-output-article-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/updateFormOutputArticle', array('nIdForm'=>$oModelForm->id)),
         'enableAjaxValidation'=>true,
         'enableClientValidation'=>true,
         'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'afterValidate'=>'js:submit_article_form',
         ),
      )); ?>

      <br/>
      <div class="row">
         <div class="cell_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMOUTPUT_FORM_HEADER_ARTICLES'); ?>
         </div>
      </div>
      <div class="row">
         <div class="cell">
            <?php $sAction = Yii::app()->controller->createUrl('updateFormOutputArticleBarcode&nIdForm=' . $oModelForm->id); ?>      
            <?php echo FWidget::showIconImageButton('warehouseFormInputArticleBarcode', 'code_barcode_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMOUTPUT_NEW_BTN_BARCODE_DESCRIPTION'), $sAction, true, '11px', '0px', '16x16', false); ?> 
         </div>
         <div class="last_cell">
            <?php $sAction = 'showHideElement(\'id_form_article_manual\');' ?>      
            <?php echo FWidget::showIconImageButton('warehouseFormOutputArticleManual', 'selector_hand_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMOUTPUT_NEW_BTN_MANUAL_DESCRIPTION'), $sAction); ?> 
         </div>
      </div>
      <div id="id_form_article_manual" style="display:none">
         <div class="row">
            <div class="last_cell">
               <?php
                  $sRefreshSubcategoryByArticleCodeUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormOutputSubcategoriesByArticleCode') . '&nIdForm=' . $oModelForm->id . '&sIdSubcategory=';
                  $sRefreshArticleByArticleCodeUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormOutputArticlesByArticleCode') . '&nIdForm=' . $oModelForm->id . '&sIdSubcategory=';
                  $sRefreshPriceUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormOutputPrice') . '&nIdForm=' . $oModelForm->id . '&nIdArticle=';
                  $sRefreshLocationUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormOutputLocation') . '&nIdForm=' . $oModelForm->id . '&nIdArticle=';
                  $sRefreshSubcategoryByArticleCodeUrl = "aj('" . $sRefreshSubcategoryByArticleCodeUrl . "' + this.value.substring(0, 4) + '&nIdArticle=' + Number(this.value.substring(4)), null, 'id_subcategory');";        
                  $sRefreshArticleByArticleCodeUrl = "aj('" . $sRefreshArticleByArticleCodeUrl . "' + this.value.substring(0, 4) + '&nIdArticle=' + Number(this.value.substring(4)), null, 'id_article');";       
                  $sRefreshPriceUrl = "aj('" . $sRefreshPriceUrl . "' + Number(this.value.substring(4)), null, 'id_price_cost');";              
                  $sRefreshLocationUrl = "aj('" . $sRefreshLocationUrl . "' + Number(this.value.substring(4)), null, 'id_location_subcategory')";
               ?>
               
               <div class="form_graph_option_content" style="background-color:#FCFFDF">   
                  <?php echo $formFormOutputArticle->labelEx($oModelFormArticle, 'nIdArticleSearch', array('style'=>'width:170px;')); ?> 
                  <?php echo $formFormOutputArticle->textField($oModelFormArticle, 'nIdArticleSearch', array('style'=>'width:170px;', 'onchange'=>$sRefreshSubcategoryByArticleCodeUrl . $sRefreshArticleByArticleCodeUrl . $sRefreshPriceUrl . $sRefreshLocationUrl)); ?>
                  <?php echo $formFormOutputArticle->error($oModelFormArticle, 'nIdArticleSearch', array('style'=>'width:170px;')); ?>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formFormOutputArticle->labelEx($oModelFormArticle, 'id_subcategory', array('style'=>'width:530px;')); ?> 
               <div id="id_subcategory">
                  <?php 
                     echo $formFormOutputArticle->dropDownList($oModelFormArticle, 'id_subcategory', CHtml::listData(WarehouseArticlesSubcategories::getFullWarehouseArticlesSubcategories(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:530px;', 'onchange'=>'aj(\'' . $sRefreshArticlesUrl . '&nIdSubcategory=\' + this.value, null, \'id_article\');')); 
                  ?>
               </div>
               <?php echo $formFormOutputArticle->error($oModelFormArticle, 'id_subcategory', array('style'=>'width:530px;')); ?>
            </div>
         </div>
         <div class="row"> 
            <div class="last_cell">
               <?php echo $formFormOutputArticle->labelEx($oModelFormArticle, 'id_article', array('style'=>'width:715px;')); ?>
               <div id="id_article">
                  <?php 
                     echo $formFormOutputArticle->dropDownList($oModelFormArticle, 'id_article', array(), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:715px;'));   
                  ?>
               </div>
               <?php echo $formFormOutputArticle->error($oModelFormArticle, 'id_article', array('style'=>'width:715px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formFormOutputArticle->labelEx($oModelFormArticle, 'location_subcategory', array('style'=>'width:432px;')); ?>
               <div id="id_location_subcategory">
                  <?php 
                     echo $formFormOutputArticle->textField($oModelFormArticle, 'location_subcategory', array('style'=>'width:432px; background-color:#dedede', 'readonly'=>true));   
                  ?>
               </div>
               <?php echo $formFormOutputArticle->error($oModelFormArticle, 'location_subcategory', array('style'=>'width:432px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formFormOutputArticle->labelEx($oModelFormArticle, 'quantity', array('style'=>'width:105px;')); ?>
               <?php echo $formFormOutputArticle->textField($oModelFormArticle, 'quantity', array('style'=>'width:105px;')); ?>
               <?php echo $formFormOutputArticle->error($oModelFormArticle, 'quantity', array('style'=>'width:105px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formFormOutputArticle->labelEx($oModelFormArticle, 'price_cost', array('style'=>'width:105px;')); ?>
               <div id="id_price_cost">
               <?php echo $formFormOutputArticle->textField($oModelFormArticle, 'price_cost', array('style'=>'width:105px', 'readonly'=>true)); ?>
               </div>
               <?php echo $formFormOutputArticle->error($oModelFormArticle, 'price_cost', array('style'=>'width:105px;')); ?>
            </div>
         </div>
         <div class="row buttons">
            <div class="last_cell" style="padding-top:7px">
               <?php echo CHtml::submitButton(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMOUTPUT_FORM_NEW_BTN_SUBMIT_ARTICLE'), array('class'=>'input_button_lightgray_radius_no_border icon_document_new_1 icon_position_left icon_label animation_background_lightgray font_size_10', 'style'=>'width:130px; text-align:left;')); ?>
            </div>
         </div>
      </div>
      
      <br/>
      <div class="cell" style="display:block"> 
         <?php 
         $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'id_CGridView',
            'template'=>'{items} {pager}',
            'ajaxUpdate'=>true,
            'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
            'pager'=>FGrid::getNavigationButtons(),
            'dataProvider'=>$oModelFormArticle->search($oModelForm->id),
            'columns'=>array(
               array(
                  'name'=>'article',
                  'value'=>'Articles::getArticle($data->id_article)->getFullName()',
                  'htmlOptions'=>array('width'=>420),
               ),
               array(
                  'name'=>'quantity',
                  'htmlOptions'=>array('width'=>60, 'style'=>'text-align:center;'),
               ),
               array(
                  'name'=>'price_cost',
                  'value'=>'FFormat::getFormatPrice($data->price_cost, false, true)',
                  'htmlOptions'=>array('width'=>60, 'style'=>'text-align:right;'),
               ),
               array(
                  'name'=>'nTotal',
                  'value'=>'FFormat::getFormatPrice(WarehouseFormOutputArticles::getWarehouseFormOutputArticleTotalPriceCost($data->id)) . \' €\'',
                  'htmlOptions'=>array('width'=>60, 'style'=>'text-align:right;'),  
               ),
               FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormOutputArticle", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>' . $oModelForm->id . '))', '(FModuleWarehouseManagement::allowUpdateWarehouseFormOutput(' . $oModelForm->id . '))'),
            ),
            'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
         )); 
         ?>
      </div>
      
      <?php $this->endWidget(); ?>
   </div>
   
   <?php
   if (Yii::app()->user->hasFlash('error')) { ?>
      <div class="flash-error">
         <?php echo Yii::app()->user->getFlash('error'); ?>
      </div> 
   <?php 
   } else if (Yii::app()->user->hasFlash('notice')) { ?>
      <div class="flash-notice">
         <?php echo Yii::app()->user->getFlash('notice'); ?>
      </div>  <?php
   } ?>

   <div id="id_error_not_available_articles"> 
   </div>  
   
   <div class="row buttons">
      <?php 
      if ($oModelForm->data_completed) {
         echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_BACK'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('viewFormsOutputs') . '\''));
      } ?>
      <?php echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit', 'onclick'=>'$(\'#warehouse-form-output-form\').submit();')); ?>
   </div> 
</div>