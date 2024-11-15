<?php
$oMaintenanceModuleParameters = MaintenanceModuleParameters::getMaintenanceModuleParameters();
?>

<style type="text/css">
.opentip-container {  
   max-width: 400px;    
   min-width: 200px;
}
</style>
        
<script type="text/javascript">
function create_form_working_part(nIdZone, nIdRegion, nIdEquipment) {
   <?php 
   if (!$bReadOnly) { ?> 
      window.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/createFormWorkingPart'); ?>' + '&nIdZone=' + nIdZone + '&nIdRegion=' + nIdRegion + '&nIdEquipment=' + nIdEquipment;
   <?php 
   } else { ?>
      parent.window.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/createFormWorkingPart'); ?>' + '&nIdZone=' + nIdZone + '&nIdRegion=' + nIdRegion + '&nIdEquipment=' + nIdEquipment;
      parent.$.fancybox.close();
   <?php
   }
   ?>
}  

function create_form_maintenance_working_part(nIdZone, nIdRegion, nIdEquipment) {
   <?php 
   if (!$bReadOnly) { ?> 
      window.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/createFormMaintenanceWorkingPart'); ?>' + '&nIdZone=' + nIdZone + '&nIdRegion=' + nIdRegion + '&nIdEquipment=' + nIdEquipment;
   <?php 
   } else { ?>
      parent.window.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/createFormMaintenanceWorkingPart'); ?>' + '&nIdZone=' + nIdZone + '&nIdRegion=' + nIdRegion + '&nIdEquipment=' + nIdEquipment;
      parent.$.fancybox.close();
   <?php
   }
   ?>
} 

function create_form_special_working_part() {
   <?php 
   if (!$bReadOnly) { ?> 
      window.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/createFormSpecialWorkingPart'); ?>';
   <?php 
   } else { ?>
      parent.window.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT) . '/main/createFormSpecialWorkingPart'); ?>';
      parent.$.fancybox.close();
   <?php
   }
   ?>
}

function create_scheduled_task(nIdZone, nIdRegion, nIdEquipment) {
   <?php 
   if (!$bReadOnly) { ?> 
      window.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewScheduledTasks'); ?>' + '&nIdZone=' + nIdZone + '&nIdRegion=' + nIdRegion + '&nIdEquipment=' + nIdEquipment;
   <?php 
   } else { ?>
      parent.window.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewScheduledTasks'); ?>' + '&nIdZone=' + nIdZone + '&nIdRegion=' + nIdRegion + '&nIdEquipment=' + nIdEquipment;
      parent.$.fancybox.close();
   <?php
   }
   ?>
}   

function create_form_task(nIdZone, nIdRegion, nIdEquipment) {
   <?php 
   if (!$bReadOnly) { ?> 
      window.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/createFormTask'); ?>' + '&nIdZone=' + nIdZone + '&nIdRegion=' + nIdRegion + '&nIdEquipment=' + nIdEquipment;
   <?php 
   } else { ?>
      parent.window.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/main/createFormTask'); ?>' + '&nIdZone=' + nIdZone + '&nIdRegion=' + nIdRegion + '&nIdEquipment=' + nIdEquipment;
      parent.$.fancybox.close();
   <?php
   }
   ?>
}

function view_attachment_equipment(nIdEquipment) {
   window.location = '<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewAttachmentEquipment'); ?>' + '&nIdForm=' + nIdEquipment;   
}                                                                                                                                            
</script>

<?php if ($bReadOnly) { $nReadOnly = 1; }
      else $nReadOnly = 0; ?>
   
<script type="text/javascript">
var oOpenTips = [];

function refreshPage(sIdZone, sIdRegion) {
   oOpenTips = [];
   $('.opentip-container').hide();
   
   if ((sIdZone === undefined) || (sIdZone === null)) sIdZone = '';
   if ((sIdRegion === undefined) || (sIdRegion === null)) sIdRegion = '';
   
   aj('<?php echo $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/manage/viewBuildScene&bReadOnly=' . $nReadOnly . '&nIdZone='); ?>' + sIdZone + '&nIdRegion=' + sIdRegion, null, 'document', null, null, null);
}

