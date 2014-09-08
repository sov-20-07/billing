<?
class FotobookController extends Site{
	function __construct(){
		if(Funcs::$uri[1]!='upload'){
			$tree=Tree::getTreeByUrl('wide');
			Funcs::setMeta($tree);
			View::render('site/page',$tree);
		}
	}
	public function upload(){
		if($_SESSION['iuser']['id']){
			if($_POST['act']=='step1'){
				$model=new Upload;
				$model->step1();
				$this->redirect('/fotobook/upload/step2/');
			}elseif($_POST['act']=='step2'){
				$model=new Upload;
				$model->step2();
				$this->redirect('/fotobook/upload/step3/');
			}elseif($_POST['act']=='step3'){
				$model=new Upload;
				$model->step3();
				View::$layout='empty';
				View::render('fotobook/upload/step3done');
			}elseif($_POST['act']=='step3return'){
				$model=new Upload;
				$model->step3return();
				//$this->redirect('/fotobook/upload/step4/');
			}elseif($_POST['act']=='step4'){
				$model=new Upload;
				$data=$model->step4();
				$this->redirect('/fotobook/upload/thanks/',$data);
			}elseif(Funcs::$uri[2]==''){
				$this->redirect('/fotobook/upload/step1/');
			}elseif(Funcs::$uri[2]=='step1'){
				$tree=Tree::getTreeByUrl('wide');
				Funcs::setMeta($tree);
				View::render('fotobook/upload/step1',$tree);
			}elseif(Funcs::$uri[2]=='step2'){
				$tree=Tree::getTreeByUrl('wide');
				Funcs::setMeta($tree);
				View::render('fotobook/upload/step2',$tree);
			}elseif(Funcs::$uri[2]=='step3'){
				$tree=Tree::getTreeByUrl('wide');
				Funcs::setMeta($tree);
				View::render('fotobook/upload/step3',$tree);
			}elseif(Funcs::$uri[2]=='step3show'){
				View::$layout='empty';
				View::render('fotobook/upload/step3show');
			}elseif(Funcs::$uri[2]=='step4'){
				$tree=Tree::getTreeByUrl('wide');
				Funcs::setMeta($tree);
				View::render('fotobook/upload/step4',$tree);
			}elseif(Funcs::$uri[2]=='thanks'){
				$tree=Tree::getTreeByUrl('wide');
				Funcs::setMeta($tree);
				View::render('fotobook/upload/thanks',$tree);
			}
		}else{
			$tree=Tree::getTreeByUrl('wide');
			Funcs::setMeta($tree);
			View::render('fotobook/upload/page',$tree);
		}
	}
}
?>