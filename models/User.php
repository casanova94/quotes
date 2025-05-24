<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public $password;
    public $role;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['username', 'email'], 'unique'],
            [['status'], 'default', 'value' => self::STATUS_INACTIVE],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['password'], 'required', 'on' => self::SCENARIO_CREATE],
            [['password'], 'string', 'min' => 6],
            [['role'], 'string'],
            [['email'], 'email'],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['username', 'email', 'password', 'role', 'status'],
            self::SCENARIO_UPDATE => ['username', 'email', 'password', 'role', 'status'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Usuario',
            'email' => 'Correo electrónico',
            'password' => 'Contraseña',
            'status' => 'Estado',
            'role' => 'Rol',
            'created_at' => 'Fecha de creación',
            'updated_at' => 'Fecha de actualización',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->generateAuthKey();
            }
            if ($this->password) {
                $this->setPassword($this->password);
            }
            return true;
        }
        return false;
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function getTechnician()
    {
        return $this->hasOne(Technicians::class, ['user_id' => 'id']);
    }

    public function isAdmin()
    {
        return Yii::$app->authManager->checkAccess($this->id, 'admin');
    }

    public function isTechnician()
    {
        return Yii::$app->authManager->checkAccess($this->id, 'technician');
    }

    public function getRole()
    {
        $roles = Yii::$app->authManager->getRolesByUser($this->id);
        if (!empty($roles)) {
            return array_key_first($roles);
        }
        return null;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }
}
