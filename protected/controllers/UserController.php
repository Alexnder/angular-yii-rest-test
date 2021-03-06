<?php

class UserController extends CController
{
    public function actionIndex()
    {
        $user = Helper::getUser();

        Helper::renderJSON(["id"=>$user->id, "username"=>$user->username]);
    }

    public function actionLogin()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $identity = new UserIdentity($username, $password);

        if (!$identity->authenticate())
        {
            Helper::renderJSONErorr("Wrong username or password");
        }

        $token = new Token;
        $token->user = $identity->getId();
        $token->token = Yii::app()->getSecurityManager()->generateRandomString(64);
        if ($token->save())
        {
            Helper::renderJSON([
                "access_token" => $token->token,
                "token_type" => "bearer",
            ]);
        }

        Helper::renderJSONErorr("Internal error");
    }

    public function actionRegister()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (strlen($username) < 3)
        {
            Helper::renderJSONErorr("Username must be at least 3 symbols: $username [".strlen($username)."]");
        }

        if (strlen($password) < 5)
        {
            Helper::renderJSONErorr("Password must be at least 5 symbols");
        }

        // Check user
        $user = User::model()->find('username=:username', array(':username'=>$username));
        if ($user)
        {
            Helper::renderJSONErorr("Username occupated");
        }

        // Create new user
        $model = new User;
        $model->username = $username;
        $model->password = CPasswordHelper::hashPassword($password);
        if ($model->save())
        {
            Helper::renderJSON($model);
        }

        // Catch errors
        $errors = [];
        foreach($model->errors as $attribute=>$attr_errors)
        {
            foreach($attr_errors as $attr_error)
            {
                $errors[] = "Attribute $attribute: $attr_error";
            }
        }

        Helper::renderJSONErorr(implode("\n", $errors));
    }
}