<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Submit results';
$charCriteria = new CDbCriteria(array('select'=>('"characterId","characterName"'),'order'=>'"characterName" ASC'));
$stageCriteria = new CDbCriteria(array('select'=>('"stageId","stageName"'),'order'=>'"stageName" ASC'));
$characters=Characters::model()->findAll($charCriteria);
$stages=Stages::model()->findAll($stageCriteria);
$tournament = Tournament::model()->findByPk($match->tournamentId);

$this->breadcrumbs=array(
    'View Tourneys'=>array('//input/admin'), $tournament->tournamentName =>array('//input/view', 'id' => $tournament->tournamentId),
    'Match',
);

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

            <div class="BOlist">
        <?php echo CHtml::activeRadioButtonList($match, "gamesNr",array(1 => "Best of 1",3 => "Best of 3",5 => "Best of 5",7 => "Best of 7"), array('template'=>"<div class=\"BestOf\">{input} </div>{label}",'separator' => " ", 'onChange' => 'js:renderGames($("#container input[type=\'radio\']:checked").val())'))?>
        </div>
        </div>
        
        <div class="games">
        <?php 
        $toRender = $match->determineGameNumber($match->games);
        
        for($i=0; $i<count($match->games); $i++):
                 $this->renderPartial('_gameResults', array(
                    'model' => $match->games[$i],
                    'index' => $i,
                    'characters' => $characters,
                    'stages' => $stages,
                    'visible'=> $i<$toRender
                ));
        endfor ?>
        </div>
        
        <div class="row buttons">
        <!-- //    <?php echo CHtml::button('Add game',
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
            </script>// -->
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

function renderGames(BestOf)
{
    for (i=0; i<7; i++)
    {
        $("#game"+i).hide();
    }

    var winCriterion = Math.ceil(BestOf/2);
    var gamesPlayed = Math.ceil(BestOf/2);
     
     var j=0;
     
    do {
        var player1=0;
        var player2=0;
        for (i=0; i<gamesPlayed; i++)
        {

            if ($("#game"+i+" input[type=\'radio\']:checked").val()==1)
            {
                player1++;
            }
            if ($("#game"+i+" input[type=\'radio\']:checked").val()==2)
            {
                player2++;
            }
        }
    var matchesToWin = Math.min(winCriterion-player1, winCriterion-player2);
    var gamesLeft = matchesToWin-(gamesPlayed-player1-player2);
    gamesPlayed+=gamesLeft;
    }
    while (gamesLeft>0);
    
    for (i=0; i<gamesPlayed; i++)
    {
        $("#game"+i).show();
    }
    
}

</script>
</div><!-- form -->
