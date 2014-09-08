<?
class Message{
	public static function addMessage($touser,$message){
		$sql='
			INSERT INTO {{messages}}
			SET 
				fromuser='.$_SESSION['iuser']['id'].',
				touser='.$touser.',
				message=\''.$message.'\',
				cdate=NOW()
		';
		DB::exec($sql);
		$sql='SELECT CONCAT(fname,\' \',lname) AS name, email FROM {{iusers}} WHERE id='.$touser.'';
		$row=DB::getRow($sql);
		$toname=$row['name'];
		$email=$row['email'];
		if(trim($toname)=='')$toname='Неизвестный';
		$text='
			Здравствуйте, '.$toname.'!<br /><br />
			'.$_SESSION['iuser']['name'].' написал Вам новое сообщение на сайте <a href="http://'.$_SERVER['HTTP_HOST'].'">'.$_SERVER['HTTP_HOST'].'</a>.<br /><br />
		';
		$text=View::getRenderEmpty('email/simple',array('text'=>$text,'title'=>'Новое сообщение'));
		$mail=new Email;
		$mail->To($email);
		$mail->Subject('Новое сообщение от '.$_SESSION['iuser']['name'].' на сайте '.$_SERVER['HTTP_HOST']);
		$mail->Text($text);
		$mail->Send();
	}
	public static function getUsers(){
		$data=array();
		$users=array();
		$sql='
			SELECT DISTINCT fromuser, touser FROM {{messages}}
			WHERE fromuser='.$_SESSION['iuser']['id'].' OR touser='.$_SESSION['iuser']['id'].'
			ORDER BY cdate 
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			if($item['fromuser']!=$_SESSION['iuser']['id']){
				$users[$item['fromuser']]='fromuser';
			}elseif($item['touser']!=$_SESSION['iuser']['id']){
				$users[$item['touser']]='touser';
			}
		}
		foreach($users as $id=>$item){
			$sql='SELECT CONCAT(fname,\' \',lname) AS name, email, avatar FROM {{iusers}} WHERE id='.$id.'';
			$user=DB::getRow($sql);
			if(trim($user['name'])=='')$user['name']='Неизвестный';
			$sql='
				SELECT message, cdate FROM {{messages}} 
				WHERE '.$item.'='.$id.'
				ORDER BY cdate DESC
				LIMIT 0,1
			';
			$message=DB::getRow($sql);
			$data[]=array(
				'name'=>$user['name'],
				'email'=>$user['email'],
				'avatar'=>$user['avatar'],
				'user'=>$id,
				'message'=>$message['message'],
				'cdate'=>$message['cdate'],
				'direction'=>$item
			);
		}
		return $data;
	}
	public static function getList($id){
		$data=array();
		$sql='SELECT id, CONCAT(fname,\' \',lname) AS name, email, avatar FROM {{iusers}} WHERE id='.$id.'';
		$user=DB::getRow($sql);
		$sql='
			SELECT * FROM {{messages}}
			WHERE (fromuser='.$_SESSION['iuser']['id'].' AND touser='.$id.') OR (fromuser='.$id.' AND touser='.$_SESSION['iuser']['id'].')
			ORDER BY cdate 
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			if($item['fromuser']!=$_SESSION['iuser']['id']){
				$direction='fromuser';
			}elseif($item['touser']!=$_SESSION['iuser']['id']){
				$direction='touser';
			}
			$data[]=array(
				'id'=>$item['id'],
				'message'=>$item['message'],
				'cdate'=>$item['cdate'],
				'direction'=>$direction
			);
		}
		return array('user'=>$user,'list'=>$data);
	}
	public static function delMessage($id){
		$sql='
			DELETE FROM {{messages}}
			WHERE id='.$id.'
		';
		DB::exec($sql);
	}
}
?>