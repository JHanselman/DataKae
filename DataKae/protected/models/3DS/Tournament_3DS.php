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
class Tournament_3DS extends Tournament
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Regions the static model class
     */
     
    public function init()
    {
      //Yii::import("application.models.3DS.*");
    }

     
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '3DS_Tournaments';
    }

        public function findByOrganizer($userId)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        
        $criteria2=new CDbCriteria;

        Yii::trace($this->tournamentName);
        
        $criteria2->join='JOIN "3DS_Tournament_Organizers" ds on ds."tournamentId" = t."tournamentId"';
        $criteria2->condition = 'ds."userId"=:userId';
        $criteria2->params = array(':userId' => $userId);
        
       // $criteria2->compare('tournamentId',$this->tournamentId);
       $criteria2->compare('"tournamentName"',$this->tournamentName, true);
       // $criteria2->compare('locationId',$this->locationId);
       // $criteria2->compare('"startDate"',$this->startDate);
       // $criteria2->compare('endDate',$this->endDate);
       // $criteria2->compare('rulesetId',$this->rulesetId);
        
        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria2,
                    'sort'=>array(
                    'defaultOrder'=>'"startDate" DESC',
                ),
                'pagination'=>array(
                    'pageSize'=>20
              ),
                ));
        
    }
    
    public function saveWithOrganizer()
    {
        $connection = Yii::app()->db;
        
        $transaction=$connection->beginTransaction();
        try
        {
            $this->createdOn = date('Y-m-d H:i:s');
            $this->changedOn = date('Y-m-d H:i:s');
            
            $this->save();
            
            $TO=new TournamentOrganizers_3DS();
            $TO->userId=Yii::app()->user->getId();
            $TO->tournamentId=$this->tournamentId;
            $TO->save();
            
            $transaction->commit();
            return true;
        }
        catch(Exception $e) // an exception is raised if a query fails
        {
            $transaction->rollback();
            echo Yii::trace(CVarDumper::dumpAsString($this->tournamentId),'vardump');
        }
    }
    
    public function editTourney()
    {
        return "editOwn3DSTourney";
    }
}