<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/articles.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_WAREHOUSE_MANAGEMENT_HEADER_LINE_ARTICLES')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWARTICLES_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formArticle = $this->beginWidget('CActiveForm', array(
      'id'=>'article-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewArticles'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
      'htmlOptions'=>array('enctype'=>'multipart/form-data'),
   )); ?>
        
   <div class="form_expand_collapse" >
      <div id="id_form_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWARTICLES_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWARTICLES_FORM_NEW_DESCRIPTION'); ?>
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
      </div>
      <div class="row buttons">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_SAVE'), array('class'=>'form_button_submit')); ?>
      </div>     
   </div>
     
   <?php $this->endWidget(); ?>
</div>
  
<div class="toolbox_table">
   <div class="toolbox_table_cell_description" style="width:60%">      
      <div class="item-description-italic">   
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWARTICLES_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('articles', null, 'Articles', $_GET['Articles']['id'], 'quantity', $this, true); ?>
   </div>
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
                                                                                                                         
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormFilters->search($_GET['Articles']['id'], 2500),
   'filter'=>$oModelFormFilters,
   'columns'=>array(
      array(               
         'name'=>'id',
         'value'=>'$data->subcategory->name . str_pad($data->id, 4, \'0\', STR_PAD_LEFT)',
         'htmlOptions'=>array('width'=>80),
      ),
      array(
         'name'=>'name',
         'htmlOptions'=>array('width'=>770),
      ),   
      array(
         'name'=>'quantity',
         'filter'=>false,
         'htmlOptions'=>array('width'=>60, 'style'=>'text-align:center;'),
      ),
      FGrid::getGenericButton('Yii::app()->controller->createUrl("viewArticleBarcode", array("nIdForm"=>$data->primaryKey))', 'true', true, false, 'code_barcode_1.png', 'SYS_GRID_BTN_PRINT', 'fancybox_noRefresh'),
      FGrid::getPrintButton('Yii::app()->controller->createUrl("frontend/" . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . "/report/formArticleExport", array("nIdForm"=>$data->primaryKey, "sFormat"=>FFile::FILE_XLS_TYPE))'),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateArticle", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailArticle", array("nIdForm"=>$data->primaryKey))', 'true', true, false, 'search_magnifying_glass_1.png', 'fancybox_allowNavigation_noRefresh'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteArticle", array("nIdForm"=>$data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>