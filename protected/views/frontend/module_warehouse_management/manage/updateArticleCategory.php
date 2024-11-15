<div class="form">
   <?php $formArticleCategory = $this->beginWidget('CActiveForm', array(
      'id'=>'warehouse-article-category-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/updateArticleCategory', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEARTICLECATEGORY_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formArticleCategory->labelEx($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formArticleCategory->textField($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formArticleCategory->error($oModelForm, 'name', array('style'=>'width:300px;')); ?>
            </div>
         </div> 
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>