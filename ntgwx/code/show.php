<?php
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
       <div id="" class="bg"><img src="<?php echo $sShowImgSrc?>"></div>
  </div>
 </body>
</html>