$(document).ready(function() { 
   var oItemCurrentDrag = null;

   <?php 
   if ($bReadOnly) { ?> 
      var nScreenHeight = screen.height;

      nScreenHeight = (nScreenHeight * 95) / 100;
      nScreenHeight = nScreenHeight - 195;
      $('.scene_map').css('height', nScreenHeight + 'px');
      
      var nScreenWidth = screen.width;
   
      nScreenWidth = (nScreenWidth * 95) / 100;
      nScreenWidth = nScreenWidth - 68;
      $('.scene_map').css('width', nScreenWidth + 'px');
   <?php
   } ?>
   
   var sSceneWidth = $('.scene_map').css('width');
   var sSceneHeight = $('.scene_map').css('height'); 
   var nSceneWidth = parseInt(sSceneWidth.replace('px', ''));
   var nSceneHeight = parseInt(sSceneHeight.replace('px', ''));
   
   var nItemRatioWidth = 0;
   var nItemRatioHeight = 0;
   var sItemImageWidth = null;
   var sItemImageHeight = null;
   var nItemImageWidth = 0;
   var nItemImageHeight = 0;
   var nItemRatioWidth = 0;
   var nItemRatioHeight = 0;
   var nItemPerCoordX = 0;
   var nItemPerCoordY = 0;
   
   <?php 
   if ($bReadOnly) { ?>
      $('.scene_item').each(function() {
         var nScreenWidthPercent = (nSceneWidth * 100) / <?php echo FModulePlantMaintenanceManagement::SCENE_WIDTH; ?>;
         var nScreenHeightPercent = (nSceneHeight * 100) / <?php echo FModulePlantMaintenanceManagement::SCENE_HEIGHT; ?>;
                        
         var sSceneItemWidth = $(this).css('width');
         var nSceneItemWidth = parseInt(sSceneItemWidth.replace('px', ''));
         
         var sSceneItemHeight = $(this).css('height');
         var nSceneItemHeight = parseInt(sSceneItemHeight.replace('px', ''));
         
         $(this).children().css('width', ((nSceneItemWidth * nScreenWidthPercent) / 100) + 'px');
         $(this).children().css('height', ((nSceneItemHeight * nScreenHeightPercent) / 100) + 'px');  
      });
   <?php
   } ?>
   
   <?php 
   if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (FString::isNullOrEmpty($nModelFormIdRegion))) {
      $oModelForm = ZonesRegions::getZonesRegionsByIdZone($nModelFormIdZone);
   }
   else if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (!FString::isNullOrEmpty($nModelFormIdRegion))) {
      $oModelForm = RegionsEquipments::getRegionsEquipmentsByIdRegion($nModelFormIdRegion);
   }
    
   foreach($oModelForm as $oElement) {
      if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (FString::isNullOrEmpty($nModelFormIdRegion))) {
         $oElement = Regions::getRegion($oElement->id_region);
      }
      else if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (!FString::isNullOrEmpty($nModelFormIdRegion))) {
         $oElement = Equipments::getEquipment($oElement->id_equipment);
      }
   
      if (!is_null($oElement)) { ?>
         sItemImageWidth = $('#scene_item_<?php echo $oElement->id;?>').css('width'); 
         sItemImageHeight = $('#scene_item_<?php echo $oElement->id;?>').css('height');

         if ((sItemImageWidth != null) && (sItemImageWidth != undefined) && (sItemImageHeight != null) && (sItemImageHeight != undefined) && (sSceneWidth != null) && (sSceneWidth != undefined) && (sSceneHeight != null) && (sSceneHeight != undefined)) {
            nItemImageWidth = parseInt(sItemImageWidth.replace('px', ''));
            nItemImageHeight = parseInt(sItemImageHeight.replace('px', ''));

            nItemRatioWidth = nItemImageWidth / (nSceneWidth - nItemImageWidth);
            nItemRatioHeight = nItemImageHeight / (nSceneHeight - nItemImageHeight);
            
            nItemPerCoordX = ((<?php echo $oElement->scene_coord_x;?> * nSceneWidth) / 100) - (nItemRatioWidth * ((<?php echo $oElement->scene_coord_x;?> * (nSceneWidth - nItemImageWidth)) / 100));
            nItemPerCoordY = ((<?php echo $oElement->scene_coord_y;?> * nSceneHeight) / 100) - (nItemRatioHeight * ((<?php echo $oElement->scene_coord_y;?> * (nSceneHeight - nItemImageHeight)) / 100));
            
            $('#scene_item_<?php echo $oElement->id;?>').css('left', nItemPerCoordX);
            $('#scene_item_<?php echo $oElement->id;?>').css('top', nItemPerCoordY);
            
            <?php 
            $sOpenTipContent = FString::STRING_EMPTY;
            
            if ((FString::isNullOrEmpty($nModelFormIdZone)) && (FString::isNullOrEmpty($nModelFormIdRegion))) { ?>
               var oOpenTip = new Opentip($('#scene_item_<?php echo $oElement->id;?>'), { tipJoint: 'bottom left', background: 'white', borderColor: '#ccc' });
               oOpenTip.hide();
               oOpenTips.push(['scene_item_<?php echo $oElement->id;?>', oOpenTip]);
            <?php
               $sOpenTipContent = "<div style=\"display:table\">";
               
               if ((!FString::isNullOrEmpty($oElement->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_ZONES . $oElement->image))) {
                  $sOpenTipContent .= "<div class=\"rectangle_content\">";
                  $sOpenTipContent .= "<img src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_ZONES . $oElement->image . "\" width=\"125px\" height=\"94px\" />";
                  $sOpenTipContent .= "</div>";
                  
                  $sOpenTipContent .= "<div class=\"last_cell\" style=\"font-size:11px; vertical-align:top; padding-left:10px; width:100%;\">"; 
               }
               else $sOpenTipContent .= "<div class=\"last_cell\" style=\"font-size:11px; vertical-align:top; width:100%;\">";
               
               $sOpenTipContent .= "<div class=\"first_row\">";
               $sOpenTipContent .= "<b>" . $oElement->name . "</b>";
               $sOpenTipContent .= "</div>";
               
               if (!FString::isNullOrEmpty($oElement->area)) {
                  $sOpenTipContent .= "<div class=\"first_row\">";
                  $sOpenTipContent .= "<b>" . Yii::t('rainbow', 'MODEL_ZONES_FIELD_AREA') . ": </b>" . $oElement->area . FString::STRING_SPACE . Yii::t('system', 'SYS_SQUARE_METER');
                  $sOpenTipContent .= "</div>";
               }
               
               if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) {
                  $oFormsWorkingParts = FormsWorkingParts::getFormsWorkingParts(true);               
                  if (count($oFormsWorkingParts) > 0) {
                     $oFormsWorkingPartsZone = FormsWorkingParts::getFormsWorkingParts(true, null, $oElement->id);
                     
                     $sOpenTipContent .= "<div class=\"first_row\">";
                     $sOpenTipContent .= "<b>" . Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWBUILDSCENE_SCENE_NUM_FORMS_WORKING_PARTS') . ": <font class=\"font_color_darkgreen\">" . count($oFormsWorkingPartsZone) . "</font>/<font class=\"font_color_red\">" . count($oFormsWorkingParts) . "</font><font class=\"font_color_darkorange\">" . ' (' . round((count($oFormsWorkingPartsZone) * 100)/ count($oFormsWorkingParts), 2) . "%)</font></b>";
                     $sOpenTipContent .= "</div>";     
                  }
                  
                  $oFormsMaintenanceWorkingParts = FormsMaintenanceWorkingParts::getFormsMaintenanceWorkingParts(true);               
                  if (count($oFormsMaintenanceWorkingParts) > 0) {
                     $oFormsMaintenanceWorkingPartsZone = FormsMaintenanceWorkingParts::getFormsMaintenanceWorkingParts(true, null, $oElement->id);
                     
                     $sOpenTipContent .= "<div class=\"first_row\">";
                     $sOpenTipContent .= "<b>" . Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWBUILDSCENE_SCENE_NUM_FORMS_MAINTENANCE_WORKING_PARTS') . ": <font class=\"font_color_darkgreen\">" . count($oFormsMaintenanceWorkingPartsZone) . "</font>/<font class=\"font_color_red\">" . count($oFormsMaintenanceWorkingParts) . "</font><font class=\"font_color_darkorange\">" . ' (' . round((count($oFormsMaintenanceWorkingPartsZone) * 100)/ count($oFormsMaintenanceWorkingParts), 2) . "%)</font></b>";
                     $sOpenTipContent .= "</div>";     
                  }
               }
               
               $sOpenTipContent .= "</div>";
               $sOpenTipContent .= "</div>";
            } else if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (FString::isNullOrEmpty($nModelFormIdRegion))) { ?>
               var oOpenTip = new Opentip($('#scene_item_<?php echo $oElement->id;?>'), { tipJoint: 'bottom left', background: 'white', borderColor: '#ccc' });
               oOpenTip.hide();
               oOpenTips.push(['scene_item_<?php echo $oElement->id;?>', oOpenTip]);
            <?php
               $sOpenTipContent = "<div style=\"display:table\">";
               
               if ((!FString::isNullOrEmpty($oElement->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_REGIONS . $oElement->image))) {
                  $sOpenTipContent .= "<div class=\"rectangle_content\">";
                  $sOpenTipContent .= "<img src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_REGIONS . $oElement->image . "\" width=\"125px\" height=\"94px\" />";
                  $sOpenTipContent .= "</div>";
                  
                  $sOpenTipContent .= "<div class=\"last_cell\" style=\"font-size:11px; vertical-align:top; padding-left:10px; width:100%;\">"; 
               }
               else $sOpenTipContent .= "<div class=\"last_cell\" style=\"font-size:11px; vertical-align:top; width:100%;\">";
               
               $sOpenTipContent .= "<div class=\"first_row\">";
               $sOpenTipContent .= "<b>" . $oElement->name . "</b>";
               $sOpenTipContent .= "</div>";
               
               if (!FString::isNullOrEmpty($oElement->area)) {
                  $sOpenTipContent .= "<div class=\"first_row\">";
                  $sOpenTipContent .= "<b>" . Yii::t('rainbow', 'MODEL_REGIONS_FIELD_AREA') . ": </b>" . $oElement->area . FString::STRING_SPACE . Yii::t('system', 'SYS_SQUARE_METER');
                  $sOpenTipContent .= "</div>";
               }
               
               if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) {
                  $oFormsWorkingParts = FormsWorkingParts::getFormsWorkingParts(true);               
                  if (count($oFormsWorkingParts) > 0) {
                     $oFormsWorkingPartsZoneRegion = FormsWorkingParts::getFormsWorkingParts(true, null, $nModelFormIdZone, $oElement->id);
                     
                     $sOpenTipContent .= "<div class=\"first_row\">";
                     $sOpenTipContent .= "<b>" . Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWBUILDSCENE_SCENE_NUM_FORMS_WORKING_PARTS') . ": <font class=\"font_color_darkgreen\">" . count($oFormsWorkingPartsZoneRegion) . "</font>/<font class=\"font_color_red\">" . count($oFormsWorkingParts) . "</font><font class=\"font_color_darkorange\">" . ' (' . round((count($oFormsWorkingPartsZoneRegion) * 100)/ count($oFormsWorkingParts), 2) . "%)</font></b>";
                     $sOpenTipContent .= "</div>";     
                  }
                  
                  $oFormsMaintenanceWorkingParts = FormsMaintenanceWorkingParts::getFormsMaintenanceWorkingParts(true);               
                  if (count($oFormsMaintenanceWorkingParts) > 0) {
                     $oFormsMaintenanceWorkingPartsZoneRegion = FormsMaintenanceWorkingParts::getFormsMaintenanceWorkingParts(true, null, $nModelFormIdZone, $oElement->id);
                     
                     $sOpenTipContent .= "<div class=\"first_row\">";
                     $sOpenTipContent .= "<b>" . Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWBUILDSCENE_SCENE_NUM_FORMS_MAINTENANCE_WORKING_PARTS') . ": <font class=\"font_color_darkgreen\">" . count($oFormsMaintenanceWorkingPartsZoneRegion) . "</font>/<font class=\"font_color_red\">" . count($oFormsMaintenanceWorkingParts) . "</font><font class=\"font_color_darkorange\">" . ' (' . round((count($oFormsMaintenanceWorkingPartsZoneRegion) * 100)/ count($oFormsMaintenanceWorkingParts), 2) . "%)</font></b>";
                     $sOpenTipContent .= "</div>";     
                  }
               }
               
               $sOpenTipContent .= "</div>";
               $sOpenTipContent .= "</div>";
            } else if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (!FString::isNullOrEmpty($nModelFormIdRegion))) { ?>
               var oOpenTip = new Opentip($('#scene_item_<?php echo $oElement->id;?>'), { tipJoint: 'bottom left', background: 'white', borderColor: '#ccc', fixed: 'true', hideTrigger: 'closeButton' });  
               oOpenTip.hide();
               oOpenTips.push(['scene_item_<?php echo $oElement->id;?>', oOpenTip]);
            <?php
               $sOpenTipContent = "<div style=\"display:table\">";
               
               if ((!FString::isNullOrEmpty($oElement->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_EQUIPMENTS . $oElement->image))) {
                  $sOpenTipContent .= "<div class=\"rectangle_content\">";
                  $sOpenTipContent .= "<img src=\"" . FApplication::FOLDER_IMAGES_APPLICATION_EQUIPMENTS . $oElement->image . "\" width=\"125px\" height=\"94px\" />";
                  $sOpenTipContent .= "</div>"; 
                  
                  $sOpenTipContent .= "<div class=\"last_cell\" style=\"font-size:11px; vertical-align:top; padding-left:10px; width:100%;\">";
               }
               else $sOpenTipContent .= "<div class=\"last_cell\" style=\"font-size:11px; vertical-align:top; width:100%;\">";
               
               $sOpenTipContent .= "<div class=\"first_row\">";
               $sOpenTipContent .= "<b>" . $oElement->name . "</b>";
               if (!FString::isNullOrEmpty($oElement->attachment)) {
                  $sOpenTipContent .= "<img src=\"" . FApplication::FOLDER_IMAGES_GENERIC_16x16 . "attachment_clip_3.png\" style=\"padding-left:4px; cursor:pointer\" onclick=\"view_attachment_equipment(" . $oElement->id . ");\">";
               }
               
               $sOpenTipContent .= "</div>";
               
               if (!FString::isNullOrEmpty($oElement->tag)) {
                  $sOpenTipContent .= "<div class=\"first_row\">";
                  $sOpenTipContent .= "<b>" . Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_TAG') . ": </b>" . $oElement->tag;
                  $sOpenTipContent .= "</div>";
               }
               
               if (!FString::isNullOrEmpty($oElement->manufacturer)) {
                  $sOpenTipContent .= "<div class=\"first_row\">";
                  $sOpenTipContent .= "<b>" . Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_MANUFACTURER') . ": </b>" . $oElement->manufacturer;
                  $sOpenTipContent .= "</div>";
               }
               
               if ((!FString::isNullOrEmpty($oElement->dimension_x)) && (!FString::isNullOrEmpty($oElement->dimension_y)) && (!FString::isNullOrEmpty($oElement->dimension_z))) {
                  $sOpenTipContent .= "<div class=\"first_row\">";
                  $sOpenTipContent .= "<b>" . Yii::t('rainbow', 'MODEL_EQUIPMENTS_FIELD_DIMENSIONS') . ": </b>" . $oElement->dimension_x . ' * ' . $oElement->dimension_y . ' * ' . $oElement->dimension_z . FString::STRING_SPACE . Yii::t('system', 'SYS_METER');
                  $sOpenTipContent .= "</div>";
               }
      
               if (Modules::getIsAvaliableModuleByName(FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) {
                  $oFormsWorkingParts = FormsWorkingParts::getFormsWorkingParts(true);               
                  if (count($oFormsWorkingParts) > 0) {
                     $oFormsWorkingPartsZoneRegionEquipment = FormsWorkingParts::getFormsWorkingParts(true, null, $nModelFormIdZone, $nModelFormIdRegion, $oElement->id);
                     
                     $sOpenTipContent .= "<div class=\"first_row\">";
                     $sOpenTipContent .= "<b>" . Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWBUILDSCENE_SCENE_NUM_FORMS_WORKING_PARTS') . ": <font class=\"font_color_darkgreen\">" . count($oFormsWorkingPartsZoneRegionEquipment) . "</font>/<font class=\"font_color_red\">" . count($oFormsWorkingParts) . "</font><font class=\"font_color_darkorange\">" . ' (' . round((count($oFormsWorkingPartsZoneRegionEquipment) * 100)/ count($oFormsWorkingParts), 2) . "%)</font></b>";
                     $sOpenTipContent .= "</div>";     
                  }
                  
                  $oFormsMaintenanceWorkingParts = FormsMaintenanceWorkingParts::getFormsMaintenanceWorkingParts(true);               
                  if (count($oFormsMaintenanceWorkingParts) > 0) {
                     $oFormsMaintenanceWorkingPartsZoneRegionEquipment = FormsMaintenanceWorkingParts::getFormsMaintenanceWorkingParts(true, null, $nModelFormIdZone, $nModelFormIdRegion, $oElement->id);
                     
                     $sOpenTipContent .= "<div class=\"first_row\">";
                     $sOpenTipContent .= "<b>" . Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWBUILDSCENE_SCENE_NUM_FORMS_MAINTENANCE_WORKING_PARTS') . ": <font class=\"font_color_darkgreen\">" . count($oFormsMaintenanceWorkingPartsZoneRegionEquipment) . "</font>/<font class=\"font_color_red\">" . count($oFormsMaintenanceWorkingParts) . "</font><font class=\"font_color_darkorange\">" . ' (' . round((count($oFormsMaintenanceWorkingPartsZoneRegionEquipment) * 100)/ count($oFormsMaintenanceWorkingParts), 2) . "%)</font></b>";
                     $sOpenTipContent .= "</div>";     
                  }
                  
                  $sOpenTipContent .= "</div></div>";
                  $sOpenTipContent .= "<div style=\"display:table; padding-top:9px\">";
                  
                  if ((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT))) {
                     $sOpenTipContent .= "<div style=\"row\">";
                     
                     if ((!FString::isNullOrEmpty($oElement->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_EQUIPMENTS . $oElement->image))) {
                        $sOpenTipContent .= "<div class=\"cell\" style=\"padding-right:4px\">";
                        $sOpenTipContent .= "</div>";
                     }
                     
                     $sOpenTipContent .= "<div class=\"cell\">";
                     $sOpenTipContent .= CHtml::submitButton(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWBUILDSCENE_SCENE_NEW_FORM_WORKING_PART'), array('class'=>'input_button_lightgray_no_radius_no_border icon_document_new_1 icon_position_left icon_label animation_background_lightgray font_size_10', 'style'=>'width:130px; text-align:left;', 'onclick'=>'create_form_working_part(' . $nModelFormIdZone . ',' . $nModelFormIdRegion . ',' . $oElement->id . ');'));
                     $sOpenTipContent .= "</div>";   
                     
                     $sOpenTipContent .= "<div class=\"last_cell\" style=\"padding-top:7px\">";
                     $sOpenTipContent .= CHtml::submitButton(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWBUILDSCENE_SCENE_NEW_FORM_MAINTENANCE_WORKING_PART'), array('class'=>'input_button_lightgray_no_radius_no_border icon_document_new_1 icon_position_left icon_label animation_background_lightgray font_size_10', 'style'=>'width:130px; text-align:left;', 'onclick'=>'create_form_maintenance_working_part(' . $nModelFormIdZone . ',' . $nModelFormIdRegion . ',' . $oElement->id . ');'));
                     $sOpenTipContent .= "</div>";
                     $sOpenTipContent .= "</div>"; 
                  }
                     
                  if ((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) && (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT))) { 
                     $sOpenTipContent .= "<div style=\"row\">";
                     
                     if ((!FString::isNullOrEmpty($oElement->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_EQUIPMENTS . $oElement->image))) {
                        $sOpenTipContent .= "<div class=\"cell\" style=\"padding-right:4px\">";
                        $sOpenTipContent .= "</div>";
                     }
                     
                     $sOpenTipContent .= "<div class=\"cell\" style=\"padding-top:7px\">";
                     $sOpenTipContent .= CHtml::submitButton(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWBUILDSCENE_SCENE_NEW_SCHEDULED_TASK'), array('class'=>'input_button_lightgray_no_radius_no_border icon_alarm_clock_1 icon_position_left icon_label animation_background_lightgray font_size_10', 'style'=>'width:130px; text-align:left;', 'onclick'=>'create_scheduled_task(' . $nModelFormIdZone . ',' . $nModelFormIdRegion . ',' . $oElement->id . ');'));
                     $sOpenTipContent .= "</div>";
                     
                     if ((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT))) {
                        $sOpenTipContent .= "<div class=\"last_cell\" style=\"padding-top:7px\">";
                        $sOpenTipContent .= CHtml::submitButton(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWBUILDSCENE_SCENE_NEW_MAINTENANCE_TASK'), array('class'=>'input_button_lightgray_no_radius_no_border icon_document_new_1 icon_position_left icon_label animation_background_lightgray font_size_10', 'style'=>'width:130px; text-align:left;', 'onclick'=>'create_form_task(' . $nModelFormIdZone . ',' . $nModelFormIdRegion . ',' . $oElement->id . ');'));
                        $sOpenTipContent .= "</div>";
                     }
                     
                     $sOpenTipContent .= "</div>";
                  }
                  else if ((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT))) {
                     $sOpenTipContent .= "<div style=\"row\">";
                     
                     if ((!FString::isNullOrEmpty($oElement->image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_EQUIPMENTS . $oElement->image))) {
                        $sOpenTipContent .= "<div class=\"cell\" style=\"padding-right:4px\">";
                        $sOpenTipContent .= "</div>";
                     }
                     
                     $sOpenTipContent .= "<div class=\"cell\" style=\"padding-top:7px\">";
                     $sOpenTipContent .= CHtml::submitButton(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWBUILDSCENE_SCENE_NEW_MAINTENANCE_TASK'), array('class'=>'input_button_lightgray_no_radius_no_border icon_document_new_1 icon_position_left icon_label animation_background_lightgray font_size_10', 'style'=>'width:130px; text-align:left;', 'onclick'=>'create_form_task(' . $nModelFormIdZone . ',' . $nModelFormIdRegion . ',' . $oElement->id . ');'));
                     $sOpenTipContent .= "</div>";
                     
                     $sOpenTipContent .= "</div>";
                  }
                     
                  $sOpenTipContent .= "</div>"; 
               }
               else $sOpenTipContent .= "</div></div>";
            }
            ?>
            
            oOpenTip.setContent('<?php echo $sOpenTipContent; ?>');
         }
         <?php
      }       
   } ?>

   <?php 
   if (!$bReadOnly) { ?> 
      $('.scene_item').draggable({  
         containment: 'parent',
         start: function(oEvent, oUi) {
            oItemCurrentDrag = oEvent.target; 
            
            <?php 
            if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (!FString::isNullOrEmpty($nModelFormIdRegion))) { ?>
            var i;
            for(i = 0; i < oOpenTips.length; i++) {
               var oOpenTip = oOpenTips[i];
               if (oOpenTip[0] == this.id) {
                  oOpenTip[1].hide();          
               }
            }
            <?php
            } ?>  
         }
      });
         
      $('.scene_map').droppable({
         drop: function(oEvent, oUi) {
            var sImageWidth = $(oItemCurrentDrag).css('width'); 
            var sImageHeight = $(oItemCurrentDrag).css('height');

            if ((sImageWidth != null) && (sImageWidth != undefined) && (sImageHeight != null) && (sImageHeight != undefined) && (sSceneWidth != null) && (sSceneWidth != undefined) && (sSceneHeight != null) && (sSceneHeight != undefined)) {
               var nImageWidth = parseInt(sImageWidth.replace('px', ''));
               var nImageHeight = parseInt(sImageHeight.replace('px', ''));

               var nRatioWidth = nImageWidth / (nSceneWidth - nImageWidth);
               var nRatioHeight = nImageHeight / (nSceneHeight - nImageHeight);
               
               var nPosCoordX = (oUi.position.left * nRatioWidth) + oUi.position.left;
               var nPosCoordY = (oUi.position.top * nRatioHeight) + oUi.position.top;

               var nPerCoordX = (nPosCoordX * 100) / nSceneWidth;
               var nPerCoordY = (nPosCoordY * 100) / nSceneHeight;
               
               var sItemId = (oItemCurrentDrag.id).replace('scene_item_', '');
               <?php 
               if ((FString::isNullOrEmpty($nModelFormIdZone)) && (FString::isNullOrEmpty($nModelFormIdRegion))) { ?>
                  aj('<?php echo $this->createUrl('updateBuildSceneZone');?>' + '&nIdZone=' + sItemId + '&nCoordX=' + nPerCoordX + '&nCoordY=' + nPerCoordY, null, null, null, null, null, null, '<?php echo FAjax::TYPE_METHOD_CONTENT_REPLACE_NONE;?>'); 
               <?php   
               } 
               else if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (FString::isNullOrEmpty($nModelFormIdRegion))) { ?>
                  aj('<?php echo $this->createUrl('updateBuildSceneRegion');?>' + '&nIdRegion=' + sItemId + '&nCoordX=' + nPerCoordX + '&nCoordY=' + nPerCoordY, null, null, null, null, null, null, '<?php echo FAjax::TYPE_METHOD_CONTENT_REPLACE_NONE;?>');  
               <?php
               }
               else if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (!FString::isNullOrEmpty($nModelFormIdRegion))) { ?>
                  aj('<?php echo $this->createUrl('updateBuildSceneEquipment');?>' + '&nIdEquipment=' + sItemId + '&nCoordX=' + nPerCoordX + '&nCoordY=' + nPerCoordY, null, null, null, null, null, null, '<?php echo FAjax::TYPE_METHOD_CONTENT_REPLACE_NONE;?>'); 
               <?php
               } ?>
            }

            <?php 
            if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (!FString::isNullOrEmpty($nModelFormIdRegion))) { ?>
            var i;
            for(i = 0; i < oOpenTips.length; i++) {
               var oOpenTip = oOpenTips[i];
               if (oOpenTip[0] == oItemCurrentDrag.id) {
                  oOpenTip[1].show();          
               }
            }
            <?php
            } ?>
            
            oItemCurrentDrag = null;
         }
      });
   <?php 
   } ?>
   
   jqueryEventAnimationFadeOnMouseOverOut('.scene_item', '<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_OTHER_ELEMENTS; ?>', 0.2, 500, 1.0, 500, true, true, true, 1.0, 0);
});

