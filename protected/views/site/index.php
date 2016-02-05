<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="container">
  <div class="row row-content" ng-controller="menuController as menuCtrl">
    <div class="col-xs-12">
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" ng-class="{active:menuCtrl.isSelected(1)}">
          <a ng-click="menuCtrl.select(1)"
            aria-controls="all menu"
          role="tab">
            The Menu
          </a>
        </li>
        <li role="presentation" ng-class="{active:menuCtrl.isSelected(2)}">
          <a ng-click="menuCtrl.select(2)"
            aria-controls="appetizers"
          role="tab">
            Appetizers
          </a>
        </li>
        <li role="presentation" ng-class="{active:menuCtrl.isSelected(3)}">
          <a ng-click="menuCtrl.select(3)"
            aria-controls="mains"
          role="tab">
            Mains
          </a>
        </li>
        <li role="presentation" ng-class="{active:menuCtrl.isSelected(4)}">
          <a ng-click="menuCtrl.select(4)"
            aria-controls="desserts"
          role="tab">
            Desserts
          </a>
        </li>
      </ul>
      <div class="tab-content">
       <ul class="media-list tab-pane fade in active">
        <li class="media" ng-repeat="dish in menuCtrl.dishes | filter:menuCtrl.filtText">
          <div class="media-left media-middle">
            <a href="#">
              <img class="media-object img-thumbnail"
              ng-src={{dish.image}} alt="Uthappizza">
            </a>
          </div>
          <div class="media-body">
            <h2 class="media-heading">{{dish.name}}
             <span class="label label-danger">{{dish.label}}</span>
             <span class="badge">{{dish.price | currency}}</span></h2>
             <p>{{dish.description}}</p>
           </div>
         </li>
       </ul>
     </div>
   </div>
  </div>
</div>
