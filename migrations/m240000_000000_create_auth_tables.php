<?php

use yii\db\Migration;

class m240000_000000_create_auth_tables extends Migration
{
    public function up()
    {
        // Tabla de usuarios
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'verification_token' => $this->string()->defaultValue(null),
        ]);

        // Tabla de roles
        $this->createTable('{{%auth_item}}', [
            'name' => $this->string(64)->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY ([[name]])',
        ]);

        // Tabla de asignación de roles
        $this->createTable('{{%auth_assignment}}', [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(),
            'created_at' => $this->integer(),
            'PRIMARY KEY ([[item_name]], [[user_id]])',
        ]);

        // Tabla de reglas
        $this->createTable('{{%auth_rule}}', [
            'name' => $this->string(64)->notNull(),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY ([[name]])',
        ]);

        // Índices
        $this->createIndex('idx-auth_item-type', '{{%auth_item}}', 'type');
        $this->createIndex('idx-auth_assignment-user_id', '{{%auth_assignment}}', 'user_id');

        // Claves foráneas
        $this->addForeignKey('fk-auth_item-rule_name', '{{%auth_item}}', 'rule_name', '{{%auth_rule}}', 'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-auth_assignment-item_name', '{{%auth_assignment}}', 'item_name', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE');

        // Insertar roles básicos
        $this->insert('{{%auth_item}}', [
            'name' => 'admin',
            'type' => 1,
            'description' => 'Administrador del sistema',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%auth_item}}', [
            'name' => 'technician',
            'type' => 1,
            'description' => 'Técnico del sistema',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        // Insertar usuario admin
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('admin123'),
            'email' => 'admin@example.com',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        // Asignar rol admin al usuario admin
        $this->insert('{{%auth_assignment}}', [
            'item_name' => 'admin',
            'user_id' => '1',
            'created_at' => time(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%auth_assignment}}');
        $this->dropTable('{{%auth_item}}');
        $this->dropTable('{{%auth_rule}}');
        $this->dropTable('{{%user}}');
    }
} 