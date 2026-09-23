<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var app\models\Empresa $model */
/** @var yii\bootstrap5\ActiveForm $form */

use app\models\Empresa;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>
<div class="empresa-form">
    <?php $form = ActiveForm::begin([
        'id' => 'empresa-form',
        'options' => ['autocomplete' => 'off'],
    ]); ?>

    <div class="row g-3">
        <div class="col-md-6">
            <?= $form->field($model, 'razao_social')->textInput([
                'maxlength' => true,
                'placeholder' => 'Razão social da empresa',
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'nome_fantasia')->textInput([
                'maxlength' => true,
                'placeholder' => 'Nome fantasia',
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'cnpj')->textInput([
                'maxlength' => true,
                'placeholder' => '00.000.000/0000-00',
                'value' => $model->cnpj ? $model->cnpjFormatado : $model->cnpj,
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email')->textInput([
                'maxlength' => true,
                'type' => 'email',
                'placeholder' => 'contato@empresa.com',
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'telefone')->textInput([
                'maxlength' => true,
                'placeholder' => '(00) 00000-0000',
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList(
                Empresa::getStatusList(),
                ['prompt' => 'Selecione o status'],
            ) ?>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Cadastrar' : 'Salvar alterações',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'],
        ) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
