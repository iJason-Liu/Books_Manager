<?php
/**
 * @copyright Copyright(c) 2014 jooyea.cn
 * @file cipay.php
 * @brief 银信证(外卡)接口
 * @author chendeshan
 * @date 2014/12/8 18:54:51
 * @version 2.8
 */

 /**
 * @class cipay
 * @brief 银信证接口
 */
class cipay extends paymentPlugin
{
	//支付插件名称
    public $name = '银信证支付';

	/**
	 * @see paymentplugin::getSubmitUrl()
	 */
	public function getSubmitUrl()
	{
		return 'https://www.cifpay.com/cifpay/gateway';
	}

	/**
	 * @see paymentplugin::notifyStop()
	 */
	public function notifyStop()
	{
		echo "SUCCESS";
	}

	/**
	 * @see paymentplugin::callback()
	 */
	public function callback($callbackData,&$paymentId,&$money,&$message,&$orderNo)
	{
		//除去待签名参数数组中的空值和签名参数
		$para_filter = $this->paraFilter($callbackData);

		//对待签名参数数组排序
		$para_sort = $this->argSort($para_filter);

		//生成签名结果
		$mysign = $this->buildMysign($para_sort,Payment::getConfigParam($paymentId,'M_PartnerKey'));

		if($callbackData['sign'] == $mysign)
		{
			//回传数据
			$orderNo = $callbackData['orderID'];

			if($callbackData['state'] == 'CREDIT_RECEIVED')
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
		$result = $this->callback($callbackData,$paymentId,$money,$message,$orderNo);

		if($result ==  true)
		{
			//履约
			$rePromise = $this->promise($callbackData,$paymentId,$money,$message,$orderNo);

			//解付
			$rePaying = $this->paying($callbackData,$paymentId,$money,$message,$orderNo);
		}
		return $result;
	}

	/**
	 * @brief 履约接口
	 */
	public function promise($callbackData,$paymentId,$money,$message,$orderNo)
	{
		$return = array();
		$return['service']  = 'SEND';
		$return['mid']      = Payment::getConfigParam($paymentId,'M_PartnerId');
		$return['bankCode'] = 'CIB';
		$return['orderID']  = $orderNo;

		//除去待签名参数数组中的空值和签名参数
		$para_filter = $this->paraFilter($return);

		//对待签名参数数组排序
		$para_sort = $this->argSort($para_filter);

		//生成签名结果
		$mysign = $this->buildMysign($para_sort,Payment::getConfigParam($paymentId,'M_PartnerKey'));

		$return['sign'] = $mysign;

		return $this->curlMethod($this->getSubmitUrl(),$return);
	}

	/**
	 * @brief 解付接口
	 */
	public function paying($callbackData,$paymentId,$money,$message,$orderNo)
	{
		$return = array();
		$return['service']  = 'CONFIRMPAY';
		$return['mid']      = Payment::getConfigParam($paymentId,'M_PartnerId');
		$return['bankCode'] = 'CIB';
		$return['orderID']  = $orderNo;

		//除去待签名参数数组中的空值和签名参数
		$para_filter = $this->paraFilter($return);

		//对待签名参数数组排序
		$para_sort = $this->argSort($para_filter);

		//生成签名结果
		$mysign = $this->buildMysign($para_sort,Payment::getConfigParam($paymentId,'M_PartnerKey'));

		$return['sign'] = $mysign;

		return $this->curlMethod($this->getSubmitUrl(),$return);
	}

	/**
	 * @brief curl方式提交
	 */
	public function curlMethod($url,$postArray)
	{
		$string = '';
		foreach ($postArray as $k => $v)
		{
		   $string .="$k=".$v.'&';
		}
		$string = substr($string,0,-1);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果需要将结果直接返回到变量里，那加上这句。
		return curl_exec($ch);
	}

	/**
	 * @see paymentplugin::getSendData()
	 */
	public function getSendData($payment)
	{
    	$return = array();
        $return['bankCode']      = 'CIB';
        $return['feeType']       = 'CNY';
		$return['inputCharset']  = 'UTF-8';
		$return['mid']           = $payment['M_PartnerId'];
		$return['noticeUrl']     = $this->serverCallbackUrl;
		$return['openBankCode']  = 'CIB';
		$return['orderID']       = $payment['M_OrderNO'];
		$return['requestTime']   = date('Y-m-d H:i:s',time());
		$return['returnUrl']     = $this->callbackUrl;
		$return['service']       = 'OPEN';
		$return['totalFee']      = $payment['M_Amount']*100;

	    //除去待签名参数数组中的空值和签名参数
		$para_filter = $this->paraFilter($return);

		//对待签名参数数组排序
		$para_sort = $this->argSort($para_filter);

		//生成签名结果
		$mysign = $this->buildMysign($para_sort, $payment['M_PartnerKey']);

		//签名结果与签名方式加入请求提交参数组中
		$return['sign'] = $mysign;

        return $return;
	}

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
	 * @param $key 银信证交易安全校验码
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
		$mysgin = strtoupper(md5($prestr));
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
}