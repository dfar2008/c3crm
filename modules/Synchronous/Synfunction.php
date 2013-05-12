<?php
	//获取数据兼容file_get_contents与curl
	function vita_get_url_content($url) {

		if(!function_exists('file_get_contents')) { 
			$file_contents = file_get_contents($url);
				echo $file_contents;die;
		} else {
		$ch = curl_init();
		$timeout = 5; 
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$file_contents = curl_exec($ch);
		
		curl_close($ch);
		}
		
		
	return $file_contents;
	}

	//签名函数
	function createSign ($paramArr,$appSecret) {
	    $sign = $appSecret;

	    ksort($paramArr);

	    foreach ($paramArr as $key => $val) {
	       if ($key !='' && $val !='') {
	           $sign .= $key.$val;
	       }
	    }
		
	    $sign = strtoupper(md5($sign.$appSecret));
	    return $sign;
	}

	//组参函数
	function createStrParam ($paramArr) {
	    $strParam = '';
	    foreach ($paramArr as $key => $val) {
	       if ($key != '' && $val !='') {
	           $strParam .= $key.'='.urlencode($val).'&'; 
	       }
	    }
	    return $strParam;
	}

	//解析xml函数
	function getXmlData ($strXml) {
		$pos = strpos($strXml, 'xml');
		if ($pos) {
			$xmlCode=simplexml_load_string($strXml,'SimpleXMLElement', LIBXML_NOCDATA);
			$arrayCode=get_object_vars_final($xmlCode);
			return $arrayCode ;
		} else {
			return '';
		}
	}

	function get_object_vars_final($obj){
		if(is_object($obj)){
			$obj=get_object_vars($obj);
		}
		if(is_array($obj)){
			foreach ($obj as $key=>$value){
				$obj[$key]=get_object_vars_final($value);
			}
		}
		return $obj;
	}

	function getArrayResult($methord,$rooturl,$session,$appKey,$appSecret,$fields,$col,$ch,$extra){
		
		if($extra != ''){

		}else{
			$extra = array();
		}

	    //参数数组
		$param = array (

			/* API系统级输入参数 Start */
				'timestamp' => date('Y-m-d H:i:s'),
				'method' => $methord, //API名称
				'session' => $session,
				'format' => 'xml', //返回格式,本demo仅支持xml
				'app_key' => $appKey, //Appkey
				'v' => '2.0', //API版本号
				'sign_method' => 'md5', //签名方式

			/* API系统级参数 End */

			/* API应用级输入参数 Start*/

				'fields' => $fields, //返回字段

			/* API应用级输入参数 End*/

		);
       $paramArr = array_merge($param,$extra);

       //生成签名
		$sign = createSign($paramArr, $appSecret);

		//组织参数
		$strParam = createStrParam($paramArr);
		$strParam .= 'sign=' . $sign;

		//构造Url
		$url = $rooturl . $strParam;
		
		
	
		//连接超时自动重试
		$cnt = 0;
			while ($cnt < 3 && ($result = @ vita_get_url_content($url)) === FALSE)
			$cnt++;

		//解析Xml数据
		$result = getXmlData($result);
		
		
        //获取错误信息
		$msg = $result['msg'];
		
		
		//返回结果
		if($ch == 's' && !empty($result)){
			$taoresult = $result[$col.'s'][$col];
		}else{
			$taoresult = $result[$col];
		}
		
		$arr = array("msg"=>$msg,"total_results"=>$taoresult);
		return $arr;
   }

	function getArrayCount($methord,$rooturl,$session,$appKey,$appSecret,$fields,$extra){
		
		if($extra != ''){

		}else{
			$extra = array();
		}
		
	    //参数数组
		$param = array (

			/* API系统级输入参数 Start */
				'timestamp' => date('Y-m-d H:i:s'),
				'method' => $methord, //API名称
				'session' => $session,
				'format' => 'xml', //返回格式,本demo仅支持xml
				'app_key' => $appKey, //Appkey
				'v' => '2.0', //API版本号
				'sign_method' => 'md5', //签名方式

			/* API系统级参数 End */

			/* API应用级输入参数 Start*/

				'fields' => $fields, //返回字段

			/* API应用级输入参数 End*/

		);
		
		$paramArr = array_merge($param,$extra);
       //生成签名
		$sign = createSign($paramArr, $appSecret);
		
		
		//组织参数
		$strParam = createStrParam($paramArr);
		$strParam .= 'sign=' . $sign;

		//构造Url
		$url = $rooturl . $strParam;  
		//连接超时自动重试
		$cnt = 0;
			while ($cnt < 3 && ($result = @ vita_get_url_content($url)) === FALSE)
			$cnt++;

		//解析Xml数据
		$result = getXmlData($result);
		

        //获取错误信息
		$msg = $result['msg']; 
		
		//返回结果
		$resultcount = $result['total_results'];
		
		$arr = array("msg"=>$msg,"total_results"=>$resultcount);
		return $arr;
   }



?>