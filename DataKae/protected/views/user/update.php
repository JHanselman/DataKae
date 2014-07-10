<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
    'Users'=>array('index'),
    $model->userId=>array('view','userId'=>$model->userId),
    'Update',
);

$this->menu=array(
    array('label'=>'List User', 'url'=>array('index')),
    array('label'=>'Create User', 'url'=>array('create'),'visible'=>Yii::app()->user->checkAccess('admin')),
    array('label'=>'View User', 'url'=>array('view', 'id'=>$model->userId)),
    array('label'=>'Manage Users', 'url'=>array('admin'),'visible'=>Yii::app()->user->checkAccess('admin')),
);
?>

<h1>Update User <?php echo $model->userId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>