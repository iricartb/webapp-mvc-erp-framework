<div class="form">
   <?php $formFormOutputArticle = $this->beginWidget('CActiveForm', array(
      'id'=>'warehouse-form-output-article-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/updateFormOutputArticleBarcode', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <img width="100%" height="200px" src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . '/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/barcode.jpg'; ?>">
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formFormOutputArticle->labelEx($oModelFormArticle, 'article', array('style'=>'width:530px;')); ?>
               <div id="id_article">
                  <?php 
                     echo $formFormOutputArticle->textField($oModelFormArticle, 'article', array('style'=>'width:530px; background-color:#dedede', 'readonly'=>true));   
                  ?>
               </div>
               <?php echo $formFormOutputArticle->error($oModelFormArticle, 'article', array('style'=>'width:530px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formFormOutputArticle->labelEx($oModelFormArticle, 'location_subcategory', array('style'=>'width:530px;')); ?>
               <div id="id_location_subcategory">
                  <?php 
                     echo $formFormOutputArticle->textField($oModelFormArticle, 'location_subcategory', array('style'=>'width:530px; background-color:#dedede', 'readonly'=>true));   
                  ?>
               </div>
               <?php echo $formFormOutputArticle->error($oModelFormArticle, 'location_subcategory', array('style'=>'width:530px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="cell">
               <?php echo $formFormOutputArticle->labelEx($oModelFormArticle, 'article_code_barcode', array('style'=>'width:250px;')); ?>
               <?php echo $formFormOutputArticle->textField($oModelFormArticle, 'article_code_barcode', array('style'=>'width:250px;', 'onchange'=>'refreshArticleByBarcode(this.value)')); ?>
               <?php echo $formFormOutputArticle->error($oModelFormArticle, 'article_code_barcode', array('style'=>'width:250px;')); ?>
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
         <div class="row">
            <div class="last_cell">
               <?php echo CHtml::submitButton(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEFORMOUTPUT_FORM_NEW_BTN_SUBMIT_ARTICLE'), array('class'=>'input_button_lightgray_radius_no_border icon_document_new_1 icon_position_left icon_label animation_background_lightgray font_size_10', 'style'=>'width:130px; text-align:left;')); ?>
            </div>
         </div> 
      </div>
   </div>
       
   <?php $this->endWidget(); ?>
</div>

<?php
if ((Yii::app()->user->hasFlash('success')) || (Yii::app()->user->hasFlash('notice')) || (Yii::app()->user->hasFlash('error'))) { ?>
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

<script type="text/javascript">
   function refreshArticleByBarcode(sBarcodeValue) {
      sBarcodeValue = sBarcodeValue.replace('\'', '-');
       
      aj('<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormOutputArticleBarcode') . '&nIdForm=' . $oModelForm->id . '&sBarcode='; ?>' + sBarcodeValue, null, 'id_article');
      aj('<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormOutputArticlePriceBarcode') . '&nIdForm=' . $oModelForm->id . '&sBarcode='; ?>' + sBarcodeValue, null, 'id_price_cost');
      aj('<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/refreshFormOutputArticleLocationBarcode') . '&nIdForm=' . $oModelForm->id . '&sBarcode='; ?>' + sBarcodeValue, null, 'id_location_subcategory');
   
      setTimeout(function() {
         document.getElementById('warehouse-form-output-article-form').submit();
      }, 5000);
   }
   
   setTimeout(function() {
      document.getElementById('WarehouseFormOutputArticles_article_code_barcode').focus(); 
   }, 1000);
</script>