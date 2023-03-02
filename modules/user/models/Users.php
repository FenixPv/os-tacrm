<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 * @property string $login
 * @property string|null $email_confirm_token
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property-read mixed $statusName
 * @property-write mixed $password
 * @property int $status
 */
class Users extends ActiveRecord implements IdentityInterface
{
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;

    public function behaviors(): array
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules(): array
    {
        return [
            [['created_at', 'updated_at', 'login', 'password_hash', 'email'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['login', 'email_confirm_token', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['login'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * @throws \Exception
     * @noinspection PhpUnused
     */
    public function getStatusName(): mixed
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    public static function getStatusesArray(): array
    {
        return [
            self::STATUS_BLOCKED => 'Заблокирован',
            self::STATUS_ACTIVE  => 'Активен',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id'         => 'ID',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлён',
            'login'      => 'Имя пользователя',
            'email'      => 'Email',
            'status'     => 'Статус',
        ];
    }

    public static function findIdentity($id): ?IdentityInterface
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        throw new NotSupportedException('findIdentityByAccessToken is not implemented.');
    }

    public function getId(): mixed
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey(): ?string
    {
        return null;
    }

    public function validateAuthKey($authKey): ?bool
    {
        return null;
    }

    public static function findByLogin($login): ?Users
    {
        return static::findOne(['login' => $login]);
    }

    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @throws Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public static function findByPasswordResetToken($token): ?Users
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid($token): bool
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @throws Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

}
