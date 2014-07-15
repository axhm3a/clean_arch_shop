var app = angular.module('shopApp', []);

app.controller('ShopCtrl', function ($scope, $http) {

    $scope.by = '';

    $scope.updateBasket = function () {
        $http.get('shop/basket.json').success(function (data) {
            $scope.basket = data;
        });
    };

    $scope.changeBasket = function (position) {
        $http.post('shop/basket/change.json', position).success(function (data) {
            $scope.updateBasket();
        });
    };

    $scope.searchArticles = function () {
        if ($scope.by == '') {
            $scope.articles = null;
            return;
        }

        $http.get('shop/search.json?by=' + $scope.by).success(function (data) {
            $scope.articles = data;
        })
    };

    $scope.updateBasket();

    $scope.getDeliveryAddresses = function () {
        $http.get('shop/deliveryaddress/list.json').success(function (data) {
            $scope.deliveryaddresses = data;
        });
    };

    $scope.selectDeliveryAddress = function (address) {
        $http.post('shop/deliveryaddress/select.json', address).success(function (data) {

        });
    };
});