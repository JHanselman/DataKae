<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
    'Users'=>array('index'),
    $model->userId,
);

$this->menu=array(
    array('label'=>'User list', 'url'=>array('index')),
    array('label'=>'Create User', 'url'=>array('create'), 'visible'=>Yii::app()->user->checkAccess('admin')),
    array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->userId), 'visible'=>Yii::app()->user->checkAccess('updateSelf',array('User'=>$model))),
    array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->userId),'confirm'=>'Are you sure you want to delete this user?'),'visible'=>Yii::app()->user->checkAccess('admin')),
    array('label'=>'Manage Users', 'url'=>array('admin'), 'visible'=>Yii::app()->user->checkAccess('admin')),
);
?>

<h1><?php echo $model->userName; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'userName',
        'emailAddress',
    ),
)); ?>
