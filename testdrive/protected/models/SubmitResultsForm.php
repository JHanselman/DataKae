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
    public $sets;
    
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
        $player1=User::model()->find('"userName"=:userName', array(':userName'=>$this->player_1));
        $player2=User::model()->find('"userName"=:userName', array(':userName'=>$this->player_2));
        
        $connection = Yii::app()->db;
        
        $transaction=$connection->beginTransaction();
        try
        {
            $newMatch=new Match;
            $newMatch->matchDate = date('Y-m-d H:i:s');
            $newMatch->matchType = '1v1';
            $newMatch->rulesetId = 1;
            $newMatch->save();
            
            foreach($this->sets as $setData)
            {
                $set=new Set;
                $set->stageId=$setData->stageId;
                $set->matchId=$newMatch->matchId;
                $set->save();
                
                $placing1;
                $placing2;
                
                if ($setData->winner==1)
                {
                    $placing1=1;
                    $placing2=2;
                }
                else
                {
                    $placing1=2;
                    $placing2=1;
                }
                    
                $pp1=new PlayerSetParticipation;
                $pp1->userId=$player1->userId;
                $pp1->characterId=$setData->character_1;
                $pp1->placing=$placing1;
                $pp1->setId=$set->setId;
                $pp1->save();
                
                $pp2=new PlayerSetParticipation;
                $pp2->userId=$player2->userId;
                $pp2->characterId=$setData->character_2;
                $pp2->placing=$placing2;
                $pp2->setId=$set->setId;
                $pp2->save();
            }
            
            $transaction->commit();
            return true;
        }
        catch(Exception $e) // an exception is raised if a query fails
        {
            $transaction->rollback();
        }
        
    }
    

}
