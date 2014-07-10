<?php
/* @var $this InputController */
/* @var $model Tournament */

$this->breadcrumbs=array(
    'Matches'=>array('index'),
    $model->matchId,
);

$this->menu=array(
    array('label'=>'Create Match', 'url'=>array('create')),
    array('label'=>'Update Match', 'url'=>array('update', 'id'=>$model->matchId)),
    array('label'=>'Delete Match', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->matchId),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Manage Matches', 'url'=>array('admin')),
);
?>

<h1>View Matches #<?php echo $model->matchId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'matchId',
        'tournamentId',
        'player1',
        'player2',
        'winner1',
    ),
)); ?>
