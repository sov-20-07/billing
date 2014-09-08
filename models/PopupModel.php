<?
class Popup{
	public function sendCallback(){
		DB::escapePost();
		$text.='<b>Имя:</b> '.trim($_POST['name']).'<br />';
		$text.='<b>Телефон:</b> '.trim($_POST['phone']).'<br />';
		View::$layout='empty';
		$text=View::getRender('email/callback',array('text'=>$text));
		$mail=new Email;
		$mail->mailTo(Funcs::$conf['email']['callback']);
		$mail->Subject('Заказ звонка на сайте '.$_SERVER['HTTP_HOST']);
		$mail->Text($text);
		$mail->Send();
		//file_get_contents("http://sms.spb.su/sms.cgi?user=".USER_SMS."&pass=".PASS_SMS."&phone=".Funcs::$conf['additional']['sms']."&flash=0&message=".urlencode(iconv('utf-8','windows-1251','Заявка на звонок '.trim($_POST['name']).' '.trim($_POST['phone'])))."&from=dvr-group");
	}
	public function sendMailback(){
		DB::escapePost();
		$text.='<b>Имя:</b> '.$_POST['name'].'<br />';
		$text.='<b>Телефон:</b> '.$_POST['phone'].'<br />';
		$text.='<b>Email:</b> '.$_POST['email'].'<br />';
		$text.='<b>Сообщение:</b> '.nl2br($_POST['message']).'<br />';
		View::$layout='empty';
		$text=View::getRender('email/callback',array('text'=>$text));
		$mail=new Email;
		$mail->mailTo(Funcs::$conf['email']['callback']);
		$mail->Subject('Обратная связь на сайте '.$_SERVER['HTTP_HOST']);
		$mail->Text($text);
		$mail->Send();
	}
}
?>