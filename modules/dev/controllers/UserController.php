<?php

class UserController extends Controller {
 
    public function actionCreate() {
        $model = new DevUser;
        $model->username = "OPX";
        $model->nip;
        
        if (isset($_POST['DevUser'])) {
            
            $model->attributes = $_POST['DevUser'];
            var_dump($model->attributes);
            die();
            
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }

        $this->renderForm('DevUser',  $model);
    }

}