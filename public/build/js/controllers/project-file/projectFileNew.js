angular.module('app.controllers')
.controller('ProjectFileNewController', [
	'$scope', '$location', '$routeParams', 'appConfig','Url', 'Upload',
	function($scope, $location, $routeParams, appConfig, Url, Upload){
	$scope.idProject = $routeParams.id;
	$scope.projectFile = {
		project_id: $routeParams.id
	};

$scope.save = function(){
		if ($scope.formProjectFile.$valid) {
				var url = appConfig.baseUrl + Url.getUrlFromUrlSymbol(appConfig.urls.projectFile, {
					id: $routeParams.id, 
					idFile: ''
				});

			Upload.upload({
	            url: url,
	            fields: {
	            	name: $scope.projectFile.name, 
	            	description: $scope.projectFile.description
	            },
	            file: $scope.projectFile.file
	        }).success(function (resp) {
				$location.path('/project/'+$routeParams.id+'/files');
	        });

		}else{
			alert('Preencha os campos corretamente!')
		};
	}
}]);