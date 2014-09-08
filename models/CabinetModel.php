<?php
class Cabinet
{
	public static function getOneAdds($id){
		$sql='SELECT * FROM {{iusers_adds}} WHERE id='.$id.' AND iuser='.$_SESSION['iuser']['id'].''; 
		return DB::getRow($sql);
	}
	public function saveAdds()
	{
		foreach ($_POST as $key=>$value) $_POST[$key] = htmlspecialchars(trim($value));
		if($_POST['id']==''){
			$sql='
				INSERT INTO {{iusers_adds}}
				SET 
					`iuser`='.$_SESSION['iuser']['id'].',
					`title`=\''.$_POST['title'].'\',
					`name`=\''.$_POST['name'].'\',
					`email`=\''.$_POST['email'].'\',
					`phone`=\''.$_POST['phone'].'\',
					`address`=\''.$_POST['address'].'\',
					`company`=\''.$_POST['company'].'\',
					`inn`=\''.$_POST['inn'].'\',
					`kpp`=\''.$_POST['kpp'].'\',
					`okpo`=\''.$_POST['okpo'].'\',
					`bank`=\''.$_POST['bank'].'\',
					`rs`=\''.$_POST['rs'].'\',
					`ks`=\''.$_POST['ks'].'\',
					`bik`=\''.$_POST['bik'].'\',
					`yura`=\''.$_POST['yura'].'\'
			';
		}else{
			$sql='
				UPDATE {{iusers_adds}}
				SET 
					`iuser`='.$_SESSION['iuser']['id'].',
					`title`=\''.$_POST['title'].'\',
					`name`=\''.$_POST['name'].'\',
					`email`=\''.$_POST['email'].'\',
					`phone`=\''.$_POST['phone'].'\',
					`address`=\''.$_POST['address'].'\',
					`company`=\''.$_POST['company'].'\',
					`inn`=\''.$_POST['inn'].'\',
					`kpp`=\''.$_POST['kpp'].'\',
					`okpo`=\''.$_POST['okpo'].'\',
					`bank`=\''.$_POST['bank'].'\',
					`rs`=\''.$_POST['rs'].'\',
					`ks`=\''.$_POST['ks'].'\',
					`bik`=\''.$_POST['bik'].'\',
					`yura`=\''.$_POST['yura'].'\'
				WHERE id='.$_POST['id'].' AND iuser='.$_SESSION['iuser']['id'].'
			';
		}
		DB::exec($sql);
	}
	public function delAdds()
	{
		$sql='DELETE FROM {{iusers_adds}} WHERE id='.Funcs::$uri[3].' AND iuser='.$_SESSION['iuser']['id'].''; 
		DB::exec($sql);
	}
	public function setRegistration(){
		foreach ($_POST as $key=>$value) $_POST[$key] = htmlspecialchars(trim($value));
		$sql='
			SELECT * FROM {{iusers}} WHERE email=\''.$_POST['email'].'\'
		';
		$return=DB::getRow($sql);
		if($return){
			$text='
				Здравствуйте, '.$return["name"].'.<br />
				Вы уже зарегистрированы на сайте '.$_SERVER["HTTP_HOST"].'.<br />
			';
			if($return['visible']==0){
				$text.='Для подтверждения регистрации нажмите на ссылку: <a href="http://'.$_SERVER["HTTP_HOST"].'/registration/confirm/?c='.md5($return["email"].'add').'">http://'.$_SERVER["HTTP_HOST"].'/registration/confirm/?c='.md5($return["email"].'add').'</a>';
			}
			$mail=new Email;
			$mail->To($_POST["email"]);
			$mail->Subject('Регистрация на сайте www.'.str_replace("www.", "", $_SERVER["HTTP_HOST"]));
			$mail->Text($text);
			$mail->Send();
		}else{
			$sql='
				INSERT INTO {{iusers}}
				SET 
					name=\''.$_POST['name'].'\',
					email=\''.$_POST['email'].'\',
					phone=\''.$_POST['phone'].'\',
					pass=MD5(\''.$_POST['pass'].'\'),
					cdate=NOW(),
					visible=0
			';
			DB::exec($sql);
			$code=md5($_POST["email"].'add');
			$text='
				Здравствуйте, ' . $_POST["name"] . '.<br />
				Кто-то, возможно Вы, оставили запрос на регистрацию на сайте ' . $_SERVER["HTTP_HOST"] . '.<br />
				Для подтверждения регистрации нажмите на ссылку: <a href="http://'.$_SERVER["HTTP_HOST"].'/registration/confirm/?c='.$code.'">http://'.$_SERVER["HTTP_HOST"].'/registration/confirm/?c='.$code.'</a>
			';
			$mail=new Email;
			$mail->To($_POST["email"]);
			$mail->Subject('Подтверждение регистрации на сайте www.'.str_replace("www.", "", $_SERVER["HTTP_HOST"]));
			$mail->Text($text);
			$mail->Send();
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
		foreach ($_POST as $key=>$value) $_POST[$key] = htmlspecialchars(trim($value));
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
				Здравствуйте, '.$return["name"].'.<br />
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
	public function getOrdersList(){
		$data=array();
		$status='';
		if($_GET['status'] && $_GET['status']!='all')$status=' AND status=\''.$_GET['status'].'\' '; 
		$sql='
			SELECT id FROM {{orders}} 
			WHERE iuser='.$_SESSION['iuser']['id'].' '.$status.'
			ORDER BY cdate DESC
		';
		$list=DB::getPagi($sql);
		foreach($list as $item){
			$data[]=Orders::getOne($item['id']);
		}
		return $data;
	}
	public function getNotification(){
		$data=array();
		$tree=array();
		$sql='SELECT id FROM {{tree}} WHERE path=\'catalog\' AND parent=1 AND visible=1';
		$parent=DB::getOne($sql);
		$sql='SELECT * FROM {{tree}} WHERE parent='.$parent.' AND visible=1 AND menu=1';
		$items=DB::getAll($sql);
		$k=0;
		$options=User::getOptions($_SESSION['iuser']['id']);
		$data['notify']=($options['notify']==1?'checked':'');
		$options['notification']=explode(',',$options['notification']);
		foreach($items as $i=>$item){
			$sql='SELECT * FROM {{tree}} WHERE parent='.$item['id'].' AND visible=1 AND menu=1';
			$subs=DB::getAll($sql);
			$item['sub']=array();
			foreach($subs as $sub){
				$checked='';
				if(in_array($sub['id'],$options['notification']))$checked='checked';
				$item['sub'][]=array(
					'id'=>$sub['id'],
					'name'=>$sub['name'],
					'checked'=>$checked					
				);
			}
			$checked='';
			if(in_array($item['id'],$options['notification']))$checked='checked';
			$item['checked']=$checked;
			$tree[$k][]=$item;
			if($i==0)$k++;
			else $k=$i%2+1;
		}
		$data['tree']=$tree;
		return $data;
	}
	public function saveNotification(){
		$notify=$_POST['notify']==1?'1':'0';
		$notification=implode(',',$_POST['trees']);
		$model=new User;
		$model->saveOptions($_SESSION['iuser']['id'],'notify',$notify);
		$model->saveOptions($_SESSION['iuser']['id'],'notification',$notification);
	}
}