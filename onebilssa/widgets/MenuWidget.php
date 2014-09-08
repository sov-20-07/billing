<?
class MenuWidget{
	function run(){
		$list=array();
		$path='/'.Funcs::$uri[0].'/'.Funcs::$uri[1].'/';
		if(method_exists('MenuWidget','get'.Funcs::$uri[1].'')){
			eval('$list=MenuWidget::get'.Funcs::$uri[1].'($path);');
		}
		if(count($list)>0){
			View::widget('menu/menu',array('list'=>$list));
		}
	}
	public function getsettings(){
		$data=array();
		$sql='
			SELECT * FROM {{settings}} 
			WHERE parent=0 ORDER BY num
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$data[]=array(
				'name'=>$item['name'],
				'path'=>'/'.Funcs::$cdir.'/settings/'.$item['id'].'/',
				'selected'=>'/settings/'.$item['id'].'/'=='/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/'?'selected':'',
			);
		}
		return $data;
	}
	public function getuser(){
		$data=array(
			0=>array(
				'name'=>'Группы',
				'path'=>'/'.Funcs::$cdir.'/user/group/',
				'selected'=>'/user/group/'=='/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/'?'selected':'',
			),
			1=>array(
				'name'=>'Пользователи',
				'path'=>'/'.Funcs::$cdir.'/user/user/',
				'selected'=>'/user/user/'=='/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/'?'selected':'',
			)
		);
		return $data;
	}
	public function getcontrol(){
		$data=array(
			0=>array(
				'name'=>'Сайты',
				'path'=>'/'.Funcs::$cdir.'/control/',
				'selected'=>'/control/lang/'!='/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/'?'selected':'',
			),
			1=>array(
				'name'=>'Языки',
				'path'=>'/'.Funcs::$cdir.'/control/lang/',
				'selected'=>'/control/lang/'=='/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/'?'selected':'',
			)
		);
		return $data;
	}
	public function getforms(){
		$data=array();
		$sql='
			SELECT * FROM {{forms}} ORDER BY name
		';
		$items=DB::getAll($sql);
		foreach($items as $item){
			$data[]=array(
				'name'=>$item['name'],
				'path'=>'/'.Funcs::$uri[0].'/'.Funcs::$uri[1].'/'.$item['id'].'/',
				'selected'=>'/forms/'.$item['id'].'/'=='/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/'?'selected':'',
			);
		}
		return $data;
	}
	public function getreference(){
		$data=array();
		$sql='
			SELECT * FROM {{reference}} 
			WHERE parent=0 ORDER BY num
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$data[]=array(
				'name'=>$item['name'],
				'path'=>'/'.Funcs::$cdir.'/reference/'.$item['id'].'/',
				'selected'=>'/reference/'.$item['id'].'/'=='/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/'?'selected':'',
			);
		}
		return $data;
	}
	public function getinfoblock(){
		$data=array();
		$sql='
			SELECT * FROM {{infoblock}} 
			WHERE parent=0 ORDER BY num
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$data[]=array(
				'name'=>$item['name'],
				'path'=>'/'.Funcs::$cdir.'/infoblock/'.$item['id'].'/',
				'selected'=>'/infoblock/'.$item['id'].'/'=='/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/'?'selected':'',
			);
		}
		return $data;
	}
	public function gettools(){
		$data=array(
			0=>array(
				'name'=>'Инструменты',
				'path'=>'/'.Funcs::$cdir.'/'.Funcs::$uri[1].'/',
			),
			1=>array(
				'name'=>'Свойства',
				'path'=>'/'.Funcs::$cdir.'/'.Funcs::$uri[1].'/properties/',
				'selected'=>'/'.Funcs::$uri[1].'/properties/'!='/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/'?'selected':'',
			),
			2=>array(
				'name'=>'Редиректы 301',
				'path'=>'/'.Funcs::$cdir.'/'.Funcs::$uri[1].'/redirects/',
				'selected'=>'/'.Funcs::$uri[1].'/redirects/'!='/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/'?'selected':'',
			),
			3=>array(
				'name'=>'Переиндексация поиска',
				'path'=>'/'.Funcs::$cdir.'/'.Funcs::$uri[1].'/research/',
				'selected'=>'/'.Funcs::$uri[1].'/research/'!='/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/'?'selected':'',
			),
			4=>array(
				'name'=>'Карта сайта XML',
				'path'=>'/'.Funcs::$cdir.'/'.Funcs::$uri[1].'/sitemap/',
				'selected'=>'/'.Funcs::$uri[1].'/sitemap/'!='/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/'?'selected':'',
			),
			5=>array(
				'name'=>'Выполнить SQL запрос',
				'path'=>'/'.Funcs::$cdir.'/'.Funcs::$uri[1].'/sql/',
				'selected'=>'/'.Funcs::$uri[1].'/sql/'!='/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/'?'selected':'',
			),
		);
		return $data;
	}
	public function ServiceMenu(){
		$data=array();
		$user=User::getInfo($_SESSION['user']['id']);
		foreach(OneSSA::$modulesStandart as $key=>$item){
			if(in_array($key,$user['access']['modules']) && in_array('top',$item['menu'])){
				$data[$key]=$item['name'];
				$_SESSION['user']['access'][$key]=$item;
			}
		}
		View::widget('menu/service',array('list'=>$data));
	}
	public function getselling(){
		$data=array(
			0=>array(
				'name'=>'Авторы',
				'path'=>'/'.Funcs::$cdir.'/selling/authors/',
				'selected'=>'/selling/authors/'=='/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/'?'selected':'',
			),
			1=>array(
				'name'=>'Пользователи',
				'path'=>'/'.Funcs::$cdir.'/selling/users/',
				'selected'=>'/selling/users/'=='/'.Funcs::$uri[1].'/'.Funcs::$uri[2].'/'?'selected':'',
			)
		);
		return $data;
	}
}
?>