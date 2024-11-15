<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/articles_locations_categories.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_WAREHOUSE_MANAGEMENT_HEADER_LINE_ARTICLES_LOCATIONS_CATEGORIES')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWARTICLESLOCATIONSCATEGORIES_DESCRIPTION'); ?>
</div>

<div class="form">
   <?php $formArticleLocationCategory = $this->beginWidget('CActiveForm', array(
      'id'=>'warehouse-article-location-category-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewArticlesLocationsCategories'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
        
   <div class="form_expand_collapse" >
      <div id="id_form_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_content_expand_collapse');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWARTICLESLOCATIONSCATEGORIES_FORM_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWARTICLESLOCATIONSCATEGORIES_FORM_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="last_cell">
               <?php echo $formArticleLocationCategory->labelEx($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formArticleLocationCategory->textField($oModelForm, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formArticleLocationCategory->error($oModelForm, 'name', array('style'=>'width:300px;')); ?>
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
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWARTICLESLOCATIONSCATEGORIES_FORM_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('warehouseArticlesLocationsCategories', FApplication::MODULE_WAREHOUSE_MANAGEMENT, 'WarehouseArticlesLocationsCategories', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
   </div>
</div>
                                                                                                                          
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormFilters->search(),
   'filter'=>$oModelFormFilters,
   'columns'=>array(
      array(
         'name'=>'name',
         'htmlOptions'=>array('width'=>710),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateArticleLocationCategory", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailArticleLocationCategory", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteArticleLocationCategory", array("nIdForm"=>$data->primaryKey))', '(FModuleWarehouseManagement::allowDeleteWarehouseArticleLocationCategory($data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 30px 0px;'),
));
?>

<div class="form">
   <?php $formArticleLocationSubcategory = $this->beginWidget('CActiveForm', array(
      'id'=>'warehouse-article-location-subcategory-form',
      'action'=>$this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewArticlesLocationsCategories'),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
      'clientOptions'=>array(
         'validateOnSubmit'=>true,
      ),
   )); ?>
        
   <div class="form_expand_collapse" >
      <div id="id_form_association_expand_collapse_image" class="form_expand_collapse_image" onclick="expandCollapseChangeBgImage('#id_form_association_expand_collapse_image'); jquerySimpleAnimationExpandCollapse('#id_form_association_content_expand_collapse');" >
      </div>
      <div class="form_expand_collapse_text">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWARTICLESLOCATIONSCATEGORIES_FORM_ASSOCIATION_NEW_BTN_DESCRIPTION'); ?>
      </div>   
   </div>
    
   <div id="id_form_association_content_expand_collapse" class="form_content_expand_collapse">
      <div class="form_header">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWARTICLESLOCATIONSCATEGORIES_FORM_ASSOCIATION_NEW_DESCRIPTION'); ?>
      </div>
      <div class="form_content">
         <div class="first_row">
            <div class="cell">
               <?php echo $formArticleLocationSubcategory->labelEx($oModelFormAssociation, 'id_location_category', array('style'=>'width:300px;')); ?>
               <?php echo $formArticleLocationSubcategory->dropDownList($oModelFormAssociation, 'id_location_category', CHtml::listData(WarehouseArticlesLocationsCategories::getWarehouseArticlesLocationsCategories(), 'id', 'name'), array('empty'=>Yii::t('system', 'SYS_FORM_COMBOBOX_SELECTION_ELEMENT'), 'style'=>'width:300px;')); ?>
               <?php echo $formArticleLocationSubcategory->error($oModelFormAssociation, 'id_location_category', array('style'=>'width:300px;')); ?>   
            </div>
            <div class="last_cell">
               <?php echo $formArticleLocationSubcategory->labelEx($oModelFormAssociation, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formArticleLocationSubcategory->textField($oModelFormAssociation, 'name', array('style'=>'width:300px;')); ?>
               <?php echo $formArticleLocationSubcategory->error($oModelFormAssociation, 'name', array('style'=>'width:300px;')); ?>
            </div>
         </div>
         <div class="row">
            <div class="last_cell">
               <?php echo $formArticleLocationSubcategory->labelEx($oModelFormAssociation, 'description', array('style'=>'width:300px;')); ?>
               <?php echo $formArticleLocationSubcategory->textField($oModelFormAssociation, 'description', array('style'=>'width:300px;')); ?>
               <?php echo $formArticleLocationSubcategory->error($oModelFormAssociation, 'description', array('style'=>'width:300px;')); ?>
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
   <div class="toolbox_table_cell_description">      
      <div class="item-description-italic">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWARTICLESLOCATIONSCATEGORIES_FORM_ASSOCIATION_GRID_DESCRIPTION'); ?>
      </div>
   </div>
   <div class="toolbox_table_cell_button">      
      <?php echo FWidget::showToolboxExporterData('warehouseArticlesLocationsSubcategories', FApplication::MODULE_WAREHOUSE_MANAGEMENT, 'WarehouseArticlesLocationsSubcategories', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, true); ?>
   </div>
</div>
                                                                                                                          
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView_2',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelFormAssociationFilters->search(),
   'filter'=>$oModelFormAssociationFilters,
   'columns'=>array(
      array(
         'name'=>'id_location_category',
         'value'=>'WarehouseArticlesLocationsCategories::getWarehouseArticleLocationCategoryName($data->id_location_category)',
         'filter'=>CHtml::listData(WarehouseArticlesLocationsCategories::getWarehouseArticlesLocationsCategories(), 'id', 'name'),
         'htmlOptions'=>array('width'=>250),
      ),
      array(
         'name'=>'name',
         'htmlOptions'=>array('width'=>310),
      ),
      array(
         'name'=>'description',
         'htmlOptions'=>array('width'=>400),
      ),
      FGrid::getEditButton('Yii::app()->controller->createUrl("updateArticleLocationSubcategory", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDetailButton('Yii::app()->controller->createUrl("viewDetailArticleLocationSubcategory", array("nIdForm"=>$data->primaryKey))'),
      FGrid::getDeleteButton('Yii::app()->controller->createUrl("deleteArticleLocationSubcategory", array("nIdForm"=>$data->primaryKey))', '(FModuleWarehouseManagement::allowDeleteWarehouseArticleLocationSubcategory($data->primaryKey))'),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>