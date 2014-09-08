<?
class FieldsController extends Site{
	function __construct(){
		//$this->checkRights();
	}
	function fileframe(){
		$ids['ids']=array();
		if($_GET['ids']){
			$ids['ids']=$_GET['ids'];
		}
		View::$layout='empty';
		View::render('fields/fileframe',$ids);
	}
	function multiupload(){
		$data=Fields::multiupload();
		$this->redirect('/fields/fileframe/?id='.$_POST['id'].'&path='.$_POST['path'].'&parent='.$_POST['parent'].'&ids[]='.implode('&ids[]=',$data));
		//View::$layout='empty';
		//View::render('../widgets/views/fields/gallery_one',$data);
	}
	function ckfinderupload(){
		$data=Fields::ckfinderupload();
		View::$layout='empty';
		View::render('../widgets/views/fields/gallery_one',$data);
	}
	function gallery(){
		View::$layout='empty';
		View::render('work/moduleitems',array('modules'=>array()));
	}
	function getfile(){
		$data=Fields::getFile($_POST['id']);
		$data['parent']=$_POST['parent'];
		View::$layout='empty';
		View::render('../widgets/views/fields/gallery_one',$data);
	}
	function removefile(){
		Fields::removeFile();
	}
	function editfile(){
		Fields::editFile();
	}
	function orderfile(){
		Fields::orderFile();
	}
	function removegallery(){
		Fields::removeGallery($_POST['id']);
	}
	function treeselect(){
		$data=Fields::getTreeselect($_GET['id'],$_GET['tree'],$_GET['path']);
		$data['field']=$_GET['path'];
		View::$layout='popup';
		View::render('fields/treeselect',$data);
	}
	function gettree(){
		$model=new Tree;
		$tree=$model->getTree();
		View::$layout='empty';
		View::render('fields/parenttree',array('tree'=>$tree));
	}
	function setfeaturesgroup(){
		if(!$_POST['id']){
			Fields::insertFeaturesGroups();
		}else{
			Fields::updateFeaturesGroups();
		}
		print View::getRenderEmpty('fields/groupfeatureslist');
	}
	function delfeaturesgroup(){
		Fields::deleteFeaturesGroups();
		print View::getRenderEmpty('fields/groupfeatureslist');
	}
	function addfeatures(){
		View::$layout='empty';
		View::render('work/addfeatures',array('modules'=>array()));
	}
}
?>