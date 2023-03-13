<?php
/**
 * @class alipay
 * @brief 微信支付
 */
class wechat extends paymentPlugin
{
	//支付插件名称
    public $name   = '微信支付';

	/**
	 * @see paymentplugin::getSubmitUrl()
	 */
	public function getSubmitUrl()
	{
		return 'https://pay.swiftpass.cn/pay/gateway';
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
	public function callback($callbackData,&$paymentId,&$money,&$message,&$orderNo){}

	/**
	 * @see paymentplugin::serverCallback()
	 */
	public function serverCallback($callbackData,&$paymentId,&$money,&$message,&$orderNo)
	{
		$callbackData = $this->converArray($callbackData);
		if(isset($callbackData['result_code']) && $callbackData['result_code'] == '0')
		{
			//除去待签名参数数组中的空值和签名参数
			$para_filter = $this->paraFilter($callbackData);

			//对待签名参数数组排序
			$para_sort = $this->argSort($para_filter);

			//生成签名结果
			$mysign = $this->buildMysign($para_sort,Payment::getConfigParam($paymentId,'M_PartnerKey'));

			//验证签名
			if($mysign == $callbackData['sign'])
			{
				if($callbackData['pay_result'] == 0)
				{
					$orderNo = $callbackData['out_trade_no'];
					$money   = $callbackData['total_fee']/100;
					return true;
				}
				else
				{
					$message = $callbackData['pay_info'];
				}
			}
			else
			{
				$message = '签名不匹配';
			}
		}

		$message = $message ? $message : $callbackData['message'];
		return false;
	}

	/**
	 * @see paymentplugin::getSendData()
	 */
	public function getSendData($payment)
	{
		$return = array();

		//基本参数
		$return['service']      = 'pay.weixin.scancode';
		$return['mch_id']       = $payment['M_PartnerId'];
		$return['out_trade_no'] = $payment['M_OrderNO'];
		$return['body']         = '商品';
		$return['total_fee']    = $payment['M_Amount'] * 100;
		$return['notify_url']   = $this->serverCallbackUrl;
		$return['mch_create_ip']= IClient::getIp();
		$return['nonce_str']    = rand(10000,99999);

		//除去待签名参数数组中的空值和签名参数
		$para_filter = $this->paraFilter($return);

		//对待签名参数数组排序
		$para_sort = $this->argSort($para_filter);

		//生成签名结果
		$mysign = $this->buildMysign($para_sort, $payment['M_PartnerKey']);

		//签名结果与签名方式加入请求提交参数组中
		$return['sign'] = $mysign;

		$xmlData = $this->converXML($return);
		$result  = $this->curlSubmit($xmlData);

		return $this->converArray($result);
	}

	/**
	 * @brief 提交数据
	 * @param xml $xmlData 要发送的xml数据
	 * @return xml 返回数据
	 */
	private function curlSubmit($xmlData)
	{
		//接收xml数据的文件
		$url = $this->getSubmitUrl();

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/xml', 'Content-Type: application/xml'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);

		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}

	/**
	 * @see paymentplugin::doPay()
	 */
	public function doPay($sendData)
	{
		if(!isset($sendData['status']) || $sendData['status'] != '0')
		{
			die($sendData['message']);
		}

		include(dirname(__FILE__).'/template/pay.php');
	}

	/**
	 * @brief 从array到xml转换数据格式
	 * @param array $arrayData
	 * @return xml
	 */
	private function converXML($arrayData)
	{
		$xml = '<xml>';
		foreach($arrayData as $key => $val)
		{
			$xml .= '<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
		}
		$xml .= '</xml>';
		return $xml;
	}

	/**
	 * @brief 从xml到array转换数据格式
	 * @param xml $xmlData
	 * @return array
	 */
	private function converArray($xmlData)
	{
		$result = array();
		$xmlHandle = xml_parser_create();
		xml_parse_into_struct($xmlHandle, $xmlData, $resultArray);

		foreach($resultArray as $key => $val)
		{
			if($val['tag'] != 'XML')
			{
				$result[$val['tag']] = $val['value'];
			}
		}
		return array_change_key_case($result);
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
		$prestr = $prestr.'&key='.$key;
		//把最终的字符串签名，获得签名结果
		$mysgin = md5($prestr);
		return strtoupper($mysgin);
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