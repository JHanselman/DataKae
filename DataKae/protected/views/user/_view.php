<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">


    <b><?php echo CHtml::encode($data->getAttributeLabel('userName')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->userName), array('view', 'id'=>$data->userId)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('emailAddress')); ?>:</b>
    <?php echo CHtml::encode($data->emailAddress); ?>
    <br />


</div>