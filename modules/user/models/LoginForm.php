<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read Users|null $user
 *
 */
class LoginForm extends Model
{
    public string $login = '';
    public string $password = '';
    public bool $rememberMe = true;

    private bool|Users $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['login', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /** @noinspection PhpUnused */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', 'Неверное имя пользователя или пароль.');
            } elseif ($user && $user->status == Users::STATUS_BLOCKED) {
                $this->addError('login', 'Ваш аккаунт заблокирован.');
            }
        }
    }

    /**
     * Logs in a user using the provided login and password.
     * @return bool whether the user is logged in successfully
     */
    public function login(): bool
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 3600);
        }
        return false;
    }

    /**
     * Finds user by [[login]]
     *
     * @return Users
     */
    public function getUser(): Users
    {
        if ($this->_user === false) {
            $this->_user = Users::findByLogin($this->login);
        }

        return $this->_user;
    }
}
