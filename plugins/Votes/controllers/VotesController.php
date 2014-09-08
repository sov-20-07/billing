<?
class VotesController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			$data['list']=Votes::getList();
			View::plugin('list',$data);
		}
	}
	function add(){
		DB::escapePost();
		if($_POST){
			$id=Votes::add();
			$this->redirect('/votes/edit/'.$id.'/');
		}else{
			View::plugin('add');
		}
	}
	function edit(){
		DB::escapePost();
		if($_POST){
			Votes::edit(Funcs::$uri[3]);
			$this->redirect('/votes/edit/'.Funcs::$uri[3].'/');
		}else{
			View::plugin('add',Votes::getOne(Funcs::$uri[3]));
		}
	}
	function del(){
		Votes::del(Funcs::$uri[3]);
		$this->redirect('/votes/');
	}
}
?>