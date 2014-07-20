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
class Match extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
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
            array('matchId, tournamentId, player1, player2, winner1', 'safe', 'on'=>'search'),
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
            'sets'=>array(self::HAS_ONE, 'Game', 'matchId'),
            'matchData'=>array(self::HAS_MANY, 'MatchData', 'matchId')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($tournamentId=false)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('"matchId"',$this->matchId);
        $criteria->compare('"roundId"',$this->roundId);        
        $criteria->compare('"tournamentId"',$this->tournamentId);
        $criteria->compare('"previousMatch"',$this->previousMatch,true);
        $criteria->compare('nextMatch',$this->nextMatch,true);
        $criteria->compare('"player1"',$this->player1);
        $criteria->compare('"player2"',$this->player2);
        $criteria->compare('"player3"',$this->player3,true);
        $criteria->compare('"player4"',$this->player4,true);
        $criteria->compare('"winner1"',$this->winner1);
        $criteria->compare('"winner2"',$this->winner2,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    

}