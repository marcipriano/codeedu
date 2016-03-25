angular.module('app.controllers')
.controller('ProjectNoteRemoveController', 
	['$scope', '$location', '$routeParams', 'ProjectNote', 
	function($scope, $location, $routeParams, ProjectNote){
	$scope.projectNote = ProjectNote.get({id: $routeParams.id, idNote: $routeParams.idNote});

	$scope.remove = function(){
		$scope.projectNote.$delete({
			id: null,
			idNote: $scope.projectNote.id
		}).then(function(){
			$location.path('/project/'+ $scope.projectNote.project_id +'/notes');
		});
	}
}]);