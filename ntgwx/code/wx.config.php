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
    'menus' => '{"button":[{"name":"主菜单","sub_button":[{"type":"click","name":"子菜单1","key":"领奖审核"},{"type":"click","name":"子菜单2","key":"兑奖审核"}]}]}',
    'wxshowmsg' => array(//微信回复图片消息的文案
        'title' => '这是一个标题文案',
        'description' => '这是一个描述文案',
        'picUrl' => 'http://images.vsuch.com/center/data/avatar/004/67/23/50_avatar_big.jpg',
    ),
    'customnews' => array(
        '领奖审核' => array('恭喜您审核通过，可点击以下链接进行领奖：http://neutrogena.mz.linksrewards.com'),
        '我要领奖' => array('欢迎参加本次活动，请按以下提示完成领奖步骤：1、请回复您的小票编码2、在提交小票编码完成后回复“领奖审核”'),
        '兑奖审核' => array('恭喜您审核通过，通过手机或电脑浏览器输入以下链接进行兑奖：http://neutrogena.linksrewards.com'),
        '我要兑奖' => array('欢迎参加本次活动，请按以下提示完成兑奖步骤： 1、请回复您的小票编码 2、在提交小票编码完成后回复“兑奖审核”'),
    )
);
//echo json_encode($wxConfig['menus']);