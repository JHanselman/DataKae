<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SubmitResultsForm_WiiU extends CFormModel
{
    public $matchId;
    public $player_1;
    public $player_2;
    public $tournamentId;
    public $games;
    public $gamesNr = 3;
    public $winner1; 
    
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            array('player_1, player_2, gamesNr', 'required')
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
            $newMatch=new Match_WiiU;
            $newMatch->player1=$player1->playerId;
            $newMatch->player2=$player2->playerId;
            $newMatch->tournamentId=$this->tournamentId;
            $newMatch->gamesNr=$this->gamesNr;
            $newMatch->winner1=-1;
            
            $userModel = User::model()->findByPk(Yii::app()->user->id);
            
            $date = date('Y-m-d H:i:s');
            $newMatch->createdOn = $date;
            $newMatch->createdBy = $userModel->userName;
            $newMatch->changedOn = $date;
            $newMatch->changedBy = $userModel->userName;
            $newMatch->save();
            
            $tournament = Tournament_WiiU::model()->findByPk($this->tournamentId);
            $tournament->changedOn = $date;
            $tournament->save();
            
            $playedGames = $this->determineGameNumber($this->games);
            $player1 = 0;
            $player2 = 0;
            
            for ($i = 0; $i< $playedGames; $i++)
            {
                $game=new Game_WiiU;
                $gameData = $this->games[$i];
                
                $game->stageId=$gameData->stageId;
                $game->gameNumber=$gameData->gameNumber;
                $game->winner1= $gameData->winner1;
                
                if ($gameData->winner1 == 1)
                {
                    $player1++;
                }
                if ($gameData->winner1 == 2)
                {
                    $player2++;
                }
                $game->characterPlayer1=$gameData->character_1;
                $game->characterPlayer2=$gameData->character_2;
                $game->matchId=$newMatch->matchId;
                
                $game->save();
            }
            
            if ($player1>$player2)
            {
                $newMatch->winner1=1;
            }
            if ($player2>$player1)
            {
                $newMatch->winner1=2;
            }
            $newMatch->save();
            
            $transaction->commit();
            return true;
        }
        catch(Exception $e) // an exception is raised if a query fails
        {
            echo Yii::trace(CVarDumper::dumpAsString($e),'vardump');
            $transaction->rollback();
            throw new CHttpException(500, 'Something went wrong while processing this request. Please try again later');
        }
        
    }
    
    public function updateResults()
    {
        $player1=Player::model()->find('"playerNickname"=:playerNickname', array(':playerNickname'=>$this->player_1));
        $player2=Player::model()->find('"playerNickname"=:playerNickname', array(':playerNickname'=>$this->player_2));
        
        $connection = Yii::app()->db;
        
        $transaction=$connection->beginTransaction();
        try
        {
            $newMatch=Match_WiiU::model()->findbyPk($this->matchId);
            //$newMatch->matchId = $this->matchId;
            $newMatch->player1=$player1->playerId;
            $newMatch->player2=$player2->playerId;
            $newMatch->tournamentId=$this->tournamentId;
            $newMatch->gamesNr=$this->gamesNr;
            $newMatch->winner1=-1;
            
            $newMatch->changedOn = date('Y-m-d H:i:s');
            $userModel = User::model()->findByPk(Yii::app()->user->id);
            $newMatch->changedBy = $userModel->userName;
            
            $newMatch->save();
            
            $playedGames = $this->determineGameNumber($this->games);
            $player1 = 0;
            $player2 = 0;
            
            for ($i = 0; $i< $playedGames; $i++)
            {
                
                $gameData = $this->games[$i];
                
                $game=Game_WiiU::model()->findbyPk($this->games[$i]->gameId);
                Yii::trace(CVarDumper::dumpAsString($i),'vardump');
                if (isset($game))
                {
                    $game->stageId=$gameData->stageId;
                    $game->gameNumber=$gameData->gameNumber;
                    $game->winner1= $gameData->winner1;
                    
                    if ($gameData->winner1 == 1)
                    {
                        $player1++;
                    }
                    if ($gameData->winner1 == 2)
                    {
                        $player2++;
                    }
                    $game->characterPlayer1=$gameData->character_1;
                    $game->characterPlayer2=$gameData->character_2;
                    $game->matchId=$newMatch->matchId;
                    
                    
                    $game->save();
                }
                else
                {
                    $game=new Game_WiiU;
                    $gameData = $this->games[$i];
                    
                    $game->stageId=$gameData->stageId;
                    $game->gameNumber=$gameData->gameNumber;
                    $game->winner1= $gameData->winner1;
                    
                    if ($gameData->winner1 == 1)
                    {
                        $player1++;
                    }
                    if ($gameData->winner1 == 2)
                    {
                        $player2++;
                    }
                    $game->characterPlayer1=$gameData->character_1;
                    $game->characterPlayer2=$gameData->character_2;
                    $game->matchId=$newMatch->matchId;
                    
                    $game->save();
                }
            }
            
            for ($i = $playedGames; $i< 7; $i++)
            {
                
                $game=Game_WiiU::model()->findbyPk($this->games[$i]->gameId);
                if (isset($game))
                {
                    $game->delete();
                }
            }
            
            if ($player1>$player2)
            {
                $newMatch->winner1=1;
            }
            if ($player2>$player1)
            {
                $newMatch->winner1=2;
            }
            
            
            $newMatch->save();
            
            $transaction->commit();
            return true;
        }
        catch(Exception $e) // an exception is raised if a query fails
        {
        
            echo Yii::trace(CVarDumper::dumpAsString($e),'vardump');
            $transaction->rollback();
            throw new CHttpException(500, 'Something went wrong while processing this request. Please try again later');
        }
        
    }
    
    public function determineGameNumber($gamesArray)
    {

        $winCriterion = ceil(($this->gamesNr)/2);
        $gamesPlayed = ceil(($this->gamesNr)/2);
     
        do {
            $player1=0;
            $player2=0;
            for ($i=0; $i<$gamesPlayed; $i++)
            {

                if ($gamesArray[$i]->winner1 == 1)
                {
                    $player1++;
                }
                if ($gamesArray[$i]->winner1 == 2)
                {
                    $player2++;
                }
            }
        $matchesToWin = min($winCriterion-$player1, $winCriterion-$player2);
        $gamesLeft = $matchesToWin-($gamesPlayed-$player1-$player2);
        $gamesPlayed+=$gamesLeft;
        }
        while ($gamesLeft>0);
        return $gamesPlayed;
    }

}
