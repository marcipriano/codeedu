angular.module('app.directives')
.directive('projectFileDownload', 
['$timeout', 'appConfig', 'ProjectFile', function($timeout, appConfig, ProjectFile){
	return {
		restrict: 'E', 
		templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
		link: function(scope,element,attr) {
			scope.$on('salvar-arquivo', function(event, data){
				var anchor = element.children()[0];
				$(anchor).removeClass('disabled');
					// window.open('data:application-octet-stream;base64,'+data.file);
					$(anchor).attr({
						href: 'data:application-octet-stream;base64,'+data.file,
						download: data.name

					});
					$timeout(function(){
						scope.downloadFile = function(){
							
						};
						$(anchor)[0].click();
					});
			});
		},
		controller: ['$scope', '$element','$attrs', '$timeout',
		function($scope, $element, $attrs, $timeout) {
			$scope.downloadFile = function(){
				var anchor = $element.children()[0];
				$(anchor).addClass('disabled');
				ProjectFile.download({id: null, idFile: $attrs.idFile}, function(data){
					$scope.$emit('salvar-arquivo', data);
				});
			};
		}]
	};
}]);