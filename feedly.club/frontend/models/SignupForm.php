<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use common\models\Editor;
use yii;
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $name;
    public $lastname;
    public $re_password;
    public $avatar;
    public $user_id;
    public $date_register;
    public $avatar_img;
    public $type_member;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['user_id', 'integer'],

            ['date_register', 'required'],
            ['date_register', 'safe'],

            ['name', 'string'],
            ['name', 'required'],

            ['lastname', 'string'],
            ['lastname', 'required'],

            ['avatar', 'string'],

            [['avatar_img'], 'file', 'skipOnEmpty' => true, 'on' => 'create', 'extensions' => 'jpg,png,gif'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['email', function ($attribute, $params) {
                if (!filter_var($this->$attribute, FILTER_VALIDATE_EMAIL)) {
                  $this->addError($attribute, 'The email format is invalid!');
                }
            }],

            ['re_password', 'integer'],
            ['re_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['type_member','string'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $gettype  = Yii::$app->request->get('type_member');
        $user = new User();
        $editor = new Editor();
        $getid = User::find('id')->orderBy(['id' => 'SORT_ASC'])->count();
        $getid = $getid + 1;
        //$editor->$date_register = $

        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->type_member = $gettype;
        $editor->name = $this->name;
        $editor->user_id = $getid;
        $editor->date_register = $this->date_register;
        $editor->lastname = $this->lastname;
        $editor->avatar = $this->avatar;

        return $user->save() && $editor->save();
    }
}
