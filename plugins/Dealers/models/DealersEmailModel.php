<?php
class DealersEmail {
	public static function order_status($order) {
		$order  = DealersOrders::getOne($order);
		$dealer = DealersMain::getOne($order['dealer']);
		self::send(
			$dealer['emailreport'],
			'Изменение статуса заказа на сайте www.'.self::site(),
			View::getPluginEmpty('email/order_status', array('dealer'=>$dealer,'order'=>$order))
		);
	}
	public static function address_status($store) {
		$store  = DealersStores::getOne($store);
		$dealer = DealersMain::getOne($store['dealer']);
		self::send(
			$dealer['emailreport'],
			'Изменение магазина на сайте www.'.self::site(),
			View::getPluginEmpty('email/address_status', array('dealer'=>$dealer,'store'=>$store))
		);
	}
	public static function address_new($store) {
		$store  = DealersStores::getOne($store);
		$dealer = DealersMain::getOne($store['dealer']);
		self::send(
			$dealer['emailreport'],
			'Изменение адреса на сайте www.'.self::site(),
			View::getPluginEmpty('email/address_new', array('dealer'=>$dealer,'store'=>$store,'site'=>self::site()))
		);
	}	
	public static function dealer_status($dealer) {
		$dealer = DealersMain::getOne($dealer);
		self::send(
			$dealer['emailreport'],
			'Изменение статуса дилера на сайте www.'.self::site(),
			View::getPluginEmpty('email/dealer_status', array('dealer'=>$dealer))
		);
	}
	public static function dealer_activate($dealer) {
		$dealer = DealersMain::getOne($dealer);
		self::send(
			$dealer['emailreport'],
			'Изменение статуса дилера на сайте www.'.self::site(),
			View::getPluginEmpty('email/dealer_activate', array('dealer'=>$dealer))
		);
	}	
	public static function files_new($dealer, $filename) {
		$dealer = DealersMain::getOne($dealer);
		self::send(
			$dealer['emailreport'],
			'Новый файл сайте www.'.self::site(),
			View::getPluginEmpty('email/files_new', array('dealer'=>$dealer,'file'=>$filename))
		);
	}
	private static function site(){
		return str_replace("www.", "", $_SERVER["HTTP_HOST"]);
	}
	private static function send($address, $subject, $text){
		$mail=new Email;
		$mail->To($address);
		$mail->Subject($subject);
		$mail->Text($text);
		$mail->Send();
	}
}
