<?php
namespace app\common\vendor;

use think\Image;
use think\Request;

class Picture
{
    public function Up($file,$type,$id=0)//（图片文件，什么需要处理,上传图片人的id号）
    {
        //进行图片命名和打开图片
        $request=new Request();
        $saveName=$request->time();//获取时间挫
        $image=Image::open($file);
        //$link得命名规范，static/picture/数据库名/时间挫.png(最好是用户id+时间挫.png)

        //图片处理，如果需要，可以在下面添加case进行图片处理，
        switch($type){
            //广告
            case 'advertise':
                $deal=$image->thumb(20,40,6);
                $link='static'.DS.'picture'.DS.$type.DS.$id.$saveName.'.png';//路径只需要从static开始
                break;
            //用户
            case 'user':
                $deal=$image->thumb(30,40,6);
                $link='static'.DS.'picture'.DS.$type.DS.$id.'.png';
                break;
        }
        //上传图片
        if($deal->save(ROOT_PATH.'public'.DS.$link)){
            //echo $deal->width()."<br/>".$deal->height();
            return $link;//放回路径
        }else{
            echo "失败";
        }
    }
}



//王康写