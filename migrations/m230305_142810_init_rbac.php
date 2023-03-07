<?php

use yii\db\Migration;

/**
 * Class m230305_142810_init_rbac
 * @noinspection PhpUnused
 */

class m230305_142810_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * @throws Exception
     */
    public function up()
    {
        $auth = Yii::$app->authManager;

        $viewCpanel = $auth->createPermission('viewCpanel');
        $viewCpanel->description = 'Доступ к админ панели';
        $auth->add($viewCpanel);

        $viewCrm = $auth->createPermission('viewCrm');
        $viewCrm->description = 'Доступ к CRM';
        $auth->add($viewCrm);

        $map = $auth->createRole('map');
        $map->description = 'Менеджер активных продаж';
        $auth->add($map);
        $auth->addChild($map, $viewCrm);

        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $auth->add($admin);
        $auth->addChild($admin, $map);
        $auth->addChild($admin, $viewCpanel);

        $auth->assign($admin, 1);
        $auth->assign($map, 2);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230305_142810_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230305_142810_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
