<?php

/**
 * This is the model class for table "Locations".
 *
 * The followings are the available columns in table 'Locations':
 * @property integer $locationId
 * @property string $locationName
 * @property string $locationCode
 *
 * The followings are the available model relations:
 * @property Users[] $users
 */
class SearchForm_3DS extends SearchForm
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
        return '3DS_Matches';
    }

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'games'=>array(self::HAS_MANY, 'Game_3DS', 'matchId')
        );
    }
}