function onMouseOverSceneItem(oElement, sName) {
   var i;
   for(i = 0; i < oOpenTips.length; i++) {
      var oOpenTip = oOpenTips[i];
      if (oOpenTip[0] != oElement.id) {
         oOpenTip[1].hide();          
      }
   }
   
   <?php 
   if (!$bReadOnly) { ?>
      $('.scene_item_label').remove(); 
   
      $('.scene_map').append('<div class="scene_item_label">' + sName + '</div>');  
      
      setSceneItemLabelAndOptionsPosition(oElement); 
   <?php
   } ?>  
}

function onMouseMoveSceneItem(oElement) {
   setSceneItemLabelAndOptionsPosition(oElement);   
}

function setSceneItemLabelAndOptionsPosition(oElement) {
   var sItemImageCoordX = $(oElement).css('left')
   var nItemImageCoordX = parseInt(sItemImageCoordX.replace('px', ''));
   var sItemImageCoordY = $(oElement).css('top')
   var nItemImageCoordY = parseInt(sItemImageCoordY.replace('px', ''));
   
   var sItemImageWidth = $(oElement).css('width')
   var nItemImageWidth = parseInt(sItemImageWidth.replace('px', ''));
   var sItemImageHeight = $(oElement).css('height')
   var nItemImageHeight = parseInt(sItemImageHeight.replace('px', ''));
   
   var sItemLabelWidth = $('.scene_item_label').css('width')
   var nItemLabelWidth = parseInt(sItemLabelWidth.replace('px', ''));
   var sItemLabelHeight = $('.scene_item_label').css('height')
   var nItemLabelHeight = parseInt(sItemLabelHeight.replace('px', ''));
   
   $('.scene_item_label').css('left', (nItemImageCoordX + (nItemImageWidth/2) - (nItemLabelWidth/2) - 6) + 'px');
   $('.scene_item_label').css('top', (nItemImageCoordY + nItemImageHeight + 6) + 'px');  
}

