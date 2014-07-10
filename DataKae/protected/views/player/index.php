<?php
/* @var $this PlayerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    'Players',
);

$this->menu=array(
    array('label'=>'Create Player', 'url'=>array('create'), 'visible'=>Yii::app()->user->checkAccess('admin')),
    array('label'=>'Manage Player', 'url'=>array('admin'), 'visible'=>Yii::app()->user->checkAccess('admin')),
);
?>

<h1>Players</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
)); ?>
