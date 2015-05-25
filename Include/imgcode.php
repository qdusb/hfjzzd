<?php
/*
session_start();
class CCheckCodeFile{ 	
	private $mCheckCodeNum=4; 	
 	private  $mCheckCode   = '';  	
 	private $mCheckImage  = '';
 	//��������
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
 /**  ����ͼƬ�ĸ������� * */ 
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



//������֤��ͼƬ 
Header("Content-type: image/PNG");
 
//srand((double)microtime()*1000000);//����һ������������ֵ����ӣ��Է���������������ɵ�ʹ��

session_start();//�����������session��
$_SESSION['code']="";
$im = imagecreate(62,20); //�ƶ�ͼƬ������С

$black = ImageColorAllocate($im, 0,0,0); //�趨������ɫ
$white = ImageColorAllocate($im, 255,255,255); 
$gray = ImageColorAllocate($im, 200,200,200); 

imagefill($im,0,0,$gray); //����������䷨���趨��0,0��

//while(($authnum=rand()%100000)<10000);
$authnum=substr(md5(rand()),5,5);
//����λ������֤�����ͼƬ 
$_SESSION['code']=$authnum;
imagestring($im, 5, 10, 3, $authnum, $black);
// �� col ��ɫ���ַ��� s ���� image �������ͼ��� x��y ���괦��ͼ������Ͻ�Ϊ 0, 0����
//��� font �� 1��2��3��4 �� 5����ʹ����������

for($i=0;$i<200;$i++) //����������� 
{ 
$randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
imagesetpixel($im, rand()%70 , rand()%30 , $randcolor); 
} 


ImagePNG($im); 
ImageDestroy($im); 
?>