<?php
/* @var $this SiteController */
/* @var $model RegisterForm */
/* @var $form CActiveForm  */

//$cs = Yii::app()->getClientScript();
//$cs->registerScriptFile('/application/external/jquery-2.0.2.js');

$criteria = new CDbCriteria(array('select'=>('"locationId","locationName", "regionName"'),'order'=>'"locationName" ASC'));
    
$locations=Location::model()->findAll($criteria);
$location='empty';
$this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array(
    'Register',
);
?>

<h1>Register</h1>

<p>Please fill in the following form in order to register:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'registration-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username'); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'playerName'); ?>
        <?php echo $form->textField($model,'playerName'); ?>
        <?php echo $form->error($model,'playerName'); ?>
    </div>
        
    <div class="row">
        <?php echo $form->labelEx($model,'playerLastName'); ?>
        <?php echo $form->textField($model,'playerLastName'); ?>
        <?php echo $form->error($model,'playerLastName'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'playerNickname'); ?>
        <?php echo $form->textField($model,'playerNickname'); ?>
        <?php echo $form->error($model,'playerNickname'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password'); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'emailAddress'); ?>
        <?php echo $form->textField($model,'emailAddress'); ?>
        <?php echo $form->error($model,'emailAddress'); ?>
    </div>
    
    <div class="dropdownbox">
        <?php echo $form->labelEx($model,'locationName'); ?>
        <?php 
        $list = CHtml::listData($locations,'locationId','locationName','regionName');
        Yii::trace(serialize($list));
        echo $form->dropDownList($model,'locationId',$list ); ?>
        <?php echo $form->error($model,'location'); ?>
    </div>
    
    <?php if(CCaptcha::checkRequirements()): ?>
    <div class="row">
        <?php echo $form->labelEx($model,'verifyCode'); ?>
        <div>
        <?php $this->widget('CCaptcha'); ?>
        <?php echo $form->textField($model,'verifyCode'); ?>
        </div>
        <div class="hint">Please enter the letters as they are shown in the image above.
        <br/>Letters are not case-sensitive.</div>
        <?php echo $form->error($model,'verifyCode'); ?>
    </div>
    <?php endif; ?>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('Register'); ?>
    </div>

<?php $this->endWidget(); ?>
</div><!-- form -->

