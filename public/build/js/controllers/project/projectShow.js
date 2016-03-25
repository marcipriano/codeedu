angular.module('app.controllers')
.controller('ProjectShowController', 
	['$scope', '$location', '$routeParams', 'Project', 'appConfig', 
	function($scope, $location, $routeParams, Project, appConfig){
	Project.get({id: $routeParams.id}, function(data){
		if (data.hasOwnProperty('error')) {
				$location.path('/projects');
		};
		$scope.project = data;
	});
	$scope.status = appConfig.project.status;

	$scope.remove = function(){
		$scope.project.$delete({id: $routeParams.id}).then(function(){
			$location.path('/projects');
		});
	}
}]);