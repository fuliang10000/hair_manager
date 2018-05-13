<?php
/**
 * Ȩ�޽ڵ���ҳ��ͼ
 * @author fuliang
 * @email fuliang19890908@163.com
 * @date 2018-05-13
 */
use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Ȩ�޽ڵ�';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="node-index">


    <p>
        <?= Html::a('�½��ڵ�', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>�ڵ�����</th>
            <th>�ڵ�����</th>
            <th>�� ��</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($nodes as $v){?>
            <tr>
                <td><?= $v->name?></td>
                <td><?= $v->description?></td>
                <td style="width: 60px;">
                    <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>',['/node/update','name'=>$v->name])?>
                    &nbsp;
                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>',['/node/delete','name'=>$v->name],[
                        'data' => [
                            'confirm' => 'ȷ��ɾ����',
                            'method' => 'post',
                        ]
                    ])?>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>


</div>
