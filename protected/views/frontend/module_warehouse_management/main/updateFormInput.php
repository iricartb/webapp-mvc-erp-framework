<script type="text/javascript">
   function submit_article_form(form, data, hasError) { 
      if (!hasError) {
         var oData = $('#warehouse-form-input-article-form').serialize();
         var sAfterAction = 'refreshAllCGridViews(); $("#WarehouseFormInputArticles_id_subcategory").val(""); $("#WarehouseFormInputArticles_id_article").val(""); $("#WarehouseFormInputArticles_location_subcategory").val(""); $("#WarehouseFormInputArticles_price_cost").val("0.000"); $("#WarehouseFormInputArticles_quantity").val("1");';
                 
         aj('<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/updateFormInputArticle') . '&nIdForm=' . $oModelForm->id ?>', oData, null, null, null, sAfterAction, null, '<?php echo FAjax::TYPE_METHOD_CONTENT_REPLACE_NONE;?>', '<?php echo FAjax::TYPE_METHOD_CONTENT_DECORATION_NONE;?>', 0); 
      }
   }

   function refresh_information(type) {
      if ((type == '<?php echo FModuleWarehouseManagement::TYPE_INPUT_WAYBILL; ?>') || (type == '<?php echo FModuleWarehouseManagement::TYPE_INPUT_REPAIR; ?>')) {
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_reference_code', true, 1.0, 1000);  
         jquerySimpleAnimationFadeAppearDisappearBlock('#id_purchase_order', true, 1.0, 1000);  
      }
      else {
         jquerySimpleAnimationFadeAppearDisappearTableCell('#id_reference_code', false, 1.0, 1000);      
         jquerySimpleAnimationFadeAppearDisappearBlock('#id_purchase_order', false, 1.0, 1000);  
      }
   }
   
   $(document).ready(function() {
      if (('<?php echo $oModelForm->type; ?>' == '<?php echo FModuleWarehouseManagement::TYPE_INPUT_WAYBILL;?>') || ('<?php echo $oModelForm->type; ?>' == '<?php echo FModuleWarehouseManagement::TYPE_INPUT_REPAIR;?>')) {
         $('#id_reference_code').css('display', 'table-cell'); 
         $('#id_purchase_order').css('display', 'block');          
      }
      else {
         $('#id_reference_code').css('display', 'none'); 
         $('#id_purchase_order').css('display', 'none'); 
      }
   });
</script>

<?php $sRefreshArticlesUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormInputArticles') . '&nIdForm=' . $oModelForm->id; ?>

<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/forms_inputs.png' ?>" />
   </div>
   <div class="item-header-text">  
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMINPUT_HEADER', array('{1}'=>$oModelForm->id))); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMINPUT_DESCRIPTION'); ?>
</div>
 
