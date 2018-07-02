<?php
use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

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
        <li class="">
          <a href="<?=Url::to(['wxuser/index']);?>">微信用户</a>
        </li>
        <li class="active">
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
        <h3 class="page-header">测试记录</h3>
        <div class="col-md-12">
        <?php $form = ActiveForm::begin();?>
           <?=$form->field($model, 'name')->label('业务名称:')?>
           <?=$form->field($model, 'price')->label('业务价格:')?>
           <?=$form->field($model, 'bonus')->label('提成价格:')?>
           <?=$form->field($model, 'status')->dropDownList(['无效', '有效'])->label('是否有效:');?>
           <p>
              <?=Html::submitButton('保存', ['class' => 'btn btn-primary', 'name' => 'submit-button'])?>
              <?=Html::resetButton('重置', ['class' => 'btn btn-default', 'name' => 'submit-button'])?>
           </p>
        <?php ActiveForm::end();?>
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