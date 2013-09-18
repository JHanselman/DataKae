<?php

/**
 * This is the model class for table "Rulesets".
 *
 * The followings are the available columns in table 'Locations':
  "rulesetId" serial NOT NULL,
  "rulesetName" character varying NOT NULL,
  "matchType" character varying NOT NULL DEFAULT '1v1'::character varying,
  "matchMode" character varying NOT NULL DEFAULT 'Stocks'::character varying,
  "numberStocks" integer NOT NULL DEFAULT 4,
  "numberTimer" interval NOT NULL DEFAULT '00:08:00'::interval,
  "itemRate" character varying NOT NULL DEFAULT 'None'::character varying,
  "specialRules" character varying,
 * The followings are the available model relations:
 * @property Users[] $users
 */
class Ruleset extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Regions the static model class
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
        return 'Rulesets';
    }


    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'users' => array(self::HAS_MANY, 'Users', 'location'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'rulesetId' => 'Ruleset Id',
            'rulesetName' => 'Ruleset Name',
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

        $criteria->compare('rulesetId',$this->rulesetId);
        $criteria->compare('rulesetName',$this->rulesetName,true);
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}