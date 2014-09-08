<?
class RegistrationController extends Site{
	function __construct(){
		if(!in_array(Funcs::$uri[1],get_class_methods(__CLASS__))){
			$tree=Tree::getTreeByUrl();
			Funcs::setMeta($tree);
			if(isset($_GET['ask'])){
				$tree['iuser']['email']=$_SESSION['info']['email'];
				$tree['iuser']['name']=$_SESSION['info']['name']['first_name'].' '.$_SESSION['info']['name']['last_name'];
			}
			View::render('registration/registration',$tree);
		}
	}
	function showlogin() {
		View::render('registration/showlogin');
	}
	function login() {
		if(trim($_POST['token'])!=''){
			$model=new User;
			$confirm=$model->loginza();
			if($confirm=='ok'){
				View::$layout='popup';
				View::render('registration/popupclose');
			}else{
				$this->redirect('/registration/ask/');
			}
		}else{
			$model=new User;
			$error=$model->login();
			if($error){
				$this->redirect('/registration/showlogin/?error');
			}else{
				if(strpos($_SERVER['HTTP_REFERER'],'/registration/showlogin/')!==false){
					$this->redirect('/cabinet/');
				}else{
					$this->redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}
	}
	public function logout(){
		unset($_SESSION['iuser']);
		//View::$layout='empty';
		//View::render('site/redirect',array('text'=>'Вы вышли из системы','href'=>'/'));
		$this->redirect('/');
	}
	public function ask(){
		View::$layout='empty';
		View::render('registration/ask');
	}
	function registration() {
		$model=new User;
		$error=$model->setRegistration();
		if($error){
			$text='';
			foreach($error as $key=>$item){
				$text.='error['.$key.']='.$item.'&';
			}
			$this->redirect('/registration/?'.$text);
		}else{
			$this->redirect('/registration/thanks/');
		}
	}
	public function thanks(){
		$tree=Tree::getTreeByUrl();
		Funcs::setMeta($tree);
		View::render('registration/thanks',$tree);
	}
	public function forgotdone(){
		$tree=Tree::getTreeByUrl();
		Funcs::setMeta($tree);
		View::render('registration/thanks',$tree);
	}
	public function email(){
		View::render('registration/form');
	}
	public function account() {
		$model=new User;
		$error=$model->setAccount();
		if($error){
			$text='';
			foreach($error as $key=>$item){
				$text.='error['.$key.']='.$item.'&';
			}
			$this->redirect('/registration/email/?'.$text);
		}else{
			$this->redirect('/registration/finish/');
		}
	}
	function confirm() {
		$model=new User;
		$model->setConfirm();
		$tree=Tree::getTreeByUrl();
		Funcs::setMeta($tree);
		View::render('registration/thanks',$tree);
	}
	function forgot() {
		$model=new User;
		$model->setForgot();
		//View::$layout='popup';
		//View::render('popup/forgotclose');
		$this->redirect('/registration/forgotdone/');
	}
	public function setpass(){
		$model=new User;
		$model->setPass();
		View::$layout='empty';
		View::render('site/redirect',array('text'=>'Пароль успешно изменен','href'=>'/cabinet/'));
	}
	function social(){
		$model=new User;
		$model->setSocial();
		View::$layout='popup';
		View::render('popup/close');
	}
	function anketa(){
		$model=new User;
		$model->setAnketa();
		$this->redirect('/customer/partners/anketa/thanks/');
	}
}
?>