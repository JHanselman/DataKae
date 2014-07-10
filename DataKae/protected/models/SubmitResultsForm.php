<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SubmitResultsForm extends CFormModel
{
    public $player_1;
    public $player_2;
    public $tournamentId;
    public $games;
    
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            array('player_1, player_2', 'required')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
        );
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function submitResults()
    {
        $player1=Player::model()->find('"playerNickname"=:playerNickname', array(':playerNickname'=>$this->player_1));
        $player2=Player::model()->find('"playerNickname"=:playerNickname', array(':playerNickname'=>$this->player_2));
        
        $connection = Yii::app()->db;
        
        $transaction=$connection->beginTransaction();
        try
        {
            $newMatch=new Match;
            $newMatch->player1=$player1->playerId;
            $newMatch->player2=$player2->playerId;
            $newMatch->winner1=1;
            $newMatch->tournamentId=$this->tournamentId;
            
            $newMatch->save();
            foreach($this->games as $gameData)
            {
                $game=new Game;
                
                $game->stageId=$gameData->stageId;
                $game->gameNumber=$gameData->gameNumber;
                $game->winner1= $gameData->winner;
                $game->characterPlayer1=$gameData->character_1;
                $game->characterPlayer2=$gameData->character_2;
                $game->matchId=$newMatch->matchId;
                
                $game->save();
            }
            
            $transaction->commit();
            return true;
        }
        catch(Exception $e) // an exception is raised if a query fails
        {
        
            echo Yii::trace(CVarDumper::dumpAsString($e),'vardump');
            $transaction->rollback();
        }
        
    }
    

}
