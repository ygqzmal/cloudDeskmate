<?php
namespace app\admin\controller;

use app\common\model\User;
use app\common\vendor\Mailer;
use think\Controller;
use think\Request;

class UserCon extends Controller
{
    //登录数据处理
    public function LoginDeal()
    {
        $data=input('post.');
        $user=new User;
        $user->LoginDeal($data);
    }

    //发送邮箱
    public function Mail()
    {
        $mail=new Mailer();
        $yanz=rand(1000,9999);
        $data['title']="(｡･∀･)ﾉﾞ嗨，这个是一个测试哦";
        $data['body']="验证码为".$yanz."你肯定猜不到我是谁吧！娃哈哈....";
        $data['sendto']='481632833@qq.com';
        $mail->GetYz($data);
        echo $yanz;
    }

    //注册的数据处理
    public function RegisterDeal()
{
$data=input('post.');//获取注册表单的值；
$user=new User();
$user->allowField(true)->validate(true)->AddUser($data);
echo $user->getError();
}
    //修改数据
    public function ReviseDeal()
    {
        $data=input('post.');
        $user=new User;
                switch($data['key']){
                    case 'head':
                        $requst=new Request();
                        $file=$requst->file('value');
                        //调用控制器中的文件进行验证
                        $result = $this->validate(['file' => $file],
                            ['file' => 'require|image|fileExt:png,jpg,gif'],
                            ['file.require' => '请选择上传文件','file.image'=>'必须是图片哦','file.fileExt'=>'文件格式不对']);
                        if($result!==true){
                            echo $result;
                        }else {
                            $user->ReviseHead($file);
                        }
                        break;
                    default :
                        $user->ReviseOther($data);
                        break;
        }
    }
}

//王康写