<?php
/*
session_start();
class CCheckCodeFile{ 	
	private $mCheckCodeNum=4; 	
 	private  $mCheckCode   = '';  	
 	private $mCheckImage  = '';
 	//干扰像素
    private $mDisturbColor  = ''; 	
 	private $mCheckImageWidth = '80'; 	
 	private $mCheckImageHeight  = '20';

 	private function OutFileHeader() {  
 		header ("Content-type: image/PNG"); 
 	}

    private function CreateCheckCode() {  
       $this->mCheckCode = strtoupper(substr(md5(rand()),0,$this->mCheckCodeNum));  
       $_SESSION['code']=$this->mCheckCode;
       return $this->mCheckCode; 
    }

    private function CreateImage() {  
    	$this->mCheckImage =@imagecreate($this->mCheckImageWidth,$this->mCheckImageHeight);  
    	//imagecolorallocate($this->mCheckImage, 200, 200, 200);
    	imagecolorallocate($this->mCheckImage,200,200,200);
    	return $this->mCheckImage; 
    }
	*/
 /**  设置图片的干扰像素 * */ 
 /*
    private function SetDisturbColor() {  
    	for ($i=0;$i<=128;$i++)  {   
    		$this->mDisturbColor = imagecolorallocate ($this->mCheckImage, rand(0,255), rand(0,255), rand(0,255));   
    		imagesetpixel($this->mCheckImage,rand(2,128),rand(2,38),$this->mDisturbColor);  
    	}
    }

    public function SetCheckImageWH($width,$height) {  
    	if($width==''||$height=='')return false;  
    	$this->mCheckImageWidth  = $width;  
    	$this->mCheckImageHeight = $height;  
    	return true; 
    }

    private function WriteCheckCodeToImage() {  
    	for ($i=0;$i<=$this->mCheckCodeNum;$i++)  {
    		$bg_color = imagecolorallocate ($this->mCheckImage, rand(0,255), rand(0,128), rand(0,255));   
    		$x = floor(($this->mCheckImageWidth-10)/$this->mCheckCodeNum)*$i;   
    		$y = rand(0,$this->mCheckImageHeight-15);   
    		imagechar ($this->mCheckImage, 5, $x+8, $y, $this->mCheckCode[$i], $bg_color);  
    	} 
    }

    public function OutCheckImage() {  
    	$this ->OutFileHeader();  
    	$this ->CreateCheckCode();
    	   	
    	$this ->CreateImage(); 
    	$this ->SetDisturbColor();  
    	$this ->WriteCheckCodeToImage();  
    	imagepng($this->mCheckImage);  
    	imagedestroy($this->mCheckImage); 
    }
}
$c_check_code_image = new CCheckCodeFile();
//$c_check_code_image ->SetCheckImageWH(100,50);
$c_check_code_image->OutCheckImage();
*/



//生成验证码图片 
Header("Content-type: image/PNG");
 
//srand((double)microtime()*1000000);//播下一个生成随机数字的种子，以方便下面随机数生成的使用

session_start();//将随机数存入session中
$_SESSION['code']="";
$im = imagecreate(62,20); //制定图片背景大小

$black = ImageColorAllocate($im, 0,0,0); //设定三种颜色
$white = ImageColorAllocate($im, 255,255,255); 
$gray = ImageColorAllocate($im, 200,200,200); 

imagefill($im,0,0,$gray); //采用区域填充法，设定（0,0）

//while(($authnum=rand()%100000)<10000);
$authnum=substr(md5(rand()),5,5);
//将四位整数验证码绘入图片 
$_SESSION['code']=$authnum;
imagestring($im, 5, 10, 3, $authnum, $black);
// 用 col 颜色将字符串 s 画到 image 所代表的图像的 x，y 座标处（图像的左上角为 0, 0）。
//如果 font 是 1，2，3，4 或 5，则使用内置字体

for($i=0;$i<200;$i++) //加入干扰象素 
{ 
$randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
imagesetpixel($im, rand()%70 , rand()%30 , $randcolor); 
} 


ImagePNG($im); 
ImageDestroy($im); 
?>