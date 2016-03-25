angular.module('app.controllers')
.controller('ProjectRemoveController', 
	['$scope', '$location', '$routeParams', 'Project', 
	function($scope, $location, $routeParams, Project){
	$scope.project = Project.get({id: $routeParams.id});
	$scope.removeSuccess = false;

	$scope.remove = function(){
		$scope.project.$delete({id: $routeParams.id}).then(function(data){
			if (data) {
				$scope.removeSuccess = true;
			};

			$location.path('/projects');
		});
	}
}]);