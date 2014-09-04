<?php
error_reporting(E_ALL);
ini_set("display_errors","On");
include_once(__DIR__."/Instagraph.class.php");
//$sShowImgSrc = "data/65cf281093a3a9cf991c4024836ca61f.tan.output.jpg";
try
{
//    exec('whereis php', $sOut);
//    var_dump($sOut);
//    exec('/usr/bin/php -v', $sOut);
//    var_dump($sOut);
//        $sPicKey = "f939a6f396b8b609bdc631d268361e1d";
//        $handle = popen('/usr/bin/php '.__DIR__.'/show.php '.$sPicKey.' &', 'r');
//        $read = fread($handle, 2096);
//        echo($read);
//        pclose($handle);
//    exit;
    $sPicKey = 'demo';
    $aOutput = array();
    $instagraph = Instagraph::factory();
    $instagraph->setImgPath($sPicKey);
//    $instagraph->kelvin();
//    $instagraph->gotham();
//    $instagraph->watermask();
    $aOutput[] = $instagraph->neutrogena_shui();
    $aOutput[] = $instagraph->neutrogena_tou();
    $aOutput[] = $instagraph->neutrogena_tan();
//    $instagraph->nashville();
    $sShowImgSrc = str_replace($_SERVER['DOCUMENT_ROOT'], "", $aOutput[array_rand($aOutput)]);
    $sShowImgSrc = str_replace("//", "/", $sShowImgSrc);
    var_dump("OK");
}
catch (Exception $e) 
{
    echo $e->getMessage();
    die;
}