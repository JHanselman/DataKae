<?php

class MatchController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/main';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view','autocomplete','search'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update', 'addgame', 'submitresults'),
                'roles'=>array('TO','admin'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'roles'=>array('admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new Match;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Match']))
        {
            $model->attributes=$_POST['Match'];
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
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);
        $matchForm=new SubmitResultsForm;
        
        $matchForm->matchId = $model->matchId;
        $matchForm->player_1 = Player::model()->findByPk($model->player1)->playerNickname;
        $matchForm->player_2 = Player::model()->findByPk($model->player2)->playerNickname;
        $matchForm->tournamentId = $model->tournamentId;
        $matchForm->gamesNr = $model->gamesNr;
        $matchForm->winner1 = $model->winner1;
        
        $gameForm=array();
        $dataProvider = Game::model()->getGamesByMatchId($id);
        
        foreach($dataProvider->data as $gameData ) 
        {
            $game = new SubmitGamesForm;
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
                $gameForm[] = new SubmitGamesForm;
            }
        $matchForm->games = $gameForm;
        
        if(isset($_POST['SubmitResultsForm']))
            {
                $matchForm->attributes=$_POST['SubmitResultsForm'];
                $updatedGames = array();
                
                for ($i=0; $i< 7;$i++)
                {
                    if(isset($_POST['SubmitGamesForm'][$i]))
                    {
                        $game = $gameForm[$i];
                        $game->attributes = $_POST['SubmitGamesForm'][$i]; 
                        $game->gameNumber = $i;
                        $updatedGames[] = $game;
                    }
                }
                $matchForm->games = $updatedGames;
                
                //Yii::trace(CVarDumper::dumpAsString($matchForm->games),'vardump');
                if($matchForm->updateResults())
                    $this->redirect(array('//input/view', 'id'=>$model->tournamentId));
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
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('Match');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Match('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Match']))
            $model->attributes=$_GET['Match'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    public function actionSubmitresults($id)
    {
        $matchForm=new SubmitResultsForm;
        $matchForm->tournamentId = $id;
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
            if ($matchForm->submitResults())
                $this->redirect(array('//input/view', 'id'=>$id));
        }
        //Otherwise you return the normal page with only one set added to the form and you render the page.
        else
            for ($i=0; $i< 7;$i++)
            {
                $gameForm[] = new SubmitGamesForm;
            }
        $matchForm->games = $gameForm;
        $this->render('submitresults', array('match' => $matchForm
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
    
    public function actionSearch()
    {
        $model=new searchForm('search');
        
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['SearchForm']))
            $model->attributes=$_GET['SearchForm'];

        $this->render('search',array(
            'model'=>$model,
        ));
    }
    
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Match::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
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
    
}
