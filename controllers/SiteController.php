<?php

namespace app\controllers;

use app\models\BookingFirstClass;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\DanceDirection;
use app\models\BookingHall;
use app\models\BookingLesson;
use app\models\Schedule;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
          $directions = DanceDirection::find()->all();

    return $this->render('index', [
        'directions' => $directions
    ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }


   public function actionPrice()
{
    return $this->render('price');
}

public function actionFirstClass()
{
    $model = new \app\models\BookingFirstClass();

    return $this->render('first-class', [
        'model' => $model,
    ]);
}

public function actionSaveFirstClass()
{
    $model = new \app\models\BookingFirstClass();

    if ($model->load(Yii::$app->request->post())) {

        $model->status = 'Новая';

        if ($model->save()) {

            Yii::$app->session->setFlash(
                'success',
                'Спасибо! Ваша заявка отправлена 💫 Мы свяжемся с вами в ближайшее время.'
            );

            return $this->redirect(['site/first-class']);
        }

    }

    Yii::$app->session->setFlash(
        'error',
        'Ошибка при отправке заявки. Попробуйте ещё раз.'
    );

    return $this->redirect(['site/first-class']);
}

public function actionCabinet()
{
    if (Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
    }

    $user = Yii::$app->user->identity;

    // занятия
    $lessonBookings = BookingLesson::find()
    ->alias('bl')
    ->joinWith('schedule s')
    ->where(['bl.user_id' => $user->id_user])
    ->andWhere(['>=', 's.lesson_date', date('Y-m-d')])
    ->all();

    $historyLessons = BookingLesson::find()
    ->alias('bl')
    ->joinWith('schedule s')
    ->where(['bl.user_id' => $user->id_user])
    ->andWhere(['<', 's.lesson_date', date('Y-m-d')])
    ->all();

    // брони залов
    $hallBookings = BookingHall::find()
        ->where(['user_id' => $user->id_user])
        ->all();

    return $this->render('cabinet', [
        'user' => $user,
        'lessonBookings' => $lessonBookings,
        'historyLessons' => $historyLessons,
        'hallBookings' => $hallBookings,
    ]);
}

public function actionDeleteHallBooking($id)
{
    $booking = BookingHall::findOne($id);

    if ($booking && $booking->user_id == Yii::$app->user->id) {

        $booking->delete();

        Yii::$app->session->setFlash(
            'success',
            'Бронирование отменено'
        );
    }

    return $this->redirect(['site/cabinet']);
}

public function actionDeleteLessonBooking($id)
{
    $booking = BookingLesson::findOne($id);

    if ($booking && $booking->user_id == Yii::$app->user->id) {

        $booking->delete();

       Yii::$app->session->setFlash('success', 'Запись на занятие отменена');
return $this->redirect(Yii::$app->request->referrer);
}

}


}
