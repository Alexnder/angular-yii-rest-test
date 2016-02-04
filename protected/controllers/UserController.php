<?php

class UserController extends CController
{
    public function actionIndex()
    {
        $headers = apache_request_headers();
        if (!isset($headers['Authorization']))
        {
            Helper::renderJSONErorr("Authorization is required");
        }

        $auth = $headers['Authorization'];
        $access_token = explode(' ', $auth);
        $access_token = end($access_token);

        $token = Token::model()->find('token=:token', array(':token'=>$access_token));
        if (!$token)
        {
            Helper::renderJSONErorr("Bad access_token");
        }

        $user = User::model()->find('id=:id', array(':id'=>$token->user));

        Helper::renderJSON(["id"=>$user->id, "username"=>$user->username]);
    }

    public function actionLogin()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $identity = new UserIdentity($username, $password);

        if ($identity->authenticate())
        {
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
        else
        {
            Helper::renderJSONErorr($identity->errorMessage);
        }
    }

    public function actionRegister()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (strlen($password) < 6)
        {
            Helper::renderJSONErorr("Password must be at least 6 symbols");
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