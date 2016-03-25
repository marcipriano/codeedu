angular.module('app.controllers')
.controller('ProjectFileShowController', 
	['$scope', '$location', '$routeParams', 'ProjectFile', 
	function($scope, $location, $routeParams, ProjectFile){
	$scope.projectFile = ProjectFile.get({
		id: $routeParams.id, 
		idFile: $routeParams.idFile
	});
	$scope.idProject = $routeParams.id;
	
	$scope.remove = function(){
		$scope.projectFile.$delete({
			id: null,
			idFile: $scope.projectFile.id
		}).then(function(){
			$location.path('/project/'+ $scope.projectFile.project_id +'/files');
		});
	}
}]);