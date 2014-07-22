<?php
/* @var $this MatchController */
/* @var $model Match */

$this->breadcrumbs=array(
    'Matches'=>array('index'),
    'Search',
);

$charCriteria = new CDbCriteria(array('select'=>('"characterId","characterName"'),'order'=>'"characterName" ASC'));
$stageCriteria = new CDbCriteria(array('select'=>('"stageId","stageName"'),'order'=>'"stageName" ASC'));
$characters=CHtml::listData(Characters::model()->findAll($charCriteria),'characterId','characterName');
$stages = CHtml::listData(Stages::model()->findAll($stageCriteria),'stageId','stageName');;

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

<h1>Search Matches</h1>

<p>
Fill in what you are looking for and press the search button to find it.
</p>
<?php Yii::app()->clientScript->registerCssFile("/application/DataKae/css/searchView.css")?>

<div class="search-form" >
<?php $this->renderPartial('_search',array(
    'model' => $model,
    'characters' => $characters,
    'stages' => $stages
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.CListView', array(
    'id'=>'match-grid',
    'dataProvider'=>$model->specialSearch(),
    'itemView'=>'_view',
    'enablePagination'=>true,
    'viewData' =>array('characters' => $characters, 'stages' => $stages)
)); ?>
