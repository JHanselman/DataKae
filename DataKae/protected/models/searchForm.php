<?php

/**
 * This is the model class for table "Match".
 *
 * The followings are the available columns in table 'Match':
   matchId integer,
   tournamentId integer,
   roundId integer,
   previousMatch integer,
   nextMatch  integer,
   player1 integer,
   player2 integer,
   player3 integer,
   player4 integer,
   winner1 integer, 
   winner2 integer
 */
class SearchForm extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
     
    public $tournamentName = null;
    public $player_1 = null;
    public $player_2 = null;
    public $character1 = null;
    public $character2 = null;
    public $stageId = null;
    
    public $before = null;
    public $after = null;
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
    return array(
        'withRelated'=>array(
            'class'=>'ext.wr.WithRelatedBehavior',
        ),
    );
    }
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'Matches';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('userName, passwordHash, emailAddress', 'required'),
            //array('userName, passwordHash, emailAddress', 'length', 'max'=>128),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('matchId, tournamentId, player1, player2, winner1, gamesNr, tournamentName, player_1, player_2, character1, character2, stageId, before', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'games'=>array(self::HAS_MANY, 'Game', 'matchId')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
        'player_1' => 'Player 1',
        'player_2' => 'Player 2',
        'character1' => 'Character 1',
        'character2' => 'Character 2',
        'stageId' => 'Stage',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */

    
    public function specialSearch()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
        
        $criteria->with = array('games' =>array('select'=> false));
        $criteria->together = true;
        
        $conditions = array();
        $params = array();
        
        if ($this->player_1)
        {
            $p1=Player::model()->find('"playerNickname"=:playerNickname', array(':playerNickname'=>$this->player_1));
            $conditions[]='("t"."player1"=:player_1 OR "t"."player2"=:player_1)';
            $params[':player_1'] = $p1->playerId; 
        }
        
        if ($this->player_2)
        {
            $p2=Player::model()->find('"playerNickname"=:playerNickname', array(':playerNickname'=>$this->player_2));
            $conditions[]='("t"."player1"=:player_2 OR "t"."player2"=:player_2)';
            $params[':player_2'] = $p2->playerId; 
        }
        
        if ($this->gamesNr)
        {
            $conditions[]='("t"."gamesNr"=:gamesNr)';
            $params[':gamesNr'] = $this->gamesNr;
        }
        
        if ($this->stageId)
        {
            $conditions[]='("games"."stageId"=:stageId)';
            $params[':stageId'] = $this->stageId;
        }
        
        if ($this->character1)
        {
            $conditions[]='("games"."characterPlayer1"=:character1 OR "games"."characterPlayer2"=:character1)';
            $params[':character1'] = $this->character1;
        }
        
        if ($this->character2)
        {
            $conditions[]='("games"."characterPlayer1"=:character2 OR "games"."characterPlayer2"=:character2)';
            $params[':character2'] = $this->character2;
        }
        
        if ($this->before)
        {
            $conditions[]='("t"."tournamentId" IN (SELECT "tournamentId" FROM "Tournaments" WHERE "startDate"<:before))';
            $params[':before'] = $this->before;
        }        
        if ($this->after)
        {
            $conditions[]='("t"."tournamentId" IN (SELECT "tournamentId" FROM "Tournaments" WHERE "endDate">:after))';
            $params[':after'] = $this->after;
        }
        
        $criteria->condition = implode(' AND ',$conditions);
        $criteria->params = $params;
        
        $criteria->order = '"createdOn" DESC';
        
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
            'pageSize'=>20
      )
        ));
    }
    

}