<?php
//$sShowImgSrc = "data/af47a2baac7ebc8c6bca362402d3b392.shui.output.jpg";
///*
include_once(__DIR__."/Instagraph.class.php");
//$sShowImgSrc = "data/65cf281093a3a9cf991c4024836ca61f.tan.output.jpg";
try
{
    $sPicKey = isset($argv) && isset($argv[1]) ? $argv[1] : null;
    $sPicKey = isset($_GET) && isset($_GET['pickey']) ? $_GET['pickey'] : $sPicKey;
    $aOutput = array();
    $instagraph = Instagraph::factory();
    $instagraph->setImgPath($sPicKey);
    $aOutput = $instagraph->getNtgAllOutput();
//    $instagraph->kelvin();
//    $instagraph->gotham();
//    $instagraph->watermask();
//    $aOutput[] = $instagraph->neutrogena_shui();
//    $aOutput[] = $instagraph->neutrogena_tou();
//    $aOutput[] = $instagraph->neutrogena_tan();
//    $instagraph->nashville();
//var_dump($aOutput);
    if(isset($argv) && isset($argv[1])){
        $aOutput[] = $instagraph->neutrogena_shui();
        $aOutput[] = $instagraph->neutrogena_tou();
        $aOutput[] = $instagraph->neutrogena_tan();
    }else{
        //处理异步, 若没完成则等待1s
        if(count($aOutput)<1)sleep(1);
        $aOutput = $instagraph->getNtgAllOutput();
    }

    $sShowImgSrc = str_replace($_SERVER['DOCUMENT_ROOT'], "/", $aOutput[array_rand($aOutput)]);
    $sShowImgSrc = str_replace("//", "/", $sShowImgSrc);
}
catch (Exception $e) 
{
    echo $e->getMessage();
    die;
}
//*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> Neutrogena </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <link type="text/css" rel="stylesheet" href="./script/style.css">
 </head>

 <body>
  <div id="" class="container">
       <div id="" class="bg"><img src="./script/bg_01.jpg"></div>
       <div id="" class="show"><img src="<?php echo $sShowImgSrc?>"></div>
       <div id="" class="bg"><img src="./script/bg_03.jpg"></div>
  </div>
  
  <script>
    var imgUrl = "http://neutrogena.yogurtdigital.com/filtered/ntg_540fb1940edbf.jpg";
    var lineLink = window.location.href;
    var descContent = "快准萌！一张照片就能看出本质，快给露得清微信发照片！";
    var shareTitle = '露得清真我滤镜';
    var appid = 'wx126d4ea63e822306';

    function shareFriend() {
        WeixinJSBridge.invoke('sendAppMessage',{
            "appid": appid,
            "img_url": imgUrl,
            "img_width": "320",
            "img_height": "480",
            "link": lineLink,
            "desc": descContent,
            "title": shareTitle
        }, function(res) {
            //_report('send_msg', res.err_msg);
        })
    }
    function shareTimeline() {
        WeixinJSBridge.invoke('shareTimeline',{
            "img_url": imgUrl,
            "img_width": "320",
            "img_height": "480",
            "link": lineLink,
            "desc": descContent,
            "title": descContent
        }, function(res) {
               //_report('timeline', res.err_msg);
        });
    }
    function shareWeibo() {
        WeixinJSBridge.invoke('shareWeibo',{
            "img_url": imgUrl,
            "img_width": "320",
            "img_height": "480",
            "content": descContent,
            "url": lineLink,
        }, function(res) {
            //_report('weibo', res.err_msg);
        });
    }
    // 当微信内置浏览器完成内部初始化后会触发WeixinJSBridgeReady事件。
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        // 发送给好友
        WeixinJSBridge.on('menu:share:appmessage', function(argv){
            shareFriend();
        });
        // 分享到朋友圈
        WeixinJSBridge.on('menu:share:timeline', function(argv){
            shareTimeline();
        });
        // 分享到微博
        WeixinJSBridge.on('menu:share:weibo', function(argv){
            shareWeibo();
        });
    }, false);
</script>
 </body>
</html>

