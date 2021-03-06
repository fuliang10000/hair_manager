<?php
/**
 * 权限节点首页视图
 * @author fuliang
 * @email fuliang19890908@163.com
 * @date 2018-05-13
 */
use yii\helpers\Html;


$this->title = '权限节点';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="node-index">


    <p>
        <?= Html::a('新建节点', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>节点名称</th>
            <th>节点描述</th>
            <th>操 作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($nodes as $v){?>
            <tr>
                <td><?= $v->name?></td>
                <td><?= $v->description?></td>
                <td style="width: 60px;">
                    <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>',['/authority/node/update','name'=>$v->name])?>
                    &nbsp;
                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>',['/authority/node/delete','name'=>$v->name],[
                        'data' => [
                            'confirm' => '确认删除吗？',
                            'method' => 'post',
                        ]
                    ])?>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>
