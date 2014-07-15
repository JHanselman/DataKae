<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Submit results';
$charCriteria = new CDbCriteria(array('select'=>('"characterId","characterName"'),'order'=>'"characterName" ASC'));
$stageCriteria = new CDbCriteria(array('select'=>('"stageId","stageName"'),'order'=>'"stageName" ASC'));
$characters=Characters::model()->findAll($charCriteria);
$stages=Stages::model()->findAll($stageCriteria);
?>
<?php Yii::app()->clientScript->registerCssFile("/application/DataKae/css/resultsform.css")?>
<h1>Match Results:</h1>

<p>Please fill out the following form with the outcome of the match:</p>

<div class="form" id="container" style="resultsform.css">
    <?php echo CHtml::beginForm()?>
        <div class="header">
            <div class="row">
                <?php echo CHtml::activeLabel($match, "player_1")?>
                <?php 
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'model'=>$match,
                        'attribute'=>'player_1',
                        'id'=>'SubmitResultsForm_player_1',
                        'name'=>'player_1',
                        'value'=>'',
                        'source'=>$this->createUrl('Player/autocomplete'),
                        // additional javascript options for the autocomplete plugin
                        'options'=>array(
                                'showAnim'=>'fold',
                        ),
                    )); ?>
                <?php //echo $form->error($model,'player_1'); ?>
            
            </div>
            <div class="row">
                <?php echo CHtml::activeLabel($match, "player_2")?>
                <?php //echo $form->textField($model,'player_2'); 
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'model'=>$match,
                        'attribute'=>'player_2',
                        'id'=>'SubmitResultsForm_player_2',
                        'name'=>'player_2',
                        'value'=>'',
                        'source'=>$this->createUrl('Player/autocomplete'),
                        // additional javascript options for the autocomplete plugin
                        'options'=>array(
                                'showAnim'=>'fold',
                        ),
                    )); ?>
            </div>
            <div class="rowfiller"> &nbsp
            </div>
        </div>
        <div class="games">
        <?php for($i=0; $i<count($games); $i++):
                 $this->renderPartial('_gameResults', array(
                    'model' => $games[$i],
                    'index' => $i,
                    'characters' => $characters,
                    'stages' => $stages
                ));
        endfor ?>
        </div>
        
        <div class="row buttons">
            <?php echo CHtml::button('Add game',
                array('class' => 'games-add'))?>
      
            <?php Yii::app()->clientScript->registerCoreScript("jquery")?>
            <script>
                $(".games-add").click(function(){
                $.ajax({
                    success: function(html){
                        $(".games").append(html);
                    },
                    type: 'get',
                    url: '<?php echo $this->createUrl('addgame')?>',
                    data: {
                        index: $('.game').length
                    },
                    cache: false,
                        dataType: 'html'
                    });
                });
            </script>
            <?php echo CHtml::submitButton('Submit results')?>
        </div>
    <?php echo CHtml::endForm()?>
</div>

<script language = 'javascript'>
function changePic(picture, pictureId, extension)
{
    if (picture.val()!='')
        document.getElementById(pictureId).src="../../../css/images/"+picture.text()+"."+extension;
    else
        document.getElementById(pictureId).src="../../../css/images/none."+extension;
}
</script>
</div><!-- form -->
