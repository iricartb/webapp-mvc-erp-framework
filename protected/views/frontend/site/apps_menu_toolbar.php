<div class="dropdown-menu">
   <ul id="apps-menu" class="menu">
      <li><a href="#">
            <div class="app-menu-item-image">
               <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . 'site/apps_menu_startup.png';?>" />
            </div>
            <div class="app-menu-item-text">
               <b><?php echo Yii::t('frontend', 'APPS_MENU_ITEM_APPLICATION'); ?></b>
            </div>
         </a>
         <ul>
            <?php
               $i = 1;
               $oListUserPrivileges = new ListUserPrivileges(Yii::app()->user->id);
               foreach ($oListUserPrivileges->getModulesPrivileges() as $oModulePrivileges) { ?>
                  <li class="app-menu-item">
                     <a class="header" href="<?php echo $this->createUrl('frontend/site/setCurrentApplication', array('sAppName'=>$oModulePrivileges->getName())); ?>">
                        <div class="header-image">
                           <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . 'site/' . $oModulePrivileges->getImage(); ?>" />
                        </div>
                        <div class="header-text">
                           <?php echo Yii::t('system', $oModulePrivileges->getTextKeyHeader()); ?>
                        </div>
                     </a>
                     <ul>
                        <li class="description"><?php echo Yii::t('system', $oModulePrivileges->getTextKeyDescription()); ?></li>
                     </ul>
                  </li>  
                  <?php
                  if ($i == count($oListUserPrivileges->getModulesPrivileges())) {
                     ?>
                     <div style="height:20px;"></div>
                     <?php      
                  }
                  
                  $i++;
               }
            ?>
         </ul>
      </li>
      <li style="float:right">
         <a href="index.php?r=frontend/site/logout">
            <div class="app-menu-item-image">
               <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_FRONTEND . 'site/apps_menu_shutdown.png';?>" />
            </div> 
            <div class="app-menu-item-text">
               <?php echo Yii::t('frontend', 'APPS_MENU_ITEM_LOGOUT'); ?>
            </div>
         </a>
      </li>
   </ul>
</div>