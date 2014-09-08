<?
class Vendors{
	public function getList($parent){
		$data=array();
		if($limit!='')$limit='LIMIT '.$limit;
		$sql='SELECT * FROM {{tree}} WHERE parent='.$parent.' AND visible=1 ORDER BY name ';
		$list=DB::getPagi($sql);
		$i=0;
		foreach ($list as $item){
			$field=Fields::getFieldsByTree($item['id'],'gal');
			$path=Tree::getPathToTree($item['id']);
			$data['list'][]=array(
				'id'=>$item['id'],
				'name'=>$item['name'],
				'path'=>$path,
				'udate'=>date('d.m.Y',strtotime($item['udate'])),
				'fields'=>$field,
				'pic'=>$field['files_gal1']['image'][0]['path'],
			);
			if(preg_match("/^[0-9]+$/",substr($item['name'],0,1))){
				$data['list2']['0-9'][]=array('id'=>$item['id'],'name'=>$item['name'],'path'=>$path);
			}
			if(preg_match("/^[a-zA-Z]+$/",substr($item['name'],0,1))){
				$data['list2'][strtoupper(substr($item['name'],0,1))][]=array('id'=>$item['id'],'name'=>$item['name'],'path'=>$path);
			}
			if(preg_match("/^[а-яА-Я]+$/",substr($item['name'],0,1))){
				$data['list2']['А-Я'][]=array('id'=>$item['id'],'name'=>$item['name'],'path'=>$path);
			}
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
}
?>