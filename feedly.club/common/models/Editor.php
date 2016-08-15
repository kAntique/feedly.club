<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "editor".
 *
 * @property integer $id
 * @property string $name
 * @property string $lastname
 * @property string $avartar
 * @property string $date_register
 * @property integer $user_id
 *
 * @property User $user
 */
class Editor extends \yii\db\ActiveRecord
{
 public $avatar_img;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'editor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'lastname', 'avatar', 'user_id'], 'required'],
            [['date_register'], 'safe'],
            [['user_id'], 'integer'],
            [['name', 'lastname', 'avatar'], 'string', 'max' => 45],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['avatar_img'], 'file', 'skipOnEmpty' => true, 'on' => 'create', 'extensions' => 'jpg,png,gif'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'lastname' => 'Lastname',
            'avatar' => 'Avatar',
            'date_register' => 'Date Register',
            'user_id' => 'User ID',
            'avatar_img' => 'avatar_img',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
