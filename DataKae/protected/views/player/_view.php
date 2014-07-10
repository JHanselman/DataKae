<?php
/* @var $this PlayerController */
/* @var $data Player */
?>

<div class="view">

    <b><?php echo 'Name'; ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->playerName).' '.CHtml::encode($data->playerLastName),
        array('view', 'id'=>$data->playerId)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('playerNickname')); ?>:</b>
    <?php echo CHtml::encode($data->playerNickname); ?>
    <br />


</div>