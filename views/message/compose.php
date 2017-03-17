<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Message */

$this->title = Yii::t('message', 'Write a message');
$this->params['breadcrumbs'][] = ['label' => Yii::t('message', 'Inbox'), 'url' => ['inbox']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-create">

    <?php if (!$dialog): ?>
        <h1> <?= Html::encode($this->title) ?> </h1>
    <?php endif ?>

    <div class="message-form">

        <?php $form = ActiveForm::begin(['id' => 'message-form']); ?>

        <?php
        if ($model->to) {
            if ($model->to && is_array($model->to) && count($model->to) === 1)
                $to = $model->to[0];
            else
                $to = json_encode($model->to);

            $recipient_label = Yii::t('message', 'Recipient');
            echo "<label class=\"control-label\" for=\"message-recipient\">$recipient_label</label>";
            echo '<p>' . $model->recipient->username . '</p>';
            echo '<input type=hidden name="Message[to]" value="' . $to . '" />';
        } else
            echo $form->field($model, 'to')->widget(Select2::className(), [
                'data' => $possible_recipients,
                'options' => [
                    'multiple' => $allow_multiple,
                ],
                'language' => Yii::$app->language ? Yii::$app->language : null,
            ]); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'required' => 'required']) ?>

        <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'context')->hiddenInput()->label(false); ?>

        <div class="form-group">
            <?php
            if ($dialog)
                echo Html::button(Yii::t('message', 'Send'), ['class' => 'btn btn-success btn-send-message']);
            else
                echo Html::submitButton(Yii::t('message', 'Send'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <hr>
        <?=  Html::a('<i class="fa fa-arrow-left" aria-hidden="true"></i> zurück zum Posteingang', ['/message/message/inbox']) ?>
    </div>

</div>
