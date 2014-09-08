<?
class MenuWidget{
	function run(){
		
	}
	public function TopMenu(){
		$data=array();
		$sql='SELECT * FROM {{tree}} WHERE parent=1 AND menu=1 AND visible=1 ORDER BY num';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$data[]=array(
				'name'=>$item['name'],
				'path'=>'/'.$item['path'].'/',
				'selected'=>Funcs::$uri[0]==$item['path']?'selected':'',
				'list'=>MenuWidget::MenuRecur($item['id'],'/'.$item['path'].'/')
			);
		}
		View::widget('menu/top',array('list'=>$data));
	}
	public function CatalogMenu(){
		$data=array();
		$sql='SELECT * FROM {{tree}} WHERE parent=2 AND menu=1 AND visible=1 ORDER BY num';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$selected='';
			if(Funcs::$uri[1]==$item['path'])$selected='selected';
			$npath='/catalog/'.$item['path'].'/';
			$sub=MenuWidget::MenuRecur($item['id'],$npath);
			$data[]=array(
				'name'=>$item['name'],
				'path'=>$npath,
				'selected'=>$selected,
				'sub'=>$sub
			);
		}
		View::widget('menu/catalog',array('list'=>$data));
	}
	public function BottomMenu(){
		$data=array();
		$sql='SELECT * FROM {{tree}} WHERE parent=1 AND menu=1 ORDER BY num LIMIT 0,3';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$sub=array();
			$sql='SELECT * FROM {{tree}} WHERE parent='.$item['id'].' AND menu=1 ORDER BY num  LIMIT 0,8';
			$list2=DB::getAll($sql);
			foreach($list2 as $item2){
				$sub[]=array(
					'name'=>$item2['name'],
					'path'=>'/'.$item['path'].'/'.$item2['path'].'/'
				);
			}
			$data[]=array(
				'name'=>$item['name'],
				'path'=>'/'.$item['path'],
				'list'=>$sub
			);
		}
		View::widget('menu/bottom',array('list'=>$data));
	}
	public function SubMenu(){
		$list=array();
		$data=array();
		if(Funcs::$uri[0]=='about'){
			$tree=Tree::getTreeByUrl('',array(Funcs::$uri[0]));
			$sql='SELECT * FROM {{tree}} WHERE parent='.$tree['id'].' AND menu=1 AND visible=1 ORDER BY num';
			$data=DB::getAll($sql);
		}elseif(Funcs::$uri[3]!=''){
			$uri=Funcs::$uri;
			unset($uri[4]);
			$tree=Tree::getTreeByUrl('',$uri);
			$sql='SELECT * FROM {{tree}} WHERE parent='.$tree['id'].' AND menu=1 AND visible=1 ORDER BY num';
			$data=DB::getAll($sql);
		}
		$num=ceil(count($data)/2);
		foreach($data as $i=>$item){
			$item['path']=Tree::getPathToTree($item['id']);
			$item['selected']='';
			if(strpos($_SERVER['REQUEST_URI'],$item['path'])!==false)$item['selected']='selected';
			if($i<$num){
				$list[0][]=$item;
			}else{
				$list[1][]=$item;
			}
		}
		View::widget('menu/sub',array('list'=>$list));
	}
	public function LeftMenu(){
		$data=array();
		$useful=array();
		$sql='SELECT id, name FROM {{tree}} WHERE parent=1 AND path=\''.Funcs::$uri[0].'\' ORDER BY num';
		$parent=DB::getRow($sql);
		$sql='SELECT * FROM {{tree}} WHERE parent='.$parent['id'].' AND menu=1 AND visible=1 ORDER BY num';
		$list=DB::getAll($sql);
		$sel=0;
		foreach($list as $item){
			$selected='';
			if($item['path']==Funcs::$uri[1] && Funcs::$uri[2]=='' && !isset($_GET['act'])){
				$selected='selected';
				$sel=1;
			}elseif($item['path']==Funcs::$uri[1] && (Funcs::$uri[2]!='' || isset($_GET['act']))){
				$selected='inner';
				$sel=1;
			}
			$path='/'.Funcs::$uri[0].'/'.$item['path'].'/';
			if($item['path']=='actions'){
				$data[]=array(
					'name'=>$item['name'],
					'path'=>$path,
					'selected'=>$selected,
					'list'=>array(
						0=>array(
							'name'=>'Действующие',
							'path'=>'?act=1',
							'selected'=>$_GET['act']=='1'?'selected':'',
						),
						1=>array(
							'name'=>'Архив',
							'path'=>'?act=0',
							'selected'=>$_GET['act']=='0'?'selected':'',
						)
					)
				);
			}else{
				$data[]=array(
					'name'=>$item['name'],
					'path'=>$path,
					'selected'=>$selected,
					'list'=>MenuWidget::MenuRecur($item['id'],$path,1)
				);
			}
		}
		View::widget('menu/left',array('list'=>$data,'name'=>$parent['name']));
	}
	public function MenuRecur($parent,$npath,$num=0){
		$data=array();
		$dpath=$npath;
		if($parent){
			$sql='SELECT * FROM {{tree}} WHERE parent='.$parent.' AND menu=1 AND visible=1 ORDER BY num ASC';
			$items=DB::getAll($sql);
			foreach($items as $item){
				$selected='';
				if($item['path']==Funcs::$uri[count(Funcs::$uri)-1]){
					$selected='selected';
				}elseif($item['path']==Funcs::$uri[$num]){
					$selected='inner';
				}
				$path=$dpath.$item['path'].'/';
				$data[]=array(
					'id'=>$item['id'],
					'name'=>$item['name'],
					'path'=>$path,
					'selected'=>$selected,
					'list'=>MenuWidget::MenuRecur($item['id'],$path,$num+1)
				);
			}
		}
		return $data;
	}
	public function CabinetMenu(){
		$menu=array(
			'0'=>'Главная',
			'profile'=>'Мой профиль',
			'orders'=>'Мои заказы',
			//'conorders'=>'Управление заказами',
			//'basket'=>'Моя корзина',
			//'books'=>'Мои книги',
			//'orders'=>'Мои заказы',
			//'rating'=>'Мой рейтинг',
			//'sales'=>'Мои продажи',
			//'income'=>'Мои доходы',
		);
		View::widget('menu/cabinetMenu',array('list'=>$menu,'name'=>'Кабинет','prefix'=>'cabinet'));
	}
	public function ManagerMenu(){
		$menu=array(
			'0'=>'Главная',
			'books'=>'Управление книгами',
			//'desrefuses'=>'Отклонения дизайнеров',
			'orders'=>'Управления заказами',
			//'delayed'=>'Просроченные заказы',
		);
		View::widget('menu/cabinetMenu',array('list'=>$menu,'name'=>'Кабинет менеджера','prefix'=>'manager'));
	}
	public function UserMenu(){
		$menu=array();
		$menu[Funcs::$uri[1]]='Смотреть портфолио';
		if($_SESSION['iuser']){
			$menu[Funcs::$uri[1].'/message']='Написать сообщение';
		}
		//'orders'=>'Оставить отзыв',
		//'delayed'=>'Вернуться к списку дизайнеров',
		View::widget('menu/cabinetMenu',array('list'=>$menu,'name'=>'Информация','prefix'=>'user'));
	}
	public function NewsMenu(){
		$data=array();
		$sql='SELECT id FROM {{tree}} WHERE parent=1 AND path=\''.Funcs::$uri[0].'\' ORDER BY num';
		$parent=DB::getOne($sql);
		$sql='SELECT * FROM {{tree}} WHERE parent='.$parent.' AND menu=1 ORDER BY num';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$selected='';
			$path='/'.Funcs::$uri[0].'/'.$item['path'].'/';
			if($item['path']==Funcs::$uri[1])$selected='inner';
			if($path=='/'.implode('/',Funcs::$uri).'/')$selected='selected';				
			$data[]=array(
				'name'=>$item['name'],
				'path'=>$path,
				'selected'=>$selected,
				'years'=>MenuWidget::NewsDateMenu($item['id'],$path)
			);
		}
		
		if(isset($_GET['d'])){
			$date=explode('-',$_GET['d']);
		}/*elseif(strpos($_SESSION['getstr'],'d=')!==false){
			$getstr=substr($_SESSION['getstr'],strpos($_SESSION['getstr'],'d=')+2,strlen($_SESSION['getstr']));
			$date=explode('-',$getstr);
		}*/else{
			$date[]=date('Y');
			//$date[]=date('m');
		}
		if(is_numeric(Funcs::$uri[count(Funcs::$uri)-1])){
			$date=array();
			$element=Tree::getTreeById(Funcs::$uri[count(Funcs::$uri)-1]);
			$date[]=date('Y',strtotime($element['udate']));
			$date[]=date('m',strtotime($element['udate']));
		}
		
		View::widget('menu/news',array('list'=>$data,'date'=>$date));
	}
	public static function NewsDateMenu($parent,$path){
		$data=array();
		$sql='SELECT MAX(udate) AS maxdate, MIN(udate) AS mindate FROM {{tree}} WHERE parent='.$parent.' AND visible=1';
		$dates=DB::getRow($sql);
		for($i=date('Y',strtotime($dates['maxdate']));$i>=date('Y',strtotime($dates['mindate']));$i--){
			for($num=11;$num>=0;$num--){
				$db=date('Y-m-d 00:00:01', strtotime($i.'-'.str_repeat('0',2-strlen($num+1)).($num+1).'-01 00:00:01'));
				$de=date('Y-m-d 00:00:01', strtotime($i.'-'.str_repeat('0',2-strlen($num+1)).($num+1).'-01 00:00:01 +1 month'));
				$sql='SELECT COUNT(*) FROM {{tree}} WHERE parent='.$parent.' AND visible=1 AND (udate BETWEEN \''.$db.'\' AND \''.$de.'\' )';
				if(DB::getOne($sql)>0){
					$data[$i][str_repeat('0',2-strlen($num+1)).($num+1)]=Funcs::$monthsRusB[$num];
				}
			}
		}
		return $data;
	}
	public static function FaqMenu(){
		$data=array();
		$sql='SELECT id FROM {{tree}} WHERE parent=1 AND path=\'faq\' AND visible=1';
		$parent=DB::getOne($sql);
		$sql='SELECT * FROM {{tree}} WHERE parent='.$parent.' AND visible=1 AND path<>\'ask\' AND path<>\'thanks\'';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$selected='';
			$sub=array();
			if($item['path']==Funcs::$uri[1])$selected='selected';
			$sql='SELECT * FROM {{tree}} WHERE parent='.$item['id'].' AND menu=0 AND visible=1 ORDER BY num';
			$items=DB::getAll($sql);
			foreach($items as $item2){
				$selected2='';
				$path=Tree::getPathToTree($item2['id']);
				if($path==$_SERVER['REQUEST_URI']){
					$selected2='selected';
				}
				$sub[]=array(
					'name'=>$item2['name'],
					'path'=>$path,
					'selected'=>$selected2
				);
			}
			$data[]=array(
				'name'=>$item['name'],
				'path'=>$item['path'],
				'selected'=>$selected,
				'sub'=>$sub,
			);
			
		}
		View::widget('menu/faq',array('list'=>$data));
	}
	public function OffersMenu(){
		$data=array();
		$sql='SELECT id FROM {{tree}} WHERE parent=1 AND path=\'offers\' AND visible=1 ORDER BY num';
		$parent=DB::getOne($sql);
		$sql='SELECT * FROM {{tree}} WHERE parent='.$parent.' AND visible=1 AND menu=1 ORDER BY num';
		$list=DB::getAll($sql);
		foreach($list as $i=>$item){
			$data[$i%4][]=array(
				'name'=>$item['name'],
				'path'=>Tree::getPathToTree($item['id']),
				'id'=>$item['id'],
			);
		}
		View::widget('menu/offers',array('list'=>$data));
	}
	public static function VendorMenuCount($tree,$vendor){
		$sql='
			SELECT COUNT(*) FROM {{tree}}
			INNER JOIN {{catalog}} ON {{tree}}.id={{catalog}}.tree
			WHERE {{tree}}.visible=1 AND {{tree}}.parent='.$tree.' AND {{catalog}}.vendor='.$vendor.'
		';
		return DB::getOne($sql);
	}
}
?>