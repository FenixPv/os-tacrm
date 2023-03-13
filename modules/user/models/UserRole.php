<?php

namespace app\modules\user\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;


/**
 * @property-read ActiveQuery $roles
 * @property-read ActiveQuery $user
 * @property-read array $rolesArray
 * @property string $item_name
 * @property int $created_at
 * @property int $user_id
 */

class UserRole extends ActiveRecord
{
//    public $item_name;

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
    public function attributeLabels(): array
    {
        return [
            'item_name' => 'Роль',
            'user_id' => 'user_id',
            'created_at' => 'created_at'
        ];
    }

    public function getRolesArray() :array
    {
        return ArrayHelper::map(Roles::find()
            ->indexBy('name')
            ->where('type = 1')->all(), 'name', 'description');
    }

}
