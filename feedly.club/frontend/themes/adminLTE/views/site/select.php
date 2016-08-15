<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'select member';
$this->params['breadcrumbs'][] = $this->title;
 ?>
 <div class="select">
   <div class="jumbotron">
     <h3>สมัครสมาชิก</h3>
     <?= Html::a('Editor', ['/site/signup','type_member'=>1], ['class'=>'btn btn-primary'] ) ?>
     <?= Html::a('Publicher', ['/site/signup','type_member'=>2], ['class'=>'btn btn-primary']) ?>
   </div>

 </div>
