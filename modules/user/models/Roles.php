<?php

namespace app\modules\user\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 *
 * @property-read ActiveQuery $userRole
 */
class Roles extends ActiveRecord
{
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules(): array
    {
        return [['name', 'type', 'created_at', 'updated_at'], ];
    }

    /**
     * @return ActiveQuery
     * @noinspection PhpUnused
     */
    public function getUserRole(): ActiveQuery
    {
        return $this->hasOne(UserRole::class, ['item_name' => 'name']);
    }
    public static function tableName() :string
    {
        return 'auth_item';
    }
}
