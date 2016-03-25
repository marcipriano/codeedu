angular.module('app.controllers')
.controller('ProjectNewController', [
	'$scope', '$location', 'Project','Client', 'User', 'appConfig', 
	function($scope, $location, Project, Client, User, appConfig){
	$scope.project = new Project;
	$scope.users = User.query();
	$scope.status = appConfig.project.status;

	$scope.due_date = {
		status: {
			opened: false
		}
	};

	$scope.open = function($event){
		$scope.due_date.status.opened = true;
	}

	$scope.save = function(){
		if ($scope.formProject.$valid) {

		$scope.project.$save().then(function(data){
			$location.path('/projects/'+data.id);
		});
		}else{
			alert('Preencha os campos corretamente!')
		};
	};

	$scope.formatName = function(model) {
		if (model) {
			return model.name;
		};

		return '';
		
	};

	$scope.getClients = function (name) {
		return Client.query({
			search: name,
			searchFields: 'name:like'
		}).$promise;
	};

	$scope.selectClient = function(item) {
		$scope.project.client_id = item.id;	
	};
}]);