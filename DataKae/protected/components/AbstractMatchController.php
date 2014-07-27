<?php

abstract class AbstractMatchController extends Controller
{

    
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function abstractView($id)
    {
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function abstractCreate($model)
    {
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST[get_class($model)]))
        {
            $model->attributes=$_POST[get_class($model)];
            if($model->save())
                $this->redirect(array('view','id'=>$model->matchId));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function abstractUpdate($id)
    {
        $model=$this->loadModel($id);
        $matchForm=$this->newSubmitResultsForm();
        
        $matchForm->matchId = $model->matchId;
        $matchForm->player_1 = Player::model()->findByPk($model->player1)->playerNickname;
        $matchForm->player_2 = Player::model()->findByPk($model->player2)->playerNickname;
        $matchForm->tournamentId = $model->tournamentId;
        $matchForm->gamesNr = $model->gamesNr;
        $matchForm->winner1 = $model->winner1;
        
        $gameForm=array();
        $dataProvider = $this->getGameModel()->getGamesByMatchId($id);
        
        foreach($dataProvider->data as $gameData ) 
        {
            $game =$this->newSubmitGamesForm();
            $game->gameId = $gameData->gameId;
            $game->character_1 = $gameData->characterPlayer1;
            $game->character_2 = $gameData->characterPlayer2;
            $game->stageId = $gameData->stageId;
            $game->gameNumber = $gameData->gameNumber;
            $game->winner1 = $gameData->winner1;
            $gameForm[] = $game;
        }
        for ($i=count($gameForm)-1; $i< 7;$i++)
            {
                $gameForm[] = $this->newSubmitGamesForm();
            }
        $matchForm->games = $gameForm;
        
        if(isset($_POST[$this->resultsFormModelName]))
            {
                $matchForm->attributes=$_POST[$this->resultsFormModelName];
                $updatedGames = array();
                
                for ($i=0; $i< 7;$i++)
                {
                    if(isset($_POST[$this->gamesFormModelName][$i]))
                    {
                        $game = $gameForm[$i];
                        $game->attributes = $_POST[$this->gamesFormModelName][$i]; 
                        $game->gameNumber = $i;
                        $updatedGames[] = $game;
                    }
                }
                $matchForm->games = $updatedGames;
                
                //Yii::trace(CVarDumper::dumpAsString($matchForm->games),'vardump');
                if($matchForm->updateResults())
                    $this->redirect(array('//'.$this->getGameName().'/input/view', 'id'=>$model->tournamentId));
            }
        //Yii::trace(serialize($gameForm[0]));
        
        $this->render('submitresults',array(
            'match'=>$matchForm
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function abstractDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function abstractIndex($model)
    {
        $dataProvider=new CActiveDataProvider(get_class($model));
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function abstractAdmin($model)
    {
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET[get_class($model)]))
            $model->attributes=$_GET[get_class($model)];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    public function abstractSubmitresults($id)
    {
        $matchForm=$this->newSubmitResultsForm();
        $matchForm->tournamentId = $id;
        $gameForm=array();
        
        //If information is submitted
        if(!empty($_POST[$this->resultsFormModelName]))
        {
            $matchForm->setAttributes($_POST[$this->resultsFormModelName]);
            
            //Set all of the data of the form
            foreach($_POST[$this->gamesFormModelName] as $i => $gameData)
            {
                $game = $this->newSubmitGamesForm();
                $game->setAttributes($gameData);
                $game->gameNumber=$i;
                $gameForm[] = $game;
            }
            $matchForm->games=$gameForm;
            $matchForm->tournamentId=$id;
            //Let the form check if everything's correct and submit the results if that's the case.
            if ($matchForm->submitResults())
                $this->redirect(array('//'.$this->getGameName().'/input/view', 'id'=>$id));
        }
        //Otherwise you return the normal page with only one set added to the form and you render the page.
        else
            for ($i=0; $i< 7;$i++)
            {
                $gameForm[] = $this->newSubmitGamesForm();
            }
        $matchForm->games = $gameForm;
        $this->render('submitresults', array('match' => $matchForm
        ));
    }
    
    public function abstractSearch($model)
    {
       
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET[get_class($model)]))
            $model->attributes=$_GET[get_class($model)];

        $this->render('search',array(
            'model'=>$model,
        ));
    }


    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='match-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    public function actionAutocomplete() {

        if (isset($_GET['term'])) {
        $qtxt ="SELECT \"userName\" FROM \"Users\" WHERE \"userName\" LIKE :username";
        $command =Yii::app()->db->createCommand($qtxt);
        $command->bindValue(":username", '%'.$_GET['term'].'%', PDO::PARAM_STR);
        $res =$command->queryColumn();
        }

        echo CJSON::encode($res);
        Yii::app()->end();
    }
    
    abstract protected function newSubmitResultsForm();
    abstract protected function newSubmitGamesForm();
    abstract protected function getGameModel();
    abstract protected function getGameName();

}
