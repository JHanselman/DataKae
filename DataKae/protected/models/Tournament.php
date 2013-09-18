<?php

/**
 * This is the model class for table "Tournaments".
 *
 * The followings are the available columns in table 'Tournaments':
 * tournamentId serial
 * tournamentName character varying
 * locationId integer
 * startDate date
 * endDate date
 * rulesetId integer
 * financesId integer
 * totalEntrants integer
 * totalDuration interval
 */
class Tournament extends CActiveRecord
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
        return 'Tournaments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tournamentName, locationId, startDate, endDate, rulesetId', 'required'),
            array('tournamentName', 'length', 'max'=>128),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('tournamentName, locationId, startDate, endDate, rulesetId', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'tournamentName' => 'name',
            'locationId' => 'location',
            'startDate' => 'start date',
            'endDate' => 'end date',
            'rulesetId' => 'ruleset',
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

        $criteria->compare('tournamentId',$this->tournamentId);
        $criteria->compare('"tournamentName"',$this->tournamentName, true);
        $criteria->compare('locationId',$this->locationId);
        $criteria->compare('"startDate"',$this->startDate);
        $criteria->compare('endDate',$this->endDate);
        $criteria->compare('rulesetId',$this->rulesetId);
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
            'defaultOrder'=>'"startDate" DESC',
        ),
        'pagination'=>array(
            'pageSize'=>20
      ),
        ));
    }
}