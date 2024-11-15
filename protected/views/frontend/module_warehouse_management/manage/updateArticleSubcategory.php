<div class="form">
   <?php $formArticleSubcategory = $this->beginWidget('CActiveForm', array(
      'id'=>'warehouse-article-subcategory-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/updateArticleSubcategory', array('nIdForm'=>$oModelForm->id)),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
   
   <div class="form_content_popup_modify">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_UPDATEARTICLESUBCATEGORY_FORM_UPDATE_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formArticleSubcategory->labelEx($oModelForm, 'id_category', array('style'=>'width:300px;')); ?>
               <?php echo $formArticleSubcategory->dropDownList($oModelForm, 'id_category', CHtml::listData(WarehouseArticlesCategories::getWarehouseArticlesCategories(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formArticleSubcategory->error($oModelForm, 'id_category', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formArticleSubcategory->labelEx($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formArticleSubcategory->textField($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formArticleSubcategory->error($oModelForm, 'name', array('style'=>'width:300px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formArticleSubcategory->labelEx($oModelForm, 'description', array('style'=>'width:300px;')); ?>
               <?php echo $formArticleSubcategory->textField($oModelForm, 'description', array('style'=>'width:300px;')); ?>
               <?php echo $formArticleSubcategory->error($oModelForm, 'description', array('style'=>'width:300px;')); ?>
            </div>
         </div>
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_MODIFY'), array('class'=>'form_button_submit')); ?>
      </div>  
   </div>
       
   <?php $this->endWidget(); ?>
</div>