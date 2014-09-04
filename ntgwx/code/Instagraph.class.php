<?php
//var_dump(getimagesize("D:/htdocs/work/waibao/imgmagic/code/tmp/5405af7e5a9e1.jpg"));
//exit;
/*


./aspectcrop  -a 1:1 d:/htdocs/work/waibao/imgmagic/input3.jpg d:/htdocs/work/waibao/imgmagic/input.tmp.jpg && ./spherize -b black -a 1.1 d:/htdocs/work/waibao/imgmagic/input.tmp.jpg d:/htdocs/work/waibao/imgmagic/output.jpg

/usr/local/bin/convert d:/htdocs/work/waibao/imgmagic/shuirun.bg2.png -resize 'x200'  d:/htdocs/work/waibao/imgmagic/output.jpg

/usr/local/bin/convert d:/htdocs/work/waibao/imgmagic/output.jpg -ping -format "%w" info:


d:/htdocs/work/waibao/imgmagic


*/



/**
 * Instagram filters with PHP and ImageMagick
 *
 * @package    Instagraph
 * @author     Webarto &lt;dejan.marjanovic@gmail.com>
 * @copyright  NetTuts+
 * @license    http://creativecommons.org/licenses/by-nc/3.0/ CC BY-NC
 */
class Instagraph 
{
     
    public $_image = NULL;
    public $_output = NULL;
    public $_prefix = 'ntg_';
    private $_tmp = NULL;
    private $_pickey = '';
    private $_fredbin = "/bin/";//fred bin
    private $_windowsfredbin = "/windowsbin/";//fred bin
    private $_tmpdir = "/tmp/";//tmp file dir
    private $_datadir = "/data/";//result file dir
    private $_meterialdir = "/meterial/";//result file dir
         
    public static function factory($image=null)
    {
        $o = new Instagraph($image);
        return $o;
    }
    public function __construct($image=null)
    {
        $sDirPath = __DIR__;
        $this->_fredbin = $sDirPath.$this->_fredbin;

        $this->_tmpdir = str_replace("\\", "/", __DIR__).$this->_tmpdir;
        $this->_datadir = str_replace("\\", "/", __DIR__).$this->_datadir;
        $this->_meterialdir = str_replace("\\", "/", __DIR__).$this->_meterialdir;
    }
    public function copyurl2data($url)
    {
        $sImageOrginName = $this->_datadir.md5($url).".jpg";
        if(!$this->my_file_exists($sImageOrginName)){
            copy($url, $sImageOrginName);
        }
        return md5($url);
    }
    function my_file_exists($file){
        if(PHP_OS=='WINNT')
            $file = str_replace('/cygdrive/d', 'd:', $file);
        return file_exists($file);
    }
    public function setImgPath($sPicKey)
    {
        $this->_image = $this->_datadir.$sPicKey.".jpg";
       if(!$this->my_file_exists($this->_image))
            throw new Exception("pickey ".$sPicKey." not found");
        $this->__formatimg();
    }

    public function tempfile()
    {
        return $this->_tmpdir.uniqid().".jpg";
    }
    public function setoutput($name)
    {
        $this->_output = str_replace(".jpg", ".".$name.".output.jpg", $this->_image);
        return($this->_output);
    }
     
    public function output()
    {
    }
 
    public function getNtgAllOutput()
    {
        $aReturn = array();
        $sFile = str_replace(".jpg", ".shui.output.jpg", $this->_image);
        if(file_exists($sFile))$aReturn[] = $sFile;
        $sFile = str_replace(".jpg", ".tou.output.jpg", $this->_image);
        if(file_exists($sFile))$aReturn[] = $sFile;
        $sFile = str_replace(".jpg", ".tan.output.jpg", $this->_image);
        if(file_exists($sFile))$aReturn[] = $sFile;

        return $aReturn;
    }

