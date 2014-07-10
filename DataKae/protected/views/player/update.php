<?php
/* @var $this PlayerController */
/* @var $model Player */

$this->breadcrumbs=array(
	'Players'=>array('index'),
	$model->playerId=>array('view','id'=>$model->playerId),
	'Update',
);

$this->menu=array(
	array('label'=>'List Player', 'url'=>array('index')),
	array('label'=>'Create Player', 'url'=>array('create')),
	array('label'=>'View Player', 'url'=>array('view', 'id'=>$model->playerId)),
	array('label'=>'Manage Player', 'url'=>array('admin')),
);
?>

<h1>Update Player <?php echo $model->playerId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>