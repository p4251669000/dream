<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\Session;

use app\models\system\Druser;
use app\common\dmpublic\DmGeneral;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;
    public $verifyCode;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'verifyCode'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            // 第二个参数是session 存在时间 ,后台为了安全，不允许记忆,参数为0，关掉浏览器 session自动注销
            $result = Yii::$app->user->login($this->getUser(), 0);

            //如果用户存在，将用户相关信息记录到session 中
            if ($result) {
                $auth = Yii::$app->authManager;
                $userinfo = array();

                $session = new Session();
                $session->open();
                $user = $this->getUser();

                $userinfo['id'] = $user->id;
                $userinfo['name'] = $user->name;
                $userinfo['img'] = $user->img;
                $assig = $auth->getAssignments($user->id);

                foreach ($assig as $key => $val) {
                    $userinfo['rolename'] = $val->roleName;
                }
                //得到角色拥有的权限
                $userinfo['permission'] = $auth->getChildren($userinfo['rolename']);
                //得到角色拥有的菜单信息
                $general = new DmGeneral();
                $userinfo['rolemenu'] = $general->getMenuTreeHtml(0,$userinfo['rolename']);

                //信息存入session
                $session->set('userinfo', $userinfo);
            }
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Druser::findByUsername($this->username);
        }
        return $this->_user;
    }
}
