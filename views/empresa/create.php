<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var app\models\Empresa $model */

use yii\helpers\Html;

$this->title = 'Nova empresa';
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['meta_description'] = 'Cadastro de uma nova empresa.';
?>
<div class="empresa-create">
    <h1 class="h3 mb-3"><?= Html::encode($this->title) ?></h1>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
