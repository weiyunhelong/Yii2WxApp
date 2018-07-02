<?php

namespace app\controllers;

use abei2017\wx\Application;
use app\models\Friend;
use app\models\Subject;
use app\models\TestFate;
use app\models\WechatUser;
use Yii;
use yii\httpclient\Client;
use yii\web\Response;

class ApiController extends \yii\web\Controller
{

    public function init()
    {
        // 返回数据格式为 json
        Yii::$app->response->format = Response::FORMAT_JSON;
        // 关闭 csrf 验证
        $this->enableCsrfValidation = false;
    }

    // 小程序授权
    public function actionLogin()
    {
        $code = Yii::$app->request->post('code', '');
        $sex = Yii::$app->request->post('sex', '');
        $avatar = Yii::$app->request->post('touxiang', '');
        $wxname = Yii::$app->request->post('wxName', '');

        if (!$code) {
            return ['status' => 'fail', 'message' => 'code 不能为空'];
        }

        if (!$sex) {
            return ['status' => 'fail', 'message' => 'sex 不能为空'];
        }

        if (!$avatar) {
            return ['status' => 'fail', 'message' => 'touxiang 不能为空'];
        }

        if (!$wxname) {
            return ['status' => 'fail', 'message' => 'wxname 不能为空'];
        }

        $data = $this->wechatAuth($code);
        if (isset($data['openid']) && isset($data['session_key'])) {
            $openid = $data['openid'];
            if ($model = WechatUser::findOne(['openid' => $openid])) {
            } else {
                $model = new WechatUser();
                $model->created_at = time();
            }
            $model->sex = $sex;
            $model->touxiang = $avatar;
            $model->wxname = $wxname;
            $model->openid = $openid;
            $model->createtime = time();
            if (!$model->validate()) {
                $errors = current($model->getErrors());
                return ['status' => 'fail', 'message' => $errors[0]];
            }
            $model->save();
            $uid = $model->id;
            return ['status' => 'success', 'openID' => $openid, 'uid' => $uid];
        } else {
            $errmsg = isset($data['errmsg']) ? $data['errmsg'] : '授权出错';
            return ['status' => 'fail', 'message' => $errmsg];
        }
    }

    //新增朋友关系
    public function actionAddfriend()
    {
        $item = new Friend();
        $uid = Yii::$app->request->post('uid'); // 用户id
        if (!$uid) {
            return ['status' => 'fail', 'message' => 'uid 不能为空'];
        }
        $fid = Yii::$app->request->post('fid'); // 朋友id
        if (!$fid) {
            return ['status' => 'fail', 'message' => 'fid 不能为空'];
        }
        $item->uid = $uid;
        $item->fid = $fid;
        $item->createtime = time();
        $model->save();

        return ['status' => 'success', 'message' => '保存朋友关系成功'];
    }

    //得到Tab部分
    public function actionGetsubject()
    {

        $datalist = Subject::find()->where(['status' => 1])->all();

        foreach ($datalist as $key => $item) {
            $data[$key]['id'] = $item->id;
            $data[$key]['name'] = $item->name;
            $data[$key]['price'] = $item->price;
            $data[$key]['bonus'] = $item->bonus;
        }
        return $data;
    }

    //新增命运测试
    public function actionAddfate()
    {
        $uid = Yii::$app->request->post('uid'); // uid
        if (!$uid) {
            return ['status' => 'fail', 'message' => 'uid 不能为空'];
        }
        $openid = Yii::$app->request->post('openid'); // openid
        if (!$openid) {
            return ['status' => 'fail', 'message' => 'openid 不能为空'];
        }
        $ceday = Yii::$app->request->post('ceday'); // 测试天
        if (!$ceday) {
            return ['status' => 'fail', 'message' => 'ceday 不能为空'];
        }
        $birthday = Yii::$app->request->post('birthday'); // 生日
        $sid = Yii::$app->request->post('sid'); // 分类id
        if (!$sid) {
            return ['status' => 'fail', 'message' => 'sid 不能为空'];
        }
        $formid = Yii::$app->request->post('formid'); // 表单id
        if (!$formid) {
            return ['status' => 'fail', 'message' => 'formid 不能为空'];
        }
        //新增赋值部分
        $model = new TestFate();
        $model->uid = $uid;
        $model->openid = $openid;
        $model->ceday = $ceday;
        $model->birthday = $birthday;
        $model->sid = $sid;
        $model->formid = $formid;
        $model->createtime = time();

        $model->save();

        return ['status' => 'success', 'message' => '提交测试成功'];
    }

    //得到大师的数据
    public function actionMaster()
    {
        $master = Master::find()->where(['status' => 1])->one();
        return ['status' => 'success', 'message' => '获取小程序码成功', 'result' => $master];
    }

    // 小程序码
    public function actionWxcode()
    {
        $uid = Yii::$app->request->post('uid');

        $conf = Yii::$app->params['wx']['mini'];
        $app = new Application(['conf' => $conf]);
        $qrcode = $app->driver("mini.qrcode");
        $path = "/pages/index/index?fid=" . $uid;
        $scene = "123456";
        $qrcode->unLimit($scene, $page, $extra = []);
        return ['status' => 'success', 'message' => '获取小程序码成功', 'wxcode' => $qrcode];
    }

