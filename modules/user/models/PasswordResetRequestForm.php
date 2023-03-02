<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;

class PasswordResetRequestForm extends Model
{
    public string $email = '';

    public function rules(): array
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
             'targetClass' => '\common\models\User',
             'filter' => ['status' => Users::STATUS_ACTIVE],
             'message' => 'There is no user with this email address.'
            ],
        ];
    }

    public function sendEmail(): bool
    {
        /* @var $user Users */
        $user = Users::findOne([
            'status' => Users::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        if (!Users::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose('@app/modules/user/mails/passwordReset', ['user' => $user])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Сброс пароля для' . Yii::$app->name)
            ->send();
    }
}