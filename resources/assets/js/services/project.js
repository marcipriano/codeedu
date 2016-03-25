angular.module('app.services')
.service('Project', [
	'$resource', '$filter', 'appConfig', '$httpParamSerializer',
	function($resource, $filter, appConfig, $httpParamSerializer){
		function transformData(data){
			if (angular.isObject(data) && data.hasOwnProperty('due_date')) {
				var o = angular.copy(data);
					data.due_date = $filter('date')(data.due_date, 'yyyy-MM-dd');
					//o.due_date = new Date(o.due_date);
					return appConfig.utils.transformRequest(o);
				};

				return data;
		}
	return $resource(appConfig.baseUrl + '/project/:id', {id: '@id'},{
		save: {
			method: 'POST',
			transformRequest: transformData
		},
		update: {
			method: 'PUT',
			transformRequest: transformData
		},
		get: {
			method: 'GET',
			transformResponse: function(data, headers){
				var o = appConfig.utils.transformResponse(data, headers);
				if (angular.isObject(o) && o.hasOwnProperty('due_date')) {
					var arrayDate = o.due_date.split('-'),
						month = parseInt(arrayDate[1])-1;
					o.due_date = new Date(arrayDate[0], month, arrayDate[2]);
				};
				
				if (angular.isObject(o) && o.hasOwnProperty('progress')) {
					o.progress = parseInt(o.progress);
				};
				
				if (angular.isObject(o) && o.hasOwnProperty('status')) {
					o.status = parseInt(o.status);
				};

				return o;
			}
		}
	});
}]);