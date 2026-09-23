<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var app\models\Empresa $model */

use app\models\Empresa;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->nome_fantasia;
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['meta_description'] = 'Detalhes da empresa ' . $model->nome_fantasia;
?>
<div class="empresa-view">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h1 class="h3 mb-0"><?= Html::encode($this->title) ?></h1>
        <div class="d-flex gap-2">
            <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Tem certeza que deseja excluir esta empresa?',
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-bordered mb-0'],
                'attributes' => [
                    'id',
                    'razao_social',
                    'nome_fantasia',
                    [
                        'attribute' => 'cnpj',
                        'value' => $model->cnpjFormatado,
                    ],
                    'email:email',
                    'telefone',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => Html::tag(
                            'span',
                            Html::encode($model->statusLabel),
                            [
                                'class' => (int) $model->status === Empresa::STATUS_ATIVA
                                    ? 'badge bg-success'
                                    : 'badge bg-secondary',
                            ],
                        ),
                    ],
                    'created_at',
                    'updated_at',
                ],
            ]) ?>
        </div>
    </div>
</div>
