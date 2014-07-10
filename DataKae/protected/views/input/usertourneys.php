<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Tourneys</h1>
<div id='TourneyGrid'>
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model->findByOrganizer($userId),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'tournamentName',
            'type' => 'text',
            'value' => 'CHtml::encode($data->tournamentName)'
        ),
        array(
            'name' => 'startDate',
            'type' => 'text',
            'value'=> $model->startDate
        )
    ),
    'selectionChanged'=>'function(id){changeTourneyView($.fn.yiiGridView.getSelection(id));}'
    )
);
?>
</div>
<div id='rightView'>
<div id='TourneyView'>
<?php $this->renderPartial('tourneyview', null)?>
</div>

</div>
<?php Yii::app()->clientScript->registerCoreScript("jquery")?>
            <script>
            function changeTourneyView(id)
            {
                <?php echo CHtml::ajax(array('type'=>'GET', 'url'=> CController::createUrl('viewTourney'), 
                    'update'=>'#TourneyView','data' => array('id' => 'js: id')));?>
            }
            </script>
