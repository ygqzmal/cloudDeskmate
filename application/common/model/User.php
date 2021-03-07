<?php
namespace app\common\model;

use app\common\vendor\Picture;
use think\exception\ErrorException;
use think\Image;
use think\Model;

class User extends Model
{
    //查找用户表中是否存在数据，默认为用户名是否存在
    public function SeekUser($value,$type='name',$id=0)//(查找的用户民，查找类型，如name,mail等~，出这个id外的其它用户名)
    {
        $where=[
            $type=>['=',$value],
            'id'=>['not in',$id]
        ];
       if($this->where($where)->select())
       {
           return true;
       }else{
           return false;
       }
    }

    //注册
    public function AddUser($data)//添加用户
    {
        if($data['test']!='1234')//判断验证码是否正确
        {
            echo '验证码不对';
            return 0;
        }else if($this->SeekUser($data['name'],$type='mail')!==false){//判断用户名存在
            echo '用户名已存在';
            return 0;
        }else if($this->SeekUser($data['mail'],$type='mail')!==false){//判断邮箱存在
            echo '邮箱已绑定用户';
            return 0;
        }else if(strlen($data['passwd'])>=5&&strlen($data['passwd'])<=15){//判断密码是否规范
            $data['head']='static'.DS."picture".DS."user".DS.'0.png';
            $data['passwd']=md5($data['passwd']);
            if($this->save($data))//写入数据库，看是否成功
            {
                echo "用户注册成功";
            }else{
                echo "未知错误,用户注册失败<br/>";
            }
        }
    }

    //登录
    public function LoginDeal($data)
    {
        if($data['test']!='1234')//判断验证码是否正确
        {
            echo '验证码不对';
            return 0;
        }else{
            $where=[
                'name'=>['=',$data['name']],
            ];
            if(!$user=$this->where($where)->find())
            {
                echo "用户密码不正确，请检查大小写";
            }else{
                if(md5($data['passwd'])!==$user['passwd'])
                {
                    echo "用户密码不正确，请检查大小写";
                }else{
                    echo "登录成功";
                }
            }
        }
    }

    //修改头像
    public function ReviseHead($file)
    {
        $pictury=new Picture();//调用图像处理函数
        $link=$pictury->Up($file,'user','1');
        if($this->where(['id'=>['=',1]])->update(['head'=>$link])||$link){
            echo "修改成功";
        }else{
            echo "修改失败";
        }
    }
    //修改其它的
    public function ReviseOther($data)
    {
        switch($data['key']){
            //修改姓名
            case 'name':
                if($this->SeekUser($data['value'],$data['key'],$data['id'])){
                    echo "用户名存在";
                    return ;
                }else if(strlen($data['value'])<2||strlen($data['value'])>15){
                    echo "用户名格式不合法";
                    return ;
                }
                break;
            //修改手机号码
            case "tele":
                if(strlen($data['value'])!=11){
                    echo "手机号格式不合法";
                    return ;
                }
                break;
            //修改邮箱
            case "mail":
                if($this->SeekUser($data['value'],$data['key'],$data['id'])){
                    echo "此邮箱判定用户，不可再次判定";
                    return ;
                }
                break;
            //修改性别
            case 'sex':
                if($data['value']!=0&&$data['value']!=1){
                    echo "性别填写错误，请小心填写哦";
                    return ;
                }
                break;
            //修改职业
            case 'professions':
                if(empty($data['value'])||strlen($data['value'])>10){
                    echo "职业可不能为空！也不可以写得太长了哦";
                    return ;
                }
            //修改省
            case 'address_sheng':
                if(empty($data['value'])||strlen($data['value'])>10){
                    echo "省可不能为空！也不可以写得太长了哦";
                    return ;
                }
            //修改市
            case 'address_shi':
                if(empty($data['value'])||strlen($data['value'])>10){
                    echo "市可不能为空！也不可以写得太长了哦";
                    return ;
                }
        }

        //如果符合条件，就进行写入数据库
        if($this->where(['id'=>['=',$data['id']]])->update([$data['key']=>$data['value']])){
            echo "修改成功";
        }else{
            echo "未知错误,也许是你还没有进行修改哦";
        }
    }

    //密码验证
    public function PasswdYz($passwd,$id){
        $passwd=md5($passwd);
        $a=$this->where(['id'=>['=',$id]])->column('passwd');
        if($passwd==$a[0]){
            return true;
        }else{
            return false;
        }
    }
    //一对多和收藏表
    public function CU()
    {
        return $this->hasMany('Collect','id','uid');
    }


}



//王康写