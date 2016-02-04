<?php

class UserController extends CController
{
  public function actionIndex()
  {
      $headers = apache_request_headers();
      $auth = $headers['Authorization'];
      if (!isset($headers['Authorization'])) {
          $this->renderJSONErorr("Authorization is required");
      }

      $access_token = explode(' ', $auth);
      $access_token = end($access_token);

      $token = Token::model()->find('token=:token', array(':token'=>$access_token));
      if (!$token) {
          $this->renderJSONErorr("Bad access_token");
      }

      $user = User::model()->find('id=:id', array(':id'=>$token->user));

      $this->renderJSON(["id"=>$user->id, "username"=>$user->username]);
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
          if ($token->save()) {
              $this->renderJSON([
                  "access_token" => $token->token,
                  "token_type" => "bearer",
              ]);
          }
          $this->renderJSONErorr("Internal error");
      }
      else
      {
          $this->renderJSONErorr($identity->errorMessage);
      }
  }

  public function actionRegister()
  {
      $username = $_POST['username'];
      $password = $_POST['password'];

      if (strlen($password) < 6)
      {
          $this->renderJSONErorr("Password must be at least 6 symbols");
      }

      // Check user
      $user = User::model()->find('username=:username', array(':username'=>$username));
      if ($user) {
          $this->renderJSONErorr("Username occupated");
      }

      // Create new user
      $model = new User;
      $model->username = $username;
      $model->password = CPasswordHelper::hashPassword($password);
      if ($model->save()) {
          $this->renderJSON($model);
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

      $this->renderJSONErorr(implode("\n", $errors));
  }

  protected function renderJSONErorr($data)
  {
      $this->renderJSON(["error"=>$data]);
  }

  protected function renderJSON($data)
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