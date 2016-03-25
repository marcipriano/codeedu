angular.module('app.controllers')
.controller('ProjectFileEditController', 
	['$scope', '$location', '$routeParams', 'ProjectFile', 
	function($scope, $location, $routeParams, ProjectFile){
	$scope.projectFile = ProjectFile.get({
		id: null,
		idFile: $routeParams.idFile

	});
	console.log($scope.projectFile);
	$scope.idProject = $routeParams.id;
	$scope.projectFile.project_id = $routeParams.id;

	$scope.save = function(){
		if ($scope.formProjectFile.$valid) {
			ProjectFile.update({
				id: $routeParams.idFile, 
				idFile: null}, $scope.projectFile, function(data){
				$location.path('/project/'+ $routeParams.id +'/files');
			});
	}else{
		alert('Preencha os campos corretamente!')
	};
	}
}]);