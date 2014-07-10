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
    'dataProvider'=>$playerModel->tourneyParticipants($model->tournamentId),
    'filter'=>$playerModel,
    'columns'=>array(
        'playerNickname',
        array(
            'class'=>'CButtonColumn',
            'updateButtonUrl'=> 'Yii::app()->createUrl("player/update", array("id"=>$data->playerId))',
            'deleteButtonUrl'=> 'Yii::app()->createUrl("player/delete", array("id"=>$data->playerId))',
            'viewButtonUrl'=> 'Yii::app()->createUrl("player/view", array("id"=>$data->playerId))'
            ),
    ),
)); 
echo CHtml::button('Add player', array('submit'=>array('addplayertotourney','id'=>$model->tournamentId)));
?>


<?php 

//$matchModel=new Match();


//Figure out how to get search working

//$data= new CActiveDataProvider($matchModel, array('criteria'=>$criteria,));

//echo $matches[1]->matchId;
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'match-grid',
    'dataProvider'=> $matchModel->search(),
    'filter'=>$matchModel,
    'columns'=>array(
        'matchId',
        'tournamentId',
        array(
            'class'=>'CButtonColumn',
            'updateButtonUrl'=> 'Yii::app()->createUrl("match/update", array("id"=>$data->matchId))',
            'deleteButtonUrl'=> 'Yii::app()->createUrl("match/delete", array("id"=>$data->matchId))',
            'viewButtonUrl'=> 'Yii::app()->createUrl("match/view", array("id"=>$data->matchId))'
            ),
        ),
    )
); 
echo CHtml::button('Add Match', array('submit'=>array('matchresults/submitresults','id'=>$model->tournamentId)));
?>


