<?
class Spage{
	public function getList($parent,$order='num',$limit=''){
		$data=array();
		if($limit!='')$limit='LIMIT '.$limit;
		$sql='SELECT * FROM {{tree}} WHERE parent='.$parent.' ORDER BY '.$order.' '.$limit;
		$list=DB::getPagi($sql);
		foreach ($list as $item){
			$field=Fields::getFieldsByTree($item['id'],'gal');
			$data[]=array(
				'id'=>$item['id'],
				'name'=>$item['name'],
				'path'=>Tree::getPathToTree($item['id']),
				'udate'=>date('d.m.Y',strtotime($item['udate'])),
				'fields'=>$field,
				'pic'=>$field['files_gal1']['image'][0]['path'],
			);
		}
		return $data;
	}
	public function getListPagi($parent,$order='num'){
		$data=array();
		$sql='SELECT * FROM {{tree}} WHERE parent='.$parent.' ORDER BY '.$order.'';
		$list=DB::getPagi($sql);
		foreach ($list as $item){
			$data[]=array(
				'name'=>$item['name'],
				'path'=>'/'.Funcs::$uri[0].'/'.$item['path'].'/',
				'udate'=>date('d.m.Y',strtotime($item['udate'])),
				'fields'=>Fields::getFieldsByTree($item['id'],'wide')
			);
		}
		return $data;
	}
	public function getOne($id){
		if($_POST){
			if(Spage::send($id)){
				View::$layout='empty';
				View::render('site/redirect',array('href'=>'/vacancy/','text'=>'Заявка принята!\nМы свяжемся с Вами в ближайшее время'));
			}
		}
		$field=Fields::getFieldsByTree($id,'wide');
		return $field;
	}
	public static function send($id){
		foreach ($_POST as $key=>$value) $_POST[$key] = htmlspecialchars(trim(strip_tags($value)));
		if($_SESSION['captcha_keystring']==$_POST['kcaptcha'] && $_SESSION['captcha_keystring']!=''){
			$text='';
			foreach($_POST as $name=>$item){
				if($_POST[$name.'_text'] && strpos($name,'_text')===false){
					if(strpos($name,'_area')!==false){
						$text.='<b>'.$_POST[$name.'_text'].':</b> <br />'.nl2br($item).'<br />';
					}else{
						$text.='<b>'.$_POST[$name.'_text'].':</b> '.$item.'<br />';
					}
				}
			}
			$mail=new Email;
			$info=Tree::getInfo($id);
			if(Funcs::$conf['mail'][$info['path']]){
				$mail->To(Funcs::$conf['mail'][$info['path']]);
			}elseif(Funcs::$conf['settings']['email']){
				$mail->To(Funcs::$conf['settings']['email']);
			}else{
				return false;
			}
			$mail->Subject($_POST['subject'].' на сайте '.$_SERVER['HTTP_HOST']);
			$mail->Text($text);
			$mail->Send();
			return true;
		}else{
			return false;
		}
	}
}
?>