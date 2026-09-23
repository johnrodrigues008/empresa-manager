# CRUD de Empresa — passo a passo

Este arquivo descreve como o CRUD de empresa foi montado em cima do Yii2 Basic já existente.

## 1. Criar o projeto

O aplicativo nasceu do template oficial do Yii2:

```bash
composer create-project --prefer-dist yiisoft/yii2-app-basic empresa-manager
```

Comandos úteis do dia a dia:

```bash
php yii serve
php yii migrate
```

- `php yii serve` sobe o servidor embutido (em geral em `http://localhost:8080`).
- `php yii migrate` aplica as migrations no banco configurado em `config/db.php`.

## 2. Configurar o banco

O Yii2 Basic já vem com conexão MySQL em `config/db.php`. O CRUD usa essa conexão:

- host: `localhost`
- database: `yii2basic`
- usuário: `root`

A base `yii2basic` precisa existir no MySQL antes de migrar.

## 3. Criar a tabela com migration

A tabela foi gerada pelo comando:

```bash
php yii migrate/create create_empresa_table
```

Isso criou `migrations/m260923_105726_create_empresa_table.php`. A migration foi preenchida com os campos da empresa:

| Campo | Tipo | Observação |
|---|---|---|
| `id` | PK | chave primária |
| `razao_social` | string, obrigatório | |
| `nome_fantasia` | string, obrigatório | |
| `cnpj` | string, único | unique index em migration extra; validado e gravado só com dígitos |
| `email` | string, obrigatório | |
| `telefone` | string, obrigatório | |
| `status` | boolean | padrão `true` (ativa) |
| `created_at` | timestamp | preenchido pelo banco |
| `updated_at` | timestamp | atualizado pelo banco |

Uma segunda migration (`m260923_111235_add_unique_index_to_empresa_cnpj`) adiciona índice único em `cnpj`.

Para criar a tabela e o índice:

```bash
php yii migrate
```

Para desfazer:

```bash
php yii migrate/down
```

## 4. Completar o model `Empresa`

Já existia `models/Empresa.php` só com `tableName()`. Ele foi complementado com:

- regras de validação (`required`, tamanho, e-mail, status e CNPJ único);
- validação de dígitos do CNPJ;
- normalização do CNPJ (remove pontuação antes de validar/salvar);
- labels em português;
- helpers `cnpjFormatado`, `statusLabel` e `getStatusList()`.

O Yii mapeia a classe `app\models\Empresa` para a tabela `empresa` automaticamente.

## 5. Criar o model de busca `EmpresaSearch`

Arquivo: `models/EmpresaSearch.php`.

Ele estende `Empresa` e monta o `ActiveDataProvider` da listagem:

- filtros por id, status, razão social, nome fantasia, CNPJ, e-mail e telefone;
- paginação de 10 registros;
- ordenação padrão por `id` decrescente.

Esse model alimenta o `GridView` da tela de índice.

## 6. Criar o controller CRUD

Arquivo: `controllers/EmpresaController.php`.

Rotas geradas pelo Yii (padrão `index.php?r=controller/action`):

| Ação | URL | Função |
|---|---|---|
| `actionIndex` | `?r=empresa/index` | lista e filtra empresas |
| `actionView` | `?r=empresa/view&id=1` | detalhe |
| `actionCreate` | `?r=empresa/create` | cadastro |
| `actionUpdate` | `?r=empresa/update&id=1` | edição |
| `actionDelete` | `?r=empresa/delete&id=1` | exclusão (somente POST) |

O `VerbFilter` impede exclusão via GET. O `findModel()` lança `404` se o id não existir. Após create/update/delete, um flash de sucesso é exibido pelo widget `Alert` do layout.

## 7. Criar as views

Pasta: `views/empresa/`.

| Arquivo | Papel |
|---|---|
| `index.php` | listagem com `GridView`, filtros e ações |
| `create.php` | tela de cadastro |
| `update.php` | tela de edição |
| `_form.php` | formulário compartilhado por create e update |
| `view.php` | detalhe com `DetailView` |

O formulário reaproveita o mesmo `_form.php` nas duas telas. O botão muda de **Cadastrar** para **Salvar alterações** conforme `$model->isNewRecord`.

## 8. Incluir o menu

Em `views/layouts/_header.php` foi adicionado o item **Empresas**, apontando para `/empresa/index`. Assim o CRUD fica acessível em qualquer página do sistema.

## 9. Como usar

1. Confirme o banco em `config/db.php`.
2. Rode `php yii migrate`.
3. Rode `php yii serve`.
4. Abra `http://localhost:8080/index.php?r=empresa/index`.
5. Clique em **Nova empresa**, preencha os dados e salve.
6. Na listagem, use visualizar / editar / excluir.

CNPJ de teste válido: `11.222.333/0001-81`.

## 10. Fluxo do CRUD

```
Menu "Empresas"
    → index (lista + filtros)
        → create → valida → salva → view
        → view → update → valida → salva → view
        → view/index → delete (POST) → index
```

1. O usuário envia o formulário.
2. O controller faz `$model->load(Yii::$app->request->post())`.
3. `Empresa::beforeValidate()` limpa o CNPJ.
4. As `rules()` validam campos, e-mail, CNPJ e unicidade.
5. `save()` grava na tabela `empresa`.
6. O usuário é redirecionado para o detalhe ou para a lista.

## 11. Arquivos envolvidos

```
migrations/m260923_105726_create_empresa_table.php
migrations/m260923_111235_add_unique_index_to_empresa_cnpj.php
models/Empresa.php
models/EmpresaSearch.php
controllers/EmpresaController.php
views/empresa/index.php
views/empresa/create.php
views/empresa/update.php
views/empresa/_form.php
views/empresa/view.php
views/layouts/_header.php
config/db.php
```
