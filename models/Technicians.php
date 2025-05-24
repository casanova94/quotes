<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "technicians".
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string|null $email
 * @property int|null $user_id
 *
 * @property Quotations[] $quotations
 * @property User $user
 */
class Technicians extends \yii\db\ActiveRecord
{
    public $password;
    public $username;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_UPDATE_PASSWORD = 'update-password';
    const SCENARIO_RESET_PASSWORD = 'reset-password';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'technicians';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'email', 'user_id'], 'default', 'value' => null],
            [['name'], 'required'],
            [['name', 'email', 'username'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['user_id'], 'integer'],
            [['email'], 'email'],
            [['username'], 'unique', 'targetClass' => '\app\models\User', 'targetAttribute' => 'username', 'when' => function($model) {
                return $model->isNewRecord;
            }],
            [['email'], 'unique', 'targetClass' => '\app\models\User', 'targetAttribute' => 'email', 'when' => function($model) {
                return $model->isNewRecord;
            }],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['username', 'password'], 'required', 'on' => self::SCENARIO_CREATE],
            [['password'], 'required', 'on' => [self::SCENARIO_UPDATE_PASSWORD, self::SCENARIO_RESET_PASSWORD]],
            [['password'], 'string', 'min' => 6, 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE_PASSWORD, self::SCENARIO_RESET_PASSWORD]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['name', 'phone', 'email', 'username', 'password'],
            self::SCENARIO_UPDATE => ['name', 'phone', 'email', 'username'],
            self::SCENARIO_UPDATE_PASSWORD => ['password'],
            self::SCENARIO_RESET_PASSWORD => ['password'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'phone' => 'Teléfono',
            'email' => 'Correo Electrónico',
            'username' => 'Usuario',
            'password' => 'Contraseña',
            'user_id' => 'Usuario',
        ];
    }

    public function getServiceOrders()
    {
        return $this->hasMany(ServiceOrder::class, ['technician_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                // Crear nuevo usuario
                $user = new User();
                $user->scenario = User::SCENARIO_CREATE;
                $user->username = $this->username;
                $user->email = $this->email;
                $user->password = $this->password;
                $user->status = User::STATUS_ACTIVE;
                $user->role = 'technician';
                
                if ($user->save()) {
                    $this->user_id = $user->id;
                    
                    // Asignar rol de técnico
                    $auth = Yii::$app->authManager;
                    $role = $auth->getRole('technician');
                    $auth->assign($role, $user->id);
                    
                    return true;
                }
                return false;
            }
            return true;
        }
        return false;
    }

    public function updatePassword()
    {
        if ($this->validate()) {
            $user = $this->user;
            if ($user) {
                $user->scenario = User::SCENARIO_UPDATE;
                $user->password = $this->password;
                return $user->save();
            }
        }
        return false;
    }

    public function resetPassword()
    {
        if ($this->validate()) {
            $user = $this->user;
            if ($user) {
                $user->scenario = User::SCENARIO_UPDATE;
                $user->password = $this->password;
                return $user->save();
            }
        }
        return false;
    }

    public function afterDelete()
    {
        parent::afterDelete();
        if ($this->user) {
            $this->user->delete();
        }
    }
}
