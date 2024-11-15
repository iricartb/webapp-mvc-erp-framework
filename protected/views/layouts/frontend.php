<?php /* @var $this Controller */ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
   <head>
      <!-- FRONTEND LAYOUT -->
      <link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->request->baseUrl . '/' . FApplication::FOLDER_IMAGES_APPLICATION_BUSINESS . 'favicon.ico';?>">

      <!-- disable jquery include automation for Yii -->
      <?php Yii::app()->clientScript->scriptMap=array('jquery.js'=>false,'jquery.min.js'=>false,); ?>
                                 
	   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	   <meta name="language" content="en" />
      
      <?php if (!is_null($this->sJsOnBeforeCss)) { ?><script type="text/javascript"><?php echo $this->sJsOnBeforeCss;?></script><?php } ?>
      
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/site.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/generic/forms/input.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/generic/forms/multiselect.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/generic/fonts/font.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/generic/animations/animation.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/generic/icons/icon.css" />
      
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/frontend/site/site.css" />     
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/frontend/site/apps_menu.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/frontend/site/page_header_items.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/frontend/site/page_footer_items.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/frontend/site/actions_menu.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/frontend/site/page_footer_events.css" />
      
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/components/nprogress/nprogress.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/components/opentip/opentip.css" />
      
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/widgets/Toolbox/css/toolbox.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/widgets/Dropzone/css/dropzone.css" />
      
	   <!-- blueprint CSS framework -->
	   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	   <!--[if lt IE 8]>
	    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	    <![endif]-->

	   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
         
      <?php
      if (strtolower(Users::getUserDefApplication(Yii::app()->user->id)) == strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT)) { ?>
         <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/frontend/<?php echo strtolower(Users::getUserDefApplication(Yii::app()->user->id)); ?>/scene.css" />      
      <?php 
      } else if (strtolower(Users::getUserDefApplication(Yii::app()->user->id)) == strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT)) { ?>
         <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/frontend/<?php echo strtolower(Users::getUserDefApplication(Yii::app()->user->id)); ?>/site.css" />      
      <?php
      }?>
      
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/jQuery/jquery.min.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/jQuery/jquery.animate-colors.min.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/jQuery/jquery.ajax.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/jQuery/jquery.animations.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/jQuery/jquery.ui.js"></script>

      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/generic/forms/forms.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/generic/forms/multiselect.min.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/sound/howler.js"></script>
      
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/components/nprogress/nprogress.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/components/tinymce/tiny_mce.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/components/opentip/opentip-jquery.js"></script>
      
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/widgets/Dropzone/javascript/dropzone.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/widgets/Toolbox/javascript/toolbox.js"></script>
      
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/frontend/site/jquery.dropdownmenu.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/frontend/site/jquery.hoverIntent.minified.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/frontend/site/jquery.tree.js"></script>
               
      <script type="text/javascript">
         tinyMCE.init({
            mode: "textareas",
            theme : "advanced",
            plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,spellchecker,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_path_location : "bottom",
            theme_advanced_buttons1 : "save,newdocument,print,|,cut,copy,paste,pastetext,pasteword,|,search,replace,|,undo,redo,|,removeformat,cleanup,|,spellchecker,|,visualaid,visualchars,|,ltr,rtl,|,code,preview,fullscreen,|,help",
            theme_advanced_buttons2 : "styleselect,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor,|,bold,italic,underline,strikethrough,|,sub,sup",
            theme_advanced_buttons3 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,hr,advhr,nonbreaking,pagebreak,blockquote,|,charmap,emotions,media,image,|,link,unlink,anchor,|,insertdate,inserttime",
            theme_advanced_buttons4 : "cite,abbr,acronym,|,tablecontrols,|,insertlayer,moveforward,movebackward,absolute,|,styleprops,del,ins,attribs,|,template",
            theme_advanced_statusbar_location : "bottom",
            theme_advanced_resize_horizontal : true,
            theme_advanced_resizing : true,
            editor_selector: "mceEditor",
            editor_deselector: "mceNoEditor"
         });
      </script>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
      <script type="text/javascript">$(document).ready(function($) { $('#apps-menu').dcDropDownMenu({ rowItems: '4', speed: 'fast' }); $('#tree').niceTree(); }); jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady('.app-menu-item', '<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_OTHER_ELEMENTS; ?>', 0.2, 1000, 1.0, 1000, true, true, true, 1.0, 0); jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady('.item-image-fade-round-border', '<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS; ?>', 1.0, 1000, 0.5, 1000, true, true, true, 0.5, 0); jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady('.item-image-fade-20-round-border', '<?php echo FAjax::TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS; ?>', 1.0, 1000, 0.2, 1000, true, true, true, 0.2, 0);</script>
      
      <?php 
      if (Yii::app()->params['paramEventsEnable']) { ?>
         <script type="text/javascript">
         var bLocked = false;
         var oSoundAlarm = new Howl({
            urls: ['sounds/rainbow/events/alarm.mp3']
         });

         $(document).ready(function($) { 
            setInterval(function() {          
               check_pending_events(false);
            }, <?php echo Yii::app()->params['paramEventsRequestDelayMinutes'];?> * 60 * 1000) 
            
            check_pending_events(false);
         });
         
         function check_pending_events(recursive) {
            var sJsAfterAction = '$("#id_page_footer_events").css("z-index", "9999");';
            var sJsAfterActionAlternative = '$("#id_page_footer_events").animate({opacity: 0.0, height: 0.0}, 500, function onCompleteHandler() { $("#id_page_footer_events").css("height", "70px"); $("#id_page_footer_events").css("z-index", "-1"); });'; 
            
            if (recursive) bLocked = true;
            else sJsAfterAction = sJsAfterAction + 'oSoundAlarm.play();';
            
            if ((recursive) || (!recursive) && (!bLocked)) {
               aj('<?php echo $this->createUrl('frontend/site/checkPendingEvents');?>', null, 'id_page_footer_events', null, null, sJsAfterAction + 'setTimeout(function(){check_pending_events(true)}, <?php echo Yii::app()->params['paramEventsOnScreenSeconds'];?> * 1000);', sJsAfterActionAlternative, '<?php echo FAjax::TYPE_METHOD_CONTENT_REPLACE;?>', '<?php echo FAjax::TYPE_METHOD_CONTENT_DECORATION_ROLL;?>', 500);      
            }
            else bLocked = false;
         }
         </script>
      <?php 
      } ?>
      
      <?php if (!is_null($this->sJsOnLoad)) { ?><script type="text/javascript">$(document).ready(function($) { <?php echo $this->sJsOnLoad;?> });</script><?php } ?>
                 
      <script type="text/javascript">
         function onEventAfterValidate(form, data, hasError) {
            if (!hasError) {
               <?php 
               if (Yii::app()->params['paramShowLoading']) { ?>
                  ajShowLoading(true);
               <?php
               } ?>
               return true;
            }
            
            return false;
         }
      </script>
                                                                                                                                                                 
      <title><?php echo CHtml::encode($this->pageTitle); ?></title>
   </head>

   <body>       
      <?php 
      $this->widget('EFancyBox', array(
         'target'=>'a[rel=fancybox]',
         'config'=>array(
            'type'=>'iframe', 
            'width'=>'80%',
            'height'=>'80%',
            'fitToView'=>true,
            'autoSize'=>false,
            'autoCenter'=>true,
            'arrows'=>false,
            'mouseWheel'=>false,
            'loop'=>false,
            'helpers'=>array('title'=>null),
            ),
         )
      );
      $this->widget('EFancyBox', array(
         'target'=>'a[rel=fancybox_minPopup]',
         'config'=>array(
            'type'=>'iframe', 
            'width'=>550,
            'height'=>300,
            'fitToView'=>true,
            'autoSize'=>false,
            'autoCenter'=>true,
            'arrows'=>false,
            'mouseWheel'=>false,
            'loop'=>false,
            'helpers'=>array('title'=>null),
            ),
         )
      );
      $this->widget('EFancyBox', array(
         'target'=>'a[rel=fancybox_maxPopup]',
         'config'=>array(
            'type'=>'iframe', 
            'width'=>'95%',
            'height'=>'95%',
            'fitToView'=>true,
            'autoSize'=>false,
            'autoCenter'=>true,
            'arrows'=>false,
            'mouseWheel'=>false,
            'loop'=>false,
            'helpers'=>array('title'=>null),
            ),
         )
      );
      $this->widget('EFancyBox', array(
         'target'=>'a[rel=fancybox_allowNavigation]',
         'config'=>array(
            'type'=>'iframe', 
            'width'=>'80%',
            'height'=>'80%',
            'fitToView'=>true,
            'autoSize'=>false,
            'autoCenter'=>true,
            'arrows'=>true,
            'mouseWheel'=>false,
            'loop'=>false,
            'helpers'=>array('title'=>null),
            'afterClose'=>'js:function() { refreshAllCGridViews(); }'
            ),
         )
      );
      $this->widget('EFancyBox', array(
         'target'=>'a[rel=fancybox_allowNavigation_noRefresh]',
         'config'=>array(
            'type'=>'iframe', 
            'width'=>'80%',
            'height'=>'80%',
            'fitToView'=>true,
            'autoSize'=>false,
            'autoCenter'=>true,
            'arrows'=>true,
            'mouseWheel'=>false,
            'loop'=>false,
            'helpers'=>array('title'=>null),
            ),
         )
      );
      $this->widget('EFancyBox', array(
         'target'=>'a[rel=fancybox_noRefresh]',
         'config'=>array(
            'type'=>'iframe', 
            'width'=>'80%',
            'height'=>'80%',
            'fitToView'=>true,
            'autoSize'=>false,
            'autoCenter'=>true,
            'arrows'=>false,
            'mouseWheel'=>false,
            'loop'=>false,
            'helpers'=>array('title'=>null),
            ),
         )
      );
      $this->widget('EFancyBox', array(
         'target'=>'a[rel=fancybox_refreshGridOnClose]',
         'config'=>array(
            'type'=>'iframe', 
            'width'=>'80%',
            'height'=>'80%',
            'fitToView'=>true,
            'autoSize'=>false,
            'autoCenter'=>true,
            'arrows'=>false,
            'mouseWheel'=>false,
            'loop'=>false,
            'helpers'=>array('title'=>null),
            'afterClose'=>'js:function() { refreshAllCGridViews(); }'
            ),
         )
      );
      $this->widget('EFancyBox', array(
         'target'=>'a[rel=fancybox_wizard]',
         'config'=>array(
            'type'=>'iframe', 
            'width'=>'725px',
            'height'=>'325px',
            'fitToView'=>true,
            'autoSize'=>false,
            'autoCenter'=>true,
            'arrows'=>false,
            'mouseWheel'=>false,
            'loop'=>false,
            'helpers'=>array('title'=>null),
            'afterClose'=>'js:function() { refreshAllCGridViews(); }'
            ),
         )
      );
      ?>
    
      <!--[if gte IE 9]>
      <script>
         $(document).ready(function(){
            NProgress.done();
         });
         NProgress.start();
      </script>
      <![endif]-->
      
      <!--[if !IE]><!-->
      <script>
         $(document).ready(function(){
            NProgress.done();
         });
         NProgress.start();
      </script>
      <!--<![endif]-->
      
      <div id="document">
         <div id="aj_loading">
            <div id="aj_loading_content">
               <p id="aj_loading_text"><?php echo Yii::t('frontend', 'LOADING');?></p>
            </div>
         </div>
         
         <?php include('protected/views/frontend/site/apps_menu_toolbar.php'); ?>
         <?php include('protected/views/frontend/site/page_header_items.php'); ?>
         <div class="container">
            <?php 
            $sCssPage = 'width:100%';
            if ($this->bShowSubgroupActions) { 
               $sCssPage = FString::STRING_EMPTY; ?>  
               <div id="actions">
                  <?php include('protected/views/frontend/site/actions_menu_toolbar.php'); ?>
               </div>
            <?php
            }
            ?>
            <div id="page" style="<?php echo $sCssPage; ?>">
               <div id="content">
                  <?php echo $content; ?>
               </div>
            </div>
         </div>
         <?php include('protected/views/frontend/site/page_footer_items.php'); ?>
         <?php include('protected/views/frontend/site/page_footer_events.php'); ?> 
      </div>
   </body>
</html>