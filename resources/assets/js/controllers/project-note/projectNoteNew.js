angular.module('app.controllers')
.controller('ProjectNoteNewController', [
	'$scope', '$location', '$routeParams', 'ProjectNote', 
	function($scope, $location, $routeParams, ProjectNote){
	$scope.projectNote = new ProjectNote;
	$scope.idProject = $routeParams.id;
	$scope.projectNote.project_id = $routeParams.id;

	$scope.save = function(){
				console.log($scope.projectNote);
		if ($scope.formProjectNote.$valid) {
			$scope.projectNote.$save({id: $routeParams.id}).then(function(data){
				//console.log(data);
				$location.path('/project/'+$routeParams.id+'/notes');
			});
		}else{
			alert('Preencha os campos corretamente!')
		};
	}
}]);