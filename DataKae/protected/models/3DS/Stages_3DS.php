<?php

/**
 * This is the model class for table "Stages".
 *
 * The followings are the available columns in table 'Stages':
 * @property integer $stageId
 * @property string $stageName
 *
 * The followings are the available model relations:
 * @property Stages[] $stages
 */
class Stages_3DS extends CActiveRecord
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
        return '3DS_Stages';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            return array(
                array('stageId, stageName', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'stageId' => 'StageId',
            'stageName' => 'Stage'
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

        $criteria->compare('stageId',$this->stageId);
        $criteria->compare('stageName',$this->stageName,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}