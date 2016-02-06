(function() {
  'use strict';

  var controllers = angular.module('myApp.controllers', [
    'ngRoute',
    'ngResource'
  ]);

  controllers.factory("Article", function($resource) {
    return $resource("index.php/api/articles/:id",
      null,
      {
          'update': { method:'PUT' }
      });
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
      Article.query(function(data) {
        $scope.articles = data;
      });
  }]);

  controllers.controller('ArticleCtrl',
    ['$scope', '$rootScope', '$routeParams', '$cookies', '$window', '$http', 'Article',
    function($scope, $rootScope, $routeParams, $cookies, $window, $http, Article) {
      $scope.error = false;

      // Get auth from cookies if need
      if (!$rootScope.accessToken) {
        $rootScope.accessToken = $cookies.get('accessToken');
      }

      // Auth
      $http.defaults.headers.common['Authorization'] = 'Bearer ' + $rootScope.accessToken;

      // Set view action
      $scope['action_' + $routeParams.action] = true;

      // If it is exists article
      if ($routeParams.id) {
        $scope.article = Article.get({ id: $routeParams.id });
      } else {
        $scope.article = new Article();
      }

      // Create || Update
      $scope.submit = function() {
        var action = Article.save;

        // Update if need
        if ($routeParams.action == "edit") {
          action = Article.update.bind(Article, { id: $routeParams.id });
        }

        action($scope.article, function(data) {
          if (data.error) {
            $scope.error = data.error;
            return;
          }

          $scope.error = false;

          if ($routeParams.action == "edit") {
            $window.location.href = '#/article/view/' + $routeParams.id;
            return;
          }

          $window.location.href = '#/';
        });
      };

      // Delete
      $scope.delete = function() {
        Article.delete({ id: $routeParams.id }, function(result) {
          if (!result.error) {
            $window.location.href = '#/';
            return;
          }

          $scope.error = result.error;
        });
      };
  }]);

})();