<?
class NewsWidget{
	function run(){
		$id=Tree::getIdTreeByModule('news');
		$list=News::getList($id,5);
		View::widget('news',array('list'=>$list));
	}
}
?>