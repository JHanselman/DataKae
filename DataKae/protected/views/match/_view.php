<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view" style="searchView">

    <table>
    <tbody>
        <tr class ="players">
            <td>
            </td>
            <td>
                <?php 
                $playerModel = Player::model()->findByPk($data->player1);
                echo $playerModel->playerNickname ?>
            </td>
           <td >
                VS
            </td>
            <td>
            </td>
            <td>
                <?php 
                $playerModel = Player::model()->findByPk($data->player2);
                echo $playerModel->playerNickname ?>
            </td>
        </tr>
    
   <?php 
   foreach($data->games as $game)
   { 
    echo '<tr>';
    
            if ($game->winner1==1)
            {
                echo '<td class="W"> W </td>';
            }
            if ($game->winner1==2)
            {
                echo '<td class="L"> L </td>';
            }
            echo '<td class ="characters">';
                echo CHtml::encode($characters[$game->characterPlayer1]); 
            echo '</td><td>'; 
            
            echo CHtml::encode($stages[$game->stageId]);
            
            if ($game->winner1==1)
            {
                echo '<td class="L"> L </td>';
            }
            if ($game->winner1==2)
            {
                echo '<td class="W"> W </td>';
            }
            echo '</td><td class ="characters">'; 
                echo CHtml::encode($characters[$game->characterPlayer2]);
            echo '</td>
        </tr>';
    
   }    ?>

   
    </tbody>
</table>

    <?php echo CHtml::link('View Details', array('view', 'id'=>$data->matchId)); ?>
    <br />

</div>