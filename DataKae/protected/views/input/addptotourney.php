<?php
/* @var $this InputController */
/* @var $model Tournament */

$this->breadcrumbs=array(
    'Users'=>array('index'),
    $model->tournamentId,
);

$this->menu=array(
    array('label'=>'List Tournaments', 'url'=>array('index')),
    array('label'=>'Create Tournament', 'url'=>array('create')),
    array('label'=>'Update Tournament', 'url'=>array('update', 'id'=>$model->tournamentId)),
    array('label'=>'Delete Tournament', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->tournamentId),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Manage Tournament', 'url'=>array('admin')),
);
?>

<h1>View <?php echo $model->tournamentName; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'tournamentId',
        'tournamentName',
        'locationId',
        'startDate',
        'endDate',
    ),
)); 

?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'participant-grid',
    'dataProvider'=>$playerModel->search(),
    'filter'=>$playerModel,
    'columns'=>array(
        'playerNickname',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{addPlayer}',
            'buttons'=>array(
                'addPlayer' => array(
                    'label'=>'Add Player',
                    //'url'=>'Yii::app()->createUrl("input/createTournamentPlayer", array("id"=>$model->tournamentId))',
                ),
            ),
        ),
))); ?>
