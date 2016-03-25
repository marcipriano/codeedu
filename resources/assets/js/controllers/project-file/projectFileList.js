angular.module('app.controllers')
.controller('ProjectFileListController', ['$scope', '$routeParams','ProjectFile', function($scope, $routeParams, ProjectFile){
	$scope.idProject = $routeParams.id;
	$scope.projectFiles = ProjectFile.query({id: $routeParams.id});
}]);