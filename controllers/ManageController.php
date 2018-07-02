<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Master;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;


class ManageController extends Controller
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

    //大师管理
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect('/manage/login');
            Yii::$app->end();
        }
        $this->layout='@app/views/layouts/blank.php';
        $provider = new ActiveDataProvider([
            'query' => Master::find()->where(['status' => 1]),
            'sort' => ['defaultOrder' => ['createtime' => 'DESC']],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'provider' => $provider,
        ]);
    }
    

    //更新大师
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect('/manage/login');
            Yii::$app->end();
        }
        if($id==0){
          $item = new Master();  
        }else{
          $item = Master::findOne($id);  
        }      

        if (Yii::$app->request->isPost) {
            $item->load(\Yii::$app->request->post());
         //保存图片

             //调用uploadedfile模型中的getInstance方法  返回一个实例
             $file = UploadedFile::getInstance($item,'infoimg');
             //调用模型中的属性  返回上传文件的名称
             $name = $file->name;
             //拼装上传文件的路径
             $rootPath = "uploads/master";
             if (!file_exists($rootPath)) {
                mkdir($rootPath,true);
            }
            //调用模型类中的方法 保存图片到该路径
            $file->saveAs($rootPath . "/". $name);
            //为模型中的图片属性赋值
            $item->infoimg = "/". $rootPath ."/". $name;

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


    //删除大师管理
    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect('/manage/login');
            Yii::$app->end();
        }

        //逻辑删除大师
        Master::findOne($id)->delete(); 
        
        $this->layout='@app/views/layouts/blank.php';
        $provider = new ActiveDataProvider([
            'query' => Master::find()->where(['status' => 1]),
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
