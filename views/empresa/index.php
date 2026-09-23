<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var app\models\EmpresaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

use app\models\Empresa;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Empresas';
$this->params['breadcrumbs'][] = $this->title;
$this->params['meta_description'] = 'Listagem e gestão de empresas cadastradas.';
?>
<div class="empresa-index">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h1 class="h3 mb-1"><?= Html::encode($this->title) ?></h1>
            <p class="text-body-secondary mb-0">Cadastre, consulte, edite e exclua empresas.</p>
        </div>
        <?= Html::a('Nova empresa', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-hover mb-0'],
                'layout' => "{items}\n<div class=\"px-3 py-2 d-flex justify-content-between align-items-center flex-wrap gap-2\">{summary}{pager}</div>",
                'emptyText' => 'Nenhuma empresa encontrada.',
                'columns' => [
                    'id',
                    'razao_social',
                    'nome_fantasia',
                    [
                        'attribute' => 'cnpj',
                        'value' => static fn (Empresa $model): string => $model->cnpjFormatado,
                    ],
                    'email:email',
                    'telefone',
                    [
                        'attribute' => 'status',
                        'filter' => Empresa::getStatusList(),
                        'format' => 'raw',
                        'value' => static function (Empresa $model): string {
                            $class = (int) $model->status === Empresa::STATUS_ATIVA
                                ? 'bg-success'
                                : 'bg-secondary';

                            return Html::tag(
                                'span',
                                Html::encode($model->statusLabel),
                                ['class' => "badge {$class}"],
                            );
                        },
                    ],
                    [
                        'class' => ActionColumn::class,
                        'urlCreator' => static function (string $action, Empresa $model): string {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        },
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
