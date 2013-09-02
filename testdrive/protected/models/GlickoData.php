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
class GlickoData extends CActiveRecord
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
        return 'GlickoData';
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
            array('glickoId, rating, userID, RD, volatility matchType', 'safe', 'on'=>'search'),
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
            'user'=>array(self::BELONGS_TO, 'User', 'userId')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'glickoId' => 'glickoId',
            'rating' => 'Rating',
            'RD' => 'RD',
            'volatility' => 'volatility',
            'userId' => 'userId',
            'matchType' => 'matchType',
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

        $criteria->compare('glickoId',$this->userId);
        $criteria->compare('rating',$this->rating,true);
        $criteria->compare('RD',$this->RD,true);
        $criteria->compare('volatility',$this->volatility,true);
        $criteria->compare('userId',$this->userId,true);
        $criteria->compare('matchType',$this->matchType,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}