    public function getOutput()
    {
        # rename working temporary file to output filename
        return $this->_output;
    }
    public function execute($command)
    {
        # remove newlines and /usr/local/bin/convert single quotes to double to prevent errors
        $command = str_replace(array("\n", "'"), array('', '"'), $command);
        $command = escapeshellcmd($command);
        # execute /usr/local/bin/convert program
//        exec("pwd", $sOutput);
//        var_dump($command);
        exec($command, $sOutput);
//        var_dump($sOutput);
    }
     
    /** ACTIONS */
    public function neutrogena_shui(){
/*
    d:/htdocs/work/waibao/imgmagic/code/bin/aspectcrop  -a 64:96 http://www.imagemagick.org/image/logo.jpg d:/htdocs/work/waibao/imgmagic/input.tmp.jpg 
    width=`/usr/local/bin/convert d:/htdocs/work/waibao/imgmagic/input.tmp.jpg -ping -format "%w" info:`
    /usr/local/bin/convert d:/htdocs/work/waibao/imgmagic/code/meterial/shui.m2.png -resize "$width"x  d:/htdocs/work/waibao/imgmagic/shuirun.bg.tmp.png 
    /usr/local/bin/composite -dissolve 50  -gravity center  -alpha Set d:/htdocs/work/waibao/imgmagic/shuirun.bg.tmp.png d:/htdocs/work/waibao/imgmagic/input.tmp.jpg  d:/htdocs/work/waibao/imgmagic/output2.jpg
*/
        $this->__neutrogena_script('shui.m2.png', 'shui');
        return $this->_output;
    }
    public function neutrogena_tou(){
         $this->__neutrogena_script('tou.m.png', 'tou');
        return $this->_output;
   }

