<?php

class InputController extends Controller
{
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
            'actions'=>array('admin','view','myTourneys','viewTourney'),
            'users'=>array('*'),
            ),
            array('allow', // allow admin user to perform 'create', 'update' and 'delete' actions
                'actions'=>array('create','update','delete','addplayertotourney'),
                'roles'=>array('authenticated'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    
    public function actionAdmin() {
        $model =new Tournament('search');
        if(isset($_GET['Tournament']))
        {
            $model->attributes =$_GET['Tournament'];
            }
    
        $params =array(
            'model'=>$model,
        );
        
        if(!isset($_GET['ajax'])) $this->render('admin', $params);
        else  $this->renderPartial('admin', $params);
    }
    
    public function actionMyTourneys($userId) {
        $model =new Tournament('search');
        if(isset($_GET['Tournament']))
        {
            $model->attributes =$_GET['Tournament'];
            }
    
        $params =array(
            'model'=>$model,'userId'=>$userId
        );
        
        if(!isset($_GET['ajax'])) $this->render('usertourneys', $params);
        else  $this->renderPartial('usertourneys', $params);
    }
    
    public function actionViewTourney()
    {
        $data=null;
        if(isset($_GET['id'])&&$_GET['id']!=null)
        {
            $data=Tournament::model()->findByPk($_GET['id'][0]);
            $this->renderpartial('tourneyView',$data, false, true);
        }
        else
            $this->renderpartial('tourneyView',$data, false, true);
        
            
    }
    
    public function actionAddPlayerToTourney($id)
    {
        $playerModel=new Player('search');
        $playerModel->unsetAttributes();  // clear any default values
        if(isset($_GET['Player']))
            $playerModel->attributes=$_GET['Player'];
        
        
        
        $params =array(
            'model'=>$this->loadModel($id), 'playerModel' => $playerModel
        );
        $this->render('addptotourney', $params);
        
            
    }
    
    public function actionCreateTournamentPlayer()
    {
        $model=new TournamentPlayer;
    
        if(isset($_POST['TournamentPlayer']))
        {
            $model->attributes=$_POST['TournamentPlayer'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->tournamentId));
        }
    }
    
        /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $matchModel = new Match('search');
        $matchModel->unsetAttributes(); 
        if(isset($_GET['Match']))
            {
                $matchModel->attributes=$_GET['Match'];
            }
        $matchModel->tournamentId=$id; 
        
        $playerModel=new Player('search');
        $playerModel->unsetAttributes();  // clear any default values
        if(isset($_GET['Player']))
            $playerModel->attributes=$_GET['Player'];
        
        
        
        $params =array(
            'model'=>$this->loadModel($id),'matchModel'=>$matchModel, 'playerModel' => $playerModel
        );
        $this->render('view', $params);
    }
    
    public function actionCreate()
    {
        $model=new Tournament;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Tournament']))
        {
            $model->attributes=$_POST['Tournament'];
            if($model->saveWithOrganizer())
                $this->redirect(array('view','id'=>$model->tournamentId));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }
    
    public function actionDelete($id)
    {
        $tourney=Tournament::model()->findByPk($id);
        $params = array('Tournament'=>$tourney);
        
        if (!Yii::app()->user->checkAccess('deleteOwnTourney',$params) &&
                !Yii::app()->user->checkAccess('admin'))
            {
                throw new CHttpException(403, 'You are not authorized to perform this action');
            }
        
        if(isset($tourney))
        {
            $tourney->delete();
        }
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
    
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Tournament']))
        {
            $model->attributes=$_POST['Tournament'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->tournamentId));
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }
    
    public function loadModel($id)
    {
        $model=Tournament::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    
}