<?php
/**
 * wechat php test
 */
set_time_limit(0);
require __DIR__."/wx.config.php";
include_once(__DIR__."/Instagraph.class.php");
//define your token
$wechatObj = new wechatCallbackapiDemo($wxConfig);
//验证函数
//$wechatObj->valid();
$sAction = isset($_GET['action']) ? $_GET['action'] : "";
switch($sAction){
    case "valid":
        $wechatObj->valid();
    break;
    case "token":
        echo $wechatObj->getAccessToken();
    break;
    default:
        $wechatObj->responseMsg();
    break;
}

class wechatCallbackapiDemo
{
    private $_wxConfig;
    private $_returnParams; //跳转链接后的返回参数
    public function __construct($wxConfig)
    {
        $this->_wxConfig = $wxConfig;
//        var_dump($this->_wxConfig);
        $this->createMenu();//创建菜单
    }

    /**
     * 响应客户消息
     */
    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        $message = '';

        //extract post data
        if (!empty($postStr)) {
            $postObj = simplexml_load_string(
                $postStr,
                'SimpleXMLElement',
                LIBXML_NOCDATA
            );
            switch (strtolower($postObj->Event)) {
                case 'subscribe':
                    //订阅消息
                    $message = $this->_response_text($postObj, _FOCUS_MESSAGE);
                    break;
                case 'click':
                //点击菜单消息
                //根据用户点击内容分发
                    $content = trim($postObj->EventKey);
                    $postObj->Content = $content; //去掉空格
                    if ($content !== '') {
                        $message = $this->_get_wx_content($postObj);
                    }
                    break;
                default:
                    switch(strtolower($postObj->MsgType)){
                        case 'image'://发送图片
                            $instagraph = Instagraph::factory();//复制照片
                            $sPicKey = $instagraph->copyurl2data($postObj->PicUrl);
                            $sReturn = SHOWPICURL."?pickey=".$sPicKey;
                            $handle = pclose(popen(PHPBIN.' show.php '.$sPicKey.' &', 'r'));
//                            $handle = popen('php show.php '.$sPicKey.' 2>&1', 'r');
//                            $read = fread($handle, 2096);
//                            echo $read;
//                            pclose($handle);
                            $aRespone = array(array(
                                'title' => $this->_wxConfig['wxshowmsg']['title'],
                                'description' => $this->_wxConfig['wxshowmsg']['description'],
                                'picUrl' => $this->_wxConfig['wxshowmsg']['picUrl'],
                                'url' => $sReturn,
                            ));
                            $message = $this->_response_news($postObj, $aRespone);
//                            $message = $this->_response_text($postObj, $sReturn);
                            break;
                        default:
                            $content = trim($postObj->Content);
                            $postObj->Content = $content; //去掉空格
                            //根据用户输入内容分发
                            if ($content !== '') {
                                $message = $this->_get_wx_content($postObj);
                            }
                        break;
                    }
                    break;
            }
        }

