<?php
namespace umbalaconmeogia\yii2api\migrations;

use batsg\migrations\BaseMigrationCreateTable;

class m130524_201442_create_sub_system_user_table extends BaseMigrationCreateTable
{
    protected $table = 'sub_system_user';

    public function createDbTable()
    {
        $this->createTableWithExtraFields($this->table, [
            'id' => $this->bigInteger()->notNull()->unique(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
        ]);
        $this->addPrimaryKey("{$this->table}_pkey", $this->table, 'id');
        $this->createIndexes($this->table, [
            'id',
        ]);
    }
}
