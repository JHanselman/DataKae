<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

    <div id="header">
        <div id="logo">
        <img id="squirrellogo" src="<?php echo Yii::app()->request->baseUrl; ?>/css/images/logo.png" /></div>
    </div><!-- header -->

    <div id="mainMbMenu">
        <?php 
        $this->widget('application.extensions.mbmenu.MbMenu',array(
            'activeCssClass'=>'active',
            'activateParents'=>true,
            'items'=>array(
                array('label'=>'Home', 'url'=>array('/site/index')),
                array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Register', 'url'=>array('/site/register'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'View Tourneys', 'items'=>array(
                    array('label'=>'Wii U','url'=>array('WiiU/input/index')),
                    array('label'=>'3DS', 'url'=>array('3DS/input/index')))), 
                array('label'=>'Matches', 'items'=> array(
                    array('label'=>'Manage Wii U Matches', 'url'=>array('WiiU/match/admin'), 'visible'=>Yii::app()->user->checkAccess('admin')),
                    array('label'=>'Manage 3DS Matches', 'url'=>array('/3DS/match/admin'), 'visible'=>Yii::app()->user->checkAccess('admin')),
                    array('label'=>'Search Wii U Matches', 'url'=>array('WiiU/match/search')),
                    array('label'=>'Search 3DS Matches', 'url'=>array('/3DS/match/search')))),
                array('label'=>'Users', 'items'=> array(
                    array('label'=>'User List', 'url'=>array('/user/index')),
                    array('label'=>'Manage Users', 'url'=>array('/user/admin'), 'visible'=>Yii::app()->user->checkAccess('admin')))),
                array('label'=>'Players', 'items'=> array(
                    array('label'=>'Player List', 'url'=>array('/player/index')),array('label'=>'Manage Players', 'url'=>array('/player/admin'), 'visible'=>Yii::app()->user->checkAccess('admin')))),
                array('label'=>'Character Stats', 'url'=>array('/site/stats')),
                array('label'=>'My Account','items'=>array(
                    array('label'=>'My Profile', 'url'=>array('/user/view/'.Yii::app()->user->getId()),'visible'=> !Yii::app()->user->isGuest),array('label'=>'My Wii U Tourneys', 'url'=>array('WiiU/input/mytourneys', 'userId'=>Yii::app()->user->getId()),'visible'=> !Yii::app()->user->isGuest),
                    array('label'=>'My 3DS Tourneys', 'url'=>array('3DS/input/mytourneys', 'userId'=>Yii::app()->user->getId()),'visible'=> !Yii::app()->user->isGuest))),
                array('label'=> 'Other', 'items'=>array(
                    array('label'=>'Downloads', 'url'=>array('/site/downloads')),
                    array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                    array('label'=>'Contact', 'url'=>array('/site/contact', 'view'=>'contact')))),
                array('label'=> 'Forum', 'url'=>array('/forum'))
                
            ),
        )); ?>
        
        
        
    </div><!-- mainmenu -->
    <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        )); ?><!-- breadcrumbs -->
    <?php endif?>


    
    <?php echo $content; ?>

    <?php if(isset($this->menu)):?>
    <?php $this->widget('zii.widgets.CMenu', array(
        'items'=>$this->menu,
    )); ?><!-- minimenu -->
    <?php endif?>
    
    <div class="clear"></div>

    <div id="footer">
        Copyright &copy; <?php echo date('Y'); ?> by LluaZarg.<br/>
        All Rights Reserved.<br/>
        <?php echo Yii::powered(); ?>
    </div><!-- footer -->

</div><!-- page -->

</body>
</html>
