<?
class TreeWidget{
	function run(){
		$model=new Tree;
		View::$layout='empty';
		View::render('tree/tree',array('tree'=>$model->getTree()));
	}
}
?>