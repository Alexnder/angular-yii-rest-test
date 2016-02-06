(function() {
  'use strict';

  var app = angular.module('myApp', [
    'ngRoute',
    'ngResource',
    'ngCookies',
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
      when('/article-create', {
        templateUrl: '/public_html/partials/article_create.html',
        controller: 'ArticleCreateCtrl'
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
