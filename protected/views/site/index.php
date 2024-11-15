<?php $this->pageTitle = Yii::app()->name; ?>

<div id="div_server_info_left_arrow" class="right-angle-arrow right-angle-arrow-yellow"></div>
<div id="div_server_info">
   <div id="div_server_info_text">
      <?php echo php_uname('s') . FString::STRING_SPACE . php_uname('n') . FString::STRING_SPACE . php_uname('v'); ?>
   </div>
</div>
<div id="div_server_info_right_arrow" class="left-angle-arrow left-angle-arrow-yellow"></div>

<?php $formLogin=$this->beginWidget('CActiveForm', array(
    'id'=>'login-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
    'htmlOptions'=>array("name"=>"login"),
)); ?>
   
<?php 
   if (Application::getAppBusinessLogoImage() != null) { ?>
      <div id="div_login_container_header" style="text-align: center">
         <img src="<?php echo Application::getAppBusinessLogoImage();?>" height="70px"/>
      </div>
   <?php
   }
?>

<div id="div_login_container_body">
    <div id="div_login_container_body_box">
        <div id="div_login_container_body_box_elements">
            <div id="div_login_container_body_box_header">
                <div id="div_login_container_body_box_header_image">
                    <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_SITE;?>lock.png" />
                </div>
                <div id="div_login_container_body_box_header_title">
                    <H2><?php echo Yii::t('site', 'LOGIN_BOX_HEADER'); ?></H2>
                </div>
            </div>
                   
            <div id="div_login_container_body_box_description">
               <?php echo Yii::t('site', 'LOGIN_BOX_DESCRIPTION'); ?>
            </div>

            <div id="div_login_container_body_box_username">
                <div id="login-box-name">
                    <?php echo Yii::t('site', 'LOGIN_BOX_ITEM_USER'); ?>
                </div>
                <div id="login-box-field" class="input-item">
                    <?php echo $formLogin->textField($modelForm, 'sUsername', array('class'=>'form-login', 'maxlength'=>12)); ?>
                    <?php $formLogin->error($modelForm, 'sUsername'); ?>
                </div>
            </div>
            <div id="div_login_container_body_box_password">
                <div id="login-box-name">
                    <?php echo Yii::t('site', 'LOGIN_BOX_ITEM_PASSWD'); ?>
                </div>
                <div id="login-box-field" class="input-item">
                    <?php echo $formLogin->passwordField($modelForm, 'sPassword', array('class'=>'form-login', 'maxlength'=>12)); ?>
                    <?php $formLogin->error($modelForm, 'sPassword'); ?>
                </div>
            </div>
            
            <div id="div_login_container_body_box_options">
                <span class="login-box-options">
                    <?php echo $formLogin->checkBox($modelForm, 'bRememberMe'); ?>&nbsp<?php echo Yii::t('site', 'LOGIN_BOX_ITEM_REMEMBER'); ?>
                    <!-- <a href="#" style="margin-left:30px;"><?php echo Yii::t('site', 'LOGIN_BOX_ITEM_LOST_PASSWD'); ?></a> -->
                </span>
            </div>

            <div id="div_login_container_body_box_submit">
                <?php echo Chtml::imageButton(FApplication::FOLDER_IMAGES_APPLICATION_SITE . 'login_btn.png', array('id'=>'button_submit')); ?>
            </div>
            
            <div id="div_login_container_body_box_err">
                <?php echo $formLogin->error($modelForm, 'sErrMessage'); ?>
            </div>                                             
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<div id="div_login_container_footer">
    <div id="div_login_container_footer_items">
        <div class="footer-item">
            &copy <?php echo Yii::app()->params['companyName']; ?>
        </div>
        <div class="footer-separator">
            |
        </div>
        <div class="footer-item">
           <?php echo Yii::app()->params['companyPhone']; ?>     
        </div>
        <div class="footer-separator">
            |
        </div>
        <div class="footer-item">
            <?php echo Yii::app()->params['companyMail']; ?>  
        </div>
    </div> 
</div>

<?php if (Application::showBrowsersLogin()) { ?>
   <div id="div_login_container_footer_banner">
      <img src="<?php echo FApplication::FOLDER_IMAGES_APPLICATION_SITE;?>browsers.png" />
   </div> 
<?php } ?>