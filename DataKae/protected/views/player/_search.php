<?php
/* @var $this PlayerController */
/* @var $model Player */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'playerId'); ?>
        <?php echo $form->textField($model,'playerId'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'playerName'); ?>
        <?php echo $form->textField($model,'playerName',array('size'=>60,'maxlength'=>128)); ?>
    </div>

        <div class="row">
        <?php echo $form->label($model,'playerLastName'); ?>
        <?php echo $form->textField($model,'playerLastName',array('size'=>60,'maxlength'=>128)); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model,'playerNickname'); ?>
        <?php echo $form->textField($model,'playerNickname',array('size'=>60,'maxlength'=>128)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->