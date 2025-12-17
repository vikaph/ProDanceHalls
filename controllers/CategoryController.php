<?php

namespace app\controllers;

use app\models\Categories;
use app\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;

class CategoryController extends ActiveController
{
    public $modelClass = 'app\models\Categories';
}

