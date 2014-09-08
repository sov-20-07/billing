<?
class SpecialsController extends Site{
	function __construct(){
		$tree=Tree::getTreeByUrl('gal');
		Funcs::setMeta($tree);
		if(Funcs::$uri[2]==''){
			$tree['list']=Specials::getList($tree['id']);
			View::render('specials/list',$tree);
		}else{
			//$parents=Tree::getParents($tree['id']);
			//$parentTree=Tree::getTreeById($parents[count($parents)-3],'gal');
			//$tree['pic']=$parentTree['fields']['files_gal1'][0]['path'];
			$tree=Specials::getOne($tree['id']);
			//$tree['tags']=Articles::getTags($tree['id']);
			View::render('specials/one',$tree);
		}
	}
}
?>