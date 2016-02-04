<?php

class Helper
{
    public static function renderJSONErorr($data)
    {
        Helper::renderJSON(["error"=>$data]);
    }

    public static function renderJSON($data)
    {
        header('Content-type: application/json');
        echo CJSON::encode($data);

        foreach (Yii::app()->log->routes as $route)
        {
            if ($route instanceof CWebLogRoute)
            {
                $route->enabled = false; // disable any weblogroutes
            }
        }
        Yii::app()->end();
    }

    public static function getUser() {
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
        return $user;
    }
}