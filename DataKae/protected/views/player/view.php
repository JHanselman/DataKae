<?php
/* @var $this PlayerController */
/* @var $model Player */

$this->breadcrumbs=array(
    'Players'=>array('index'),
    $model->playerNickname,
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
)); 
?>
<br>
<label> Character Usage: </label>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'characterusage-grid',
    'dataProvider'=>$characterUsage->search(),
    'summaryText' => '',
    'columns'=>array(
        'characterName',
        'games'
    ),
));
?>
<label> Stage Usage: </label>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'stageusage-grid',
    'dataProvider'=>$stageUsage->search(),
    'summaryText' => '',
    'columns'=>array(
        'stageName',
        'games'
    ),
));
?>
<label> Amount of times lost to: <label>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'vslossesusage-grid',
    'dataProvider'=>$vsLosses->search(),
    'summaryText' => '',
    'columns'=>array(
        'characterName',
        'losses'
    ),
));

?>
