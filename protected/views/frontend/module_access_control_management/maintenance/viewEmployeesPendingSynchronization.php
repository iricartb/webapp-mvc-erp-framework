<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '/employees.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEESPENDINGSYNCHRONIZATION_TITLE')); ?>
   </div>
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEESPENDINGSYNCHRONIZATION_DESCRIPTION'); ?>
</div>

<?php 
$oAccessControlModuleParameters = AccessControlModuleParameters::getAccessControlModuleParameters();

if ((!is_null($oAccessControlModuleParameters)) && ($oAccessControlModuleParameters->block_synchronization) && (count(AccessControlEmployees::getAccessControlEmployeesByPendingSynchronization(true)) > 0)) { ?>
   <div style="margin-bottom:10px;"> 
      <?php 
      $sAction = 'if (confirm(\'' . Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEESPENDINGSYNCHRONIZATION_FORM_SUBMIT_SYNCHRONIZE_CONFIRMATION') . '\')) { window.location = \'' . Yii::app()->controller->createUrl('updateEmployeesPendingSynchronization') . '\';'; 
      if (Yii::app()->params['paramShowLoading']) {
         $sAction .= 'ajShowLoading(true);';   
      }
      $sAction .= '}';
      ?>      
      <?php echo FWidget::showIconImageButton('employeesPendingSynchronization', 'refresh_arrow_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'PAGE_VIEWEMPLOYEESPENDINGSYNCHRONIZATION_REFRESH_BTN_DESCRIPTION', array('{1}'=>count(AccessControlEmployees::getAccessControlEmployeesByPendingSynchronization(true)))), $sAction); ?>                                         
   </div>
<?php 
} ?>
                                                                                                
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
   'id'=>'id_CGridView',
   'template'=>'{items} {pager}',
   'ajaxUpdate'=>false,
   'emptyText'=>Yii::t('system', 'SYS_GRID_EMPTY_RECORDS'),
   'pager'=>FGrid::getNavigationButtons(),
   'dataProvider'=>$oModelForm->search(FString::STRING_EMPTY, true),
   'rowCssClassExpression'=>'(!$data->pending_synchronize) ? (($data->active) ? ((!is_null($data->id_biostar)) ? \'completed\' : \'no_completed\') : \'finalized\') : \'pending\'',
   'columns'=>array(
      array(
         'name'=>'full_name',
         'htmlOptions'=>array('width'=>320),
      ),
      array(
         'name'=>'identification',
         'htmlOptions'=>array('width'=>130),
      ),
      array(
         'name'=>'id_business',
         'value'=>'Businesses::getBusinessName($data->id_business)',
         'htmlOptions'=>array('width'=>350),
      ),
      array(
         'name'=>'id_group_device',
         'value'=>'AccessControlGroupsDevices::getAccessControlGroupDeviceName($data->id_group_device)',
         'htmlOptions'=>array('width'=>160),
      ),
      array(
         'name'=>'pending_synchronize_action',
         'htmlOptions'=>array('width'=>140),
      ),
   ),
   'htmlOptions'=>array('style'=>'padding: 0px 0px 0px 0px;'),
));
?>

<?php 
if ((Yii::app()->user->hasFlash('success')) || (Yii::app()->user->hasFlash('error'))) { ?>
   <?php if (Yii::app()->user->hasFlash('success')) { ?>
      <div class="flash-success">
         <?php echo Yii::app()->user->getFlash('success'); ?>
      </div> 
   <?php } 
         
         if (Yii::app()->user->hasFlash('notice')) { ?>
      <div class="flash-notice">
         <?php echo Yii::app()->user->getFlash('notice'); ?>
      </div>   
   <?php } 
   
         if (Yii::app()->user->hasFlash('error')) { ?>
      <div class="flash-error">
         <?php echo Yii::app()->user->getFlash('error'); ?>
      </div>
   <?php }
} ?>