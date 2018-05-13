<?php
namespace common\models;
use Yii;
use yii\base\Model;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: fuliang
 * Date: 2018/5/13
 * Time: 21:25
 */
class NodeForm extends Model
{
    public $name;
    public $description;
    public $parent;

    public function rules(){
        return [
            [['name','parent'],'string','max'=>20],
            [['name','description'],'required','message'=>'name���Բ���Ϊ��'],
            ['name','match','pattern'=>'/^[a-z][a-z-_]{2,20}$/','message'=>'name���Բ��Ϸ�'],
            ['parent','match','pattern'=>'/^[a-z-_][a-z-_]{2,20}$/','message'=>'parent���Բ��Ϸ�'],
            ['parent','validateParent'],
            ['description','filter','filter'=>function($value){
                return Html::encode($value);
            }],
        ];
    }

    public function validateParent($attribute,$params){
        if(!$this->hasErrors()){
            $authManager = Yii::$app->authManager;
            $node = $authManager->getPermission($this->parent);
            if(empty($node)){
                $this->addError($attribute,'�ϼ��ڵ㲻����');
            }
        }
    }

    public function attributeLabels(){
        return [
            'name'=>'�ڵ�����',
            'description'=>'�ڵ�����',
            'parent'=>'�����ڵ�',
        ];
    }

    public function save(){
        if($this->validate()){
            $authManager = Yii::$app->authManager;
            $node = $authManager->createPermission($this->name);
            $node->description = $this->description;
            $authManager->add($node);

            if(!empty($this->parent)){
                $parent = $authManager->getPermission($this->parent);
                $authManager->addChild($parent,$node);
            }
            return true;
        }else{
            return false;
        }
    }

    public function update($name){
        if($this->validate()){
            $authManager = Yii::$app->authManager;
            $node = $authManager->getPermission($name);
            if(!$node) return false;
            $authManager->remove($node);

            $node = $authManager->createPermission($this->name);
            $node->description = $this->description;
            $authManager->add($node);
            if(!empty($this->parent)){
                $parent = $authManager->getPermission($this->parent);
                $authManager->addChild($parent,$node);
            }
            return true;
        }
        return false;
    }
}