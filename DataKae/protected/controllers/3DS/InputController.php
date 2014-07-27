<?php

class InputController extends AbstractInputController
{
    public function init()
    {
      Yii::import("application.models.3DS.*");
    }
    
    
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
    
    public function accessRules()
    {
    return array(
    
            array('allow',  // allow all users to perform 'admin','myTourneys' and 'viewTourney' actions
            'actions'=>array('index','view','viewTourney'),
            'users'=>array('*'),
            ),
            array('allow', // allow admin and TO user to perform 'create', 'update' and 'delete' actions
                'actions'=>array('create','myTourneys','update','delete','addplayertotourney','removeplayerfromtourney'),
                'roles'=>array('TO','admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    
    public function actionIndex() {
        $model =new Tournament_3DS('search');
        $this->abstractIndex($model);
    }
    
    public function actionMyTourneys($userId) {
        $model =new Tournament_3DS('search');
        $this->abstractMyTourneys($userId,$model);
    }
    
    public function actionViewTourney()
    {
        $model =new Tournament_3DS();
        $this->abstractViewTourney($model);
    }
    
    public function actionAddPlayerToTourney($id)
    {
        $model=new TournamentPlayers_3DS();
        $this->abstractAddPlayerToTourney($id, $model);
    }
    
    public function actionRemovePlayerFromTourney($id)
    {
        $model = TournamentPlayers_3DS::model();
        $this->abstractRemovePlayerFromTourney($id, $model);
    }
    
        /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $matchModel = new Match_3DS('search');
        $this->abstractView($id, $matchModel);
    }
    
    public function actionCreate()
    {
        $model=new Tournament_3DS;

        $this->abstractCreate($model);
    }
    
    public function actionDelete($id)
    {
        $this->abstractDelete($id);
    }
    
    public function actionUpdate($id)
    {
        $this->abstractUpdate($id);
    }
    
    public function loadModel($id)
    {
        $model=Tournament_3DS::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    
}