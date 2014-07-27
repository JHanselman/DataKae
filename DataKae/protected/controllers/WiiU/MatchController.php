<?php

class MatchController extends AbstractMatchController
{
    public $resultsFormModelName ='SubmitResultsForm_WiiU';
    public $gamesFormModelName ='SubmitGamesForm_WiiU';
    public function init()
    {
      Yii::import("application.models.WiiU.*");
    }

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
        $this->abstractView($id);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new Match_WiiU;
        abstractCreate($model);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $this->abstractUpdate($id);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->abstractDelete($id);
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new Match_WiiU;
        $this->abstractIndex($model);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Match_WiiU('search');
        $this->abstractAdmin($model);
    }

    public function actionSubmitresults($id)
    {
        $this->abstractSubmitresults($id);
    }
    
    public function actionSearch()
    {
        $model=new searchForm_WiiU('search');
        $this->abstractSearch($model);
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
        $model=Match_WiiU::model()->findByPk($id);
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
    function newSubmitResultsForm()
    {
        return new SubmitResultsForm_WiiU();
    }
    function newSubmitGamesForm()
        {
        return new SubmitGamesForm_WiiU();
    }
    function getGameModel()
        {
        return Game_WiiU::model();
    }
        function getGameName()
        {
        return 'WiiU';
    }
}
