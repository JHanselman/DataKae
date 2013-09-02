<?php

class MatchResultsController extends Controller
{
    
    public function actionSubmitresults()
    {
        $matchForm=new SubmitResultsForm;
        $setForm=array();
        
        if(!empty($_POST['SubmitResultsForm']))
        {
            $matchForm->setAttributes($_POST['SubmitResultsForm']);
            foreach($_POST['SubmitSetsForm'] as $setData)
            {
                $set = new SubmitSetsForm;
                $set->setAttributes($setData);
                $setForm[] = $set;
            }
            $matchForm->sets=$setForm;
            $matchForm->submitResults();
            
            //change this
            //$this->redirect(array("site/index"));
        }
        else
            $setForm[] = new SubmitSetsForm;
        $this->render('submitresults', array('match' => $matchForm,
                'sets' => $setForm,
        ));
    }
    
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