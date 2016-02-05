<?php

class ApiController extends Controller
{
    public function filters()
    {
        return array();
    }

    public function actionList()
    {
        switch ($_GET['model'])
        {
            case 'articles':
                $models = Article::model()->findAll();
                break;
            case 'users':
                $models = User::model()->findAll();
                break;
            default:
                Helper::renderJSONErorr('list is not implemented for model '.$_GET['model']);
        }

        if (empty($models))
        {
            Helper::renderJSONErorr('No items where found for model '.$_GET['model']);
        }

        // Send results
        $rows = array();
        foreach($models as $model)
        {
            $rows[] = $model->attributes;
        }
        Helper::renderJSON($rows);
    }

    public function actionView()
    {
        if (!isset($_GET['id']))
        {
            Helper::renderJSONErorr('Error: Parameter id is missing');
        }

        switch ($_GET['model'])
        {
            case 'articles':
                $model = Article::model()->findByPk($_GET['id']);
                break;
            default:
                Helper::renderJSONErorr('get is not implemented for model ' . $_GET['model']);
        }

        if (is_null($model))
        {
            Helper::renderJSONErorr('No Item found with id '.$_GET['id']);
        }

        Helper::renderJSON($model);
    }

    public function actionCreate()
    {
        $author = $this->_checkAuth();

        switch($_GET['model'])
        {
            case 'articles':
                $model = new Article;
                break;
            default:
                Helper::renderJSONErorr('create is not implemented for model '.$_GET['model']);
        }

        foreach ($_POST as $var => $value) {
            if ($model->hasAttribute($var))
            {
                $model->$var = $value;
            }
            else
            {
                Helper::renderJSONErorr("Parameter $var is not allowed for model ".$_GET['model']);
            }
        }

        if ($model->hasAttribute('author'))
        {
            $model->author = $author->id;
        }

        // Try to save the model
        if ($model->save())
        {
            Helper::renderJSON($model);
        }

        $msg = sprintf("Couldn't create model %s\n", $_GET['model']);

        foreach ($model->errors as $attribute=>$attr_errors)
        {
            $msg .= "Attribute: $attribute\n";
            foreach ($attr_errors as $attr_error)
            {
                $msg .= "- $attr_error\n";
            }
        }
        Helper::renderJSONErorr($msg);
    }

    public function actionUpdate()
    {
        $author = $this->_checkAuth();

        $json = file_get_contents('php://input');
        $put_vars = CJSON::decode($json, true);

        switch ($_GET['model'])
        {
            case 'articles':
                $model = Article::model()->findByPk($_GET['id']);
                break;
            default:
                Helper::renderJSONErorr('update is not implemented for model '.$_GET['model']);
        }

        if (is_null($model))
        {
            Helper::renderJSONErorr('Error: Didn\'t find any model '.$_GET['model'].' with ID '.$_GET['id']);
        }

        // Try to assign PUT parameters to attributes
        foreach($put_vars as $var=>$value) {
            // Does model have this attribute? If not, raise an error
            if ($model->hasAttribute($var))
            {
                $model->$var = $value;
            }
            else
            {
                Helper::renderJSONErorr("Parameter $var is not allowed for model ".$_GET['model']);
            }
        }

        // TODO: check author

        if ($model->save())
        {
            Helper::renderJSON($model);
        }

        $msg = sprintf("Couldn't update model %s\n", $_GET['model']);

        foreach ($model->errors as $attribute=>$attr_errors)
        {
            $msg .= "Attribute: $attribute\n";
            foreach ($attr_errors as $attr_error)
            {
                $msg .= "- $attr_error\n";
            }
        }
        Helper::renderJSONErorr($msg);
    }

    public function actionDelete()
    {
        $author = $this->_checkAuth();

        switch ($_GET['model'])
        {
            case 'articles':
                $model = Article::model()->findByPk($_GET['id']);
                break;
            default:
                Helper::renderJSONErorr('delete is not implemented for model '.$_GET['model']);
        }

        if (is_null($model))
        {
            Helper::renderJSONErorr('Didn\'t find any model '.$_GET['model'].' with ID '.$_GET['id']);
        }

        // TODO: check author

        // Delete the model
        if ($model->delete())
        {
            Helper::renderJSON(true);
        }

        Helper::renderJSONErorr('Couldn\'t delete model '.$_GET['model'].' with ID '.$_GET['id']);
    }

    private function _checkAuth()
    {
        $user = Helper::getUser();
        if (!$user)
        {
            Helper::renderJSONErorr("Internal user error");
        }

        return $user;
    }
}