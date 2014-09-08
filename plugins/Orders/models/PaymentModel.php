<?
class Payment{
	public static $payments=array(
		'Наличными при получении',
		'Банковской картой Visa или MasterCard при получении',
		'Онлайн оплата банковской картой Visa или MasterCard',
		'Электронными деньгами (Яндекс.Деньги, Qiwi, Webmoney)',
		'Банковский перевод',
		'Наличными при получении',
		'Банковской картой Visa или MasterCard при получении',
		'Наложенный платёж',
		'Оплата с личного счета'
	);
	public static function getPayment(){
		$model=new Orders;
		$data=$model->getOrderById(Funcs::$uri[3]);
		print View::getPluginEmpty('payment',$data);
	}
}
?>