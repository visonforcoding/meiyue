<?php

/**
 * Encoding     :   UTF-8
 * Created on   :   2016-4-13 14:32:54 by caowenpeng , caowenpeng1990@126.com
 * 数据配置文件
 */
return [
    'key' => [
        'hanvon' => 'b7be897a-a101-4163-88c9-d914cd9ecb59'
        //,'juhe' => '9379ea56576d3d2c07c992afa3383f3b'
    ],
    'sms' => [
        'userid' => 11053, //真美车
        'account' => 'xifeo',
        'password' => 'SHAOye1688'
    ],
    'encrypt'=>[
        'key'=>'e878caddbb44ee591f30389477f21e30a3cd4377', //实际要求要32位
        'salt'=>'d2339263f44886091b8a62ef43196f15',
    ],
    'weixin' => [
        'appID' => 'wxf3d1e078715e41ce',
        'appsecret' => '293c2fb5bcf96db8eea854365471d48b',
        'token'=>'cwptest',
        'mchid'=>'1296107201',
        'App_mchid'=>'1420153502',
        'key'=>'33DB349F8DB955DC78FC5F84F8E5D3F8',  //设置的商户key
        'sslcert_path'=> dirname(__FILE__).'/wxcert/apiclient_cert.pem',
        'sslkey_path'=> dirname(__FILE__).'/wxcert/apiclient_key.pem',
        'notify_url'=>'/wx/wx-notify',
        'AppID'=>'wx77a25160df0c8641',     //APP端的 开放平台appid
        'AppSecret'=>'9835541c22d191e3a227235e561d502b',
        'master_model'=>false,   //中控模式
        'master_ip'=>'112.74.88.156' ,   //中控服务器ip
        'master_domain'=>'m.chinamatop.com'    //中控服务器域名
    ],
    'alipay' => [
        'partner' => '2088521191540268',  //合作者身份
        'seller_id' => 'service@beauty-engine.com',
        'notify_url'=>'/wx/ali-notify',
        'sslkey_path'=>dirname(__FILE__).'/alipay/cacert.pem',
        'private_key'=>  dirname(__FILE__).'/alipay/key/rsa_private_key.pem',
        'alipay_public_key'=>  dirname(__FILE__).'/alipay/key/alipay_public_key.pem',
    ],
    'umeng_android' => [
        'AppKey' => '58637f708630f54f66001a42',
        'AppMasterSecret' => 'g1qwkqscsbhmk8e3wjfqtetiatyjhwac',
        'UmengMessageSecret' => '67bcef177bfa94db3dd30e89d0e27fb0',
    ],
    'umeng_ios' => [
        'AppKey' => '58637b8307fe654cea001c93',
        'AppMasterSecret' => 'ri5axfugo74rueuzemybtn1ngjks8jpu',
//        'UmengMessageSecret' => '795ffe74e61cd9b28cba5efd98f97171',
    ],
    'pvlog'=>[
      'store_nums'=>100, //pvlog的redis 缓冲区数目 
    ],
    'baidu'=>[
        'mapkey'=>'474572ab0a64485f5b02d3e8accaf09c'
    ],
    'netim'=>[
       'app_key'=>'9e0e349ffbcf4345fdd777a65584fb68',
       'app_secret'=>'1d4cb8f1d21b',
    ]
];
