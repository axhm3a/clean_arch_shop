var app = angular.module('shopApp', ['ui.bootstrap']);

app.controller('ShopCtrl', function ($scope, $http, $modal, $log) {

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

    $scope.getDeliveryAddresses = function (successCallback) {
        $http.get('shop/deliveryaddress/list.json').success(function (data) {
            $scope.deliveryaddresses = data;
        }).success(successCallback);
    };

    $scope.openDeliveryAddressBook = function (size) {
        $scope.getDeliveryAddresses(function () {
            $modal.open({
                templateUrl: 'deliveryAddressBook.html',
                controller: DeliveryAddressBook,
                size: size,
                resolve: {
                    deliveryaddresses: function () {
                        return $scope.deliveryaddresses;
                    }
                }
            });
        });
    };
});

var DeliveryAddressBook = function ($scope, $modalInstance, $http, $log, deliveryaddresses) {
    $scope.deliveryaddresses = deliveryaddresses;

    $scope.selectDeliveryAddress = function (address) {
        $http.post('shop/deliveryaddress/select.json', address).success(function (data) {
            $modalInstance.close();
        });
    };

    $scope.editDeliveryAddress = function (address) {
        $log.error('editDeliveryAddress not implemented yet');
    };

    $scope.deleteDeliveryAddress = function (address) {
        $log.error('deleteDeliveryAddress not implemented yet');
    };

    $scope.ok = function () {
        $modalInstance.close();
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};