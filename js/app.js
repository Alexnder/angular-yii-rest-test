(function() {
  'use strict';

  var app = angular.module('myApp', [
    'ngRoute',
    'ngResource',
    'ngCookies',
    'angular-confirm',
    'myApp.controllers'
  ]);

  app.config(['$routeProvider', function($routeProvider) {
    $routeProvider.
      when('/', {
        templateUrl: '/public_html/partials/articles.html',
        controller: 'ArticlesCtrl'
      }).
      when('/login', {
        templateUrl: '/public_html/partials/login.html',
        controller: 'LoginCtrl'
      }).
      when('/register', {
        templateUrl: '/public_html/partials/register.html',
        controller: 'RegisterCtrl'
      }).
      when('/article/:action', {
        templateUrl: '/public_html/partials/article.html',
        controller: 'ArticleCtrl'
      }).
      when('/article/:action/:id', {
        templateUrl: '/public_html/partials/article.html',
        controller: 'ArticleCtrl'
      }).
      otherwise({
        redirectTo: '/login'
      });
  }]);

})();
