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
        <?php //echo $form->label($model,'tournamentName'); ?>
        <?php //echo $form->textField($model,'tournamentName',array('size'=>60,'maxlength'=>128)); ?>
    </div>
    <div class="row">
     <?php echo CHtml::activeRadioButtonList($model, "gamesNr",array(null => 'All',1 => "Best of 1",3 => "Best of 3",5 => "Best of 5",7 => "Best of 7"), array('template'=>"<div class=\"BestOf\">{input} </div>{label}",'separator' => " "))?>
    </div>
       <div class="row">
        <?php //echo $form->label($model,'player1'); ?>
        <?php 
               /* $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute'=>'player_1',
                        'id'=>'searchForm_player_1',
                        'name'=>'player_1',
                        'value'=>'',
                        'source'=>$this->createUrl('Player/autocomplete'),
                        // additional javascript options for the autocomplete plugin
                        'options'=>array(
                                'showAnim'=>'fold',
                        ),
                    ));*/ ?>
    </div>
    
    <div class="row">
    <?php echo $form->label($model,'character1'); ?>
    <?php echo CHtml::activeDropDownList($model,'character1',$characters,array('empty' => 'Any character')); ?>
    </div>
    
    <div class="row">
    <?php echo $form->label($model,'character2'); ?>
    <?php echo CHtml::activeDropDownList($model,'character2',$characters,array('empty' => 'Any character')); ?>
    </div>
    
    <div class="row">
        <?php /* echo $form->label($model,'winner1'); ?>
        <?php // echo $form->textField($model,'winner1',array('size'=>60,'maxlength'=>128));*/ ?>
    </div>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->