<?php
/**
 * @copyright Copyright(c) 2015 www.aircheng.com
 * @file wap_alipay.php
 * @brief 支付宝插件类[手机网站支付]
 * @author dabao
 * @date 2015/01/13 03:25:16
 * @version 1.0.0
 * @note
 */

/**
 * @class wap_alipay
 * @brief 支付宝插件类[手机网站支付]
 */
class wap_alipay extends paymentPlugin
{
	//支付插件名称
    public $name 		= '支付宝移动支付';
	private $format 	= 'xml';
	private $charset 	= 'utf-8';
	private $sign_type	= 'MD5';
	private $_version	= '2.0';

	/**
	 * @see paymentplugin::getSubmitUrl()
	 */
	public function getSubmitUrl()
	{
		return 'http://wappaygw.alipay.com/service/rest.htm?_input_charset=' . $this->charset;
	}

	/**
	 * @see paymentplugin::notifyStop()
	 */
	public function notifyStop()
	{
		echo "success";
	}

	/**
	 * @see paymentplugin::callback()
	 */
	public function callback($callbackData,&$paymentId,&$money,&$message,&$orderNo)
	{
		$returnSign = $callbackData['sign'];
		$callbackData['sign']='';
		$callbackData['sign_type']='';

		//除去待签名参数数组中的空值和签名参数
		$para_filter = $this->paraFilter($callbackData);

		//对待签名参数数组排序
		$para_sort = $this->argSort($para_filter);

		//生成签名结果
		$mysign = $this->buildMysign($para_sort,Payment::getConfigParam($paymentId,'M_PartnerKey'));

		if($returnSign == $mysign)
		{
			//回传数据
			$orderNo = $callbackData['out_trade_no'];

			if($callbackData['result'] == 'success')
			{
				return true;
			}
		}
		else
		{
			$message = '签名不正确';
		}
		return false;
	}

