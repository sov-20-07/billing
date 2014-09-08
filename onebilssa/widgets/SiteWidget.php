<?
class SiteWidget{
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
}
?>