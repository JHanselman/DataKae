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
    public $character1 = null;
    public $character2 = null;
    
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
            array('matchId, tournamentId, player1, player2, winner1, gamesNr, tournamentName, player_1, character1, character2', 'safe', 'on'=>'search'),
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
        'character1' => 'Character 1',
        'character2' => 'Character 2'
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
        
        
        $criteria->with = array('games');
        $criteria->together = true;
        
        
        $conditions = array();
        $params = array();
        
        if ($this->gamesNr)
        {
            $conditions[]='("t"."gamesNr"=:gamesNr)';
            $params[':gamesNr'] = $this->gamesNr;
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