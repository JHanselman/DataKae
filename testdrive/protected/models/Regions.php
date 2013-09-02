<?php

/**
 * This is the model class for table "Regions".
 *
 * The followings are the available columns in table 'Regions':
 * @property integer $regionId
 * @property string $regionName
 * @property string $regionCode
 *
 * The followings are the available model relations:
 * @property Users[] $users
 */
class Regions extends CActiveRecord
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
        return 'Regions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('regionName', 'length', 'max'=>50),
            array('regionCode', 'length', 'max'=>5),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('regionId, regionName, regionCode', 'safe', 'on'=>'search'),
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
            'users' => array(self::HAS_MANY, 'Users', 'region'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'regionId' => 'Region',
            'regionName' => 'Region Name',
            'regionCode' => 'Region Code',
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

        $criteria->compare('regionId',$this->regionId);
        $criteria->compare('regionName',$this->regionName,true);
        $criteria->compare('regionCode',$this->regionCode,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}