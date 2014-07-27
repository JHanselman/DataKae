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
class Game_WiiU extends Game
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
        return 'WiiU_Games';
    }


}