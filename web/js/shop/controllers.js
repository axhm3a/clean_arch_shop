var app = angular.module('shopApp', []);

app.controller('ShopCtrl', function ($scope, $http) {
    $scope.updateBasket = function () {
        $http.get('basket.json').success(function (data) {
            $scope.basket = data;
        });
    };

    $scope.changeBasket = function (position) {
        $http.post('basket/change.json', position).success(function (data) {
            $scope.updateBasket();
        });
    };

    $scope.updateBasket();
});