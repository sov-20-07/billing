<?
class CrumbsWidget{
	function run(){
		$data=array();
		$path='';
		$id=Funcs::$uri[2];
		if(Funcs::$uri[1]=='tree' && is_numeric($id)){
			$sql='SELECT parent FROM {{tree}} WHERE id='.$id.'';
			$parent=DB::getOne($sql);
			while($id!=0){
				$sql='SELECT id, parent, name FROM {{tree}} WHERE id='.$id.'';
				$row=DB::getRow($sql);
				$row['path']='/'.ONESSA_DIR.'/work/'.$row['id'].'/';
				$id=$row['parent'];
				$data[]=$row;
			}
			$data=array_reverse($data);
			
		}elseif(Funcs::$uri[1]=='settings' && is_numeric($id)){
			$data[]=array(
				'name'=>'Настройки',
				'path'=>'/'.ONESSA_DIR.'/settings/'
			);
			$data[]=array();
		}elseif(Funcs::$uri[1]=='infoblock' && is_numeric($id)){
			$data[]=array(
				'name'=>'Инфоблоки',
				'path'=>'/'.ONESSA_DIR.'/infoblock/'
			);
			$data[]=array();
		}elseif(Funcs::$uri[1]=='reference' && is_numeric($id)){
			$sql='SELECT parent FROM {{reference}} WHERE id='.$id.'';
			$parent=DB::getOne($sql);
			while($id!=0){
				$sql='SELECT id, parent, name FROM {{reference}} WHERE id='.$id.'';
				$row=DB::getRow($sql);
				$row['path']='/'.ONESSA_DIR.'/reference/'.$row['id'].'/';
				$id=$row['parent'];
				$data[]=$row;
			}
			$data[]=array(
				'name'=>'Справочник',
				'path'=>'/'.ONESSA_DIR.'/reference/'
			);
			$data=array_reverse($data);
			
		}
		View::widget('crumbs',array('list'=>$data));
	}
}
?>