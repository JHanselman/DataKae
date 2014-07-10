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
    'id'=>'Player-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'playerName'); ?>
        <?php echo $form->textField($model,'playerName',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'playerName'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'playerLastName'); ?>
        <?php echo $form->textField($model,'playerLastName',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'playerLastName'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'playerNickname'); ?>
        <?php echo $form->textField($model,'playerNickname',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'playerNickname'); ?>
    </div>

    <div class="dropdownbox">
        <?php echo $form->labelEx($model,'locationName'); ?>
        <?php echo $form->dropDownList($model,'locationId', CHtml::listData($locations,'locationId','locationName'),array('empty' => '(Select a location)')); ?>
        <?php echo $form->error($model,'location'); ?>
    </div>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->