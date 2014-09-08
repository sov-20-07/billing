<?
class ArticlesController extends Site{
	function __construct(){
		$tree=Tree::getTreeByUrl('gal');
		Funcs::setMeta($tree);
		if(Funcs::$uri[1]==''){
			$tree['pic']=$tree['fields']['files_gal1'][0]['path'];
			$tree['list']=Articles::getList($tree['id']);
			$tree['tags']=Articles::getTagList($tree['id']);
			View::render('articles/list',$tree);
		}else{
			$parents=Tree::getParents($tree['id']);
			$parentTree=Tree::getTreeById($parents[count($parents)-3],'gal');
			$tree['pic']=$parentTree['fields']['files_gal1'][0]['path'];
			$tree['list']=Articles::getOne($tree['id']);
			$tree['tags']=Articles::getTags($tree['id']);
			View::render('articles/one',$tree);
		}
	}
}
?>