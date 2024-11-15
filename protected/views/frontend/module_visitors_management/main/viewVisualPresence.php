<?php
$oAccessControlModuleParameters = AccessControlModuleParameters::getAccessControlModuleParameters();   

if ((is_null($oAccessControlModuleParameters)) || ((!is_null($oAccessControlModuleParameters)) && (!($oAccessControlModuleParameters->show_checkin_manual)))) { ?>
   <script type="text/javascript">
      setInterval(function() {
         aj('<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/main/refreshVisualPresence');?>', null, 'idVisualPresenceEmployees', null, null, null, null, '<?php echo FAjax::TYPE_METHOD_CONTENT_REPLACE;?>', '<?php echo FAjax::TYPE_METHOD_CONTENT_DECORATION_NONE;?>', 0, true, false, '<?php echo Yii::app()->params['paramShowLoading'];?>');   
      }, 300000);
   </script>
<?php
} ?>

<div class="item-header">
   <div class="item-header-image">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT) . '/visual_presence.png' ?>" />
   </div>
   <div class="item-header-text">
      <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_VISITORS_MANAGEMENT_HEADER_LINE_VISUAL_PRESENCE')); ?>
   </div>          
</div>

<div class="item-header-description-padding">
   <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'PAGE_VIEWVISUALPRESENCE_DESCRIPTION'); ?>
</div>

<div id="idVisualPresenceEmployees">
   <?php include('viewVisualPresenceEmployees.php'); ?>
</div>

<?php 
if ((Yii::app()->user->hasFlash('success')) || (Yii::app()->user->hasFlash('error'))) { 
    if (Yii::app()->user->hasFlash('success')) { 
       Yii::app()->user->getFlash('success'); 
    } else if (Yii::app()->user->hasFlash('notice')) { 
       Yii::app()->user->getFlash('notice');   
    } else {
       Yii::app()->user->getFlash('error'); 
    }
} ?>