    public function __formatimg(){
//        $sReturn = $this->_image;
//        list($nWidth, $nHeight) = getimagesize($this->_image);
//        var_dump($nWidth, $nHeight);
//        if($nWidth>$nHeight){
//            $input_tmp = $this->tempfile();
//            $this->execute("/usr/local/bin/convert $this->_image   -colorspace  sRGB -rotate 90 $this->_image");
//            $this->_image = $input_tmp;
//        }
    }
    public function __neutrogena_script($sSelectBgPng, $sOutPutExt){
        $this->setoutput($sOutPutExt);
        if($this->my_file_exists($this->_output))return $this->_output;
        $input_tmp = $this->tempfile();
        $this->execute($this->_fredbin."aspectcrop -a 2:3 $this->_image $input_tmp");
//        $input_tmp = 'D:/htdocs/work/waibao/imgmagic/code/tmp/5405af7e5a9e1.jpg';
        list($nWidth, $nHeight) = getimagesize($input_tmp);
        $bgfile = $this->_meterialdir.$sSelectBgPng;
        $bgfile_tmp = $this->_tmpdir."meterial_".md5($bgfile)."_".$nWidth.".png";
//        var_dump("/usr/local/bin/convert $bgfile -resize ".$nWidth."x  $bgfile_tmp");
        if(!$this->my_file_exists($bgfile_tmp))$this->execute("/usr/local/bin/convert $bgfile -resize ".$nWidth."x  $bgfile_tmp");
//        $this->execute("/usr/local/bin/composite -watermark  35  -gravity center  -alpha Set ".$bgfile_tmp." ".$input_tmp."  ".$this->_output);
//        $this->execute("/usr/local/bin/composite -dissolve 45x100  -gravity center  -alpha Set ".$bgfile_tmp." ".$input_tmp."  ".$this->_output);
        $this->execute("/usr/local/bin/composite -dissolve 50  -gravity center  -alpha Set ".$bgfile_tmp." ".$input_tmp."  ".$this->_output);
//        $this->execute("/usr/local/bin/composite -dissolve 35x100  -gravity center  -alpha Set ".$bgfile_tmp." ".$input_tmp."  ".$this->_output);
    }
    public function neutrogena_tan(){
    /*
    d:/htdocs/work/waibao/imgmagic/code/bin/aspectcrop  -a 1:1 d:/htdocs/work/waibao/imgmagic/input3.jpg d:/htdocs/work/waibao/imgmagic/input.tmp.jpg
    d:/htdocs/work/waibao/imgmagic/code/bin/spherize -b black -a 1.2 d:/htdocs/work/waibao/imgmagic/input.tmp.jpg d:/htdocs/work/waibao/imgmagic/input.tmp.jpg 
    d:/htdocs/work/waibao/imgmagic/code/bin/softfocus -m 100 -O 80 d:/htdocs/work/waibao/imgmagic/input.tmp.jpg d:/htdocs/work/waibao/imgmagic/input.tmp.jpg 
    d:/htdocs/work/waibao/imgmagic/code/bin/aspectcrop  -a 8:9 d:/htdocs/work/waibao/imgmagic/input.tmp.jpg d:/htdocs/work/waibao/imgmagic/input.tmp.jpg
    width=`/usr/local/bin/convert d:/htdocs/work/waibao/imgmagic/input.tmp.jpg -ping -format "%w" info:`
    height=`/usr/local/bin/convert d:/htdocs/work/waibao/imgmagic/input.tmp.jpg -ping -format "%h" info:`
    echo $width."\n"
    ((height = $height+170))
    echo $height."\n"
    /usr/local/bin/convert d:/htdocs/work/waibao/imgmagic/input.tmp.jpg  -background black -gravity north   -extent "$width"x"$height" d:/htdocs/work/waibao/imgmagic/input.tmp.jpg
    /usr/local/bin/convert  d:/htdocs/work/waibao/imgmagic/input.tmp.jpg   d:/htdocs/work/waibao/imgmagic/code/meterial/tan.logo.png  -gravity SouthWest   -/usr/local/bin/composite  d:/htdocs/work/waibao/imgmagic/output.jpg
    */
        $this->setoutput('tan');
        if($this->my_file_exists($this->_output))return $this->_output;
        $input_tmp = $this->tempfile();
        $this->microtime_float();
        $this->execute("/usr/local/bin/convert $this->_image -resize 640x  $input_tmp");
        $this->execute($this->_fredbin."aspectcrop -a 1:1 $this->_image $input_tmp");
         $this->microtime_float();
       $this->execute($this->_fredbin."spherize -b black -a 1.3 $input_tmp $input_tmp");
        $this->microtime_float();
        $this->execute($this->_fredbin."feather -d 1 $input_tmp $input_tmp");
//        $this->execute($this->_fredbin."softfocus -m 100 -O 80 $input_tmp $input_tmp");
//        $this->execute($this->_fredbin."aspectcrop  -a 8:9 $input_tmp $input_tmp");
          $this->microtime_float();
       list($nWidth, $nHeight) = getimagesize($input_tmp);
        $bgfile = $this->_meterialdir."/tan.logo.png";

        $logo_tmp = $this->tempfile();
//        $logo_tmp = $logo_tmp.".png";
        $logo_tmp = $bgfile;
       list($nLogoWidth, $nLogoHeight) = getimagesize($logo_tmp);
       if($nLogoWidth>$nWidth){
            $this->execute("/usr/local/bin/convert $bgfile -resize ".($nWidth*5/8)."x $logo_tmp");
       }
//         $this->execute("/usr/local/bin/convert $logo_tmp  -background black -gravity East   -extent 520x{$nLogoHeight} $logo_tmp");
//         $this->execute("/usr/local/bin/convert $logo_tmp  -background black -gravity West   -extent 640x{$nLogoHeight} $logo_tmp");
//        $nHeight = $nHeight+($nHeight/3);
        $nHeight = $nHeight+($nLogoHeight);

        $this->execute("/usr/local/bin/convert $input_tmp  -background black -gravity north   -extent {$nWidth}x{$nHeight} $input_tmp");
         $this->execute("/usr/local/bin/composite  -compose Screen  -gravity South ".$logo_tmp." ".$input_tmp."  ".$this->_output);
//      $this->execute("/usr/local/bin/convert $input_tmp $logo_tmp  -gravity South -/usr/local/bin/composite ".$this->_output);
//        $this->execute("/usr/local/bin/composite -channel RGB -gravity  South -alpha Set  ".$input_tmp." ".$logo_tmp."  ".$this->_output);

        return $this->_output;
   }
    function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

}
