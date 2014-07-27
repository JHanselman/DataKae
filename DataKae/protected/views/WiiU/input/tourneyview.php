
<div class="TourneyView">
<?php
    $tournamentName='Unkown';
    $startDate='Unkown';
    $endDate='Unkown';
    $locationregion='Unkown';
    $rulesetName='Unkown';
    $totalEntrants='Unkown';
    $totalDuration='Unkown';
    
    
if ($data!=null)
{
    $tournamentName=$data->tournamentName;
    $startDate=$data->startDate;
    $endDate=$data->endDate;
    if (isset($data->locationId))
    {
        $location=Location::model()->findByPk($data->locationId);
        $locationregion=$location->locationName.', '.$location->regionCode;
    }
    if (isset($data->rulesetId))
    {
        $ruleset=Ruleset::model()->findByPk($data->rulesetId);
        $rulesetName=$ruleset->rulesetName;
    }
    $totalEntrants=$data->totalEntrants;
    $totalDuration=$data->totalDuration;
}


?>
<table>
    <tbody>
        <tr>
            <td>
                Tournament Name:
            </td>
            <td>
                <?php 
                    echo $tournamentName ?> <br>
            </td>
        </tr>
        <tr>
            <td>
                Start Date:
            </td>
            <td>
                <?php echo $startDate ?> <br>
            </td>
        </tr>
        <tr>
            <td>
                End Date:
            </td>
            <td>
                <?php echo $endDate ?> <br>
            </td>
        </tr>
        <tr>
            <td>
                Location:
            </td>
            <td>
                <?php echo $locationregion ?> <br>
            </td>
        </tr>
        <tr>
            <td>
                Ruleset:
            </td>
            <td>
                <?php echo $rulesetName ?> <br>
            </td>
        </tr>
        <tr>
            <td>
                Total Entrants:
            </td>
            <td>
                <?php echo $totalEntrants; ?> <br>
            </td>
        </tr>
        <tr>
            <td>        
                Total Duration:
            </td>
            <td>
                <?php echo $totalDuration; ?> <br>
            </td>
        </tr>
    </tbody>
</table>

<?php
if (Yii::app()->user->checkAccess('TO')||Yii::app()->user->checkAccess('admin'))
    {
        echo CHtml::button('Create', array('submit'=>array('create')));
    }
if ($data!=null)
{
    echo CHtml::link('View', array('view','id'=>$data->tournamentId));
    if (Yii::app()->user->checkAccess('editOwnWiiUTourney',array('Tournament'=>$data))||Yii::app()->user->checkAccess('admin'))
    {
        echo CHtml::button('Update', array('submit'=>array('update','id'=>$data->tournamentId)));
        echo CHtml::button('Delete', array('submit'=>array('delete','id'=>$data->tournamentId),'confirm'=>'Are you sure you want to delete this item?'));
    }
    
    
 }
 ?>
</div>