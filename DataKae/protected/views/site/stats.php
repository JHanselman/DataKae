<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Stats';
$this->breadcrumbs=array(
    'Stats',
);
?>

<?php Yii::app()->clientScript->registerCssFile("/application/DataKae/css/stats.css")?>
<h1>Character Wins Vs another character</h1>
<div class="stats" style="stats.css">
<?php
$charCriteria = new CDbCriteria(array('select'=>('"characterId","characterName"'),'order'=>'"characterName" ASC'));
$characters=CHtml::listData(Characters::model()->findAll($charCriteria),'characterId','characterName');
foreach ($characters as $id => $character)
{
echo '<div class="statscolumn">';
echo '<b> '.$character.':</b>';

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'charactervswins-grid'.$id,
    'dataProvider'=>$model->search($id),
    'summaryText' => '',
    'columns'=>array(
        'character2',
        'wins'
    ),
));

echo '</div>';
}
?>
</div>

