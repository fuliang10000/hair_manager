<?php
/**
 * ����Ȩ�޽ڵ�Ȩ����ͼ
 * @author fuliang
 * @email fuliang19890908@163.com
 * @date 2018-05-13
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = '���½ڵ�';
$this->params['breadcrumbs'][] = ['label'=>'�ڵ�','url'=>['/node/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <?php $form=ActiveForm::begin()?>
    <div class="col-md-6">
        <?= $form->field($model,'name')->textInput(['maxlength'=>true,'value'=>$model->name])->hint('�ڵ�������Сд��ĸ��ͷ��3-20λ�ַ���Сд��ĸ-_�����')?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model,'description')->textarea(['rows'=>3,'value'=>$model->description])?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model,'parent')->textInput(['maxlength'=>true,'parent'=>$model->parent])->hint('�ڵ�������Сд��ĸ��ͷ��3-20λ�ַ���a-z-_�����')?>
    </div>
    <div class="col-md-8">
        <?=Html::submitButton((Yii::$app->controller->action->id == 'create')?'�½�':'����',['class'=>'btn btn-primary'])?>
    </div>
    <?php ActiveForm::end()?>
</div>
