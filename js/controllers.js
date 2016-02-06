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
    ['$scope', '$http', '$httpParamSerializerJQLike',
    function ($scope, $http, $httpParamSerializerJQLike) {
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
          $scope.error = data.result;

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

})();