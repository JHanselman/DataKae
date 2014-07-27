<?php
/* @var $this MatchController */
/* @var $model Match */

$this->breadcrumbs=array(
    'Users'=>array('index'),
    'Manage',
);

$this->menu=array(
    array('label'=>'Create Match', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#match-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Manage Matches</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>



<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'match-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'matchId',
        'tournamentId',
        'player1',
        'player2',
        'winner1',
        array(
            'class'=>'CButtonColumn',
        ),
    ),
)); ?>
