<?php
error_reporting(E_ALL);
ini_set("display_errors","On");

/**
 * 开发配置
 * @var unknown
 */
define("TOKEN", "30e8f073f388469e0193300623691a36");
define("APPID", "wx14e42f14c1f869b7");
define("APPSECRET", "fdb1e8dee02caba5aa015d28ab21f7c2");
define("PHPBIN", "/usr/bin/php");

//点击微信信息的跳转地址
define("SHOWPICURL", "http://112.124.104.10/show.php");

//关注时候返回的消息
define('_FOCUS_MESSAGE', '亲，欢迎订阅【neutrogena微信号】。请发布图片互动');	
define('_DEFAULTREPLY', '之前都没有听到过这种回复，很有意思。您可以把您的照片发给我, 会有惊喜哦！');

$wxConfig = array(//
    'menus' => '{"button":[{"name":"真我不藏","sub_button":[{"type":"click","name":"十周年庆典","key":"十周年庆典"},{"type":"click","name":"真我肖像I","key":"真我肖像I"},{"type":"click","name":"真我肖像II","key":"真我肖像II"}]}, {"type":"click","name":"最新活动","key":"最新活动"}]}',
    'wxshowmsg' => array(//微信回复图片消息的文案
        'title' => '制作成功！',
        'description' => '你的【真我照片】已新鲜出炉！【点击获取】～［长按照片可保存］赶快上传更多照片，尝试不同滤镜风格～分享至朋友圈，更有机会赢十周年产品套装！',
        'picUrl' => 'http://ntg-campaign.b0.upaiyun.com/ntgfilters/filtercover2.jpg',
    ),
    'customnews' => array(
        '领奖审核' => array('type'=>'text', 'data'=>array('恭喜您审核通过，可点击以下链接进行领奖：http://neutrogena.mz.linksrewards.com')),
        '我要领奖' => array('type'=>'text', 'data'=>array('欢迎参加本次活动，请按以下提示完成领奖步骤：1、请回复您的小票编码2、在提交小票编码完成后回复“领奖审核”')),
        '兑奖审核' => array('type'=>'text', 'data'=>array('恭喜您审核通过，通过手机或电脑浏览器输入以下链接进行兑奖：http://neutrogena.linksrewards.com')),
        '我要兑奖' => array('type'=>'text', 'data'=>array('欢迎参加本次活动，请按以下提示完成兑奖步骤： 1、请回复您的小票编码 2、在提交小票编码完成后回复“兑奖审核”')),
        '最新活动' => array('type'=>'news', 'data'=>array(array(
            '露得清两件立减30元', 
            '炎炎夏日已经差不多过去，秋意渐浓，经过一夏的洗礼，补水美白成为目前护肤的首要任务。',
            'http://mmbiz.qpic.cn/mmbiz/KymczK3Rld5dASH4giaHepYYyoXCy01I8psl37qZqib2eOHRxT2jJS1dUJKxoxaoWY7Rwkicxnga9eicEp1fWZicV8w/0',
            'http://mp.weixin.qq.com/s?__biz=MzA3MTIyNjcyMA==&mid=201726096&idx=1&sn=74e1ee3a2e3b788b0891e7fe9a36acf2#rd',
        ))),
        '十周年庆典' => array('type'=>'news', 'data'=>array(array(
            '露得清十周年庆典在上海举行！', 
            '3月10日品牌十周年庆典现场，露得清携手著名当代艺术家向京、全新代言人陈意涵，推出10张真我肖像。真我不藏，美丽露得清，点击【阅读全文】了解更多信息！',
            'http://mmbiz.qpic.cn/mmbiz/KymczK3Rld6GOpldVPVQ0bM3dmTlKGLxYNkHeKEYzWBxpCZ5SXYlKgicyH5T5lebVyohAnurGLYBxjn6NNiadjrQ/0',
            'http://mp.weixin.qq.com/s?__biz=MzA3MTIyNjcyMA==&mid=200254141&idx=1&sn=6439db01dd0310142fa04a88c0646f78#rd',
        ))),
        '真我肖像I' => array('type'=>'news', 'data'=>array(
            array(
                '向京：与世交错的真我影像', 
                '',
                'http://mmbiz.qpic.cn/mmbiz/KymczK3Rld7Q0j4ujLYYaT3sWDiaVWDvEPQy9CH0URgTHA0xq97uibDIjHDibVhWsdN93icVM6XykCBAUzQa6UDpGw/0',
                'http://mp.weixin.qq.com/s?__biz=MzA3MTIyNjcyMA==&mid=200396509&idx=1&sn=671cc4f54fe7e0b80edb851d84a6639a#rd',
            ),
            array(
                '露得清“真我不藏”践行者', 
                '',
                'http://mmbiz.qpic.cn/mmbiz/KymczK3Rld7Q0j4ujLYYaT3sWDiaVWDvE5Yrrulsrqwutrz9IqZRXJ6hQcEK5G1yZ8Dcib21MDkTibicZsaCIRLNbQ/0',
                'http://mp.weixin.qq.com/s?__biz=MzA3MTIyNjcyMA==&mid=200396509&idx=2&sn=bb49e9dc767434e48ccaa3376c2dd8d9#rd',
            ),
            array(
                '露得清“生而不息”践行者', 
                '',
                'http://mmbiz.qpic.cn/mmbiz/KymczK3Rld7Q0j4ujLYYaT3sWDiaVWDvElNEERiajYibytRvozquOMT2h3YF91cN8g5jjcu6q2ORMQsSOdYMhcuhA/0',
                'http://mp.weixin.qq.com/s?__biz=MzA3MTIyNjcyMA==&mid=200396509&idx=3&sn=70cc2972fff3cbb5ea6ff2d261c8535e#rd',
            ),
            array(
                '露得清“独具一格”践行者', 
                '',
                'http://mmbiz.qpic.cn/mmbiz/KymczK3Rld7Q0j4ujLYYaT3sWDiaVWDvEpt6cL2iahoUUGG6ywib36U1yA4Yt1FDsh6RJiap1lnNF1PjcZuEKzsYTw/0',
                'http://mp.weixin.qq.com/s?__biz=MzA3MTIyNjcyMA==&mid=200396509&idx=4&sn=3af97f7e5981e817ace5bb24c0c0ec3f#rd',
            ),
            array(
                '露得清“真实可信”践行者', 
                '',
                'http://mmbiz.qpic.cn/mmbiz/KymczK3Rld7Q0j4ujLYYaT3sWDiaVWDvEUcrt5kKCVIricUy6YqJovzqUGD3LRKC4o91YhrVzN8teYcceLRmaqrA/0',
                'http://mp.weixin.qq.com/s?__biz=MzA3MTIyNjcyMA==&mid=200396509&idx=5&sn=edf2a77b48a3a0a3c7b3f0057ac7cd0f#rd',
            ),
            array(
                '露得清“绽放光彩”践行者', 
                '',
                'http://mmbiz.qpic.cn/mmbiz/KymczK3Rld7Q0j4ujLYYaT3sWDiaVWDvEtXw897XqP0HccnKypydqAOiaa8bhMC7otjiasxzYebBxTmiaCYs69icxBw/0',
                'http://mp.weixin.qq.com/s?__biz=MzA3MTIyNjcyMA==&mid=200396509&idx=6&sn=4f35eb17d1389c7a90d603c8fe9b1315#rd',
            ),
            array(
                '露得清“乐观积极”践行者', 
                '',
                'http://mmbiz.qpic.cn/mmbiz/KymczK3Rld7Q0j4ujLYYaT3sWDiaVWDvEsLgib1FicpCpXwtkvepaXbZmPHDygqrK1ibaA5bHjZY5FMHvExQfecsOw/0',
                'http://mp.weixin.qq.com/s?__biz=MzA3MTIyNjcyMA==&mid=200396509&idx=7&sn=c0269cfc22621fc78cc0558ab3e85c15#rd',
            ),
        )),
        '真我肖像II' => array('type'=>'news', 'data'=>array(
            array(
                '露得清“率性而为”践行者', 
                '',
                'http://mmbiz.qpic.cn/mmbiz/KymczK3Rld7Q0j4ujLYYaT3sWDiaVWDvEuVlIxibdkpUWic57PdV69wyR7mvnPZnfWcp3sZnaXticJJDVf0xOo64tg/0',
                'http://mp.weixin.qq.com/s?__biz=MzA3MTIyNjcyMA==&mid=200396605&idx=1&sn=c4ff03a1bc0712488bca2c955e990538#rd',
            ),
            array(
                '露得清“热情不灭”践行者', 
                '',
                'http://mmbiz.qpic.cn/mmbiz/KymczK3Rld7Q0j4ujLYYaT3sWDiaVWDvEBnic5oSyFuBX5ryGUQ1ArUYCC5e6LfEwbm2vVicoslGINuQwz3fB4uFQ/0',
                'http://mp.weixin.qq.com/s?__biz=MzA3MTIyNjcyMA==&mid=200396605&idx=2&sn=b5d3f6049c2a4db7f5e10a694a8ad016#rd',
            ),
            array(
                '露得清“自然灵动”践行者', 
                '',
                'http://mmbiz.qpic.cn/mmbiz/KymczK3Rld7Q0j4ujLYYaT3sWDiaVWDvEzCWxCRJ31UMydwk8aXhufTOkmXrHPxyLDx1qOgEqMPehymratKyF4w/0',
                'http://mp.weixin.qq.com/s?__biz=MzA3MTIyNjcyMA==&mid=200396605&idx=3&sn=bb20395f90e5ad9e75c0332c699b6238#rd',
            ),
            array(
                '露得清“真言不妄”践行者', 
                '',
                'http://mmbiz.qpic.cn/mmbiz/KymczK3Rld7Q0j4ujLYYaT3sWDiaVWDvEVF02TutaGm6BAo7S38z7ACL4Jd9P7ZXURB3CCWDVYKnxIMic5bbtECg/0',
                'http://mp.weixin.qq.com/s?__biz=MzA3MTIyNjcyMA==&mid=200396605&idx=4&sn=a5a60eaa8732c068ce8c95f8f7ff625a#rd',
            ),
        )),
    )
);
//echo json_encode($wxConfig['menus']);