<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var app\models\Empresa $model */

use yii\helpers\Html;

$this->title = 'Atualizar empresa: ' . $model->nome_fantasia;
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome_fantasia, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
$this->params['meta_description'] = 'Edição dos dados da empresa ' . $model->nome_fantasia;
?>
<div class="empresa-update">
    <h1 class="h3 mb-3"><?= Html::encode($this->title) ?></h1>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