function onMouseOutSceneItem(oElement) {
   $('.scene_item_label').remove();   
}
</script>

<?php 
if (!$bReadOnly) { ?>           
   <div class="item-header">
      <div class="item-header-image">
         <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT) . '/build_scene.png' ?>" />
      </div>
      <div class="item-header-text">
         <?php echo FString::castStrToUpper(Yii::t('system', 'SYS_MODULE_PLANT_MAINTENANCE_MANAGEMENT_HEADER_LINE_BUILD_SCENE')); ?>
      </div>
   </div>

   <div class="item-header-description-padding">
      <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWBUILDSCENE_DESCRIPTION'); ?>
   </div>

   <div class="scene_legend_items">
      <?php 
      if ((FString::isNullOrEmpty($nModelFormIdZone)) && (FString::isNullOrEmpty($nModelFormIdRegion))) {
         foreach($oModelForm as $oZone) {
            ?>
            <div class="item"> 
            <?php
               echo FWidget::showDropzone($this, $oZone->id, 'DropzoneZones', FWidget::DROPZONE_TYPE_SINGLE_ITEM, FWidget::DROPZONE_FILE_TYPE_IMAGE, $oZone->id, $oZone->id, 'refreshPage()', 'refreshPage()', 'background-image:none;min-height:90px;', 'width:48px;height:48px;margin-left:0px;'); 
            ?>
               <div class="label">
                  <?php echo FString::getAbbreviationSentence($oZone->name, 30, 15, '.'); ?>
               </div>
            </div>
         <?php 
         }
      } 
      else if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (FString::isNullOrEmpty($nModelFormIdRegion))) {
         $oZoneRegions = ZonesRegions::getZonesRegionsByIdZone($nModelFormIdZone);
         foreach($oZoneRegions as $oZoneRegion) {
            $oRegion = Regions::getRegion($oZoneRegion->id_region);
            if (!is_null($oRegion)) {
               ?>
               <div class="item"> 
               <?php
                  echo FWidget::showDropzone($this, $oRegion->id, 'DropzoneRegions', FWidget::DROPZONE_TYPE_SINGLE_ITEM, FWidget::DROPZONE_FILE_TYPE_IMAGE, $oRegion->id, $oRegion->id, 'refreshPage(\'' . $nModelFormIdZone . '\')', 'refreshPage(\'' . $nModelFormIdZone . '\')', 'background-image:none;min-height:90px;', 'width:48px;height:48px;margin-left:0px;'); 
               ?>
                  <div class="label">
                     <?php echo FString::getAbbreviationSentence($oRegion->name, 30, 15, '.'); ?>
                  </div>
               </div>
               <?php
            }
         }
      }
      else if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (!FString::isNullOrEmpty($nModelFormIdRegion))) {
         $oRegionEquiments = RegionsEquipments::getRegionsEquipmentsByIdRegion($nModelFormIdRegion);
         foreach($oRegionEquiments as $oRegionEquiment) {
            $oEquipment = Equipments::getEquipment($oRegionEquiment->id_equipment);
            if (!is_null($oEquipment)) {
               ?>
               <div class="item"> 
               <?php
                  echo FWidget::showDropzone($this, $oEquipment->id, 'DropzoneEquipments', FWidget::DROPZONE_TYPE_SINGLE_ITEM, FWidget::DROPZONE_FILE_TYPE_IMAGE, $oEquipment->id, $oEquipment->id, 'refreshPage(\'' . $nModelFormIdZone . '\',\'' . $nModelFormIdRegion . '\')', 'refreshPage(\'' . $nModelFormIdZone . '\',\'' . $nModelFormIdRegion . '\')', 'background-image:none;min-height:90px;', 'width:48px;height:48px;margin-left:0px;'); 
               ?>
                  <div class="label">
                     <?php echo FString::getAbbreviationSentence($oEquipment->name, 30, 15, '.'); ?>
                  </div>
               </div>
               <?php
            }
         }
      } ?>
   </div>
