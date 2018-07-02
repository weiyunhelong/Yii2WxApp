<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Subject;
use yii\data\ActiveDataProvider;

class SubjectController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
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
        if (Yii::$app->user->isGuest) {
            $this->redirect('/manage/login');
            Yii::$app->end();
        }
        $this->layout='@app/views/layouts/blank.php';
        $provider = new ActiveDataProvider([
            'query' => Subject::find()->where(['status'=>1]),
            'sort' => ['defaultOrder' => ['createtime' => 'DESC']],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'provider' => $provider,
        ]);
    }


    //编辑页面
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect('/manage/login');
            Yii::$app->end();
        }
        
        if($id==0){
            $item =new Subject();  
        }else{
            $item = Subject::findOne($id);  
        }

        if (Yii::$app->request->isPost) {
            $item->load(\Yii::$app->request->post());
         
            $item->createtime = time();
            if ($item->validate()) {
                $item->save();
                return $this->redirect(['index']);
            } else {
                $errors = $item->errors;
            }
        }

        $this->layout='@app/views/layouts/blank.php';

        return $this->render('update', [
            'model' => $item
        ]);
    }
    
    //删除页面
    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect('/manage/login');
            Yii::$app->end();
        }
        //删除业务
        Subject::findOne($id)->delete(); 
        
        $this->layout='@app/views/layouts/blank.php';
        $provider = new ActiveDataProvider([
            'query' => Subject::find()->where(['status' => 1]),
            'sort' => ['defaultOrder' => ['createtime' => 'DESC']],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'provider' => $provider,
        ]);   
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout='@app/views/layouts/blank.php';
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

}
