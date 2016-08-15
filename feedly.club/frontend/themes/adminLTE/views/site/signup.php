<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\fileupload\FileUpload;
use dosamigos\fileupload\FileUploadUI;
use kartik\file\FileInput;
use yii\helpers\Url;
//use kartik\widgets\ActiveForm;
use kartik\label\LabelInPlace;
$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'options' => ['enctype' => 'multipart/form-data'] ]); ?>
                  
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>


                <?= $form->field($model, 'name')->textInput() ?>

                <?= $form->field($model, 'lastname')->textInput() ?>
                  <!--?= $form->field($model, 'avatar')->textInput() ?-->
                <!--?= $form->field($model, 'avatar')->fileInput() ?-->
                <!--?php echo $form->field($model, 'avatar_img')->widget(FileInput::classname(), [
                  //  'options' => ['accept' => 'image/*'],
                  'pluginOptions' => ['showUpload' => false,],
                    ]); ?-->

              <br><?php echo FileInput::widget([
                    'model' => $model,
                  'attribute' => 'avatar_img',
                    'pluginOptions' => [
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  'Select Photo'
                    ],
                    'options' => ['accept' => 'image/*']
                ]); ?><br>
                <!-- <
                $form->field($model, 'user_id')->textInput() ?> -->

                <!--
                $form->field($model, 'user_id')->textInput(['readonly' => true, 'value' => $model->id])

                ?> -->

                <?= $form->field($model, 'date_register')->textInput(['readonly' => true, 'value' => date('Y-m-d')]) ?>

                <?= $form->field($model, 'email') ?>


                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 're_password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
