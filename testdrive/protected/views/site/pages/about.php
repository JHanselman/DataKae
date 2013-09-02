<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$rank=new RankingCalculator;

$this->breadcrumbs=array(
    'About',
);
?>
<h1>About</h1>

<p>This website was blablabla</p>
<?php echo $rank->Rank() ?>