    // 获取好友的个数
    public function actionFriendnum()
    {
        $uid = Yii::$app->request->post('uid'); // uid
        if (!$uid) {
            return ['status' => 'fail', 'message' => 'uid 不能为空'];
        }
        $result = Friend::find()->where(['fid' => $uid])->count();
        return ['status' => 'success', 'message' => '获取数据成功', 'count' => $result];
    }

    // 好友测试记录
    public function actionRecord()
    {
        $uid = Yii::$app->request->post('uid');

        if (!$uid) {
            return ['status' => 'fail', 'message' => '用户ID不能为空'];
        }
        $datalist = TestFate::find()->where(['uid' => $uid, 'status' => 1])->orderBy(['createtime'])->all();

        foreach ($datalist as $item => $key) {
            $data[$key]['id'] = $item->id;
            $data[$key]['cedate'] = $item->ceday;
            $smitem = Subject::find()->where(['id' => $item->sid])->one();
            if (!empty($bonus)) {
                $cetype = $smitem->name;
            } else {
                $cetype = "";
            }
            $data[$key]['cetype'] = $cetype;
            $data[$key]['birthday'] = $item->birthday;
            $data[$key]['tiangan'] = $this->gettian($item->birthday);
            $data[$key]['jieguo'] = $item->subject;
        }
        return ['status' => 'success', 'message' => '获取数据成功', 'record' => $data];
    }

    // 账户余额
    public function actionAccount()
    {
        $uid = Yii::$app->request->post('uid'); // uid
        if (!$uid) {
            return ['status' => 'fail', 'message' => 'uid 不能为空'];
        }
        $datalist = Account::find()->where(['uid' => $uid])->all();
        $result = 0;
        foreach ($datalist as $item => $key) {
            $smitem = Subject::find()->where(['id' => $item->sid])->one();
            if (!empty($smitem)) {
                $result = $result + $smitem->bonus;
            }
        }
        return ['status' => 'success', 'message' => '获取数据成功', 'account' => $result];
    }

    //好友列表
    public function actionFriendlist()
    {
        $uid = Yii::$app->request->post('uid'); // uid
        if (!$uid) {
            return ['status' => 'fail', 'message' => 'uid 不能为空'];
        }

        //查询好友列表
        $flist = Friend::find()->where(['fid' => $uid])->all();
        foreach ($flist as $fitem => $key) {
            //测试记录
            $datalist = TestFate::find()->where(['uid' => $fitem->uid, 'status' => 1])->all();
            //微信用户
            $wxuser = WechatUser::find()->where(['id' => $fitem->uid])->one();
            //账户钱
            $adatalist = Account::find()->where(['uid' => $uid])->all();
            $result = 0;
            foreach ($adatalist as $item => $key) {
                $smitem = Subject::find()->where(['id' => $item->sid])->one();
                if (!empty($smitem)) {
                    $result = $result + $smitem->bonus;
                }
            }
            $data[$key]['id'] = $item->id;
            $data[$key]['txsrc'] = $wxuser->touxiang;
            $data[$key]['wxname'] = $wxuser->wxname;
            $data[$key]['num'] = $datalist->count();
            $data[$key]['qian'] = $result;
        }

        return ['status' => 'success', 'message' => '获取数据成功', 'result' => $result];
    }

    //测试的结果
    public function actionResult()
    {
        $id = Yii::$app->request->post('id'); // id
        if (!$id) {
            return ['status' => 'fail', 'message' => 'id 不能为空'];
        }
        //得到测试的结果
        $item = TestFate::find()->where(['id' => $id])->one();

        //整理数据的格式
        $data['id'] = $item->id;
        $data['cedate'] = $item->ceday;
        $smitem = Subject::find()->where(['id' => $item->sid])->one();
        if (!empty($bonus)) {
            $cetype = $smitem->name;
        } else {
            $cetype = "";
        }
        $data[$key]['cetype'] = $cetype;
        $data[$key]['birthday'] = $item->birthday;
        $data[$key]['tiangan'] = $this->gettian($item->birthday);
        $data[$key]['jieguo'] = $item->subject;
        $data[$key]['result'] = $item->result;

        return ['status' => 'success', 'message' => '获取数据成功', 'result' => $data];
    }
    // 消息模板
    public function actionNewsmuban()
    {

        $conf = Yii::$app->params['wx']['mini'];
        $app = new Application(['conf' => $conf]);
        $template = $app->driver("mini.template");
        $data = [
            'keyword1' => ['你好', '#173177'],
            'keyword2' => ['你好', '#173177'],
            'keyword3' => ['你好', '#173177'],
        ]; //模板消息的内容
        $template->send($toUser, $templateId, $formId, $data, $extra = []);
        /*
        $toUser 接收者（用户）的 openid
        $templateId 所需下发的模板消息的id
        $formId 表单提交场景下，为 submit 事件带上的 formId；支付场景下，为本次支付的 prepay_id
        $data 模板内容，不填则下发空模板
        $extra 其他参数，都放到$extra数组中，比如page、color、emphasis_keyword
         */
        return ['status' => 'success', 'message' => '发送成功'];

    }

