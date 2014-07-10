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
