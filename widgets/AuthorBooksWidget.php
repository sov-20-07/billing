<?
class AuthorBooksWidget{
	function run($list){
		View::widget('authorBooks',array('list'=>$list));
	}
}
?>