<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<div id='TourneyGrid'>
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model->search(),
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
<?php echo CHtml::button('Delete', array('submit'=>array('delete','id'=>'js: 9;'),'confirm'=>'Are you sure you want to delete this item?'));?>
</div>
<?php Yii::app()->clientScript->registerCoreScript("jquery")?>
            <script>
            function changeTourneyView(id)
            {
                <?php echo CHtml::ajax(array('type'=>'GET', 'url'=> CController::createUrl('viewTourney'), 
                    'update'=>'#TourneyView','data' => array('id' => 'js: id')));?>
            }
            </script>
