<?php

namespace frontend\controllers;

class FileManagerController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
