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
    public $character_1;
    public $character_2;
    public $stageId;
    public $winner;
    
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            array('player_1, player_2, character_1, character_2, stageId, winner', 'required')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'rememberMe'=>'Remember me next time',
            'winner'=>''
        );
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function submitResults()
    {
        
        
        //$player1=User::model()->find('"userName"=:userName', array(':userName'=>$this->player_1));
        //$player2=User::model()->find('"userName"=:userName', array(':userName'=>$this->player_2));
        
        //$placing1;
        //$placing2;
        
        //if (isset($this->winner))
        //{
            //file_put_contents('E:/wamp/www/logo.txt',!isset($this->winner));
         //   if ($this->winner==1)
         //   {
         //       $placing1=1;
         //       $placing2=2;
         //   }
         //   else
         //   {
         //       $placing1=2;
         //       $placing2=1;
         //   }
       // }
       // else
       // {
            //throw error
       // }
        
        //$pp1=new PlayerSetParticipation;
        //$pp1->userId=18;
        //$pp1->characterId=1;
        //$pp1->placing=1;
        
        //$pp2=new PlayerSetParticipation;
        //$pp2->userId=19;
        //$pp2->characterId=7;
        //$pp2->placing=2;
        
        $set1=new Set;
        $set1->stageId=$this->stageId;
        //$set1->participants=$pp1;
        
        
        $newMatch=new Match;
        $newMatch->matchDate = date('Y-m-d H:i:s');
        $newMatch->matchType = '1v1';
        $newMatch->rulesetId = 1;
        $newMatch->sets=$set1;
        if($newMatch->withRelated->save(true,array('sets')))
        {
            return true;
        }
    }
    

}