<?php
} ?>

<div class="scene">
   <?php 
      $sCssSceneToolbox = FString::STRING_EMPTY;
      if ($bReadOnly) $sCssSceneToolbox = 'width:100%;'; 
   ?>
   
   <div class="scene_toolbox" style="<?php echo $sCssSceneToolbox; ?>">
      <div class="title">
         <?php  
         if ((FString::isNullOrEmpty($nModelFormIdZone)) && (FString::isNullOrEmpty($nModelFormIdRegion))) {
            echo '<font class="font_style_bold font_color_darkgray">' . FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWBUILDSCENE_SCENE_TITLE')) . '</font>';    
         } else {
            if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (FString::isNullOrEmpty($nModelFormIdRegion))) {
               $oZone = Zones::getZone($nModelFormIdZone);  
               if (!is_null($oZone)) echo '<font class="font_style_bold font_color_lightgray">' . FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWBUILDSCENE_SCENE_TITLE')) . ' > </font>' . '<font class="font_style_bold font_color_darkgray">' . FString::castStrToUpper($oZone->name) . '</font>';      
            }
            else if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (!FString::isNullOrEmpty($nModelFormIdRegion))) {
               $oZone = Zones::getZone($nModelFormIdZone); 
               $oRegion = Regions::getRegion($nModelFormIdRegion);  
               if ((!is_null($oZone)) && (!is_null($oRegion))) echo '<font class="font_style_bold font_color_lightgray">' . FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWBUILDSCENE_SCENE_TITLE')) . ' > </font>' . '<font class="font_style_bold font_color_lightgray">' . FString::castStrToUpper($oZone->name) . ' > </font>' . '<font class="font_style_bold font_color_darkgray">' . FString::castStrToUpper($oRegion->name) . '</font>';     
            }        
         } ?>  
      </div>
      <div class="options">
         <?php
         if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (FString::isNullOrEmpty($nModelFormIdRegion))) { ?>
         <div class="button">
            <?php echo FWidget::showIconImageButton('backArrowZones', 'back_arrow_1.png', Yii::t('system', 'SYS_BACK'), 'refreshPage()'); ?>
         </div>
         <?php 
         } 
         else if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (!FString::isNullOrEmpty($nModelFormIdRegion))) { ?>
         <div class="button">
            <?php echo FWidget::showIconImageButton('backArrowRegions', 'back_arrow_1.png', Yii::t('system', 'SYS_BACK'), 'refreshPage(\'' . $nModelFormIdZone . '\')'); ?>
         </div>
         <?php 
         } ?>
      </div>
      <div class="options_buttons">
         <?php
         if ((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT)) && (!Users::getIsModuleRestricedUser(Yii::app()->user->id, FApplication::MODULE_WORKING_PARTS_MANAGEMENT))) { ?>
         <div class="button">
            <?php echo FWidget::showIconImageButton('formSpecialWorkingPart', 'document_new_1.png', Yii::t('frontend_' . strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT), 'PAGE_VIEWBUILDSCENE_SCENE_NEW_FORM_SPECIAL_WORKING_PART'), 'create_form_special_working_part()'); ?>
         </div>
         <?php 
         } ?>
      </div>
   </div>
    
   <div class="scene_map">     
      <?php 
      if ((FString::isNullOrEmpty($nModelFormIdZone)) && (FString::isNullOrEmpty($nModelFormIdRegion))) {
         foreach($oModelForm as $oZone) {
            if ((!is_null($oZone->scene_image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'zones/' . $oZone->scene_image))) {
               if (!$bReadOnly) { ?> 
               <div id="scene_item_<?php echo $oZone->id;?>" class="scene_item" onmouseover="onMouseOverSceneItem(this, '<?php echo $oZone->name;?>')" onmousemove="onMouseMoveSceneItem(this);" onmouseout="onMouseOutSceneItem(this);" ondblclick="refreshPage('<?php echo $oZone->id;?>');" >
               <?php 
               } else { ?>
               <div id="scene_item_<?php echo $oZone->id;?>" class="scene_item" onmouseover="onMouseOverSceneItem(this, '<?php echo $oZone->name;?>')" onmousemove="onMouseMoveSceneItem(this);" onmouseout="onMouseOutSceneItem(this);" onclick="refreshPage('<?php echo $oZone->id;?>');" >
               <?php
               }
               ?>
                  <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'zones/' . $oZone->scene_image; ?>"/>  
               </div>  
               <?php
            }
         }
      } 
      else if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (FString::isNullOrEmpty($nModelFormIdRegion))) {
         $oZoneRegions = ZonesRegions::getZonesRegionsByIdZone($nModelFormIdZone); 
         foreach($oZoneRegions as $oZoneRegion) {
            $oRegion = Regions::getRegion($oZoneRegion->id_region);
            if (!is_null($oRegion)) {
               if ((!is_null($oRegion->scene_image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'regions/' . $oRegion->scene_image))) {
                  if (!$bReadOnly) { ?> 
                  <div id="scene_item_<?php echo $oRegion->id;?>" class="scene_item" onmouseover="onMouseOverSceneItem(this, '<?php echo $oRegion->name;?>')" onmousemove="onMouseMoveSceneItem(this);" onmouseout="onMouseOutSceneItem(this);" ondblclick="refreshPage('<?php echo $nModelFormIdZone;?>', '<?php echo $oRegion->id;?>');">
                  <?php 
                  } else { ?>
                  <div id="scene_item_<?php echo $oRegion->id;?>" class="scene_item" onmouseover="onMouseOverSceneItem(this, '<?php echo $oRegion->name;?>')" onmousemove="onMouseMoveSceneItem(this);" onmouseout="onMouseOutSceneItem(this);" onclick="refreshPage('<?php echo $nModelFormIdZone;?>', '<?php echo $oRegion->id;?>');">
                  <?php
                  }
                  ?>    
                     <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'regions/' . $oRegion->scene_image; ?>" />  
                  </div>  
                  <?php
               }
            }
         }
      }
      else if ((!FString::isNullOrEmpty($nModelFormIdZone)) && (!FString::isNullOrEmpty($nModelFormIdRegion))) {
         $oRegionEquiments = RegionsEquipments::getRegionsEquipmentsByIdRegion($nModelFormIdRegion); 
         foreach($oRegionEquiments as $oRegionEquiment) {
            $oEquipment = Equipments::getEquipment($oRegionEquiment->id_equipment);
            if (!is_null($oEquipment)) {
               if ((!is_null($oEquipment->scene_image)) && (file_exists(FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'equipments/' . $oEquipment->scene_image))) {
                  ?>
                  <div id="scene_item_<?php echo $oEquipment->id;?>" class="scene_item" onmouseover="onMouseOverSceneItem(this, '<?php echo $oEquipment->name;?>')" onmousemove="onMouseMoveSceneItem(this);">
                     <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_SCENE . 'equipments/' . $oEquipment->scene_image; ?>" />  
                  </div>  
                  <?php
               }
            }
         }
      }
      ?>
   </div>
</div>