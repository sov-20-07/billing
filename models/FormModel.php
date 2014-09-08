<?
class Form{
	public static $fieldsStandart=array(
		'string'=>'Строка',
		'text'=>'Текст',
		'select'=>'Выбор',
		'radio'=>'Радио (да/нет)',
		'hidden'=>'Скрытое'
	);
	function __construct(){
		
	}
	public function send(){
		$form=$this->getForm(Funcs::$uri[1]);
		$text='';
		foreach($this->getFields(Funcs::$uri[1]) as $item){
			if($item['type']=='text'){
				$text.='<b>'.$item['name'].'</b><br /> '.nl2br($_POST[$item['path']]).'<br />';
			}elseif($item['type']=='checkbox'){
				if($_POST[$item['path']]){
					$text.='<b>'.$item['name'].'</b><br />';
				}
			}else{
				$text.='<b>'.$item['name'].'</b> '.$_POST[$item['path']].'<br />';
			}
		}
		$mail=new Email;
		$mail->mailTo($form["email"]);
		$mail->Subject($form['theme']);
		$mail->Text($text);
		$mail->Send();
	}
	public function getForm($id){
		$sql='SELECT * FROM {{forms}} WHERE id='.$id.'';
		return DB::getRow($sql);
	}
	public function getFields($forms){
		$sql='SELECT * FROM {{forms_fields}} WHERE forms='.$forms.'';
		return DB::getAll($sql);
	}
}
?>