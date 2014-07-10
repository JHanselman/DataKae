<?php

class MatchResultsController extends Controller
{
    //Redirects to the submit match results form
    public function actionSubmitresults($id)
    {
        $matchForm=new SubmitResultsForm;
        $gameForm=array();
        
        //If information is submitted
        if(!empty($_POST['SubmitResultsForm']))
        {
            $matchForm->setAttributes($_POST['SubmitResultsForm']);
            
            //Set all of the data of the form
            foreach($_POST['SubmitGamesForm'] as $i => $gameData)
            {
                $game = new SubmitGamesForm;
                $game->setAttributes($gameData);
                $game->gameNumber=$i;
                $gameForm[] = $game;
            }
            $matchForm->games=$gameForm;
            $matchForm->tournamentId=$id;
            //Let the form check if everything's correct and submit the results if that's the case.
            $matchForm->submitResults();
            
            //change this
            //$this->redirect(array("site/index"));
        }
        //Otherwise you return the normal page with only one set added to the form and you render the page.
        else
            $gameForm[] = new SubmitGamesForm;
        $this->render('submitresults', array('match' => $matchForm,
                'games' => $gameForm,
        ));
    }
    
    //Adds a new set to the form and renders that part
    public function actionAddGame($index)
    {
        $game = new SubmitGamesForm();
        $charCriteria = new CDbCriteria(array('select'=>('"characterId","characterName"'),'order'=>'"characterName" ASC'));
        $stageCriteria = new CDbCriteria(array('select'=>('"stageId","stageName"'),'order'=>'"stageName" ASC'));
        $this->renderPartial('_gameResults', array(
            'model' => $game,
            'index' => $index,
            'characters' => $characters=Characters::model()->findAll($charCriteria),
            'stages' => $stages=Stages::model()->findAll($stageCriteria)
        ));
    }
    
}