    // 小程序支付
    public function actionWxpay()
    {
        $conf = Yii::$app->params['wx']['mini'];
        $app = new Application(['conf' => $conf]);
        $pay = $app->driver("mini.pay");
        $attributes = [
            'body' => "购买VIP会员",
            'out_trade_no' => $out_trade_no,
            'total_fee' => 129,
            'notify_url' => Yii::$app->urlManager->createAbsoluteUrl(['/order/notify']),
            'openid' => $openId,
        ];

        $jsApi = $payment->jsApi($attributes);
        if ($jsApi->return_code == 'SUCCESS' && $jsApi->result_code == 'SUCCESS') {
            $prepayId = $jsApi->prepay_id;
        }
        $result = $payment->configForPayment($prepayId);
        /*
        $result是一个数组，里面包含appId、timeStamp、nonceStr、package、signType、paySign。
         */
        return $result;
    }

    //退款接口
    public function actionWxrefund($outTradeNo,$outRefundNo,$total_fee,$refundFee){
        //$outTradeNo 商户订单号 / 微信订单号
        //$isTransactionId 默认为假，代表$outTradeNo为商户订单号
        //$outRefundNo 退款订单号
        //$totalFee 订单总金额
        //$refundFee 退款金额
        //$extra 额外数组
        $conf = [];
        $app = new Application(['conf'=>$conf['mp']]);
        $pay = $app->driver("mp.pay");

        $result = $pay->refund($outTradeNo,$isTransactionId = false,$outRefundNo,$totalFee,$refundFee,$extra = []);

        return $result;
    }
    
    // 企业退款打到个人微信零钱包
    public function actionDaqian($transaction_id,$openid,$total_fee,$refund_fee)
    {
        $conf = Yii::$app->params['wx']['mp'];

        $app = new Application(['conf'=>$conf]);
        $mch = $app->driver("mp.mch");
     
        //$params 必填参数为partner_trade_no、openid、amount、desc、check_name
        //partner_trade_no->商户订单号
        //openid->用户openid
        //amount->金额(单位：分)
        //desc->企业付款描述信息(退款)
        //check_name->校验用户姓名选项NO_CHECK：不校验真实姓名 FORCE_CHECK：强校验真实姓名
        $params = [
            'partner_trade_no' => $transaction_id,
            'openid' => $openid,
            'amount' => $total_fee*100,
            'desc' => "退款",
            'check_name' => "NO_CHECK",
        ];
        $result=  $mch->send($params);

        return $result;
    }

    // OPNEID
    public function actionOpenid()
    {
        $conf = Yii::$app->params['wx']['mini'];
        $app = new Application(['conf' => $conf]);
        $user = $app->driver("mini.user");
        $code = "011g0QCQ0UAZi921tNDQ0TIPCQ0g0QCR";
        $result = $user->codeToSession($code);
        /*
        $result是一个数组，里面包含appId、timeStamp、nonceStr、package、signType、paySign。
         */
        return $result;
    }
    // ******************************** 处理方法 *****************************

    // 微信授权获取 openid
    public function wechatAuth($code)
    {
        $url = 'https://api.weixin.qq.com/sns/jscode2session?grant_type=authorization_code';

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->setData([
                'appid' => Yii::$app->params['appid'],
                'secret' => Yii::$app->params['secret'],
                'js_code' => $code,
            ])
            ->send();
        if ($response->isOk) {
            $data = $response->data;
        }

        return $data;
    }

    // 根据经纬度获取具体位置信息
    public function getLocation($lat, $lng)
    {
        $key = Yii::$app->params['lbskey'];
        $url = "http://apis.map.qq.com/ws/place/v1/search";
        $radius = 1000; // 半径，米
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->setData([
                'key' => $key,
                'boundary' => "nearby({$lat},{$lng},{$radius})",
                'page_size' => 5,
                'page_index' => 1,
                'orderby' => '_distance',
                // 'keyword' => '大学',
                'filter' => 'category=大学',
            ])
            ->send();

        $school = [];
        if ($response->isOk) {
            $data = $response->data;
            if (isset($data['data'])) {
                foreach ($data['data'] as $item) {
                    $school[] = $item['title'];
                }
            }
        }
        if (empty($school)) {
            $school[] = '其它';
        }
        return $school;
    }

    // 得到天干地支
    public function gettian($date)
    {

        ///<summary>
        /// 十天干
        ///</summary>
        $tg = ["甲", "乙", "丙", "丁", "戊", "己", "庚", "辛", "壬", "癸"];

        ///<summary>
        /// 十二地支
        ///</summary>
        $dz = ["子", "丑", "寅", "卯", "辰", "巳", "午", "未", "申", "酉", "戌", "亥"];

        $year = ((int) substr($date, 0, 4));
        if ($year > 3) {
            $tgIndex = ($year - 4) % 10;
            $dzIndex = ($year - 4) % 12;

            return $tg[tgIndex] . $dz[dzIndex];
        } else {
            return "无效的年份!";
        }
    }

}
