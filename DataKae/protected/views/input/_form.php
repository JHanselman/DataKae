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
    'id'=>'Tournament-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'tournamentName'); ?>
        <?php echo $form->textField($model,'tournamentName',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'tournamentName'); ?>
    </div>

    <div class="dropdownbox">
        <?php echo $form->labelEx($model,'locationName'); ?>
        <?php echo $form->dropDownList($model,'locationId', CHtml::listData($locations,'locationId','locationName'),array('empty' => '(Select a location)')); ?>
        <?php echo $form->error($model,'location'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'Start_Date'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'startDate',
            'options' => array(
                'showAnim' => 'fold',
                'dateFormat'=>'yy-mm-dd',
                'changeMonth'=>true,
                'changeYear'=>true,
                'yearRange'=>'2000:2099',
                'minDate' => '2000-01-01',      // minimum date
                'maxDate' => '2099-12-31',      // maximum date
                ),
            'htmlOptions' => array(
                'size' => '10',         // textField size
                'maxlength' => '10',    // textField maxlength
            ),
        ));
        ?>
        <?php echo $form->error($model,'startDate'); ?>
    </div>
    
        <div class="row">
        <?php echo $form->labelEx($model,'End_Date'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'endDate',
            'options' => array(
                'showAnim' => 'fold',
                'dateFormat'=>'yy-mm-dd',
                ),
            'htmlOptions' => array(
                'size' => '10',         // textField size
                'maxlength' => '10',    // textField maxlength
            ),
        ));
        ?>
        <?php echo $form->error($model,'endDate'); ?>
    </div>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->