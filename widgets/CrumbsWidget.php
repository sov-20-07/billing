<?
class CrumbsWidget{
	function run($id=''){
		$fullURI=Funcs::$uri;
		if($id){
			$fullURI=explode('/',Tree::getPathToTree($id));
			unset($fullURI[0]);
			unset($fullURI[count($fullURI)]);
		}
		$data=array();
		$parent=Funcs::$siteDB;
		$path='';
		foreach($fullURI as $uri){
			$path=$path.'/'.$uri;
			if(is_numeric($uri)){
				$sql='SELECT * FROM {{tree}} WHERE parent='.$parent.' AND id='.$uri.'';
			}else{
				$sql='SELECT * FROM {{tree}} WHERE parent='.$parent.' AND path=\''.$uri.'\'';
			}
			$row=DB::getRow($sql);
			$row['path']=$path.'/';
			$parent=$row['id'];
			if($parent=='')$parent=0;
			$data[]=$row;
		}
		if($fullURI[0]=='catalog' && is_numeric($fullURI[count(Funcs::$uri)-1])){
			$uri=explode('/',$_SERVER['REQUEST_URI']);
			$num=count($data);
			$data[count($data)]=$data[count($data)-1];
			$path=$data;
			unset($path[count($path)-1]);
			unset($path[count($path)-1]);
			$items=array();
			foreach($path as $item){
				$items[]=$item['path'];
			}		
			Funcs::$reference['vendor'][$uri[$num]]['path']=$items[count($items)-1].Funcs::$reference['vendor'][$uri[$num]]['path'].'/';
			$data[count($data)-2]=Funcs::$reference['vendor'][$uri[$num]];
		}elseif(isset($_GET['ve'])){
			$path=$items[count($items)].Funcs::$reference['vendor'][$uri[$num]]['path'].'/';
			$data[]=array(
				'name'=>Funcs::$referenceId['vendor'][$_GET['ve']]['name'],
				'path'=>$path
			);
		}
		View::widget('crumbs',array('list'=>$data/*,'allsite'=>CrumbsWidget::allSite()*/));
	}
	function allSite(){
		$data=array();
		//if(Funcs::$uri[0]=='catalog'){
			$sql='SELECT * FROM {{tree}} WHERE parent=2 AND visible=1 AND path<>\'catalogopt\' ORDER BY num';
			$list=DB::getAll($sql);
			foreach($list as $i=>$item){
				$sub=array();
				$path='/catalog/'.$item['path'].'/';
				$sql='
					SELECT {{tree}}.* FROM {{tree}}
					INNER JOIN {{relations}} ON {{relations}}.id1={{tree}}.id
					WHERE {{tree}}.parent='.$item['id'].' AND {{tree}}.visible=1 
						AND {{relations}}.modul1=\'tree\' AND modul2=\'struct_catalog\'
					 ORDER BY {{tree}}.num
				';
				$list2=DB::getAll($sql);
				$selected='';
				if(Funcs::$uri[0]=='catalog' && Funcs::$uri[1]==$item['path'] && Funcs::$uri[2]==''){
					$selected='selected';
				}
				foreach($list2 as $item2){
					$selected2='';
					if(Funcs::$uri[0]=='catalog' && Funcs::$uri[1]==$item['path'] && Funcs::$uri[2]==$item2['path']){
						$selected2='selected';
					}
					$sub[]=array(
						'id'=>$item2['id'],
						'name'=>$item2['name'],
						'path'=>$path.$item2['path'].'/',
						'selected'=>$selected2
					);
				}
				$data[]=array(
					'id'=>$item['id'],
					'name'=>$item['name'],
					'path'=>$path,
					'sub'=>$sub,
					'selected'=>$selected
				);
			}
		/*}else{
			$sql='SELECT * FROM {{tree}} WHERE parent=1 AND id<>2 AND visible=1 AND menu=1 ORDER BY num';
			$list=DB::getAll($sql);
			foreach($list as $i=>$item){
				$sub=array();
				$path='/'.$item['path'].'/';
				$sql='SELECT * FROM {{tree}} WHERE parent='.$item['id'].' AND visible=1 AND path<>\'thanks\' ORDER BY num';
				$list2=DB::getAll($sql);
				foreach($list2 as $item2){
					$sub[]=array(
						'id'=>$item2['id'],
						'name'=>$item2['name'],
						'path'=>$path.$item2['path'].'/',
					);
				}
				$data[$i%4][]=array(
					'id'=>$item['id'],
					'name'=>$item['name'],
					'path'=>$path,
					'sub'=>$sub
				);
			}
		}*/
		return $data;
	}
}
?>