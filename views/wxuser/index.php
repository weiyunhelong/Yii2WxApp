<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '微信用户';
?>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><?=$this->title;?></a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
        <li>
            <?=
Html::beginForm(['/manage/logout'], 'post');
Html::submitButton(
    'Logout (' . Yii::$app->user->identity->username . ')',
    ['class' => 'btn btn-link logout']
);
echo "<button style='margin-top:7px' class='btn btn-primary'>退出</button>";
Html::endForm();
?>
        </li>
        </ul>
    </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="nav nav-sidebar">
        <li class="">
          <a href="<?=Url::to(['manage/index']);?>">大师管理</a>
        </li>
        <li class="">
          <a href="<?=Url::to(['subject/index']);?>">业务管理</a>
        </li>
        <li class="active">
          <a href="<?=Url::to(['wxuser/index']);?>">微信用户</a>
        </li>
        <li class="">
          <a href="<?=Url::to(['fate/index']);?>">测试记录</a>
        </li>
        <li class="">
          <a href="<?=Url::to(['friend/index']);?>">好友记录</a>
        </li>
        <li class="">
          <a href="<?=Url::to(['account/index']);?>">账户记录</a>
        </li>
      </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1 class="page-header">微信用户</h1>
        <div class="row placeholders">
        <?=GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        [
            'label' => 'OPENID',
            'attribute' => 'openid',
        ],
        [
            'label' => '微信昵称',
            'attribute' => 'wxname',
        ],
        [
            'label' => '微信头像',
            'attribute' => 'touxiang',  
            'format' => [
                'image', 
                 [
                   'width'=>'50',
                   'height'=>'50'
                 ]
               ],
               'value' => function ($model) { 
                   return $model->touxiang; 
               }
        ],
        [
            'label' => '微信性别',
            'attribute' => 'sex',
            'value' => function ($model) {
                if($model->sex==0){
                    return "未知";
                }else if($model->sex==1){
                    return "男";
                }else{
                    return "女";
                }
            },
        ],
        [
            'label' => '创建时间',
            'attribute' => 'createtime',
            'value' => function ($m) {
                return date("Y-m-d H:i:s", $m->createtime);
            },
        ]
    ],
])?>
        </div>
    </div>
    </div>
</div>


<style>
        /*
    * Base structure
    */

    /* Move down content because we have a fixed navbar that is 50px tall */
    body {
    padding-top: 50px;
    }


    /*
    * Global add-ons
    */

    .sub-header {
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
    }

    /*
    * Top navigation
    * Hide default border to remove 1px line.
    */
    .navbar-fixed-top {
    border: 0;
    }

    /*
    * Sidebar
    */

    /* Hide for mobile, show later */
    .sidebar {
    display: none;
    }
    @media (min-width: 768px) {
    .sidebar {
        position: fixed;
        top: 51px;
        bottom: 0;
        left: 0;
        z-index: 1000;
        display: block;
        padding: 20px;
        overflow-x: hidden;
        overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
        background-color: #f5f5f5;
        border-right: 1px solid #eee;
    }
    }

    /* Sidebar navigation */
    .nav-sidebar {
    margin-right: -21px; /* 20px padding + 1px border */
    margin-bottom: 20px;
    margin-left: -20px;
    }
    .nav-sidebar > li > a {
    padding-right: 20px;
    padding-left: 20px;
    }
    .nav-sidebar > .active > a,
    .nav-sidebar > .active > a:hover,
    .nav-sidebar > .active > a:focus {
    color: #fff;
    background-color: #428bca;
    }


    /*
    * Main content
    */

    .main {
    padding: 20px;
    }
    @media (min-width: 768px) {
    .main {
        padding-right: 40px;
        padding-left: 40px;
    }
    }
    .main .page-header {
    margin-top: 0;
    }


    /*
    * Placeholder dashboard ideas
    */

    .placeholders {
    margin-bottom: 30px;
    text-align: center;
    }
    .placeholders h4 {
    margin-bottom: 0;
    }
    .placeholder {
    margin-bottom: 20px;
    }
    .placeholder img {
    display: inline-block;
    border-radius: 50%;
    }
</style>