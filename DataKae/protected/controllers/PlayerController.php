<?php

class PlayerController extends Controller
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
                'actions'=>array('index','view','autocomplete'),
                'users'=>array('*'),
            ),
            array('allow', // allow TO and admin user to perform 'create' and 'update' actions
                'actions'=>array('create','update'),
                'roles'=>array('TO', 'admin'),
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
        $model = $this->loadModel($id);
        
        $characterUsageModel = new CharacterUsage;
        $characterUsageModel->player = $id;
        
        $stageUsageModel = new StageUsage;
        $stageUsageModel->player = $id;
        
        $vsLossesModel = new PlayerVsCharacterLosses;
        $vsLossesModel->player = $id;
        
        $this->render('view',array(
            'model'=>$this->loadModel($id),'characterUsage' => $characterUsageModel,'stageUsage' =>$stageUsageModel, 'vsLosses' => $vsLossesModel)
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new Player;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Player']))
        {
            $model->attributes=$_POST['Player'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->playerId));
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (!Yii::app()->user->checkAccess('updateSelf',$params) &&
                !Yii::app()->user->checkAccess('admin'))
            {
                throw new CHttpException(403, 'You are not authorized to perform this action');
            }
        if(isset($_POST['Player']))
        {
            $model->attributes=$_POST['Player'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->playerId));
        }

        $this->render('update',array(
            'model'=>$model,
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
        $dataProvider=new CActiveDataProvider('Player');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Player('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Player']))
            $model->attributes=$_GET['Player'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Player the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Player::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Player $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='player-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    public function actionAutocomplete() {

        if (isset($_GET['term'])) {
        $qtxt ="SELECT \"playerNickname\" FROM \"Players\" WHERE \"playerNickname\" LIKE :playerName";
        $command =Yii::app()->db->createCommand($qtxt);
        $command->bindValue(":playerName", '%'.$_GET['term'].'%', PDO::PARAM_STR);
        $res =$command->queryColumn();
        }

        echo CJSON::encode($res);
        Yii::app()->end();
    }
}
