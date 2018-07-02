<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!--引用资源-->
    <link href="/css/common.css" rel="stylesheet" />
    <script src="/jquery/jquery-2.1.1.min.js"></script>
    <script src="/bootstrap/bootstrap.js"></script>
    <link href="/bootstrap/bootstrap.min.css" rel="stylesheet" />
    <link href="/layer/skin/layer.css" rel="stylesheet" />
    <script src="/layer/layer.js"></script>
    <style type="text/css">
     .nav .nav-sidebar li a{
         height:50px;
         line-height:30px;
     }
     ..nav .nav-sidebar li .active a{
         height:50px;
         line-height:30px;
     }
    </style>
</head>
<body>
<?php $this->beginBody() ?>
     
    <!--左侧的菜单-->
    <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><?= $this->title; ?></a>
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
          <li id="onemenu"><a href="/manage/index">微信用户</a></li>
          <li id="twomenu"><a href="/advert/index">广告管理</a></li>
          <li id="teenthreemenu"><a href="/advertrecord/index">广告点击</a></li>
          <li id="teenfourmenu"><a href="/advertcount/index">广告统计</a></li>
          <li id="threemenu"><a href="/type/index">学科管理</a></li>
          <li id="fourmenu"><a href="/knowledge/index">知识点</a></li>
          <li id="sixmenu"><a href="/checktiku/index">选择题管理</a></li>          
          <li id="fivemenu"><a href="/testpaper/index">测试管理</a></li>
          <li id="sevenmenu"><a href="/todaychange/index">今日挑战</a></li>
          <li id="eightmenu"><a href="/tips/index">小窍门</a></li>
          <li id="ninemenu"><a href="/record/index">答题记录</a></li>
          <li id="teenmenu"><a href="/answerrecord/index">用户答题</a></li>
          <li id="teenonemenu"><a href="/changerecord/index">挑战记录</a></li>
          <li id="teenfivemenu"><a href="/shilianicon/index">试炼助手图标</a></li>
          <li id="teentwomenu"><a href="/shilian/index">试炼助手内容</a></li>
          <li id="teensevenmenu"><a href="/shilianrecord/index">试炼助手点击</a></li>
          <li id="teensixmenu"><a href="/shiliancount/index">试炼助手统计</a></li>
        </ul>
     </div>

    <!--右侧的内容-->
    <?= $content ?>

   </div>
</div>

<script type="text/javascript">
//页面的初始化函数
$(function(){
   //移除其他的选中的样式
   $(".nav .nav-sidebar li").each(function(){
      $(this).removeClass("active"); 
   })
})
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>