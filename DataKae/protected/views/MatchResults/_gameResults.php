<!-- A block of set results to submit -->

<div class="game">
    <div class="players">
        <div class="player">
                <?php echo CHtml::activeLabel($model, "[$index]characterName")?>
                <?php echo "<img id=\"character_1".$index."\" src=\"../../../css/images/none.gif\" />" ?>
                <?php echo CHtml::activeDropDownList($model,"[$index]character_1",
                    CHtml::listData($characters,'characterId','characterName'),
                    array('onchange'=>"changePic($(this).find(\"option:selected\"), 'character_1".$index."','gif')",
                    'empty' => '(Select a character)')); ?>
        </div>
        <div class="player">
                <?php echo CHtml::activeLabel($model, "[$index]characterName")?>
                <?php echo "<img id=\"character_2".$index."\" src=\"../../../css/images/none.gif\" />" ?>
                <?php echo CHtml::activeDropDownList($model,"[$index]character_2",
                    CHtml::listData($characters,'characterId','characterName'),
                    array('onchange'=>"changePic($(this).find(\"option:selected\"), 'character_2".$index."','gif')",
                    'empty' => '(Select a character)')); ?>
        </div> 
        <div class="checkboxes">
        <?php echo CHtml::activeRadioButtonList($model,"[$index]winner", array('1'=>'1', '2'=>'2'),
        array( 'template'=>"<div class=\"checkbox\">{input} </div>",'separator' => " " ));?>
        </div>
    </div>
        <div class="stage">
            <?php echo "<img id=\"stage".$index."\" src=\"../../../css/images/none.png\" />" ?>
                <?php echo CHtml::activeLabel($model, "[$index]stageId")?>
                <?php echo CHtml::activeDropDownList($model,"[$index]stageId",
                    CHtml::listData($stages,'stageId','stageName'),
                    array('onchange'=> "changePic($(this).find(\"option:selected\"), 'stage".$index."','png')", 
                    'empty' => '(Select a stage)')); ?>
        
        </div>


</div>