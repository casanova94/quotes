<?php
$this->title = 'Panel de control';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => '150',
                'text' => 'Clientes',
                'icon' => 'fas fa-user',
                'linkUrl' => Yii::$app->urlManager->createUrl(['clients/index']),
            ]) ?>
        </div>
 
    </div>
</div>