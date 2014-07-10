<?php

/**
 * This is the model class for table "Users".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 */
class TournamentPlayers extends CActiveRecord
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
        return 'TournamentPlayers';
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
            //array('id, userName, passwordHash, emailAddress', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
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
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('tournamentId',$this->tournamentId, true);
        $criteria->compare('playerId',$this->playerId,true);
        $criteria->compare('placing',$this->placing, true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    
    public function OwnTourney($tourneyId,$userId)
    {
        $criteria=new CDBCriteria;
        $criteria->condition = '"userId"=:userId AND "tournamentId"=:tournamentId';
        return (new CActiveDataProvider($this, array('criteria'=>$criteria,)).itemCount()>0);
    }
}