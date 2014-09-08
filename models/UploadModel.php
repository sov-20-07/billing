<?
class Upload{
	public function step1(){
		Funcs::escapePost();
		$_SESSION['iuser']['upload']['title']=$_POST['title'];
		$_SESSION['iuser']['upload']['phrase']=$_POST['phrase'];
		$_SESSION['iuser']['upload']['author']=$_POST['author'];
		$_SESSION['iuser']['upload']['spec']=$_POST['spec'];
		$_SESSION['iuser']['upload']['description']=$_POST['description'];
		$_SESSION['iuser']['upload']['private']=$_POST['private']==1?1:0;
	}
	public function step2(){
		Funcs::escapePost();
		$_SESSION['iuser']['upload']['booksize']=$_POST['booksize'];
		$_SESSION['iuser']['upload']['countpage']=$_POST['countpage'];
		$_SESSION['iuser']['upload']['binding']=$_POST['binding'];
		$_SESSION['iuser']['upload']['countbook']=$_POST['countbook'];
		$_SESSION['iuser']['upload']['paper']=$_POST['paper'];
	}
	public function step3 (){
		Funcs::escapePost();
		if($_FILES['filecover']['type']=='application/pdf' && $_FILES['filepages']['type']=='application/pdf'){
			foreach($_FILES as $key=>$item){
				$name=explode('/',$item['tmp_name']);
				$name=$name[count($name)-1];
				$dirfile=$_SERVER['DOCUMENT_ROOT'].TEMP_DIR.$name;
				move_uploaded_file($item['tmp_name'],$dirfile);
				chmod($dirfile,0777);
				$_SESSION['iuser']['upload'][$key]['name']=$item['name'];
				$_SESSION['iuser']['upload'][$key]['path']=$dirfile;
				if($key=='filepages'){
					$imagick = new Imagick($dirfile);
					$countpage=$imagick->getNumberImages();
					$countpage=$countpage+$countpage%2;
					$_SESSION['iuser']['upload']['countpage']=$countpage;
				}
			}
		}
	}
	public function step3return (){
		print 'dddddd'.'-'.apc_fetch("upload_1234");
		print_r(apc_fetch("upload_1234"));
		print_r(apc_fetch("upload_$_POST[APC_UPLOAD_PROGRESS]"));
	}
	public function step4(){
		$tree=array('name'=>$_SESSION['iuser']['upload']['title']);
		$id=Tree::addTree($_SESSION['iuser']['upload']['spec'],$tree,'catalog');
		if(file_exists($_SESSION['iuser']['upload']['filecover']['path']) && file_exists($_SESSION['iuser']['upload']['filepages']['path'])){
			$dir=$_SERVER['DOCUMENT_ROOT'].IUSER_DIR.md5('fotouser'.$_SESSION['iuser']['id']).'/';
			if(!file_exists($dir)){
				mkdir($dir,0777);
			}
			$dir=$dir.md5('fotobook'.$id).'/';
			mkdir($dir,0777);
			for($file2i=0;$file2i<2;$file2i++){
				if($file2i==0){
					$filename=explode('.',$_SESSION['iuser']['upload']['filecover']['name']);
					$filesource=$_SESSION['iuser']['upload']['filecover']['path'];
				}else{
					$filename=explode('.',$_SESSION['iuser']['upload']['filepages']['name']);
					$filesource=$_SESSION['iuser']['upload']['filepages']['path'];
				}
				$raz=$filename[count($filename)-1];
				unset($filename[count($filename)-1]);
				$filename=implode('',$filename);
				$filenameraz=Funcs::Transliterate($filename).'.'.$raz;
				$dirfile=$dir.$filenameraz;
				$x=0;$i=1;
				while($x==0){
					if(file_exists($dirfile)){
						$filenameraz=Funcs::Transliterate($filename).$i.'.'.$raz;
						$dirfile=$dir.md5($filename).'/'.$filenameraz;
					}else{
						$x=1;
					}
					$i++;
				}
				copy($filesource,$dirfile);
				chmod($dirfile,0777);
				unlink($filesource);
				if($file2i==0){
					$filename1=$filenameraz;
				}else{
					$filename2=$filenameraz;
				}
			}
		}
		$price=Basket::getPrice('session');
		$sql='
			INSERT INTO {{catalog}}
			SET
				tree='.$id.',
				description=\''.$_SESSION['iuser']['upload']['description'].'\',
				phrase=\''.$_SESSION['iuser']['upload']['phrase'].'\',
				author=\''.$_SESSION['iuser']['upload']['author'].'\',
				private='.$_SESSION['iuser']['upload']['private'].',
				booksize='.$_SESSION['iuser']['upload']['booksize'].',
				countpage='.$_SESSION['iuser']['upload']['countpage'].',
				binding='.$_SESSION['iuser']['upload']['binding'].',
				paper='.$_SESSION['iuser']['upload']['paper'].',
				price='.$price.',
				filecover=\''.$filename1.'\',
				filepages=\''.$filename2.'\',
				vendor='.$_SESSION['iuser']['id'].'
		';
		DB::exec($sql);
		unset($_SESSION['iuser']['upload']);
		$_SESSION['iuser']['upload']['id']=$id;
		$_SESSION['iuser']['upload']['price']=$price;
		Upload::addGallery($id,$filename1,$filename2,$dir);
		Email::uploadSend();
	}
	public static function addGallery($tree,$filecover,$filepages,$dir){
		$id1=Fields::importSimpleField($tree,'gal','gallery','value_int',0,0);
		
		//Обложка
		$path=$dir.$filecover;
		exec('convert -scale 1200x600 '.$path.' '.$dir.'cover.jpg');
		exec('convert -crop 600x600+600+0 '.$dir.'cover.jpg '.$dir.'cover_front.jpg');
		exec('convert -crop 600x600+0+0 '.$dir.'cover.jpg '.$dir.'cover_rear.jpg');
		unlink($dir.'cover.jpg');
		
		//Страницы
		$path=$dir.$filepages;
		exec('convert -scale 600x600 '.$path.' '.$dir.'page%d.jpg');
		
		//Процесс записи в админку
		for($i=0;$i<100;$i++){
			if(file_exists($dir.'page'.$i.'.jpg')){
				$i<10?rename($dir.'page'.$i.'.jpg',$dir.'page00'.$i.'.jpg'):rename($dir.'page'.$i.'.jpg',$dir.'page0'.$i.'.jpg');
			}
		}
		$diraar=scandir($dir);
		foreach($diraar as $key=>$file){
			if($file!='.' && $file!='..'){
				$pathsql=$dir.$file;
				$pathsql=str_replace($_SERVER['DOCUMENT_ROOT'],'',$pathsql);
				$raz=explode('.',$pathsql);
				$raz=$raz[count($raz)-1];
				if($raz=='jpg'){
					$mime='image';
				}else{
					$mime='application';
				}
				$sql='
					INSERT INTO {{files}} 
					SET
						path=\''.$pathsql.'\',
						mime=\''.$mime.'\',
						size=1,
						visible=1,
						num=\''.($key-2).'\',
						cdate=now()
				';
				$id2=DB::exec($sql);
				$sql='
					INSERT INTO {{relations}} 
					SET modul1=\'data\',
						modul2=\'files\',
						id1='.$id1.',
						id2='.$id2.',
						cdate=NOW()
				';
				DB::exec($sql);
			}
		}
	}
}
?>