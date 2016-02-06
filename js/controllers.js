(function() {
  'use strict';

  var controllers = angular.module('myApp.controllers', [
    'ngRoute',
    'ngResource'
  ]);

  controllers.factory("Article", function($resource) {
    return $resource("index.php/api/articles/:id");
  });

  controllers.controller('LoginCtrl',
    ['$scope', '$rootScope', '$cookies', '$http', '$httpParamSerializerJQLike',
    function ($scope, $rootScope, $cookies, $http, $httpParamSerializerJQLike) {
      $scope.error = false;

      $scope.submit = function() {
        $http({
          url:'index.php/user/login',
          method: "POST",
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          data: $httpParamSerializerJQLike({
            username: $scope.username,
            password: $scope.password,
          })
        })
        .then(function(response) {
          var data = response.data;

          if (data.error) {
            $scope.error = data.error;
            return;
          }

          $rootScope.accessToken = data.access_token;

          $cookies.put('accessToken', data.access_token);

          $scope.success = true;
        });
      };
  }]);

  controllers.controller('RegisterCtrl',
    ['$scope', '$http', '$httpParamSerializerJQLike',
    function ($scope, $http, $httpParamSerializerJQLike) {
      $scope.error = false;

      $scope.submit = function() {
        $http({
          url:'index.php/user/register',
          method: "POST",
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          data: $httpParamSerializerJQLike({
            username: $scope.username,
            password: $scope.password,
          })
        })
        .then(function(response) {
          var data = response.data;

          if (data.error) {
            $scope.error = data.error;
            return;
          }
          $scope.error = data.result;

          $scope.success = true;
        });
      };
  }]);

  controllers.controller('ArticlesCtrl',
    ['$scope', '$routeParams', 'Article',
    function($scope, $routeParams, Article) {
      $scope.articleId = $routeParams.id;

      Article.query(function(data) {
        $scope.articles = data;
      });
  }]);

  controllers.controller('ArticleCreateCtrl',
    ['$scope', '$rootScope', '$cookies', '$http', 'Article',
    function($scope, $rootScope, $cookies, $http, Article) {
      $scope.error = false;

      if (!$rootScope.accessToken) {
        $rootScope.accessToken = $cookies.get('accessToken');
      }

      $http.defaults.headers.common['Authorization'] = 'Bearer ' + $rootScope.accessToken;

      $scope.article = new Article();

      $scope.submit = function() {
        console.log("article", $scope.article.title, $scope.article);

        Article.save($scope.article, function(data) {
          if (data.error) {
            $scope.error = data.error;
            return;
          }
          console.log(data);
        });
      };
      // Article.query(function(data) {
      //   $scope.articles = data;
      // });
  }]);

})();