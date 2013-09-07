<?php

class MatchResultsController extends Controller
{
    //Redirects to the submit match results form
    public function actionSubmitresults()
    {
        $matchForm=new SubmitResultsForm;
        $setForm=array();
        
        //If information is submitted
        if(!empty($_POST['SubmitResultsForm']))
        {
            $matchForm->setAttributes($_POST['SubmitResultsForm']);
            
            //Set all of the data of the form
            foreach($_POST['SubmitSetsForm'] as $setData)
            {
                $set = new SubmitSetsForm;
                $set->setAttributes($setData);
                $setForm[] = $set;
            }
            $matchForm->sets=$setForm;
            
            //Let the form check if everything's correct and submit the results if that's the case.
            $matchForm->submitResults();
            
            //change this
            //$this->redirect(array("site/index"));
        }
        //Otherwise you return the normal page with only one set added to the form and you render the page.
        else
            $setForm[] = new SubmitSetsForm;
        $this->render('submitresults', array('match' => $matchForm,
                'sets' => $setForm,
        ));
    }
    
    //Adds a new set to the form and renders that part
    public function actionAddSet($index)
    {
        $set = new SubmitSetsForm();
        $charCriteria = new CDbCriteria(array('select'=>('"characterId","characterName"'),'order'=>'"characterName" ASC'));
        $stageCriteria = new CDbCriteria(array('select'=>('"stageId","stageName"'),'order'=>'"stageName" ASC'));
        $this->renderPartial('_setResults', array(
            'model' => $set,
            'index' => $index,
            'characters' => $characters=Characters::model()->findAll($charCriteria),
            'stages' => $stages=Stages::model()->findAll($stageCriteria)
        ));
    }
    
}