<?php
/* @var $this InputController */
/* @var $model Tournament */

$this->breadcrumbs=array(
    $model->matchId,
);

$this->menu=array(
    array('label'=>'Update Match','url'=>array('update', 'id'=>$model->matchId), 
            'visible' => Yii::app()->user->checkAccess('editOwnWiiUTourney',array('Tournament'=>Tournament_WiiU::model()->findByPk($model->tournamentId)))||Yii::app()->user->checkAccess('admin')),
    array('label'=>'Delete Match', 'url'=>'#', 'linkOptions' =>array('submit'=>array('delete','id'=>$model->matchId),'confirm'=>'Are you sure you want to delete this item?'),'visible' => Yii::app()->user->checkAccess('editOwnWiiUTourney',array('Tournament'=>Tournament_WiiU::model()->findByPk($model->tournamentId)))||Yii::app()->user->checkAccess('admin')),
    array('label'=>'Manage Matches', 'url'=>array('admin'), 'visible' => Yii::app()->user->checkAccess('admin')),
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
