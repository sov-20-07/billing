<?
class TreeWidget{
	public static $tree=array();
	function run(){
		$id=1;
		if(is_numeric(Funcs::$uri[2])){
			$id=Funcs::$uri[2];
		}elseif(is_numeric($_GET['parent'])){
			$id=$_GET['parent'];
		}elseif(is_numeric($_GET['id'])){
			$sql='SELECT parent FROM {{tree}} WHERE id='.$_GET['id'];
			$id=DB::getOne($sql);
		}
		View::$layout='empty';
		View::render('tree/tree',array('tree'=>TreeWidget::getTree($id)));
	}
	function getTree($id){
		$data=array();
		$tree=array();
		$parent=$id;
		$tree[]=$id;
		while($parent){
			$sql='SELECT parent FROM {{tree}} WHERE id='.$parent.'';
			$parent=DB::getOne($sql);
			$tree[]=$parent;
		}
		$sql='SELECT * FROM {{tree}} ORDER BY num ASC';
		$list=DB::getAll($sql);
		foreach($list as $item){
			TreeWidget::$tree[$item['parent']][$item['id']]=$item;
		}
		$parent=0;
		if(count(TreeWidget::$tree[$parent])>0){
			foreach(TreeWidget::$tree[$parent] as $id=>$item){
				if(in_array($id,$tree)){
					$item['sub']=TreeWidget::getBranch($id,$tree);
					$item['selected']='selected';
				}elseif(count(TreeWidget::$tree[$id])>0){
					$item['inner']='inner';
				}
				$data[]=$item;
			}
		}
		return $data;
	}
	function getBranch($parent,$tree){
		$data=array();
		if(count(TreeWidget::$tree[$parent])>0){
			foreach(TreeWidget::$tree[$parent] as $id=>$item){
				if(in_array($id,$tree)){
					$item['sub']=TreeWidget::getBranch($id,$tree);
					$item['selected']='selected';
				}elseif(count(TreeWidget::$tree[$id])>0){
					$item['inner']='inner';
				}
				$data[]=$item;
			}
		}
		return $data;
	}
	function ajax(){
		$data=array();
		$sql='SELECT * FROM {{tree}} WHERE parent='.$_POST['id'].' ORDER BY num';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$sql='SELECT COUNT(*) FROM {{tree}} WHERE parent='.$item['id'].'';
			$count=DB::getOne($sql);
			if($count>0){
				$item['inner']='inner';
			}
			$data[]=$item;
		}
		print View::getRenderEmpty('tree/branch',array('sub'=>$data));
		die;
	}
}
?>