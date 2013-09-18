<?php

class InputController extends Controller
{
    /*
    public function accessRules()
    {
    return array(
    
            array('allow',  // allow all users to perform 'index' and 'view' actions
            'actions'=>array('gridView','viewTourney','delete'),
            'users'=>array('*'),
            )
        );
    }
    */
    public function actionGridView() {
        $model =new Tournament('search');
        if(isset($_GET['Tournament']))
            $model->attributes =$_GET['Tournament'];
    
        $params =array(
            'model'=>$model,
        );
    
        if(!isset($_GET['ajax'])) $this->render('admin', $params);
        else  $this->renderPartial('admin', $params);
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
    
    public function actionDelete($id)
    {
        $tourney=Tournament::model()->findByPk($id);
        if(isset($tourney))
        {
            $tourney->delete();
        }
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('gridview'));
    }
    
}