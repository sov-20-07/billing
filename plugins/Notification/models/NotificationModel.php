<?
class Notification{
	public static $emaillist=array('iusers'=>'Клиентам','subscribers'=>'Подписчикам','orders'=>'Покупателям');
	public static $groups=array('iusers'=>'Клиенты','subscribers'=>'Подписчики','orders'=>'Покупатели');
	private static $viewDir;
	function __construct(){
		$dirname = dirname(dirname(__FILE__)).'/';
		self::$viewDir = str_replace($_SERVER['DOCUMENT_ROOT'], '', $dirname);
	}
	function getList(){
		$data=array();
		$sql='SELECT * FROM {{notification}} ORDER BY cdate DESC';
		$list=DB::getPagi($sql);
		foreach($list as $item){
			$user=User::getInfo($item['author']);
			$item['author']=$user['name'];
			$data[]=$item;
		}
		return $data;
	}
	function getEdit($id){
		$sql='SELECT * FROM {{notification}} WHERE id='.$id.'';
		return DB::getRow($sql);
	}
	function send(){
		$emails=array();
		$groups=array();
		if(!isset($_POST['users']) and !isset($_POST['email'])){
			return;
		}
		$sqlGroups='';
		if(!empty($_POST['users'])){
			foreach($_POST['users'] as $item){
				if($item=='iusers'){
					$sql='SELECT email FROM {{iusers}} WHERE visible=1';
					$emails=array_merge($emails,DB::getAll($sql,'email'));
				}elseif($item=='subscribers'){
					$sql='SELECT email FROM {{subscribers}}';
					$emails=array_merge($emails,DB::getAll($sql,'email'));
				}elseif($item=='orders'){
					$sql='SELECT email FROM {{orders}}';
					$emails=array_merge($emails,DB::getAll($sql,'email'));
				}else{
					$groups[]=$item;
				}
			}
			$sqlGroups='emailgroups=\''.implode(',',$_POST['users']).'\',';
		}
		if(!empty($groups)){
			$users = Iuser::getGroupUsers($groups, 'email');
			$emails=array_merge($emails,$users);
		}
		$emails[]=$_POST['email'];
		$emails=array_unique($emails);
		$text = View::getRenderFullEmpty('email/notifications',array('text'=>$_POST['body'],'title'=>$_POST['subject']));
		foreach($emails as $email){
			$mail = new Email;
			$mail->Text($text);
			$mail->Subject($_POST['subject']);
			$mail->From($_POST['emailfrom']);
			$mail->mailTo($email);
			$mail->Send();
		}
		$sql='
			INSERT INTO {{notification}}
			SET 
				subject=\''.$_POST['subject'].'\',
				body=\''.$_POST['body'].'\',
				email=\''.implode(',',$emails).'\',
				'.$sqlGroups.'
				emailfrom=\''.$_POST['emailfrom'].'\',
				cdate=NOW(),
				author='.$_SESSION['user']['id'].'
		';
		DB::exec($sql);
	}
	function getGroups(){
		return Notification::$groups;
	}
	function getGroup($name){
		$data['list']=array();
		if($name=='iusers'){
			$sql='SELECT * FROM {{iusers}} WHERE visible=1';
			$data['list']=DB::getAll($sql);
		}elseif($name=='subscribers'){
			$sql='SELECT * FROM {{subscribers}}';
			$data['list']=DB::getAll($sql);
		}elseif($name=='orders'){
			$sql='SELECT * FROM {{orders}}';
			$data['list']=DB::getAll($sql);
		}
		return $data;
	}
}
?>