<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\UploadedFile;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
          Yii::$app->session->setFlash('success', 'logout success.');
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSelect(){


    return $this->render('select');

        }

    /**
     * Signs user up.
     *
     * @return mixed
     */
     public function actionSignup()
    {
        $model = new SignupForm();
        //$user = new User();
        //$editor = new Editor();
        //$editor = $model->user_id;

        if ($model->load(Yii::$app->request->post())) {
          $file = \yii\web\UploadedFile::getInstance($model, 'avatar_img');
              $file = UploadedFile::getInstance($model,'avatar_img');
              $model->avatar = $file->name;
              $file->saveAs('uploads/avatar/'.$file->baseName . '.' . $file->extension);
               $model->avatar = 'uploads/avatar/'.$file->baseName . '.' . $file->extension;
               //$model->save();

            if($_POST['SignupForm']['password'] == $_POST['SignupForm']['re_password']){
              if ($user = $model->signup() && $editor = $model->signup()) {

                  if (Yii::$app->getUser()->login($user)) {

                      return $this->goHome();
                  }
              }
                  Yii::$app->session->setFlash('success', 'สมัครสมาชิกเรียบร้อยแล้ว login เพื่อเข้าสู้ระบบ');
                  return $this->render('welcome',[
                      'model' => $model,
                  ]);

            }else{
              Yii::$app->session->setFlash('error', 'รหัสผ่านไม่ตรงกัน!!! กรุณากรอกรหัสผ่านใหม่');
              return $this->render('signup',[
                'model' => $model,
              ]);
            }
        }

        return $this->render('signup', [
            'model' => $model,
            //'type' => $type,
            //'user' => $user,
            //'editor' => $editor,
        ]);
    }
    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
           if($_POST['ResetPasswordForm']['password'] == $_POST['ResetPasswordForm']['re_password']){
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }}

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}