        echo $message;
    }

    /**
     * 返回微信内容
     * @param SimpleXMLElement $postObj
     * @return Ambigous <string, mixed>
     */
    private function _get_wx_content(SimpleXMLElement $postObj)
    {
        $apiContent = $this->_wxConfig['customnews'];
        $content = trim(strtoupper($postObj->Content));
//                                var_dump($this->_wxConfig);
//                                var_dump($apiContent);
//                                var_dump($message);
//                                var_dump($apiContent[$content]);
        if (isset($apiContent[$content])) {
            //没有显示菜单,调用API,此处无法赋值数组
            switch($apiContent[$content]['type']){
                case 'text':
                default:
                    $resultStr = $this->_response_text($postObj, $apiContent[$content]['data'][0]);
                    break;
                case 'news':
                    $newsContent = array();
                    foreach ($apiContent[$content]['data'] as $aTmp) {
                        $options = array(
                            'title' => $aTmp[0],
                            'description' => $aTmp[1],
                            'picUrl' => $aTmp[2],
                            'url' => $aTmp[3]
                        );
                        array_push($newsContent, $options);
                    }

                    $resultStr = $this->_response_news($postObj, $newsContent);
                   break;
            }

        }else{
            $resultStr = $this->_response_text($postObj, _DEFAULTREPLY);
        }
        return $resultStr;
    }


    /**
     * 返回自定义特殊消息
     * @param SimpleXMLElement $postObj
     */
    public function getCustomMessages(SimpleXMLElement $postObj){
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postObj = simplexml_load_string(
            $postStr,
            'SimpleXMLElement',
            LIBXML_NOCDATA
        );
        $content = trim($postObj->Content);
        $custommessages = $this->_wxConfig['custommessages'];

        if (isset($custommessages[$content])){
            $message = $this->_response_news($postObj, $custommessages[$content]);
            echo $message;
        }
    }


    /**
     * 获取API信息返回到微信平台
     * @param SimpleXMLElement $postObj
     * @return string
     */
    public function getResponseByApi(SimpleXMLElement $postObj)
    {
        $resultStr = '';
        $datas = $this->getContentFromApi($postObj->apiContent);

        if (!empty($datas)) {
            //成功返回数据
            //$datas = $this->_apiDatasFormat($objData->data);
            $newsContent = array();
            foreach ($datas as $data) {
                $options = array(
                    'title' => $data['data'][0]['msg_title'],
                    'description' => $data['data'][0]['msg_memo'],
                    'picUrl' => $data['data'][0]['msg_img'],
                    'url' => $data['data'][0]['msg_url']
                );
                array_push($newsContent, $options);
            }

            $resultStr = $this->_response_news($postObj, $newsContent);
        }
        return $resultStr;
    }

    /**
     * 生成图文消息内容
     * @param SimpleXMLElement $postObj
     * @param array $newsContent
     * @return string
     */
    private function _response_news(SimpleXMLElement $postObj, $newsContent)
    {
        $newsTplHead = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <ArticleCount>%s</ArticleCount>
                <Articles>";
        $newsTplBody = "<item>
                <Title><![CDATA[%s]]></Title>
                <Description><![CDATA[%s]]></Description>
                <PicUrl><![CDATA[%s]]></PicUrl>
                <Url><![CDATA[%s]]></Url>
                </item>";
        $newsTplFoot = "</Articles>
                <FuncFlag>0</FuncFlag>
                </xml>";

        //计算数组个数,微信平台最多只支持10个图文显示
        $count = count($newsContent);
        $count = $count > 10 ? 10 : $count;
        //头文件
        $header = sprintf(
            $newsTplHead,
            $postObj->FromUserName,
            $postObj->ToUserName,
            time(),
            $count
        );

        for ($i = 0; $i < $count; $i++) {
            $title = isset($newsContent[$i]['title']) ? $newsContent[$i]['title']
                : '';
            $desc = isset($newsContent[$i]['description']) ? $newsContent[$i]['description']
                : '';
            $picUrl = isset($newsContent[$i]['picUrl']) ? $newsContent[$i]['picUrl']
                : '';
            if ($i == 0 && empty($picUrl)) {
                $picUrl = _DEFAULTIMAGE;
            }
            $url = isset($newsContent[$i]['url']) ? $newsContent[$i]['url'] : '';
            $paramurl = $this->getParamUrl($postObj->Content, $title);
            if (!empty($paramurl)) {
                $url .= '?' . $paramurl;
            }
            $this->_wxlog($url."\n");
            //图文显示部分
            $body .= sprintf($newsTplBody, $title, $desc, $picUrl, $url);
        }

        //脚
        $FuncFlag = 0;
        $footer = sprintf($newsTplFoot, $FuncFlag);
        return $header . $body . $footer;
    }

    /**
     * 返回文本信息
     * @param SimpleXMLElement $postObj
     * @param unknown $message
     * @return string
     */
    private function _response_text(SimpleXMLElement $postObj, $content)
    {
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $time = time();
        $textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>%s</FuncFlag>
					</xml>";
        $msgType = "text";
        $FuncFlag = 0;
        $resultStr = sprintf(
            $textTpl,
            $fromUsername,
            $toUsername,
            $time,
            $msgType,
            $content,
            $FuncFlag
        );
        return $resultStr;
    }

    /**
     * 根据类型id远程获取数据
     * @param json $category
     * @return mixed
     */

    /**
     * 格式化API获取的数据
     * @param unknown $datas
     * @return multitype:
     */
    private function _apiDatasFormat($datas)
    {
        $aryData = array();
        if (!empty($datas)) {
            foreach ($datas as $data) {
                if (is_array($data->data)) {
                    foreach ($data->data as $val) {
                        array_push($aryData, $val);
                    }
                } else {
                    array_push($aryData, $data);
                }
            }
        }
        return $aryData;
    }

    /**
     * 设置点击连接中带的返回参数
     * @param array $params
     * @return multitype:
     */
    public function setReturnParams(array $params)
    {
        $this->_returnParams = $params;
        return $params;
    }

    /**
     * 获取点击连接中带的返回参数
     * @return multitype:
     */
    public function getReturnParams()
    {
        return $this->_returnParams;
    }

    /**
     * 返回扩展URL的参数link
     * @param string $input
     * @param string $title
     * @return string
     */
    public function getParamUrl($input, $title)
    {
        $paramurl = '';
        $params = $this->getReturnParams();
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                if (!empty($paramurl))
                    $paramurl .= '&';
                switch ($val) {
                    case _EXT_INPUT:
                        $paramurl .= "$key=" . urlencode($input);
                        break;
                    case _EXT_TITLE:
                        $paramurl .= "$key=" . urlencode($title);
                        break;
                    default:
                        $paramurl .= "$key=" . urlencode($val);
                        break;
                }
            }
        }
        return $paramurl;
    }

    /**
     * 创建菜单
     * @return mixed
     */
    public function createMenu()
    {
        $json_menus = ($this->_wxConfig['menus']);

        //获取access_token
        $access_token = $this->getAccessToken();

        //检查菜单不存在的时候创建菜单
        $result = "";
//        var_dump($access_token);
//        var_dump($this->checkMenu($access_token));
        if (!$result = $this->checkMenu($access_token)){
            $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
            $result = $this->_wx_curl($url, $json_menus, 'POST');
//        var_dump($json_menus);
//        var_dump($result);
        }
        return $result;
    }

    /**
     * 检测自定义菜单是否存在
     * @param unknown $access_token
     * @return boolean
     */
    public function checkMenu($access_token){
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$access_token;
        $result = $this->_wx_curl($url);
        $data = json_decode($result,true);

        return isset($data['errcode']) ? false : $result;
    }

    /**
     * 获取access_token
     * @return mixed
     */
    public function getAccessToken()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='
            . APPID . '&secret=' . APPSECRET;

        $result = $this->_wx_curl($url);
        $tokens = json_decode($result, 1);

        if (isset($tokens['access_token'])) {
            return $tokens['access_token'];
        } else {
            return '';
        }
    }

    /**
     * 获取远程API接口数据
     * @param unknown $url
     * @param unknown $param
     * @param string $sMethod
     * @return mixed
     */
    private function _wx_curl($url, $params=array(), $sMethod = 'GET')
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回

        if (strtoupper($sMethod) == 'POST') {
            curl_setopt($ch, CURLOPT_POST, TRUE);//设置POST传递
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        return $result;
    }

	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
    /**
     * 记录微信日志
     * @return string
     */
    private function _wxlog($content)
    {
        $filename = __DIR__.'/tmp/wx.log';
        if ($handle = fopen($filename, 'a')) {
            if (!fwrite($handle, $content . "\n")) {
                return '';
            }
        }
        fclose($handle);
    }
}