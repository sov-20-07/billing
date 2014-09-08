<?php
include $_SERVER['DOCUMENT_ROOT'].'/'.ONESSA_DIR.'/lib/mycurl.php';
class User
{
	public function login(){
		Funcs::escapePost();
		$sql='SELECT * FROM {{iusers}} WHERE email=\''.$_POST['email'].'\' AND visible=1';
		$user=DB::getRow($sql);
		if($user['id'] && $user['pass']==md5($_POST['pass'])){
			//$options=User::getOptions($user['id']);
			if($_SESSION['info']['provider']){
				$addprovider=$_SESSION['info']['provider'].'=\''.$_SESSION['info']['uid'].'\'';
				$sql='
					UPDATE {{iusers}}
					SET 
						'.$addprovider.'
					WHERE id='.$user['id'].'
				';
				$newuser=DB::exec($sql);
			}
			User::setSession($user['id']);
			return '';
		}else{
			return 'error';
		}
	}
	public function loginza(){
		$answer=file_get_contents('http://loginza.ru/api/authinfo?token='.$_POST['token']);
		$info=json_decode($answer, true);
		if(strpos($info['provider'],'facebook')!==false){
			$provider='fb';
		}elseif(strpos($info['provider'],'vk')!==false){
			$provider='vk';
		}elseif(strpos($info['provider'],'twitter')!==false){
			$provider='tw';
		}elseif(strpos($info['provider'],'google')!==false){
			$provider='go';
		}elseif(strpos($info['provider'],'yandex')!==false){
			$provider='ya';
		}elseif(strpos($info['provider'],'linkedin')!==false){
			$provider='ya';
		}
		if($info['name']['first_name']){
			$name['first_name']=$info['name']['first_name'];
			$name['last_name']=$info['name']['last_name'];
		}else{
			$temp=explode(' ',$info['name']['full_name']);
			$name['first_name']=$temp[0];
			$name['last_name']=$temp[1];
		}
		$info['name']=$name;
		$info['provider']=$provider;
		$sql='SELECT id FROM {{iusers}} WHERE visible=1 AND '.$provider.'=\''.$info['uid'].'\'';
		$userId=DB::getOne($sql);
		if($userId){
			User::setSession($userId);
			return 'ok';
		}else{
			$_SESSION['info']=$info;
		}
	}
	public function setUpdate()
	{
		Funcs::escapePost();
		/*$sql='SELECT count(*) FROM {{iusers}} WHERE login=\''.$_POST['login'].'\'';
		if(DB::getOne($sql)==0) $login='login=\''.$_POST['login'].'\',';
		$sql='SELECT count(*) FROM {{iusers}} WHERE email=\''.$_POST['email'].'\'';
		if(DB::getOne($sql)==0) $email='login=\''.$_POST['login'].'\',';
		if(date('d.m.Y',strtotime($_POST['birthday']))=='01.01.1970' && $_POST['birthday']!='01.01.1970') $birthday='birthday=\'0000-00-00\',';
		else $birthday='birthday=\''.date('Y-m-d',strtotime($_POST['birthday'])).'\',';
		$sql='
			SELECT count(*) FROM {{iusers}} 
			WHERE pass=\''.md5($_POST['pass']).'\' AND id='.$_SESSION['iuser']['id'].'
		';
		if(DB::getOne($sql)>0 && $_POST['newpass']!='') $pass='pass=\''.md5($_POST['newpass']).'\',';
		if($_POST['emailhide']=='')$_POST['emailhide']=0;*/
		$sql='
			UPDATE {{iusers}}
			SET 
				name=\''.$_POST['name'].'\',
				phone=\''.$_POST['phone'].'\',
				address=\''.$_POST['address'].'\'
			WHERE id='.$_SESSION['iuser']['id'].'
		';
		DB::exec($sql);
		if($_SESSION['iuser']['role']=='dealer'){
			foreach(OneSSA::$iuserStandartAdds['Карточка пользователя'] as $key=>$item){
				$sql='DELETE FROM {{iusers_adds}} WHERE name=\''.$key.'\' AND iuser='.$_SESSION['iuser']['id'].'';
				DB::exec($sql);
				$sql='
					INSERT INTO {{iusers_adds}} 
					SET iuser='.$_SESSION['iuser']['id'].',
						name=\''.$key.'\',
						string_value=\''.$_POST[$key].'\' 
				';
				DB::exec($sql);
			}
		}
		User::setSession();
	}
	public function setPass()
	{
		Funcs::escapePost();
		$sql='
			UPDATE {{iusers}}
			SET pass=MD5(\''.$_POST['pass'].'\')
			WHERE id='.$_SESSION['iuser']['id'].'
		';
		DB::exec($sql);
	}
	public function setAccount(){
		Funcs::escapePost();
		$error=array();
		$sql='SELECT id FROM {{iusers}} WHERE email=\''.$_POST['email'].'\'';
		if(DB::getOne($sql)>0) $error['email']=1;
		if(count($error)>0){
			return $error;
		}else{
			$pass=$this->generate_password(8);
			if(trim($_POST['pass'])!='')$pass=$_POST['pass'];
			$sql='
				INSERT INTO {{iusers}}
				SET 
					login=\''.$_POST['login'].'\',
					email=\''.$_POST['email'].'\',
					pass=MD5(\''.$pass.'\'),
					cdate=NOW(),
					visible=0
			';
			$newuser=DB::exec($sql);
			$code=md5($_POST["email"].'add');
			$text='
				Здравствуйте, ' . $_POST["login"] . '.<br />
				Кто-то, возможно Вы, оставили запрос на регистрацию на сайте ' . $_SERVER["HTTP_HOST"] . '.<br />
				Для подтверждения регистрации нажмите на ссылку: <a href="http://'.$_SERVER["HTTP_HOST"].'/registration/confirm/?c='.$code.'">http://'.$_SERVER["HTTP_HOST"].'/registration/confirm/?c='.$code.'</a><br />
			';
			if(trim($_POST['pass'])==''){
				$text.='
					<br />
					Вам выдан пароль: '.$pass.'<br />
					Для смены пароля воспользуйтесь личным кабинетом.
				';
			}
			$mail=new Email;
			$mail->To($_POST["email"]);
			$mail->Subject('Подтверждение регистрации на сайте www.'.str_replace("www.", "", $_SERVER["HTTP_HOST"]));
			$mail->Text($text);
			$mail->Send();
			//return $newuser;
		}
	}
	public function setRegistration($userinfo=''){
		Funcs::escapePost();
		$error=array();
		if($userinfo==''){
			$userinfo=array(
				'name'=>$_POST['name'],
				'email'=>$_POST['email'],
				'phone'=>$_POST['phone'],
				'address'=>$_POST['address'],
			);
		}
		$sql='SELECT id FROM {{iusers}} WHERE email=\''.$userinfo['email'].'\'';
		$id=DB::getOne($sql);
		if($id>0) $error['email']=1;
		if(count($error)>0){
			return $id;
			/*$text='
				Здравствуйте, '.$return["login"].'.<br />
				Вы уже зарегистрированы на сайте '.$_SERVER["HTTP_HOST"].'.<br />
			';
			if($return['visible']==0){
				$text.='Для подтверждения регистрации нажмите на ссылку: <a href="http://'.$_SERVER["HTTP_HOST"].'/registration/confirm/?c='.md5($return["email"].'add').'">http://'.$_SERVER["HTTP_HOST"].'/registration/confirm/?c='.md5($return["email"].'add').'</a>';
			}
			$mail=new Email;
			$mail->To($_POST["email"]);
			$mail->Subject('Регистрация на сайте www.'.str_replace("www.", "", $_SERVER["HTTP_HOST"]));
			$mail->Text($text);
			$mail->Send();*/
		}else{
			$pass=$this->generate_password(8);
			if(trim($_POST['pass'])!='')$pass=$_POST['pass'];
			if($_SESSION['info']['provider']){
				$addprovider=$_SESSION['info']['provider'].'=\''.$_SESSION['info']['uid'].'\', ';
			}
			$sql='
				INSERT INTO {{iusers}}
				SET 
					name=\''.$userinfo['name'].'\',
					email=\''.$userinfo['email'].'\',
					phone=\''.$userinfo['phone'].'\',
					address=\''.$userinfo['address'].'\',
					pass=MD5(\''.$pass.'\'),
					'.$addprovider.'
					cdate=NOW(),
					visible=0
			';
			$newuser=DB::exec($sql);
			$code=md5($userinfo["email"].'add');
			$text='
				Здравствуйте, ' . $userinfo["name"] . '.<br />
				Кто-то, возможно Вы, оставили запрос на регистрацию на сайте ' . $_SERVER["HTTP_HOST"] . '.<br />
				Для подтверждения регистрации нажмите на ссылку: <a href="http://'.$_SERVER["HTTP_HOST"].'/registration/confirm/?c='.$code.'">http://'.$_SERVER["HTTP_HOST"].'/registration/confirm/?c='.$code.'</a><br />
			';
			if(trim($_POST['pass'])==''){
				$text.='
					<br />
					Вам выдан пароль: '.$pass.'<br />
					Для смены пароля воспользуйтесь личным кабинетом.
				';
			}
			$mail=new Email;
			$mail->To($userinfo["email"]);
			$mail->Subject('Подтверждение регистрации на сайте www.'.str_replace("www.", "", $_SERVER["HTTP_HOST"]));
			$mail->Text($text);
			$mail->Send();
			return $newuser;
		}
	}
	public function setConfirm(){
		$sql='
			UPDATE {{iusers}}
			SET visible=1
			WHERE MD5(CONCAT(email,"add"))="'.$_GET["c"].'"
		';
		DB::exec($sql);
		$sql='
			SELECT * FROM {{iusers}} WHERE MD5(CONCAT(email,"add"))="'.$_GET["c"].'"
		';
		$return=DB::getRow($sql);
		$text='
			Здравствуйте, '.$return['name'].'.<br />
			Вы успешно зарегистрированы на сайте <a href="http://www.'.str_replace('www.', '', $_SERVER["HTTP_HOST"]).'">'.$_SERVER["HTTP_HOST"].'</a>.		
		';
		$mail=new Email;
		$mail->To($return['email']);
		$mail->Subject('Подтверждение регистрации на сайте www.'.str_replace("www.", "", $_SERVER["HTTP_HOST"]));
		$mail->Text($text);
		$mail->Send();
	}
	public function setForgot(){
		DB::escapePost();
		$sql='
			SELECT * FROM {{iusers}} WHERE email=\''.$_POST['email'].'\'
		';
		$return=DB::getRow($sql);
		if($return){			
			$pass=$this->generate_password(8);
			$sql='
				UPDATE {{iusers}}
				SET pass=MD5(\''.$pass.'\')
				WHERE email=\''.$_POST['email'].'\'
			';
			DB::exec($sql);
			$text='
				Здравствуйте, '.$return["login"].'.<br />
				Ваш новый пароль '.$pass.'.<br />
				Сменить пароль Вы можете в личном кабинете. 
			';
			$mail=new Email;
			$mail->To($_POST['email']);
			$mail->Subject('Восстановление пароля на сайте www.'.str_replace("www.", "", $_SERVER["HTTP_HOST"]));
			$mail->Text($text);
			$mail->Send();
		}
	}
	public function generate_password($number){  
	    $arr = array('a','b','c','d','e','f',  
	                 'g','h','i','j','k','l',  
	                 'm','n','o','p','r','s',  
	                 't','u','v','x','y','z',  
	                 'A','B','C','D','E','F',  
	                 'G','H','I','J','K','L',  
	                 'M','N','O','P','R','S',  
	                 'T','U','V','X','Y','Z',  
	                 '1','2','3','4','5','6',  
	                 '7','8','9','0');  
	    // Генерируем пароль  
	    $pass = "";  
	    for($i = 0; $i < $number; $i++)  
	    {  
	      // Вычисляем случайный индекс массива  
	      $index = rand(0, count($arr) - 1);  
	      $pass .= $arr[$index];  
	    }  
	    return $pass;  
	}
	public static function getOptions($id)
	{
		$data=array();
		$sql='SELECT * FROM {{iusers_options}} WHERE iuser='.$id.'';
		$temp=DB::getRow($sql);
		if(is_array($temp)){
			foreach($temp as $key=>$item){
				if($key!='id' && $key!='iuser'){
					$data[$key]=$item;
				}
			}
		}
		return $data;
	}
	public function saveOptions($id,$option,$value)
	{
		if(count($this->getOptions($id))>0){
			$sql='
				UPDATE {{iusers_options}}
				SET '.$option.'=\''.$value.'\'
				WHERE iuser='.$id.'
			';
		}else{
			$sql='
				INSERT INTO {{iusers_options}}
				SET iuser='.$id.',
					'.$option.'=\''.$value.'\'
			';
		}
		DB::exec($sql);
	}
	public function avatar(){
		if($_FILES['upload']['name']){
			$dir='';
			$outdir='';
			$filename=explode('.',$_FILES['upload']['name']);
			$raz=$filename[count($filename)-1];
			if(in_array(strtolower($raz),array('jpeg','jpg','png','gif','bmp'))){
				unset($filename[count($filename)-1]);
				$filename=implode('',$filename);
				$filenameraz=Funcs::Transliterate($filename).'.'.$raz;
				$dir=$_SERVER['DOCUMENT_ROOT'].PHOTO_DIR.'iuser/';
				$dirfile=$dir.$filenameraz;
				$x=0;$i=1;
				while($x==0){
					if(file_exists($dirfile)){
						$filenameraz=Funcs::Transliterate($filename).$i.'.'.$raz;
						$dirfile=$dir.$filenameraz;
					}else{
						$x=1;
					}
					$i++;
				}
				Funcs::resizePicCrop($_FILES['upload']['tmp_name'],$dirfile,80,80,$raz);
				chmod($dirfile,0777);
				if(file_exists($_SERVER['DOCUMENT_ROOT'].$_SESSION['iuser']['avatar'])) unlink($_SERVER['DOCUMENT_ROOT'].$_SESSION['iuser']['avatar']);
				$dirfile=substr($dirfile,strpos($dirfile,PHOTO_DIR),strlen($dirfile));
				$sql='
					UPDATE {{iusers}} SET avatar=\''.$dirfile.'\'
					WHERE id='.$_SESSION['iuser']['id'].'
				';
				DB::exec($sql);
				User::setSession();
			}
		}
	}
	public function avatardel(){
		if(file_exists($_SERVER['DOCUMENT_ROOT'].$_SESSION['iuser']['avatar'])) unlink($_SERVER['DOCUMENT_ROOT'].$_SESSION['iuser']['avatar']);
		$sql='
			UPDATE {{iusers}} SET avatar=\'\'
			WHERE id='.$_SESSION['iuser']['id'].'
		';
		DB::exec($sql);
		User::setSession();
	}
	public static function setSession($id=0){
		if($id==0)$id=$_SESSION['iuser']['id'];
		$sql='SELECT * FROM {{iusers}} WHERE id='.$id.' AND visible=1';
		$user=DB::getRow($sql);
		if($user){
			$sql='SELECT * FROM {{iusers_adds}} WHERE iuser='.$id.'';
			$list=DB::getAll($sql);
			foreach($list as $item){
				$userinfo[$item['name']]=$item['string_value'];
			}
			$sql='SELECT * FROM {{igroups}} WHERE id='.$user['igroup'].'';
			$user['igroup']=DB::getRow($sql);
			$user['role']=$user['igroup']['path'];
			$user['info']=$userinfo;
			$_SESSION['iuser']=$user;
		}else{
			unset($_SESSION['iuser']);
		}
	}
	public static function getAvatar($id){
		$sql='
			SELECT avatar FROM {{iusers}}
			WHERE id='.$id.'
		';
		return DB::getOne($sql);
	}
	public static function getOne($id){
		$sql='SELECT * FROM {{iusers}} WHERE id='.$id.' AND visible=1';
		$data=DB::getRow($sql);
		return $data;
	}
	public function setAnketa(){
		Funcs::escapePost();
		$data=array();
		$text='';
		foreach(OneSSA::$iuserStandartAdds as $title=>$items){
			$text.='<h3>'.$title.':</h3>';
			foreach($items as $key=>$item){
				if($item['type']=='bool'){
					$data[$key]=$_POST[$key]==1?'1':'0';
					$_POST[$key]=$_POST[$key]==1?'Да':'Нет';
				}else{
					if($item['main']!=1){
						$data[$key]=$_POST[$key];
					}
				}
				$text.='<b>'.$item['name'].':</b> '.$_POST[$key].'<br />';
			}
		}
		$pass=Funcs::generate_password(8);
		$address=array();
		foreach(OneSSA::$iuserStandartAdds['1.2 Фактический адрес'] as $key=>$item){
			if($_POST[$key]!='')$address[]=$_POST[$key];
		}
		if(count($address)>0)$address=implode(', ',$address);
		else $address='';
		$sql='
			INSERT INTO {{iusers}}
			SET name=\''.$_POST['name'].'\',
				phone=\''.$_POST['phone'].'\',
				email=\''.$_POST['email'].'\',
				pass=\''.md5($pass).'\',
				address=\''.$address.'\',
				visible=0,
				cdate=NOW()
		';
		$id=DB::exec($sql);
		$text.='<b>Пароль:</b> '.$pass.'<br />';
		$text.='<b>Пользователь:</b> '.$id.'<br />';
		foreach($data as $key=>$item){
			$sql='
				INSERT INTO {{iusers_adds}}
				SET iuser='.$id.',
					name=\''.$key.'\',
					string_value=\''.$_POST[$key].'\'
			';
			DB::exec($sql);
		}
		$mail=new Email;
		$mail->mailTo(Funcs::$conf['email']['anketa']);
		$mail->Subject('Новая анкета партнера на сайте '.str_replace("www.", "", $_SERVER["HTTP_HOST"]));
		View::$layout='empty';
		$text=View::getRender('email/anketa',array('text'=>$text));
		$mail->Text($text);
		$mail->Send();
	}
}