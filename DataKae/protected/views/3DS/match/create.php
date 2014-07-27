<?php
/* @var $this InputController */
/* @var $model Tournament */



$this->menu=array(
    array('label'=>'Manage Tournaments', 'url'=>array('admin'))
);
?>

<h1>Create Tournament</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>