<?php

return [
    'appid' => 'wx4abffedf1c290818', //小程序APPID
    'secret' => 'd77fac92ff83169d0dedf60d8c43c6b2', //小程序密钥
    'lbskey' => 'ZPABZ-TO2AG-2SNQO-IWCA6-5YT5S-2AFRV', //腾讯地图
    'wx' => [
        //  公众号信息
        'mp' => [
            //  账号基本信息
            'app_id' => '', // 公众号的appid
            'secret' => '', // 公众号的秘钥
            'token' => '', // 接口的token
            'encodingAESKey' => '',
            'safeMode' => 0,

            //  微信支付
            'payment' => [
                'mch_id' => '', // 商户ID
                'key' => '', // 商户KEY
                'notify_url' => '', // 支付通知地址
                'cert_path' => '', // 证书
                'key_path' => '', // 证书
            ],

            // web授权
            'oauth' => [
                'scopes' => 'snsapi_userinfo', // 授权范围
                'callback' => '', // 授权回调
            ],
        ],
        //  小程序配置
        'mini' => [
            //  基本配置
            'app_id' => 'wx4abffedf1c290818',
            'secret' => 'd77fac92ff83169d0dedf60d8c43c6b2',
            //  微信支付
            'payment' => [
                'mch_id' => '',
                'key' => '',
            ],
        ],
    ],
];