	/**
	 * @see paymentplugin::serverCallback()
	 */
	public function serverCallback($callbackData,&$paymentId,&$money,&$message,&$orderNo)
	{
		$doc = new DOMDocument();
		$doc->loadXML($callbackData['notify_data']);
		$notify_id = $doc->getElementsByTagName( "notify_id" )->item(0)->nodeValue;

		//获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
		$responseTxt = 'true';
		if ($notify_id)
		{
			$responseTxt = $this->getResponse($notify_id,Payment::getConfigParam($paymentId,'M_PartnerId'));
		}
		$returnSign = $callbackData['sign'];

		//对待签名参数数组排序
		$para_sort = array(
			'service' => $callbackData['service'],
			'v' => $callbackData['v'],
			'sec_id' => $callbackData['sec_id'],
			'notify_data' => $callbackData['notify_data']
		);

		$mysign = $this->buildMysign($para_sort,Payment::getConfigParam($paymentId,'M_PartnerKey'));

		if ($mysign == $returnSign && preg_match("/true$/i",$responseTxt))
		{
			$orderNo = $doc->getElementsByTagName( "out_trade_no" )->item(0)->nodeValue;
			$trade_no = $doc->getElementsByTagName( "trade_no" )->item(0)->nodeValue;
			unset($doc);
			$message = '支付成功';
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * @see paymentplugin::getSendData()
	 */
	public function getSendData($payment)
	{
		//基本参数
		$req_id = date('Ymdhis'); //必填，须保证每次请求都是唯一
		$partner = trim($payment['M_PartnerId']);
		$key = trim($payment['M_PartnerKey']);
		$seller_email = trim($payment['M_Email']);
		$return_url = $this->callbackUrl;//支付结果返回
		$notify_url = $this->serverCallbackUrl; //异步支付结果返回
		$merchant_url = $this->merchantCallbackUrl;//中断支付返回

		//业务参数
		$subject = $payment['R_Name'];
		$out_trade_no = $payment['M_OrderNO'];
		$price = number_format($payment['M_Amount'], 2, '.', '');

		//请求业务参数详细
		$req_data = '<direct_trade_create_req><notify_url><![CDATA[' . $notify_url . ']]></notify_url>';
		$req_data .= '<call_back_url><![CDATA[' . $return_url . ']]></call_back_url>';
		$req_data .= '<seller_account_name>' . $seller_email . '</seller_account_name>';
		$req_data .= '<out_trade_no>' . $out_trade_no . '</out_trade_no>';
		$req_data .= '<subject>' . $subject . '</subject>';
		$req_data .= '<total_fee>' . $price . '</total_fee>';
		$req_data .= '<merchant_url><![CDATA[' . $merchant_url . ']]></merchant_url></direct_trade_create_req>';

		//远程模拟开始
		$para_token = array(
			"service" => 'alipay.wap.trade.create.direct',
			"partner" => $partner,
			"sec_id" => $this->sign_type,
			"format"	=> $this->format,
			"v"	=> $this->_version,
			"req_id"	=> $req_id,
			"req_data"	=> $req_data,
			"_input_charset"	=> $this->charset
		);

		//获取$request_token
		$para_token = $this->buildRequestPara($para_token, $key); //构造para_token数据
		$request_token = $this->requestToken($para_token);

		//获取Token后，支付接口数据
		$req_data = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';

		//构造要请求的参数数组，无需改动
		$parameter = array(
			"service" => "alipay.wap.auth.authAndExecute",
			"partner" => $partner,
			"sec_id" => $this->sign_type,
			"format"	=> $this->format,
			"v"	=> $this->_version,
			"req_id"	=> $req_id,
			"req_data"	=> $req_data,
			"_input_charset"	=> $this->charset
		);

		$return = array();
		$this->method = 'get';
		$return = $this->buildRequestPara($parameter, $key); //构造return数据
		return $return;
	}

	/**
	 * 除去数组中的空值和签名参数
	 * @param $para 签名参数组
	 * return 去掉空值与签名参数后的新签名参数组
	 */
	private function paraFilter($para)
	{
		$para_filter = array();
		foreach($para as $key => $val)
		{
			if($key == "sign" || $key == "sign_type" || $val == "")
			{
				continue;
			}
			else
			{
				$para_filter[$key] = $para[$key];
			}
		}
		return $para_filter;
	}

	/**
	 * 对数组排序
	 * @param $para 排序前的数组
	 * return 排序后的数组
	 */
	private function argSort($para)
	{
		ksort($para);
		reset($para);
		return $para;
	}

	/**
	 * 生成签名结果
	 * @param $sort_para 要签名的数组
	 * @param $key 支付宝交易安全校验码
	 * @param $sign_type 签名类型 默认值：MD5
	 * return 签名结果字符串
	 */
	private function buildMysign($sort_para,$key,$sign_type = "MD5")
	{
		//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$prestr = $this->createLinkstring($sort_para);
		//把拼接后的字符串再与安全校验码直接连接起来
		$prestr = $prestr.$key;
		//把最终的字符串签名，获得签名结果
		$mysgin = md5($prestr);
		return $mysgin;
	}

	/**
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	private function createLinkstring($para)
	{
		$arg  = "";
		foreach($para as $key => $val)
		{
			$arg.=$key."=".$val."&";
		}

		//去掉最后一个&字符
		$arg = trim($arg,'&');

		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc())
		{
			$arg = stripslashes($arg);
		}

		return $arg;
	}
	/*
	 *调用授权接口alipay.wap.trade.create.direct获取授权码token
     * @param $para 请求前的参数数组
     * @return 要请求的字符串
     */
	function requestToken($para)
	{
		$url = $this->getSubmitUrl();
		$cacert_url = IUrl::getHost() . '/plugins/payments/pay_wap_alipay/cacert.pem';
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
		curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//证书地址
		curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
		curl_setopt($curl,CURLOPT_POST,true); // post传输数据
		curl_setopt($curl,CURLOPT_POSTFIELDS,$para);// post传输数据
		$responseText = curl_exec($curl);
		//var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
		curl_close($curl);

		//URLDECODE返回的信息
		$html_text = urldecode($responseText);
		$para_sort = $this->parseResponse($html_text); //解析远程模拟提交后返回的信息
		return $para_sort['request_token'];
	}

	/**
	 * @param 获取配置参数
	 */
	public function configParam()
	{
		$result = array(
			'M_PartnerId'  => '合作者身份（PID）',
			'M_PartnerKey' => '安全校验码（Key）',
			'M_Email'      => '绑定账号(邮箱，手机号)',
		);
		return $result;
	}

	/**
     * 解析远程模拟提交后返回的信息
	 * @param $str_text 要解析的字符串
     * @return 解析结果
     */
	function parseResponse($str_text)
	{
		//以“&”字符切割字符串
		$para_split = explode('&',$str_text);
		//把切割后的字符串数组变成变量与数值组合的数组
		foreach ($para_split as $item)
		{
			//获得第一个=字符的位置
			$nPos = strpos($item,'=');
			//获得字符串长度
			$nLen = strlen($item);
			//获得变量名
			$key = substr($item,0,$nPos);
			//获得数值
			$value = substr($item,$nPos+1,$nLen-$nPos-1);
			//放入数组中
			$para_text[$key] = $value;
		}

		if(isset($para_text['res_error']) && $para_text['res_error'])
		{
			die($para_text['res_error']);
		}

		if(isset($para_text['res_data']))
		{
			//token从res_data中解析出来（也就是说res_data中已经包含token的内容）
			$doc = new DOMDocument();
			$doc->loadXML($para_text['res_data']);
			$para_text['request_token'] = $doc->getElementsByTagName( "request_token" )->item(0)->nodeValue;
		}
		return $para_text;
	}

	/**
     * 生成要请求给支付宝的参数数组
     * @param $para_temp 请求前的参数数组
     * @param $key 商户安全校验
     * @return 要请求的参数数组
     */
	function buildRequestPara($para_temp, $key = '')
	{
		//除去待签名参数数组中的空值和签名参数
		$para_filter = $this->paraFilter($para_temp);
		//对待签名参数数组排序
		$para_sort = $this->argSort($para_filter);
		//生成签名结果
		$mysign = $this->buildMysign($para_sort, $key);
		//签名结果与签名方式加入请求提交参数组中
		$para_sort['sign'] = $mysign;

		if($para_sort['service'] != 'alipay.wap.trade.create.direct' && $para_sort['service'] != 'alipay.wap.auth.authAndExecute') {
			$para_sort['sign_type'] = $this->sign_type;
		}
		return $para_sort;
	}


    /**
     * 获取远程服务器ATN结果,验证返回URL,异步调用
     * @param $notify_id 通知校验ID
     * @return 服务器ATN结果
     * 验证结果集：
     * invalid命令参数不对 出现这个错误，请检测返回处理中partner和key是否为空
     * true 返回正确信息
     * false 请检查防火墙或者是服务器阻止端口问题以及验证时间是否超过一分钟
     */
	function getResponse($notify_id,$partner)
	{
		$veryfy_url = 'http://notify.alipay.com/trade/notify_query.do?';
		$cacert_url = IUrl::getHost() . '/plugins/payments/pay_wap_alipay/cacert.pem';
		$veryfy_url = $veryfy_url."partner=" . $partner . "&notify_id=" . $notify_id;
		$curl = curl_init($veryfy_url);
		curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
		curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//证书地址
		$responseText = curl_exec($curl);
		//var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
		curl_close($curl);
		return $responseText;
	}
}