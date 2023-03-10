<?php

namespace app\modules\user\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


/**
 * @property-read ActiveQuery $roles
 * @property-read ActiveQuery $user
 */

class UserRole extends ActiveRecord
{

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules(): array
    {
        return [
            [['created_at', 'item_name', 'user_id'], 'required'],
            [['created_at', 'user_id'], 'integer'],
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /** @noinspection PhpUnused */
    public function getRoles(): ActiveQuery
    {
        return $this->hasMany(Roles::class, ['name' => 'item_name']);
    }

    public static function tableName(): string
    {
        return 'auth_assignment';
    }

    public function generateAttributeLabel($name): array
    {
        return [
            'item_name' => 'Роль',
            'user_id'   => 'Пользователь',
        ];
    }

}
