<?php /* @var $this Controller */ ?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
   <head>
      <!-- ERROR LAYOUT -->
      <link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->request->baseUrl . '/' . FApplication::FOLDER_IMAGES_APPLICATION_BUSINESS . 'favicon.ico';?>">

      <!-- disable jquery include automation for Yii -->
      <?php Yii::app()->clientScript->scriptMap=array('jquery.js'=>false,'jquery.min.js'=>false,); ?>
         
	   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	   <meta name="language" content="en" />

      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/site/error.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/generic/fonts/font.css" />
       
	   <!-- blueprint CSS framework -->
	   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	   <!--[if lt IE 8]>
	    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	    <![endif]-->
	   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/jQuery/jquery.min.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/jQuery/jquery.animate-colors.min.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/jQuery/jquery.ajax.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/jQuery/jquery.animations.js"></script>
                
      <title><?php echo CHtml::encode($this->pageTitle); ?></title>
   </head>

   <body>
      <div id="document">
         <?php echo $content; ?> 
      </div>
   </body>
</html>