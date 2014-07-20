<?php
/* @var $this InputController */
/* @var $model Tournament */

$this->breadcrumbs=array(
    'View Tourneys'=>array('admin'),
    $model->tournamentName,
);


$this->menu=array(
    array('label'=>'View Tournaments', 'url'=>array('admin')),
    array('label'=>'Create Tournament', 'url'=>array('create'), 'visible' => Yii::app()->user->checkAccess('TO')),
    array('label'=>'Update Tournament', 'url'=>array('update', 'id'=>$model->tournamentId), 'visible' => Yii::app()->user->checkAccess('editOwnTourney',array('Tournament'=>$model))||Yii::app()->user->checkAccess('admin')),
    array('label'=>'Delete Tournament', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->tournamentId),'confirm'=>'Are you sure you want to delete this item?'), 'visible' => Yii::app()->user->checkAccess('editOwnTourney',array('Tournament'=>$model))||Yii::app()->user->checkAccess('admin'))
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

<?php Yii::app()->clientScript->registerCssFile("/application/DataKae/css/tourneyView.css")?>

<div class = "tourneyViewer" style="tourneyView.css">
<div class = "row">
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'participant-grid',
    'dataProvider'=>$playerModel->tourneyParticipants($model->tournamentId, true),
    'filter'=>$playerModel,
    'columns'=>array(
        'playerNickname',
        array(
            'class'=>'CButtonColumn',
            'template' => '{view}',
            'viewButtonUrl'=> 'Yii::app()->createUrl("player/view", array("id"=>$data->playerId))'
            ),
    ),
)); 
if (Yii::app()->user->checkAccess('editOwnTourney',array('Tournament'=>$model))||Yii::app()->user->checkAccess('admin'))
    {
        echo CHtml::button('Add/Remove participants', array('submit'=>array('addplayertotourney','id'=>$model->tournamentId)));
    }
?>
</div>
<div class = "row">
<?php 

//$matchModel=new Match();


//Figure out how to get search working

//$data= new CActiveDataProvider($matchModel, array('criteria'=>$criteria,));
$template = '{view}';
if (Yii::app()->user->checkAccess('editOwnTourney',array('Tournament'=>$model))||Yii::app()->user->checkAccess('admin'))
    {
        $template = '{view}{update}{delete}';
    }
//echo $matches[1]->matchId;
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'match-grid',
    'dataProvider'=> $matchModel->search(),
    'filter'=>$matchModel,
    'columns'=>array(
        'matchId',
        array(
            'class'=>'CButtonColumn',
            'template' => $template,
            'updateButtonUrl'=> 'Yii::app()->createUrl("match/update", array("id"=>$data->matchId))',
            'deleteButtonUrl'=> 'Yii::app()->createUrl("match/delete", array("id"=>$data->matchId))',
            'viewButtonUrl'=> 'Yii::app()->createUrl("match/view", array("id"=>$data->matchId))',
            'htmlOptions'=>array('width'=>'90px')
            ),
        ),
    )
); 
if (Yii::app()->user->checkAccess('editOwnTourney',array('Tournament'=>$model))||Yii::app()->user->checkAccess('admin'))
    {
        echo CHtml::button('Add Match', array('submit'=>array('match/submitresults','id'=>$model->tournamentId)));
    }

?>
</div>
</div>

