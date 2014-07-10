<?php
/* @var $this PlayerController */
/* @var $model Player */

$this->breadcrumbs=array(
    'Players'=>array('index'),
    $model->playerId,
);

$this->menu=array(
    array('label'=>'Player list', 'url'=>array('index')),
    array('label'=>'Create Player', 'url'=>array('create'), 'visible'=>Yii::app()->user->checkAccess('admin')),
    array('label'=>'Update Player', 'url'=>array('update', 'id'=>$model->playerId),'visible'=>Yii::app()->user->checkAccess('admin')),
    array('label'=>'Delete Player', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->playerId),'confirm'=>'Are you sure you want to delete this item?'),'visible'=>Yii::app()->user->checkAccess('admin')),
    array('label'=>'Manage Player', 'url'=>array('admin'),'visible'=>Yii::app()->user->checkAccess('admin')),
);
?>

<h1><?php echo $model->playerNickname; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'playerName',
        'playerLastName',
        'playerNickname',
    ),
)); ?>
