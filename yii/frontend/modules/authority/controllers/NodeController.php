<?php
namespace frontend\modules\community\controllers;
use frontend\controllers\BaseController;
use common\models\NodeForm;

/**
 * Ȩ�޽ڵ���������
 * @author fuliang
 * @email fuliang19890908@163.com
 * @date 2018-05-13
 */

class NodeController extends BaseController
{
    #Ȩ�޹�����ҳ
    public function actionIndex(){
        $authManager = \Yii::$app->authManager;
        $nodes = $authManager->getPermissions();

        return $this->render('index',[
            'nodes'=>$nodes,
        ]);
    }
    #����Ȩ��
    public function actionCreate(){
        $model = new NodeForm();

        if($model->load(\Yii::$app->request->post()) && $model->save()){
            \Yii::$app->session->setFlash('success','�ڵ�['.$model->name.']��ӳɹ�');
            return $this->redirect(['/node/index']);
        }else{
            return $this->render('create',[
                'model'=>$model,
            ]);
        }
    }
    #����Ȩ��
    public function actionUpdate($name){
        $authManager = \Yii::$app->authManager;
        $child = $authManager->getChildren($name);
        if($child){
            \Yii::$app->session->setFlash('success','�ڵ�['.$name.']���ӽڵ�,�����޸�');
            return $this->redirect(['/node/index']);
        }

        $node = $authManager->getPermission($name);
        if(!$node) return false;
        $model = new NodeForm();
        $model->name = $node->name;
        $model->description = $node->description;

        if($model->load(\Yii::$app->request->post()) && $model->update($name)){
            \Yii::$app->session->setFlash('success','�ڵ�['.$name.']�޸ĳɹ�');
            return $this->redirect(['/node/index']);
        }else{
            return $this->render('update',[
                'model'=>$model,
            ]);
        }
    }
    #ɾ��Ȩ��
    public function actionDelete($name){
        $authManager = \Yii::$app->authManager;
        $child = $authManager->getChildren($name);
        if($child){
            \Yii::$app->session->setFlash('success','�ڵ�['.$name.']���ӽڵ�,����ɾ��');
            return $this->redirect(['/node/index']);
        }
        $node = $authManager->getPermission($name);
        if(!$node) return false;
        if($authManager->remove($node)){
            \Yii::$app->session->setFlash('success','�ڵ�['.$name.']ɾ���ɹ�');
        }else{
            \Yii::$app->session->setFlash('error','�ڵ�['.$name.']ɾ��ʧ��');
        }
        return $this->redirect(['/node/index']);
    }
}