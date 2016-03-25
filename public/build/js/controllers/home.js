angular.module('app.controllers')
.controller('HomeController', ['$scope', '$cookies', function($scope, $cookies){
	$scope.userLocal = $cookies.getObject('user');
	console.log($cookies.getObject('user').email);
}]);