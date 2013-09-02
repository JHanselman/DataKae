<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'userId'); ?>
        <?php echo $form->textField($model,'userId'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'userName'); ?>
        <?php echo $form->textField($model,'userName',array('size'=>60,'maxlength'=>128)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'emailAddress'); ?>
        <?php echo $form->textField($model,'emailAddress',array('size'=>60,'maxlength'=>128)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->