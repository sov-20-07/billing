<?
require_once $_SERVER['DOCUMENT_ROOT'].'/settings.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/'.ONESSA_DIR.'/class/Funcs.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/'.ONESSA_DIR.'/class/DB'.BDCONNECTION.'.php';
new DB;
class file{
	function __construct(){
		if(isset($_GET['h'])){
			$file=substr($_SERVER['REQUEST_URI'],3,strlen($_SERVER['REQUEST_URI']));
			if(strpos($file,'?')!==false){
				$file=substr($file,0,strpos($file,'?'));
			}
			$file=$_SERVER['DOCUMENT_ROOT'].$file;
			if(!file_exists($file)){
				//$this->error();
				$file=$_SERVER['DOCUMENT_ROOT'].'/of/nopic.png';
			}
			$raz=explode('.',$file);
			$raz=$raz[count($raz)-1];
			if(isset($_GET['c'])){
				$this->resizeSmall($file,$_GET['h'],$_GET['w'],$raz);
			}else{
				$this->resize($file,$_GET['h'],$_GET['w'],$raz);
			}
		}elseif(isset($_GET['gray'])){
			$file=substr($_SERVER['REQUEST_URI'],3,strlen($_SERVER['REQUEST_URI']));
			$file=substr($file,0,strpos($file,'?'));
			$raz=explode('.',$file);
			$raz=$raz[count($raz)-1];
			$this->toGray($file,$raz);
		}else{
			$file=substr($_SERVER['REQUEST_URI'],4,strlen($_SERVER['REQUEST_URI']));
			$num=substr($file,0,strpos($file,'/'));
			if($num=='')$num=$file;
			$file=substr($file,strpos($file,'/'),strlen($file));
			if(strpos($file,'?')!==false){
				$file=substr($file,0,strpos($file,'?'));
			}
			$wh=$this->getConfig();
			$file=$_SERVER['DOCUMENT_ROOT'].$file;
			if(!file_exists($file)){
				//$this->error();
				$file=$_SERVER['DOCUMENT_ROOT'].'/of/nopic.png';
			}
			$raz=explode('.',$file);
			$raz=$raz[count($raz)-1];
			if($wh[$num][2]=='c'){
				$this->resizeSmall($file,$wh[$num][1],$wh[$num][0],$raz,$num);
			}elseif($wh[$num][2]=='s'){
				$this->resizeSmallColor($file,$wh[$num][1],$wh[$num][0],$raz,$num,$wh[$num][3]);
			}else{
				$this->resize($file,$wh[$num][1],$wh[$num][0],$raz,$num);
			}
		}
	}
	function resize($input, $height, $width,$raz,$num=0) {
		if (file_exists ( $output ))
			unlink ( $output );
		$size = getimagesize ( $input );
		$w = $size [0];
		$h = $size [1];
		if($height=='')$height=$h;
		if($width=='')$width=$w;
		if ($h < $height) {
			$a = 1;
			$newy = $h;
		} else {
			$a = $height / $h;
			$newy = $height;
		}
		$newx = $a * $w;
		if ($newx > $width) {
			$a = $width / $newx;
			$newx = $width;
			$newy = $newy * $a;
		}
		
		$source = imagecreatefromstring(file_get_contents($input)) or die ( 'Cannot load watermark Image' );

		$target = imagecreatetruecolor ( $newx, $newy );
		
		if ($raz == ".png") {
			
			  imagealphablending($target, false);
			  imagesavealpha($target,true);
			  $transparent = imagecolorallocatealpha($target, 255, 255, 255, 127);
			  imagefilledrectangle($target, 0, 0, $newx, $newy, $transparent);

			
		}
		imagecopyresampled ( $target, $source, 0, 0, 0, 0, $newx, $newy, $size [0], $size [1] );
		if($num>100){
			$watermark = imagecreatefromstring(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/of/watermark.png')) or die ( 'Cannot load original Image' );
			imagecopy($target,$watermark,10,10,0,0,104,21);
		}
		if ($raz=="png"){
			header('Content-Type: image/png;');
			imagepng($target);
		}elseif($raz=="gif"){
			header('Content-Type: image/gif;');
			imagegif($target);
		}elseif($raz=="bmp"){
			header('Content-Type: image/bmp;');
			imagebmp($target);
		}else{
			header('Content-Type: image/jpeg;');
			imagejpeg ( $target);
		}
		imagedestroy ( $target );
		imagedestroy ( $source );
	}
	function resizeSmall($input, $height, $width, $raz,$num=0) {
		/*if (file_exists ( $output ))
			unlink ( $output );*/
		$size = getimagesize ( $input );
		$w = $size [0];
		$h = $size [1];
		if($height=='')$height=$h;
		if($width=='')$width=$w;
		if($w>$h){
			if ($h < $height) {
				$a = 1;
				$newy = $h;
			} else {
				$a = $height / $h;
				$newy = $height;
			}
			$newx = $a * $w;
		}else{
			if ($w < $width) {
				$a = 1;
				$newx = $w;
			} else {
				$a = $width / $w;
				$newx = $width;
			}
			$newy = $a * $h;
		}
		if($newx<$width){
				  if ($w < $width) {
						$a = 1;
						$newx = $w;
				  } else {
						$a = $width / $w;
						$newx = $width;
				  }
				  $newy = $a * $h;
		 }
			if($newy<$height){
				  if ($h < $height) {
						$a = 1;
						$newy = $h;
				  } else {
						$a = $height / $h;
						$newy = $height;
				  }
				  $newx = $a * $w;
		}
		$source = imagecreatefromstring(file_get_contents($input)) or die ( 'Cannot load original Image' );
		$target = imagecreatetruecolor ( $newx, $newy );
		imagealphablending($target,true);
		imagecopyresampled ( $target, $source, 0, 0, 0, 0, $newx, $newy, $size [0], $size [1] );
		
		if($newx<$width)$width=$newx;
		if($newy<$height)$height=$newy;
		$left=0;
		$top=0;
		if(($newx-$width)>0)$left=($newx-$width)/2;
		if(($newy-$height)>0)$top=($newy-$height)/2;
		
		//$source = imagecreatefromstring(file_get_contents($input)) or die ( 'Cannot load original Image' );
		$target2 = imagecreatetruecolor ( $width, $height );
		imagealphablending($target2,true);
		imagecopy($target2,$target,0, 0,$left,$top, $width, $height) or die ('Cannot copy');
		if($num>100){
			$watermark = imagecreatefromstring(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/of/watermark.png')) or die ( 'Cannot load original Image' );
			imagecopy($target2,$watermark,10,10,0,0,104,21);
		}
		if ($raz=="png"){
			header('Content-Type: image/png;');
			imagepng($target2);
		}elseif($raz=="gif"){
			header('Content-Type: image/gif;');
			imagegif($target2);
		}elseif($raz=="bmp"){
			header('Content-Type: image/bmp;');
			imagebmp($target2);
		}else{
			header('Content-Type: image/jpeg;');
			imagejpeg ($target2);
		}
		imagedestroy ( $target );
		imagedestroy ( $target2 );
		imagedestroy ( $source );
	}
	function resizeSmallColor($input, $height, $width,$raz,$num=0,$color) {
		if (file_exists ( $output ))
			unlink ( $output );
		$size = getimagesize ( $input );
		$w = $size [0];
		$h = $size [1];
		if($height=='')$height=$h;
		if($width=='')$width=$w;
		if ($h < $height) {
			$a = 1;
			$newy = $h;
		} else {
			$a = $height / $h;
			$newy = $height;
		}
		$newx = $a * $w;
		if ($newx > $width) {
			$a = $width / $newx;
			$newx = $width;
			$newy = $newy * $a;
		}
		
		$source = imagecreatefromstring(file_get_contents($input)) or die ( 'Cannot load watermark Image' );

		$target = imagecreatetruecolor ( $width, $height );
		
		if ($raz == ".png") {
			
			  imagealphablending($target, false);
			  imagesavealpha($target,true);
			  $transparent = imagecolorallocatealpha($target, 255, 255, 255, 0);
			  imagefilledrectangle($target, 0, 0, $newx, $newy, $transparent);
			  //imagecopyresampled ( $target, $source, 0, 0, 0, 0, $newx, $newy, $size [0], $size [1] );
			  imagecopyresampled ( $target, $source, 0, round(($height-$newy)/2), 0, 0, $newx, $newy, $size [0], $size [1] );
			
		}else{
			$transparent = imagecolorallocatealpha($target, 255, 255, 255, 0);
			imagefilledrectangle($target, 0, 0, $width, $height, $transparent);
			imagecopyresampled ( $target, $source, 0, round(($height-$newy)/2), 0, 0, $newx, $newy, $size [0], $size [1] );
		}
		if ($raz=="png"){
			header('Content-Type: image/png;');
			imagepng($target);
		}elseif($raz=="gif"){
			header('Content-Type: image/gif;');
			imagegif($target);
		}elseif($raz=="bmp"){
			header('Content-Type: image/bmp;');
			imagebmp($target);
		}else{
			header('Content-Type: image/jpeg;');
			imagejpeg ( $target);
		}
		imagedestroy ( $target );
		imagedestroy ( $source );
	}
	public function getConfig(){
		$data=array();
		$sql='SELECT id FROM '.BDPREFIX.'settings WHERE visible=1 AND parent=0 AND path=\'pic\'';
		$parent=DB::getOne($sql);
		$sql='SELECT * FROM '.BDPREFIX.'settings WHERE visible=1 AND parent='.$parent.'';
		$res=DB::getAll($sql);
		foreach($res as $row){
			$data[$row['path']]=explode('x',$row['value']);
		}
		return $data;
	}
	public function error(){
		header("HTTP/1.0 404 Not Found");
		header("Location: /of/nopic.png");
		die;
	}
	public function toGray($img,$raz){
		$dither=false;
		$img=imagecreatefromstring(file_get_contents($_SERVER['DOCUMENT_ROOT'].$img));
		if (!($i = imagecolorstotal($img)))
			imagetruecolortopalette($img, $dither, $i = 256);
		while ($i--) {
			$c = imagecolorsforindex($img,$i);
			$c = 0.299*$c['red'] + 0.587*$c['green'] + 0.114*$c['blue'];
			imagecolorset($img,$i,$c,$c,$c);
		}
		 header("Content-type: image/gif");
		if ($raz=="png"){
			header('Content-Type: image/png;');
			imagepng($img);
		}elseif($raz=="gif"){
			header('Content-Type: image/gif;');
			imagegif($img);
		}elseif($raz=="bmp"){
			header('Content-Type: image/bmp;');
			imagebmp($img);
		}else{
			header('Content-Type: image/jpeg;');
			imagejpeg($img);
		}
	}
}
new file;
?>