<?
class Feedback{
	public function getList($parent){
		$data=array();
		$ids[]=$parent;
		$ids=array_merge($ids,Tree::getChilds($parent));		
		$sql='
			SELECT * FROM {{tree}}
			WHERE parent='.$parent.' AND visible=1
			ORDER BY num
		';
		$list=DB::getPagi($sql);
		foreach ($list as $item){
			$fields=Fields::getFieldsByTree($item['id'],'wide');
			$data[]=array(
				'name'=>$item['name'],
				'path'=>$path,
				'udate'=>date('d.m.Y',strtotime($item['udate'])),
				'answer'=>$fields['answer']
			);
		}
		return $data;
	}
	public function getSearch($parent){
		$data=array();
		$sql='
			SELECT {{tree}}.* FROM {{tree}} INNER JOIN {{search}} ON {{tree}}.id={{search}}.tree 
			WHERE parent='.$parent.' AND search LIKE \'%'.$_POST['q'].'%\' AND visible=1 
			ORDER BY udate DESC
		';
		$list=DB::getAll($sql);
		foreach ($list as $item){
			$data[]=array(
				'name'=>$item['name'],
				'path'=>Tree::getPathToTree($item['id']),
				'udate'=>date('d.m.Y',strtotime($item['udate'])),
				'fields'=>Fields::getFieldsByTree($item['id'],'wide')
			);
		}
		return $data;
	}
	public function sendMessage(){
		Funcs::escapePost();
		//if($_POST['kcaptcha']==$_SESSION['captcha_keystring'] && $_POST['kcaptcha']!='' && $_SESSION['captcha_keystring']!=''){
			$text='
				<b>ФИО:</b> '.$_POST['fio'].'<br />
				<b>Телефон:</b> '.$_POST['tel'].'<br />
				<b>Email:</b> <a href="mailto:'.$_POST['email'].'">'.$_POST['email'].'</a><br />
				<b>Тема:</b> '.$_POST['theme'].'<br />
				<b>Сообщение:</b><br />'.nl2br($_POST['quest']).'<br />
			';
			$mail=new Email;
			$mail->To(Funcs::$conf['email']['feedback']);
			$mail->Subject('Обратная связь на сайте '.$_SERVER['HTTP_HOST']);
			$mail->Text($text);
			$mail->Send();
			return false;
		/*}else{
			return true;
		}*/
	}
	public function getRubricsTree($tree){
		$data=array();
		$parent=Tree::getIdTreeByModule('faq');
		$sql='
			SELECT * FROM {{tree}}
			WHERE parent='.$parent.' AND visible=1 AND path<>\'ask\' AND path<>\'thanks\'
			ORDER BY num
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$countAll=0;
			if(Funcs::$uri[1]=='' || Funcs::$uri[1]=='ask' || (Funcs::$uri[1]!='' && $tree==$item['id'] && Funcs::$uri[1]!='ask')){
				$items=Faq::getRecurs($item['id']);
				$data[]=array(
					'id'=>$item['id'],
					'name'=>$item['name'],
					'path'=>$item['path'],
					'sub'=>$items['sub'],
					'count'=>$countAll
				);
			}
		}
		return $data;
	}
	public function getRecurs($parent){
		$data=array('sub'=>array(),'count'=>0,);
		$sql='
			SELECT * FROM {{tree}}
			WHERE parent='.$parent.' AND visible=1 AND menu=0
			ORDER BY num
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$items=Faq::getRecurs($item['id']);
			$path=Tree::getPathToTree($item['id']);
			$data['sub'][]=array(
				'name'=>$item['name'],
				'path'=>$path,
				'sub'=>$items['sub'],
				'count'=>$countAll
			);
		}
		$data['count']=$countAll;
		return $data;
	}
	public function getCountItems($parent){
		$sql='
			SELECT COUNT(*) FROM {{tree}}
			INNER JOIN {{data}} ON {{tree}}.id={{data}}.tree
			WHERE {{tree}}.parent='.$parent.' AND {{tree}}.visible=1 AND {{data}}.path=\'question\' AND value_text<>\'\'
		';
		return DB::getOne($sql);
	}
}
?>