<?
class SearchController extends Site{
	function __construct(){
		$tree=Tree::getTreeByUrl();
		Funcs::setMeta($tree);
		$list=Search::getResult();
		View::render('site/search',array('list'=>$list));
	}
}
?>