<div class="form">
   <div class="form_content">       
      <?php $formFormInput = $this->beginWidget('CActiveForm', array(
         'id'=>'warehouse-form-input-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/updateFormInput', array('nIdForm'=>$oModelForm->id)),
         'enableAjaxValidation'=>true,
         'enableClientValidation'=>true,
         'clientOptions'=>array(
            'validateOnSubmit'=>true,    
         ),  
         'htmlOptions'=>array('enctype'=>'multipart/form-data'),
      )); ?>
                      
      <div class="first_row">
         <div class="cell_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMINPUT_FORM_HEADER_MAIN'); ?>
         </div>
      </div>
      <div class="row">
         <div class="last_cell">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_OWNER') . ':' . FString::STRING_SPACE . $oModelForm->owner; ?>
         </div>
      </div>
      <div class="row">
         <div class="cell">
            <?php echo $formFormInput->labelEx($oModelForm, 'type', array('style'=>'width:250px;')); ?>
            <?php echo $formFormInput->dropDownList($oModelForm, 'type', array(FModuleWarehouseManagement::TYPE_INPUT_WAYBILL=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_TYPE_VALUE_WAYBILL'), FModuleWarehouseManagement::TYPE_INPUT_BENEFIT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_TYPE_VALUE_BENEFIT'), FModuleWarehouseManagement::TYPE_INPUT_REPAIR=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_TYPE_VALUE_REPAIR'), FModuleWarehouseManagement::TYPE_INPUT_REGULARIZATION=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_TYPE_VALUE_REGULARIZATION')), array('style'=>'width:250px;', 'onchange'=>'refresh_information(this.value);')); ?>
            <?php echo $formFormInput->error($oModelForm, 'type', array('style'=>'width:250px;')); ?>
         </div>
         <div id="id_reference_code" class="last_cell">
            <?php echo $formFormInput->labelEx($oModelForm, 'code', array('style'=>'width:250px;')); ?>
            <?php echo $formFormInput->textField($oModelForm, 'code', array('style'=>'width:250px')); ?>
            <?php echo $formFormInput->error($oModelForm, 'code', array('style'=>'width:250px;')); ?>
         </div>
      </div>     
      <div class="row"> 
         <div class="last_cell">
            <?php
               $sJsRefreshProvider = 'window.location = \'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/updateFormInput') . '&nIdForm=' . $oModelForm->id . '&WarehouseFormsInputs[type]=\' + document.getElementById("WarehouseFormsInputs_type").value + \'&WarehouseFormsInputs[code]=\' + document.getElementById("WarehouseFormsInputs_code").value + \'&WarehouseFormsInputs[id_provider]=\' + this.value';
            ?>
            <?php echo $formFormInput->labelEx($oModelForm, 'id_provider', array('style'=>'width:530px;')); ?>
            <?php echo $formFormInput->dropDownList($oModelForm, 'id_provider', CHtml::listData(Providers::getProviders(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:530px;', 'onchange'=>$sJsRefreshProvider)); ?>
            <?php echo $formFormInput->error($oModelForm, 'id_provider', array('style'=>'width:530px;')); ?>   
         </div>
      </div>
      
      <?php 
      if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_PURCHASES_MANAGEMENT)) { ?>  
         <div id="id_purchase_order">
            <br/>
            <div class="row">
               <div class="cell_header">
                  <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMINPUT_FORM_HEADER_PURCHASE_ORDER'); ?>
               </div>
            </div>
            <div class="row">
               <div class="last_cell">
                  <?php echo $formFormInput->textField($oModelForm, 'id_form_purchase_order', array('style'=>'width:100px; background-color:#dedede', 'readonly'=>true)); ?> 
               </div>
            </div>
            
            <div class="last_cell table_no_margin_bottom table_empty_not_show" style="display:block">
               <?php 
               if (FString::isNullOrEmpty($oModelForm->id_provider)) $nFilterProvider = 0;
               else $nFilterProvider = $oModelForm->id_provider;
               
               $sJsOnClickPurchaseOrder = 'var oRow = $(this).attr("href").split("&");                                                        
                                           document.getElementById("WarehouseFormsInputs_id_form_purchase_order").value = oRow[1].substr(3);  
                                           aj("' . Yii::app()->controller->createUrl('viewDetailFormInputPurchaseOrder') . '&nIdForm=" + oRow[1].substr(3), null, "id_selector_preview");
                                           ';
               
               $this->widget('zii.widgets.grid.CGridView', array(
                  'id'=>'id_CGridView',
                  'template'=>'{items}',
                  'ajaxUpdate'=>true,       
                  'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
                  'pager'=>FGrid::getNavigationButtons(),
                  'dataProvider'=>$oModelFormPurchaseOrder->search($nFilterProvider), 
                  'columns'=>array(
                     FGrid::getSelectorButton('Yii::app()->controller->createUrl("selectFormPurchaseOrder", array("id"=>$data["id"]))', FString::STRING_BOOLEAN_TRUE, $sJsOnClickPurchaseOrder, false, 'selector_hand_1.png', 60),
                     array(
                        'name'=>'owner',
                        'htmlOptions'=>array('width'=>100),
                     ),
                     array(                          
                        'name'=>'description',
                        'value'=>'FString::getAbbreviationSentence($data->description, 100)',           
                        'htmlOptions'=>array('width'=>440),
                     ),
                     array(
                        'name'=>'price',
                        'value'=>'FFormat::getFormatPrice($data->price) . FString::STRING_SPACE . Yii::t(\'system\', \'SYS_EUR\')',
                        'htmlOptions'=>array('width'=>150, 'style'=>'text-align:right;'),
                     ),
                  ),
                  'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
               )); 
               ?>
            </div>
            
            <div class="row">
               <div class="last_cell">
                  <div id="id_selector_preview" style="background-color:white;">
                  </div>
               </div>
            </div>
         </div>
         <?php
      }
      ?>
      
      <br/>
      <div class="row">
         <div class="cell_header">
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMINPUT_FORM_HEADER_COMMENTS_AND_STATUS'); ?>
         </div>
      </div>   
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormInput->labelEx($oModelForm, 'status', array('style'=>'width:530px;')); ?>
            <div class="form_graph_option_content">   
               <?php
               $oTypeStatusList = array(FModuleWarehouseManagement::STATUS_SUCCESS=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_STATUS_VALUE_SUCCESS'), FModuleWarehouseManagement::STATUS_ALERT=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_STATUS_VALUE_ALERT'), FModuleWarehouseManagement::STATUS_ERROR=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'MODEL_WAREHOUSEFORMSINPUTS_FIELD_STATUS_VALUE_ERROR'));
               echo $formFormInput->radioButtonList($oModelForm, 'status', $oTypeStatusList, array('labelOptions'=>array('style'=>'display:inline; margin-right:40px;'), 'separator'=>FString::STRING_SPACE));
               ?>
            </div>
            <?php echo $formFormInput->error($oModelForm, 'status', array('style'=>'width:530px;')); ?>
         </div>
      </div>
      <div class="row">
         <div class="last_cell">
            <?php echo $formFormInput->labelEx($oModelForm, 'comments', array('style'=>'width:530px;')); ?>
            <?php echo $formFormInput->textArea($oModelForm, 'comments', array('style'=>'width:530px; height:60px; overflow:auto; resize:none')); ?>
            <?php echo $formFormInput->error($oModelForm, 'comments', array('style'=>'width:530px;')); ?>
         </div>
      </div>

      <?php $this->endWidget(); ?>
      
      <?php $formFormInputArticle = $this->beginWidget('CActiveForm', array(
         'id'=>'warehouse-form-input-article-form',
         'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/updateFormInputArticle', array('nIdForm'=>$oModelForm->id)),
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
            <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMINPUT_FORM_HEADER_ARTICLES'); ?>
         </div>
      </div>  
      <div class="row">
         <div class="cell">
            <?php $sAction = Yii::app()->controller->createUrl('updateFormInputArticleBarcode&nIdForm=' . $oModelForm->id); ?>      
            <?php echo FWidget::showIconImageButton('warehouseFormInputArticleBarcode', 'code_barcode_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMINPUT_NEW_BTN_BARCODE_DESCRIPTION'), $sAction, true, '11px', '0px', '16x16', false); ?> 
         </div>   
         <div class="last_cell">
            <?php $sAction = 'showHideElement(\'id_form_article_manual\');' ?>      
            <?php echo FWidget::showIconImageButton('warehouseFormInputArticleManual', 'selector_hand_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMINPUT_NEW_BTN_MANUAL_DESCRIPTION'), $sAction); ?> 
         </div>   
      </div>     
      <div id="id_form_article_manual" style="display:none">    
         <div class="row">
            <div class="last_cell">
               <?php
                  $sRefreshSubcategoryByArticleCodeUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormInputSubcategoriesByArticleCode') . '&nIdForm=' . $oModelForm->id . '&sIdSubcategory=';
                  $sRefreshArticleByArticleCodeUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormInputArticlesByArticleCode') . '&nIdForm=' . $oModelForm->id . '&sIdSubcategory=';
                  $sRefreshPriceUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormInputPrice') . '&nIdForm=' . $oModelForm->id . '&nIdArticle=';
                  $sRefreshLocationUrl = $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormInputLocation') . '&nIdForm=' . $oModelForm->id . '&nIdArticle=';
                  $sRefreshSubcategoryByArticleCodeUrl = "aj('" . $sRefreshSubcategoryByArticleCodeUrl . "' + this.value.substring(0, 4) + '&nIdArticle=' + Number(this.value.substring(4)), null, 'id_subcategory');";        
                  $sRefreshArticleByArticleCodeUrl = "aj('" . $sRefreshArticleByArticleCodeUrl . "' + this.value.substring(0, 4) + '&nIdArticle=' + Number(this.value.substring(4)), null, 'id_article');";       
                  $sRefreshPriceUrl = "aj('" . $sRefreshPriceUrl . "' + Number(this.value.substring(4)), null, 'id_price_cost');";              
                  $sRefreshLocationUrl = "aj('" . $sRefreshLocationUrl . "' + Number(this.value.substring(4)), null, 'id_location_subcategory')";
               ?>
               
               <div class="form_graph_option_content" style="background-color:#FCFFDF">   
                  <?php echo $formFormInputArticle->labelEx($oModelFormArticle, 'nIdArticleSearch', array('style'=>'width:170px;')); ?> 
                  <?php echo $formFormInputArticle->textField($oModelFormArticle, 'nIdArticleSearch', array('style'=>'width:170px;', 'onchange'=>$sRefreshSubcategoryByArticleCodeUrl . $sRefreshArticleByArticleCodeUrl . $sRefreshPriceUrl . $sRefreshLocationUrl)); ?>
                  <?php echo $formFormInputArticle->error($oModelFormArticle, 'nIdArticleSearch', array('style'=>'width:170px;')); ?>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formFormInputArticle->labelEx($oModelFormArticle, 'id_subcategory', array('style'=>'width:530px;')); ?> 
               <div id="id_subcategory">
                  <?php 
                     echo $formFormInputArticle->dropDownList($oModelFormArticle, 'id_subcategory', CHtml::listData(WarehouseArticlesSubcategories::getFullWarehouseArticlesSubcategories(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:530px;', 'onchange'=>'aj(\'' . $sRefreshArticlesUrl . '&nIdSubcategory=\' + this.value, null, \'id_article\');')); 
                  ?>
               </div>
               <?php echo $formFormInputArticle->error($oModelFormArticle, 'id_subcategory', array('style'=>'width:530px;')); ?>
            </div>
         </div>
         <div class="row"> 
            <div class="last_cell">
               <?php echo $formFormInputArticle->labelEx($oModelFormArticle, 'id_article', array('style'=>'width:715px;')); ?>
               <div id="id_article">
                  <?php 
                     echo $formFormInputArticle->dropDownList($oModelFormArticle, 'id_article', array(), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:715px;'));   
                  ?>    
               </div>
               <?php echo $formFormInputArticle->error($oModelFormArticle, 'id_article', array('style'=>'width:715px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formFormInputArticle->labelEx($oModelFormArticle, 'location_subcategory', array('style'=>'width:432px;')); ?>
               <div id="id_location_subcategory">
                  <?php 
                     echo $formFormInputArticle->textField($oModelFormArticle, 'location_subcategory', array('style'=>'width:432px; background-color:#dedede', 'readonly'=>true));   
                  ?>   
               </div>
               <?php echo $formFormInputArticle->error($oModelFormArticle, 'location_subcategory', array('style'=>'width:432px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formFormInputArticle->labelEx($oModelFormArticle, 'quantity', array('style'=>'width:105px;')); ?>
               <?php echo $formFormInputArticle->textField($oModelFormArticle, 'quantity', array('style'=>'width:105px;')); ?>
               <?php echo $formFormInputArticle->error($oModelFormArticle, 'quantity', array('style'=>'width:105px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formFormInputArticle->labelEx($oModelFormArticle, 'price_cost', array('style'=>'width:105px;')); ?>
               <div id="id_price_cost">
               <?php echo $formFormInputArticle->textField($oModelFormArticle, 'price_cost', array('style'=>'width:105px')); ?>
               </div>
               <?php echo $formFormInputArticle->error($oModelFormArticle, 'price_cost', array('style'=>'width:105px;')); ?>
            </div>
         </div>
         <div class="row buttons">
            <div class="last_cell" style="padding-top:7px;">
               <?php echo CHtml::submitButton(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMINPUT_FORM_NEW_BTN_SUBMIT_ARTICLE'), array('class'=>'input_button_lightgray_radius_no_border icon_document_new_1 icon_position_left icon_label animation_background_lightgray font_size_10', 'style'=>'width:130px; text-align:left;')); ?>
            </div>
         </div>
      </div>
      
      <br/>      
      <div class="last_cell" style="display:block"> 
         <?php 
         $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'id_CGridView_3',
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
                  'value'=>'FFormat::getFormatPrice(WarehouseFormInputArticles::getWarehouseFormInputArticleTotalPriceCost($data->id)) . \' €\'',
                  'htmlOptions'=>array('width'=>60, 'style'=>'text-align:right;'),
               ),
               FGrid::getGenericButton('Yii::app()->controller->createUrl("viewArticleBarcode", array("nIdForm"=>$data->id_article))', 'true', true, false, 'code_barcode_1.png', 'SYS_GRID_BTN_PRINT', 'fancybox_noRefresh'),
               FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteFormInputArticle", array("nIdForm"=>$data->primaryKey, "nIdFormParent"=>' . $oModelForm->id . '))', '(FModuleWarehouseManagement::allowUpdateWarehouseFormInput(' . $oModelForm->id . '))'),
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

   <div class="row buttons">
      <?php 
      if ($oModelForm->data_completed) {
         echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_BACK'), array('class'=>'form_button_submit', 'onclick'=>'window.location=\'' . Yii::app()->controller->createUrl('viewFormsInputs') . '\'')); 
      } ?>
      <?php echo CHtml::button(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit', 'onclick'=>'$(\'#warehouse-form-input-form\').submit();')); ?>
   </div> 
</div>