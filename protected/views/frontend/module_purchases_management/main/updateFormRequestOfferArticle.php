<div class="form">
   <?php $formFormRequestOfferArticle = $this->beginWidget('CActiveForm', array(
      'id'=>'purchases-form-request-offer-article-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormRequestOfferArticle', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMREQUESTOFFERARTICLE_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formFormRequestOfferArticle->labelEx($oModelForm, 'quantity', array('style'=>'width:60px;')); ?>
               <?php echo $formFormRequestOfferArticle->textField($oModelForm, 'quantity', array('style'=>'width:60px;')); ?>
               <?php echo $formFormRequestOfferArticle->error($oModelForm, 'quantity', array('style'=>'width:60px;')); ?>   
            </div>
            <div class="cell">
               <?php echo $formFormRequestOfferArticle->labelEx($oModelForm, 'description', array('style'=>'width:480px;')); ?>
               <?php echo FForm::textFieldAutoComplete($oModelForm, 'description', CHtml::listData(Articles::getArticles(), 'name', 'fullNameWithStock'), array('style'=>'width:480px;'), false, true); ?>
               <?php echo $formFormRequestOfferArticle->error($oModelForm, 'description', array('style'=>'width:480px;')); ?>   
            </div>
            <div class="cell">
               <?php echo $formFormRequestOfferArticle->labelEx($oModelForm, 'requirements_date', array('style'=>'width:140px;')); ?>
               <?php 
               if (!FString::isNullOrEmpty($oModelForm->requirements_date)) {
                  $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'requirements_date', false, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '140px', FString::STRING_EMPTY, FDate::getTimeZoneFormattedDate($oModelForm->requirements_date)));
               }
               else {
                  $this->widget('CJuiDateTimePicker', FForm::getDatePickerAttributes($oModelForm, 'requirements_date', false, 'strtotime()', FString::STRING_EMPTY, FString::STRING_EMPTY, FString::STRING_EMPTY, false, false, '140px'));
               } ?>
               <?php echo $formFormRequestOfferArticle->error($oModelForm, 'requirements_date', array('style'=>'width:140px;')); ?>
            </div>
            <div class="last_cell">
               <?php echo $formFormRequestOfferArticle->labelEx($oModelForm, 'service', array('style'=>'width:60px;')); ?>
               <?php echo $formFormRequestOfferArticle->checkBox($oModelForm, 'service', array('style'=>'width:10px;')); ?>
               <?php echo $formFormRequestOfferArticle->error($oModelForm, 'service', array('style'=>'width:60px;')); ?>  
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>