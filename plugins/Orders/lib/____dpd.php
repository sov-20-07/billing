<?
class DPD_service{
	public static $arMSG = array(); // массив-сообщение ('str' => текст_сообщения, 'type' => тип_сообщения (по дефолту: 0 - ошибка)
	private static $IS_ACTIVE = 1; // флаг активности сервиса (0 - отключен, 1 - включен)
	private static $IS_TEST = 0; // флаг тестирования (0 - работа, 1 - тест)
	private static $SOAP_CLIENT; // SOAP-клиент
	private static $MY_NUMBER = '1001030870'; // ЗАМЕНИТЬ НА СВОЙ!!! - клиентский номер в системе DPD (номер договора с DPD)
	private static $MY_KEY = '1F551C5E86088C1BF11FF52FB399BF75249E2594'; // ЗАМЕНИТЬ НА СВОЙ!!! - уникальный ключ для авторизации
	private static $arDPD_HOST = array(
		0 => 'ws.dpd.ru/services/', // рабочий хост
		1 => 'appl.dpd.ru:8080/services/', // тестовый хост
	);
	private static $arSERVICE = array( // сервисы: название => адрес
		'getCitiesCashPay' => 'geography', // География DPD (города доставки)
		'getTerminalsSelfDelivery' => 'geography', // список терминалов DPD (TODO)
		'getServiceCost' => 'calculator2', // Расчѐт стоимости
		'createOrder' => 'order2', // Создать заказ на доставку (TODO)
		'getOrderStatus' => 'order2', // Получить статус создания заказа (TODO)
	);
	/**
	* Список городов доставки
	*
	* @access public
	* @return
	*/
	public function getCityList()
	{
		$obj = DPD_service::_getDpdData('getCitiesCashPay');
		// конверт $obj --> $arr
		$res = DPD_service::_parceObj2Arr($obj->return);
		return $res;
	}
	public function getTerminalsSelfDelivery()
	{
		$obj = DPD_service::_getDpdData('getTerminalsSelfDelivery');
		// конверт $obj --> $arr
		$res = DPD_service::_parceObj2Arr($obj->return);
		return $res;
	}
	/**
	* Определение стоимости доставки
	*
	* @access public
	* @param array $arData // массив входных параметров*
	* @return
	*/
	public function getServiceCost($arData){
		// куда
		if($arData['delivery']['cityName']){
			$arData['delivery']['cityName'] = iconv('windows-1251','utf-8',$arData['delivery']['cityName']);
		}
		// откуда
		$arData['pickup'] = array(
			'cityId' => 48994107,
			'cityName' => iconv('windows-1251','utf-8','Екатеринбург'),
			//'regionCode' => '66',
			//'countryCode' => 'RU',
		);
		// что делать с терминалом
		$arData['selfPickup'] = true; // Доставка ОТ терминала
		$arData['selfDelivery'] = true; // Доставка ДО терминала
		// третий параметр - флаг упаковки запроса в общее поле "request"
		$obj = DPD_service::_getDpdData('getServiceCost', $arData, 1);
		// конверт $obj --> $arr
		$res = DPD_service::_parceObj2Arr($obj->return);
		return $res;
	}
	// PRIVATE ------------------------
	/**
	* Коннект с соответствующим сервисом
	*
	* @access private
	* @param string $method_name Запрашиваемый метод сервиса (см. ключ свойства класса DPD_service::arSERVICE)
	* @return bool Результат инициализации (если положительный - появится свойство DPD_service::SOAP_CLIENT, иначе DPD_service::arMSG)
	*/
	private function _connect2Dpd($method_name){
		if(!DPD_service::$IS_ACTIVE) return false;
		if(!$service = DPD_service::$arSERVICE[$method_name]){
			DPD_service::$arMSG['str'] = 'В свойствах класса нет сервиса "'.$method_name.'"';
			return false;
		}
		$host = DPD_service::$arDPD_HOST[DPD_service::$IS_TEST].$service.'?WSDL';
		try{
			// Soap-подключение к сервису
			DPD_service::$SOAP_CLIENT = new SoapClient('http://'.$host);
			if(!DPD_service::$SOAP_CLIENT) throw new Exception('Ошибка');
		} catch (Exception $ex) {
			DPD_service::$arMSG['str'] = 'Не удалось подключиться к сервисам DPD '.$service;
			return false;
		}
		return true;
	}
	/**
	* Запрос данных в методе сервиса
	*
	* @access private
	* @param string $method_name Название метода Dpd-сервиса (см. $arSERVICE)
	* @param array $arData Массив параметров, передаваемых в метод
	* @param integer $is_request флаг упаковки запроса в поле 'request'
	* @return XZ_obj Объект, полученный от сервиса
	*/
	private function _getDpdData($method_name, $arData=array(), $is_request=0){
		if(!DPD_service::_connect2Dpd($method_name)) return false;
		// параметр запроса для аутентификации
		$arData['auth'] = array(
			'clientNumber' => DPD_service::$MY_NUMBER,
			'clientKey' => DPD_service::$MY_KEY,
		);
		// упаковка запроса в поле 'request'
		if($is_request) $arRequest['request'] = $arData;
		else $arRequest = $arData;
		try{
			//eval("\$obj = \DPD_service::SOAP_CLIENT->\$method_name(\$arRequest);");
			$obj = DPD_service::$SOAP_CLIENT->$method_name($arRequest);
			if(!$obj) throw new Exception('Ошибка');
		} catch (Exception $ex) {
			DPD_service::$arMSG['str'] = 'Не удалось вызвать метод '.$method_name.' / '.$ex;
		}
		return $obj ? $obj : false;
	}
	/**
	* Парсер объекта в массив (рекурсия)
	*
	* @access private
	* @param object $obj Объект
	* @param integer $isUTF Флаг необходимости конвертирования строк из UTF в WIN (0|1), по-дефолту "1" - конвертить
	* @param array $arr Внутренний cлужебный массив для обеспечения рекурсии
	* @return array
	*/
	private function _parceObj2Arr($obj,$isUTF=1,$arr=array()){
		$isUTF = $isUTF ? 1 : 0;
		if(is_object($obj) || is_array($obj) ){
			$arr = array();
			for(reset($obj); list($k, $v) = each($obj);){
				if($k === "GLOBALS") continue;
				$arr[$k] = DPD_service::_parceObj2Arr($v, $isUTF, $arr);
			}return $arr;
		}elseif(gettype($obj) == 'boolean'){
			return $obj ? 'true' : 'false';
		}else{
			// конверт строк: utf-8 --> windows-1251
			if($isUTF && gettype($obj)=='string') $obj = iconv('utf-8','windows-1251',$obj);
			return $obj;
		}
	}
}
?>