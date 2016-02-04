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
}