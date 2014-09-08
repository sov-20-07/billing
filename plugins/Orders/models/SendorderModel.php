<?
class Sendorder{
	public static $cabinet=false;
	public static function sendStatus($id){
		$data=Orders::getOrderById($id);
		View::$layout='empty';
		$text=View::getRenderFullEmpty('email/status',$data);
		$mail=new Email;
		$mail->mailTo($data['email']);
		$mail->Subject('Статус заказа №'.(str_repeat('0',6-strlen($id)).$id).' на сайте '.$_SERVER['HTTP_HOST'].' изменен');
		$mail->From('robot@'.str_replace('www.','',$_SERVER["HTTP_HOST"]));
		$mail->Text($text);
		$mail->Send();
	}
	public static function sendYandex($row){
		View::$layout='empty';
		$text=View::getRenderFullEmpty('email/yaopinions',$row);
		$mail=new Email;
		$mail->mailTo(array($row['email'],'svv@one-touch.ru'));
		$mail->Subject('Оставьте свой отзыв о магазине '.$_SERVER['HTTP_HOST']);
		$mail->From('robot@'.str_replace('www.','',$_SERVER["HTTP_HOST"]));
		$mail->Text($text);
		$mail->Send();
	}
	public static function sendFile($id){
		View::$layout='empty';
		$text='
			Здравствуйте!<br />
			Вам выставлен счет за заказ №'.(str_repeat('0',6-strlen($id)).$id).'
		';
		$text=View::getRenderFullEmpty('email/simple',array('text'=>$text));
		$mail=new Email;
		$mail->mailTo(trim($_POST['email']));
		$mail->Subject('Выставлен счет за заказ №'.(str_repeat('0',6-strlen($id)).$id).' на сайте '.$_SERVER['HTTP_HOST']);
		$mail->From('robot@'.str_replace('www.','',$_SERVER["HTTP_HOST"]));
		$mail->Text($text);
		$mail->Attach($_FILES['upload']['tmp_name'],$_FILES['upload']['name'], "", "attachment" );
		$mail->Send();
	}
	public static function sendAllOrder($id){
		$data=Orders::getOrderById($id);
		View::$layout='empty';
		$text=View::getRenderFullEmpty('email/order',$data);
		$mail=new Email;
		$mail->mailTo($data['email']);
		$mail->Subject('Статус заказа №'.(str_repeat('0',6-strlen($id)).$id).' на сайте '.$_SERVER['HTTP_HOST'].' изменен');
		$mail->From('robot@'.str_replace('www.','',$_SERVER["HTTP_HOST"]));
		$mail->Text($text);
		$mail->Send();
	}
}
?>