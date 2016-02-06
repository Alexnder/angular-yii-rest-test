(function() {
  'use strict';

  var app = angular.module('myApp', [
    'ngRoute',
    'ngResource',
    'myApp.controllers'
  ]);

  app.config(['$routeProvider', function($routeProvider) {
    $routeProvider.
      when('/login', {
        templateUrl: '/public_html/partials/login.html',
        controller: 'LoginCtrl'
      }).
      when('/register', {
        templateUrl: '/public_html/partials/register.html',
        controller: 'RegisterCtrl'
      }).
      when('/articles', {
        templateUrl: '/public_html/partials/articles.html',
        controller: 'ArticlesCtrl'
      }).
      when('/articles/:id', {
        templateUrl: '/public_html/partials/article.html',
        controller: 'ArticlesCtrl'
      }).
      otherwise({
        redirectTo: '/login'
      });
  }]);

})();
