<?php
namespace frontend\controllers;


use yii\web\Controller;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)){
            $controllerId=$action->controller->id;
            $actionId=$action->id;
            $nodeName=$controllerId.'_'.$actionId;
            $user=\Yii::$app->user->identity;
            if(in_array($nodeName,['site_login','site_error', 'site_password'])){
                return true;
            }
            if(!\Yii::$app->user->isGuest){
                //检查是否没有修改默认密码
                if($user->getIsDefaultPwd()&&!in_array($nodeName,['site_login','site_error','site_password'])){
                    return $this->redirect(['/site/password']);
                }
            }
            if($controllerId==='site'||$user->getId()==User::SUPER_ADMIN){
                return true;
            }
            if(\Yii::$app->user->can($nodeName)){
                return true;
            }else{
                throw new ForbiddenHttpException('对不起，您现在还没获此操作的权限');
            }
        }else{
            return false;
        }
    }
}