<?
class PanelController extends Site{
	function __construct(){
		if(!in_array(Funcs::$uri[2],get_class_methods(__CLASS__))){
			if(Funcs::$uri[2]==''){
				View::render('control/list',array('list'=>Control::getList()));
			}elseif(is_numeric(Funcs::$uri[2])){
				View::render('control/list',array('list'=>Control::getList(Funcs::$uri[2])));
			}
		}
	}
	public static function on(){
		if($_SESSION['user']['panel']['edit']=='') $_SESSION['user']['panel']['edit']='on';
		else $_SESSION['user']['panel']['edit']='';
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}
	public static function save(){
		Fields::updateFieldById($_POST['OneSSAEditorFieldId'],$_POST['OneSSAEditorFieldField'],$_POST['OneSSAEditorFieldValue']);
	}
}
?>