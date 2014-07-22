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
        <?php echo $form->label($model,'player_1'); ?>
        <?php 
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
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
                    )); ?>
        </div>
        <div class="row">
        <?php echo $form->label($model,'player_2'); ?>
        <?php 
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute'=>'player_2',
                        'id'=>'searchForm_player_2',
                        'name'=>'player_2',
                        'value'=>'',
                        'source'=>$this->createUrl('Player/autocomplete'),
                        // additional javascript options for the autocomplete plugin
                        'options'=>array(
                                'showAnim'=>'fold',
                        ),
                    )); ?>
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
        <?php echo CHtml::activeLabel($model, "stageId")?>
                <?php echo CHtml::activeDropDownList($model,"stageId",
                    $stages,array('empty' => '(Any stage)')); ?>

    </div>
        <div class="row">
        <?php echo $form->labelEx($model,'before'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'before',
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
        <?php echo $form->error($model,'before'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'after'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'after',
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
        <?php echo $form->error($model,'before'); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->