<?php
/* @var $this InputController */
/* @var $model Tournament */
Yii::app()->clientScript->registerCssFile("/application/DataKae/css/playerForm.css");
$this->breadcrumbs=array(
    'View Tournament'=>array('view','id'=>$model->tournamentId),
    $model->tournamentId,
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
<div class="hubbo" id="container" style="playerForm.css">
<div class="griddy">
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'participant-grid',
    'dataProvider'=>$playerModel->tourneyParticipants($model->tournamentId, true),
    'filter'=>$playerModel,
    'columns'=>array(
        'playerNickname',
        ),
        'selectionChanged'=>'function(id){playerManager.selectedParticipant=$.fn.yiiGridView.getSelection(id);}'
)); 

?>
</div>
<div class="griddy">
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'possibleplayer-grid',
    'dataProvider'=>$playerModel->tourneyParticipants($model->tournamentId, false),
    'filter'=>$playerModel,
    'columns'=>array(
        'playerNickname',
        ),
    'selectionChanged'=>'function(id){playerManager.selectedPlayer=$.fn.yiiGridView.getSelection(id);}'
)); 
?>

</div>
</div>

<?php
echo CHtml::ajaxSubmitButton('Add selected player',Yii::app()->createUrl('input/addPlayerToTourney',array('id' => $model->tournamentId)),
                    array(
                        'type'=>'POST',
                        'data'=> 'js:{"TournamentPlayer": playerManager.selectedPlayer}',
                        'datatype'=> 'text',                      
                        'success'=>'function(data){$.fn.yiiGridView.update(\'possibleplayer-grid\');$.fn.yiiGridView.update(\'participant-grid\');}'      
                    ));
?>

<?php
echo CHtml::ajaxSubmitButton('Remove selected player',Yii::app()->createUrl('input/removePlayerFromTourney',array('id' => $model->tournamentId)),
                    array(
                        'type'=>'POST',
                        'data'=> 'js:{"TournamentPlayer": playerManager.selectedParticipant}',
                        'datatype'=> 'text',                      
                        'success'=>'function(data){$.fn.yiiGridView.update(\'possibleplayer-grid\');$.fn.yiiGridView.update(\'participant-grid\');}'      
                    ));
?>
         
<script language = 'javascript'>
playerManager = function ()
{
   var selectedPlayer;
   var selectedParticipant;
}
</script>
