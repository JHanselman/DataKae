<?php

/**
 * This is the model class for table "Players".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $playerId
 * @property string $playerName
 * @property string $playerLastName
 * @property string $playerNickname
 * @property integer $locationId
 */
class Player extends CActiveRecord
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

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'Players';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('playerName, playerLastName, playerNickname, locationId', 'required'),
            array('playerName, playerLastName, playerNickname','length', 'max'=>128),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('playerId, playerName, playerLastName, playerNickname', 'safe', 'on'=>'search'),
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

        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'playerId' => 'ID',
            'playerName' => 'First Name',
            'playerLastName' => 'Last Name',
            'playerNickname' => 'PlayerTag',
            'locationId' => 'Location',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('"playerId"',$this->playerId);
        $criteria->compare('"playerName"',$this->playerName,true);
        $criteria->compare('"playerLastName"',$this->playerLastName,true);
        $criteria->compare('"playerNickname"',$this->playerNickname,true);
        $criteria->compare('"locationId"',$this->locationId,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    
    public function tourneyParticipantsWiiU($tournamentId, $not)
    {
        // This is probably ugly as hell.
        
        $criteria2=new CDbCriteria;
        
        if ($not)
        {
            $criteria2->join='LEFT OUTER JOIN "WiiU_Tournament_Players" ds on ds."playerId" = t."playerId"';
            $criteria2->condition = 'ds."tournamentId"=:tournamentId';
        }
        else
        {
           $criteria2->condition = 't."playerId" NOT IN 
        (SELECT "Players"."playerId"
        FROM "Players" LEFT OUTER JOIN "WiiU_Tournament_Players"
        ON "Players"."playerId" = "WiiU_Tournament_Players"."playerId"
        WHERE "WiiU_Tournament_Players"."tournamentId" = :tournamentId) 
        ';
        }
        
        $criteria2->params = array(':tournamentId' => $tournamentId);
        
        $criteria2->compare('"playerId"',$this->playerId);
        $criteria2->compare('"playerName"',$this->playerName,true);
        $criteria2->compare('"playerLastName"',$this->playerLastName,true);
        $criteria2->compare('"playerNickname"',$this->playerNickname,true);
        $criteria2->compare('"locationId"',$this->locationId,true);
        
return new CActiveDataProvider($this, array(
            'criteria'=>$criteria2,
        'pagination'=>array(
            'pageSize'=>20
      ),
        ));
    }
    
     public function tourneyParticipants3DS($tournamentId, $not)
    {
        // This is probably ugly as hell.
        
        $criteria2=new CDbCriteria;
        
        if ($not)
        {
            $criteria2->join='LEFT OUTER JOIN "3DS_Tournament_Players" ds on ds."playerId" = t."playerId"';
            $criteria2->condition = 'ds."tournamentId"=:tournamentId';
        }
        else
        {
           $criteria2->condition = 't."playerId" NOT IN 
        (SELECT "Players"."playerId"
        FROM "Players" LEFT OUTER JOIN "3DS_Tournament_Players"
        ON "Players"."playerId" = "3DS_Tournament_Players"."playerId"
        WHERE "3DS_Tournament_Players"."tournamentId" = :tournamentId) 
        ';
        }
        
        $criteria2->params = array(':tournamentId' => $tournamentId);
        
        $criteria2->compare('"playerId"',$this->playerId);
        $criteria2->compare('"playerName"',$this->playerName,true);
        $criteria2->compare('"playerLastName"',$this->playerLastName,true);
        $criteria2->compare('"playerNickname"',$this->playerNickname,true);
        $criteria2->compare('"locationId"',$this->locationId,true);
        
return new CActiveDataProvider($this, array(
            'criteria'=>$criteria2,
        'pagination'=>array(
            'pageSize'=>20
      ),
        ));
    }
}