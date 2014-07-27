<?php

abstract class AbstractInputController extends Controller
{
    
    
    public function abstractIndex($model)
    {
        if(isset($_GET[get_class($model)]))
        {
            $model->attributes =$_GET[get_class($model)];
            }
    
        $params =array(
            'model'=>$model,
        );
        
        if(!isset($_GET['ajax'])) $this->render('admin', $params);
        else  $this->renderPartial('admin', $params);
    }
    
    
    public function abstractMyTourneys($userId,$model) {
        
        if(isset($_GET[get_class($model)]))
        {
            $model->attributes =$_GET[get_class($model)];
            }
    
        $params =array(
            'model'=>$model,'userId'=>$userId
        );
        
        if(!isset($_GET['ajax'])) $this->render('usertourneys', $params);
        else  $this->renderPartial('usertourneys', $params);
    }
    
    public function abstractViewTourney($model)
    {
        $data=null;
        if(isset($_GET['id'])&&$_GET['id']!=null)
        {
            $data=$this->loadModel($_GET['id'][0]);
            $this->renderpartial('tourneyView',$data, false, true);
        }
        else
            $this->renderpartial('tourneyView',$data, false, true);
        
            
    }
    
    public function abstractAddPlayerToTourney($id, $model)
    {
        
        
        $playerModel=new Player('search');
        $playerModel->unsetAttributes();  // clear any default values
        if(isset($_GET['Player']))
            $playerModel->attributes=$_GET['Player'];
        
        if(isset($_POST[get_class($model)][0]))
        {
            
            $model->playerId=$_POST[get_class($model)][0];
            $model->tournamentId=$id;
            if($model->save())
                $this->redirect(array('view','id'=>$id));
        }
        
        //Yii::trace(CVarDumper::dumpAsString($_POST['data']),'vardump');
        $params =array(
            'model'=>$this->loadModel($id), 'playerModel' => $playerModel
        );
        $this->render('addptotourney', $params);
        
            
    }
    
    public function abstractRemovePlayerFromTourney($id, $model)
    {
        if(isset($_POST[get_class($model)][0]))
        {           
            $model->deleteIt($id, $_POST[get_class($model)][0]);
        }
    }
    
        /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function abstractView($id, $matchModel)
    {
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
    
    public function abstractCreate($model)
    {
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST[get_class($model)]))
        {
            $model->attributes=$_POST[get_class($model)];
            if($model->saveWithOrganizer())
                $this->redirect(array('view','id'=>$model->tournamentId));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }
    
    public function abstractDelete($id)
    {
        $tourney=$this->loadModel($id);
        $params = array(get_class($tourney)=>$tourney);
        
        if (!Yii::app()->user->checkAccess($model->editTourney(),$params) &&
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
    
    public function abstractUpdate($id)
    {
        $model=$this->loadModel($id);
        $params = array('Tournament'=>$model);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        
        if (!Yii::app()->user->checkAccess($model->editTourney(),$params) &&
                !Yii::app()->user->checkAccess('admin'))
            {
                throw new CHttpException(403, 'You are not authorized to perform this action');
            }
        
        
        if(isset($_POST[get_class($model)]))
        {
            $model->attributes=$_POST[get_class($model)];
            if($model->save())
                $this->redirect(array('view','id'=>$model->tournamentId));
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }
    
    abstract function loadModel($id);
    
}