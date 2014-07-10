<?php
/* @var $this PlayerController */
/* @var $model Player */
/* @var $form CActiveForm */

$criteria = new CDbCriteria(array('select'=>('"locationId","locationName"'),'order'=>'"locationName" ASC'));

$locations=Location::model()->findAll($criteria);
$location='empty';
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'Match-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'player1'); ?>
        <?php echo $form->textField($model,'player1',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'player1'); ?>
    </div>

    
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->