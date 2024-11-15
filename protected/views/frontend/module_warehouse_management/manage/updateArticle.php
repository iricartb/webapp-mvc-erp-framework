<?php 
   $oLastProvider = Articles::getArticleLastProvider($oModelForm->id); 
   $sLastProvider = FString::STRING_EMPTY;
   $sLastProviderPhone = FString::STRING_EMPTY;
   $sLastProviderMail = FString::STRING_EMPTY;
   
   if (count($oLastProvider) > 0) {
      if (!FString::isNullOrEmpty($oLastProvider[0])) {
         $oProvider = Providers::getProvider($oLastProvider[0]);
         if (!is_null($oProvider)) {
            $sLastProvider = $oProvider->name;   
            $sLastProviderPhone = $oProvider->phone;   
            $sLastProviderMail = $oProvider->mail;   
         }
      }
      else {
         if (!FString::isNullOrEmpty($oLastProvider[1])) $sLastProvider = $oLastProvider[1];   
      }    
   }
?>

<div class="form">
   <?php $formArticle = $this->beginWidget('CActiveForm', array(
      'id'=>'article-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/updateArticle', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
      'htmlOptions'=>array('enctype'=>'multipart/form-data'),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEARTICLE_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formArticle->labelEx($oModelForm, 'name', array('style'=>'width:433px;')); ?>
               <?php echo $formArticle->textField($oModelForm, 'name', array('style'=>'width:433px;')); ?>
               <?php echo $formArticle->error($oModelForm, 'name', array('style'=>'width:433px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formArticle->labelEx($oModelForm, 'model', array('style'=>'width:200px;')); ?>
               <?php echo $formArticle->textField($oModelForm, 'model', array('style'=>'width:200px;')); ?>
               <?php echo $formArticle->error($oModelForm, 'model', array('style'=>'width:200px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formArticle->labelEx($oModelForm, 'id_subcategory', array('style'=>'width:320px;')); ?>
               <?php echo $formArticle->dropDownList($oModelForm, 'id_subcategory', CHtml::listData(WarehouseArticlesSubcategories::getFullWarehouseArticlesSubcategories(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:320px;')); ?>
               <?php echo $formArticle->error($oModelForm, 'id_subcategory', array('style'=>'width:320px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formArticle->labelEx($oModelForm, 'id_location_subcategory', array('style'=>'width:320px;')); ?>
               <?php echo $formArticle->dropDownList($oModelForm, 'id_location_subcategory', CHtml::listData(WarehouseArticlesLocationsSubcategories::getFullWarehouseArticlesLocationsSubcategories(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:320px;')); ?>
               <?php echo $formArticle->error($oModelForm, 'id_location_subcategory', array('style'=>'width:320px;')); ?>   
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formArticle->labelEx($oModelForm, 'sLastProvider', array('style'=>'width:320px;')); ?>
               <?php echo $formArticle->textField($oModelForm, 'sLastProvider', array('style'=>'width:320px;', 'disabled'=>'disabled', 'value'=>$sLastProvider)); ?>
               <?php echo $formArticle->error($oModelForm, 'sLastProvider', array('style'=>'width:320px;')); ?>   
            </div>
            <div class="cell">
               <?php echo $formArticle->labelEx($oModelForm, 'sLastProviderPhone', array('style'=>'width:120px;')); ?>
               <?php echo $formArticle->textField($oModelForm, 'sLastProviderPhone', array('style'=>'width:120px;', 'disabled'=>'disabled', 'value'=>$sLastProviderPhone)); ?>
               <?php echo $formArticle->error($oModelForm, 'sLastProviderPhone', array('style'=>'width:120px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formArticle->labelEx($oModelForm, 'sLastProviderMail', array('style'=>'width:160px;')); ?>
               <?php echo $formArticle->textField($oModelForm, 'sLastProviderMail', array('style'=>'width:160px;', 'disabled'=>'disabled', 'value'=>$sLastProviderMail)); ?>
               <?php echo $formArticle->error($oModelForm, 'sLastProviderMail', array('style'=>'width:160px;')); ?>   
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formArticle->labelEx($oModelForm, 'code_barcode', array('style'=>'width:200px;')); ?>
               <?php echo $formArticle->textField($oModelForm, 'code_barcode', array('style'=>'width:200px;')); ?>
               <?php echo $formArticle->error($oModelForm, 'code_barcode', array('style'=>'width:200px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formArticle->labelEx($oModelForm, 'code_kks', array('style'=>'width:200px;')); ?>
               <?php echo $formArticle->textField($oModelForm, 'code_kks', array('style'=>'width:200px;')); ?>
               <?php echo $formArticle->error($oModelForm, 'code_kks', array('style'=>'width:200px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formArticle->labelEx($oModelForm, 'ipe', array('style'=>'width:60px;')); ?>
               <?php echo $formArticle->checkBox($oModelForm, 'ipe', array('style'=>'width:10px;')); ?>
               <?php echo $formArticle->error($oModelForm, 'ipe', array('style'=>'width:60px;')); ?>
            </div>
            <div class="cell">
               <?php echo $formArticle->labelEx($oModelForm, 'absolete', array('style'=>'width:60px;')); ?>
               <?php echo $formArticle->checkBox($oModelForm, 'absolete', array('style'=>'width:10px;')); ?>
               <?php echo $formArticle->error($oModelForm, 'absolete', array('style'=>'width:60px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formArticle->labelEx($oModelForm, 'commonwealth', array('style'=>'width:60px;')); ?>
               <?php echo $formArticle->checkBox($oModelForm, 'commonwealth', array('style'=>'width:10px;')); ?>
               <?php echo $formArticle->error($oModelForm, 'commonwealth', array('style'=>'width:60px;')); ?>
            </div>
         </div> 
         <div class="row">
            <div class="last_cell">
               <?php echo $formArticle->labelEx($oModelForm, 'description', array('style'=>'width:430px;')); ?>
               <?php echo $formArticle->textArea($oModelForm, 'description', array('style'=>'width:430px; height:60px;')); ?>
               <?php echo $formArticle->error($oModelForm, 'description', array('style'=>'width:430px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formArticle->labelEx($oModelForm, 'image', array('style'=>'width:430px;')); ?>
               <?php echo $formArticle->fileField($oModelForm, 'image', array('style'=>'width:430px;')); ?>
               <?php echo $formArticle->error($oModelForm, 'image', array('style'=>'width:430px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formArticle->labelEx($oModelForm, 'price_medium', array('style'=>'width:100px;')); ?>
               <?php echo $formArticle->textField($oModelForm, 'price_medium', array('style'=>'width:100px;', 'disabled'=>'disabled', 'value'=>FFormat::getFormatPrice($oModelForm->price_medium))) . ' €'; ?>
               <?php echo $formArticle->error($oModelForm, 'price_medium', array('style'=>'width:100px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formArticle->labelEx($oModelForm, 'nPriceLast', array('style'=>'width:100px;')); ?>
               <?php echo $formArticle->textField($oModelForm, 'nPriceLast', array('style'=>'width:100px;', 'disabled'=>'disabled', 'value'=>FFormat::getFormatPrice(Articles::getArticleHistoricalPriceLast($oModelForm->id)))) . ' €'; ?>
               <?php echo $formArticle->error($oModelForm, 'nPriceLast', array('style'=>'width:100px;')); ?>
            </div>
         </div> 
         <div class="row">
            <div class="cell">
               <?php echo $formArticle->labelEx($oModelForm, 'weight', array('style'=>'width:100px;')); ?>
               <?php echo $formArticle->textField($oModelForm, 'weight', array('style'=>'width:100px;')) . ' g'; ?>
               <?php echo $formArticle->error($oModelForm, 'weight', array('style'=>'width:100px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formArticle->labelEx($oModelForm, 'volume', array('style'=>'width:100px;')); ?>
               <?php echo $formArticle->textField($oModelForm, 'volume', array('style'=>'width:100px;')) . ' cm³'; ?>
               <?php echo $formArticle->error($oModelForm, 'volume', array('style'=>'width:300px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formArticle->labelEx($oModelForm, 'quantity_min', array('style'=>'width:400px;')); ?>
               <?php echo $formArticle->textField($oModelForm, 'quantity_min', array('style'=>'width:100px;')) . ' uds'; ?>
               <?php echo $formArticle->error($oModelForm, 'quantity_min', array('style'=>'width:400px;')); ?>
            </div>
         </div> 
         <div class="row">
            <div class="cell">
               <?php echo $formArticle->labelEx($oModelForm, 'id_related_article', array('style'=>'width:320px;')); ?>
               <?php echo $formArticle->dropDownList($oModelForm, 'id_related_article', CHtml::listData(Articles::getArticles(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:320px;')); ?>
               <?php echo $formArticle->error($oModelForm, 'id_related_article', array('style'=>'width:320px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formArticle->labelEx($oModelForm, 'id_equivalent_article', array('style'=>'width:320px;')); ?>
               <?php echo $formArticle->dropDownList($oModelForm, 'id_equivalent_article', CHtml::listData(Articles::getArticles(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:320px;')); ?>
               <?php echo $formArticle->error($oModelForm, 'id_equivalent_article', array('style'=>'width:320px;')); ?>   
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>