<?
class CompareController extends Site{
	function __construct(){
		if(Funcs::$uri[1]==''){
			$tree=Tree::getTreeByUrl(Funcs::$uri[0]);
			Funcs::setMeta($tree);
			$tree['list']=Compare::getCompare();
			View::render('compare/list',$tree);
		}
	}
	function add(){
		$count=Compare::setCompare($_POST['id']);
		print $count;
		die;
	}
	function addlist(){
		$count=Compare::setCompareList($_POST['id']);
		print $count;
		die;
	}
	function del(){
		$count=Compare::delCompare($_POST['id']);
		print $count;
		die;
	}
}
?>