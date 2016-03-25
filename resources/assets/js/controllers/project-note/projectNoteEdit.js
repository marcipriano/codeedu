angular.module('app.controllers')
.controller('ProjectNoteEditController', 
	['$scope', '$location', '$routeParams', 'ProjectNote', 
	function($scope, $location, $routeParams, ProjectNote){
	$scope.projectNote = ProjectNote.get({
		id: $routeParams.id,
		idNote: $routeParams.idNote

	});
	$scope.idProject = $routeParams.id;
	//$scope.projectNote = $scope.projectNote.[0];
	$scope.projectNote.project_id = $routeParams.id;

	$scope.save = function(){
		if ($scope.formProjectNote.$valid) {
			ProjectNote.update({id: $scope.projectNote.id, idNote: $routeParams.idNote}, $scope.projectNote, function(){
				$location.path('/project/'+ $routeParams.id +'/notes');
			});
	}else{
		alert('Preencha os campos corretamente!')
	};
	}
}]);