<?php /* @var $this Controller */ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
   <head>
      <!-- POPUP LAYOUT -->
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
      
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/frontend/<?php echo strtolower(FApplication::MODULE_PLANT_MAINTENANCE_MANAGEMENT); ?>/scene.css" />      
      
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/jQuery/jquery.min.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/jQuery/jquery.animate-colors.min.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/jQuery/jquery.ajax.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/jQuery/jquery.animations.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/jQuery/jquery.ui.js"></script>
      
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/generic/forms/forms.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/generic/forms/multiselect.min.js"></script>

      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/components/tinymce/tiny_mce.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/components/opentip/opentip-jquery.js"></script>
      
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/widgets/Dropzone/javascript/dropzone.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/widgets/Toolbox/javascript/toolbox.js"></script>
      
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
      <div id="document">
         <div id="aj_loading">
            <div id="aj_loading_content">
               <p id="aj_loading_text"><?php echo Yii::t('frontend', 'LOADING');?></p>
            </div>
         </div>
         
         <div id="popup_page" class="container">
            <div id="content">
               <?php echo $content; ?>
            </div>
         </div>
      </div>
   </body>
</html>