<?php
/* @var $this MatchController */
/* @var $model Match */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'matchId'); ?>
        <?php echo $form->textField($model,'matchId'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'tournamentId'); ?>
        <?php echo $form->textField($model,'tournamentId',array('size'=>60,'maxlength'=>128)); ?>
    </div>

        <div class="row">
        <?php echo $form->label($model,'player1'); ?>
        <?php echo $form->textField($model,'player1',array('size'=>60,'maxlength'=>128)); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model,'player2'); ?>
        <?php echo $form->textField($model,'player2',array('size'=>60,'maxlength'=>128)); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model,'winner1'); ?>
        <?php echo $form->textField($model,'winner1',array('size'=>60,'maxlength'=>128)); ?>
    </div>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->