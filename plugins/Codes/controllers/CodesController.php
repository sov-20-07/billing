<?
class CodesController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			$list=Codes::getIndexTypes();
			View::plugin('index',array('list'=>$list));
		}elseif(is_numeric(Funcs::$uri[2])){
			View::plugin('list',array('list'=>Codes::getCodes(Funcs::$uri[2])));
		}
	}
	function add(){
		DB::escapePost();
		if($_POST){
			Codes::addCodesType();
			$this->redirect('/codes/');
		}else{
			$data['fromdate']=date('d.m.Y H:i');
			$data['todate']=date('d.m.Y H:i',strtotime('+1 year'));
			View::plugin('add',$data);
		}
	}
	function edit(){
		DB::escapePost();
		if($_POST){
			Codes::editCodesType();
			$this->redirect('/codes/');
		}else{
			$data=Codes::getType($_GET['id']);
			View::plugin('add',$data);
		}
	}
	function editstr(){
		DB::escapePost();
		if($_POST){
			Codes::editCode();
		}
	}
	function delcode(){
		DB::escapeGet();
		Codes::delCode();
		$this->redirect('/codes/'.$_GET['parent'].'/');
	}
	function actedit(){
		Dealers::edit();
		$this->redirect('/dealers/');
	}
	function actdel(){
		DB::escapeGet();
		Codes::delCodesType();
		$this->redirect('/codes/');
	}
	public function generatepass(){
		print Iuser::generate_password(8);
	}
	public function checkfield(){
		print Dealers::checkFieldUnique();
	}
}
?>