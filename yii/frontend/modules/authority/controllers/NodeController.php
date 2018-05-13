<?php
namespace frontend\modules\authority\controllers;
use frontend\controllers\BaseController;
use common\models\NodeForm;

/**
 * 权限节点管理控制器
 * @author fuliang
 * @email fuliang19890908@163.com
 * @date 2018-05-13
 */

class NodeController extends BaseController
{
    #权限管理首页
    public function actionIndex(){
        $authManager = \Yii::$app->authManager;
        $nodes = $authManager->getPermissions();

        return $this->render('index',[
            'nodes'=>$nodes,
        ]);
    }
    #创建权限
    public function actionCreate(){
        $model = new NodeForm();

        if($model->load(\Yii::$app->request->post()) && $model->save()){
            \Yii::$app->session->setFlash('success','节点['.$model->name.']添加成功');
            return $this->redirect(['/authority/node/index']);
        }else{
            return $this->render('create',[
                'model'=>$model,
            ]);
        }
    }
    #更新权限
    public function actionUpdate($name){
        $authManager = \Yii::$app->authManager;
        $child = $authManager->getChildren($name);
        if($child){
            \Yii::$app->session->setFlash('success','节点['.$name.']有子节点,不能修改');
            return $this->redirect(['/authority/node/index']);
        }

        $node = $authManager->getPermission($name);
        if(!$node) return false;
        $model = new NodeForm();
        $model->name = $node->name;
        $model->description = $node->description;

        if($model->load(\Yii::$app->request->post()) && $model->update($name)){
            \Yii::$app->session->setFlash('success','节点['.$name.']修改成功');
            return $this->redirect(['/authority/node/index']);
        }else{
            return $this->render('update',[
                'model'=>$model,
            ]);
        }
    }
    #删除权限
    public function actionDelete($name){
        $authManager = \Yii::$app->authManager;
        $child = $authManager->getChildren($name);
        if($child){
            \Yii::$app->session->setFlash('success','节点['.$name.']有子节点,不能删除');
            return $this->redirect(['/authority/node/index']);
        }
        $node = $authManager->getPermission($name);
        if(!$node) return false;
        if($authManager->remove($node)){
            \Yii::$app->session->setFlash('success','节点['.$name.']删除成功');
        }else{
            \Yii::$app->session->setFlash('error','节点['.$name.']删除失败');
        }
        return $this->redirect(['/authority/node/index']);
    }
}