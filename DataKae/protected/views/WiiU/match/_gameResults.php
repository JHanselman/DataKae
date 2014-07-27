<!-- A block of set results to submit -->

<?php $characterData = CHtml::listData($characters,'characterId','characterName');
$stageData = CHtml::listData($stages,'stageId','stageName');

echo '<div class="game" id="game'.$index.'"';
if (!$visible)
{
    echo ' style = "display:none"';
}
echo "\">";
?>


    <div class="players">
    
        <div class="player">
            <?php echo CHtml::activeLabel($model, "[$index]characterName")?>
            <?php 
            if ($model->character_1!= null)
                {
                    $char1 = $model->character_1;
                    $name = $characterData[$char1];
                    echo "<img id=\"character_1".$index."\" src=\"../../../css/images/".$name.".gif\" />";
                }
            else{
                    echo "<img id=\"character_1".$index."\" src=\"../../../css/images/none.gif\" />" ;
                }
            ?>
                <?php echo CHtml::activeDropDownList($model,"[$index]character_1",
                    CHtml::listData($characters,'characterId','characterName'),
                    array('onchange'=>"changePic($(this).find(\"option:selected\"), 'character_1".$index."','gif')", 'onkeyup'=>"changePic($(this).find(\"option:selected\"), 'character_1".$index."','gif')",
                    'empty' => '(Select a character)')); ?>
        </div>
        
        <div class="player">
            <?php echo CHtml::activeLabel($model, "[$index]characterName")?>
            
            <?php 
            if ($model->character_2!= null)
                {
                    $char2 = $model->character_2;
                    $name = $characterData[$char2];
                    echo "<img id=\"character_2".$index."\" src=\"../../../css/images/".$name.".gif\" />";
                }
            else{
                    echo "<img id=\"character_2".$index."\" src=\"../../../css/images/none.gif\" />" ;
                }
            ?>
            <?php echo CHtml::activeDropDownList($model,"[$index]character_2",
                CHtml::listData($characters,'characterId','characterName'),
                array('onchange'=>"changePic($(this).find(\"option:selected\"), 'character_2".$index."','gif')",'onkeyup'=>"changePic($(this).find(\"option:selected\"), 'character_2".$index."','gif')",
                'empty' => '(Select a character)')); ?>
        </div> 
        
        <div class="checkboxes">
        <?php echo CHtml::label("Winner", "[$index]winner1")?>
        <?php echo CHtml::activeRadioButtonList($model,"[$index]winner1", array('1'=>'1', '2'=>'2'),
        array( 'template'=>"<div class=\"checkbox\">{input} </div>",'separator' => " ", 
        'onchange'=> 'renderGames($("#container input[type=\'radio\']:checked").val())'));?>
        </div>
    </div>
        <div class="stage">
        
        
            <?php 
            if ($model->stageId!= null)
                {
                    $stage = $model->stageId;
                    $name = $stageData[$stage];
                    echo "<img id=\"stage".$index."\" src=\"../../../css/images/".$name.".png\" />";
                }
            else{
                    echo "<img id=\"stage".$index."\" src=\"../../../css/images/none.png\" />" ;
                }
            ?>
                <?php echo CHtml::activeLabel($model, "[$index]stageId")?>
                <?php echo CHtml::activeDropDownList($model,"[$index]stageId",
                    $stageData,
                    array('onchange'=> "changePic($(this).find(\"option:selected\"), 'stage".$index."','png')", 'onkeyup'=>"changePic($(this).find(\"option:selected\"), 'stage".$index."','png')",
                    'empty' => '(Select a stage)')); ?>
        
        </div>


</div>