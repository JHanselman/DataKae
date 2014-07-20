<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
//$rank=new RankingCalculator;

$this->breadcrumbs=array(
    'About',
);
?>
<h1>About</h1>

<p>This website was blablabla</p>

<?php 
$charCriteria = new CDbCriteria(array('select'=>('"characterId","characterName"'),'order'=>'"characterName" ASC'));
$characters=Characters::model()->findAll($charCriteria);
$character=Characters::model();

$haha=array();

 foreach($characters as $char) 
    {
        if(isset($char->characterName)) 
            $haha[$char->characterId]=$char->characterName;
    }

//$this->widget('application.components.CharacterSelectScreen', array('characters'=> $characters)); ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'Tournament-form',
    'enableAjaxValidation'=>false,
)); ?>


<div class="row">
        <?php echo $form->labelEx($character, 'character'); ?>
 
            <div class="compactRadioGroup">
            <?php
                echo $form->radioButtonList($character, 'characterName', $haha,
                array('template'=>'<img src="../../css/images/'.'{label}'.'.gif" />')
                //<img src="../../css/images/none.gif" />')
                );
            ?>
            </div>
    </div>


<?php $this->endWidget(); ?>



<?php

/*$auth=Yii::app()->authManager;

$bizRule='return !Yii::app()->user->isGuest;';
$auth->createRole('authenticated', 'authenticated user', $bizRule);
 
$bizRule='return Yii::app()->user->isGuest;';
$auth->createRole('guest', 'guest user', $bizRule);

$role = $auth->createRole('admin', 'administrator');
$auth->assign('admin',18); // adding admin to me
*/

/*
$auth=Yii::app()->authManager;
$bizRule = 'return Yii::app()->user->id==$params["User"]->id;';
$auth->createTask('updateSelf', 'update own information', $bizRule);

$role = $auth->getAuthItem('authenticated'); // pull up the authenticated role
$role->addChild('updateSelf'); // assign updateSelf tasks to authenticated users
*/


 //echo $rank->Rank() ?>
