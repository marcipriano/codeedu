
var app = angular.module('app', [
	'ngRoute', 'angular-oauth2','app.controllers', 'app.services', 'app.filters', 'app.directives',
	"ui.bootstrap.datepicker", "ui.bootstrap.typeahead", "ui.bootstrap.tpls", 'ngFileUpload'
	]);

angular.module('app.controllers', ['ngMessages', 'angular-oauth2']);
angular.module('app.filters', []);
angular.module('app.directives', []);
angular.module('app.services', ['ngResource']);

app.provider('appConfig', ['$httpParamSerializerProvider', function($httpParamSerializerProvider){
	var config = {
		baseUrl: 'http://code.app',
		project: {
			status: [
				{value: 1, label: 'Nao Iniciado'},
				{value: 2, label: 'Iniciado'},
				{value: 3, label: 'Concluido'}
			]
		},
		urls: {
			projectFile: '/project/{{id}}/file/{{idFile}}'
		},
		utils: {
			transformRequest: function(data){
				if (angular.isObject(data)) {
					return $httpParamSerializerProvider.$get()(data);
				};

				return data;

			},
			transformResponse: function(data, headers){
				var headersGetter = headers();

				//VERIFICA SE O RETORNO ´E UM JSON
				if (headersGetter['content-type'] == 'application/json' ||
					headersGetter['content-type'] == 'text/json') {
					var dataJson = JSON.parse(data);
					
					//VERIFICA SE EXISTE A PROPRIEDADE DATA
					if (dataJson.hasOwnProperty('data')) {
						dataJson = dataJson.data;
					};
						return dataJson;
				
				};
				
				return data;
			}
		}
	};

	return {
		config: config,
		$get: function(){
			return config;
		}
	}
}]);

app.config([
	'$routeProvider', '$httpProvider', 'OAuthProvider', 'OAuthTokenProvider', 'appConfigProvider',
	function($routeProvider, $httpProvider, OAuthProvider, OAuthTokenProvider, appConfigProvider){
	$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
	$httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded; charset=utf-8';
	$httpProvider.defaults.transformRequest = appConfigProvider.config.utils.transformRequest;
	$httpProvider.defaults.transformResponse = appConfigProvider.config.utils.transformResponse;
	$routeProvider
		.when('/login', {
			templateUrl: 'build/views/login.html',
			controller: 'LoginController'
		})
		.when('/home', {
			templateUrl: 'build/views/home.html',
			controller: 'HomeController'
		})
		.when('/clients', {
			templateUrl: 'build/views/client/list.html',
			controller: 'ClientListController'
		})
		.when('/clients/new', {
			templateUrl: 'build/views/client/new.html',
			controller: 'ClientNewController'
		})
		.when('/clients/:id', {
			templateUrl: 'build/views/client/show.html',
			controller: 'ClientShowController'
		})
		.when('/clients/:id/edit', {
			templateUrl: 'build/views/client/edit.html',
			controller: 'ClientEditController'
		})
		.when('/clients/:id/remove', {
			templateUrl: 'build/views/client/remove.html',
			controller: 'ClientRemoveController'
		})
		.when('/projects', {
			templateUrl: 'build/views/project/list.html',
			controller: 'ProjectListController'
		})
		.when('/projects/new', {
			templateUrl: 'build/views/project/new.html',
			controller: 'ProjectNewController'
		})
		.when('/projects/:id', {
			templateUrl: 'build/views/project/show.html',
			controller: 'ProjectShowController'
		})
		.when('/projects/:id/edit', {
			templateUrl: 'build/views/project/edit.html',
			controller: 'ProjectEditController'
		})
		.when('/projects/:id/remove', {
			templateUrl: 'build/views/project/remove.html',
			controller: 'ProjectRemoveController'
		})
		.when('/project/:id/notes', {
			templateUrl: 'build/views/project-note/list.html',
			controller: 'ProjectNoteListController'
		})
		.when('/project/:id/notes/new', {
			templateUrl: 'build/views/project-note/new.html',
			controller: 'ProjectNoteNewController'
		})
		.when('/project/:id/notes/:idNote', {
			templateUrl: 'build/views/project-note/show.html',
			controller: 'ProjectNoteShowController'
		})
		.when('/project/:id/notes/:idNote/edit', {
			templateUrl: 'build/views/project-note/edit.html',
			controller: 'ProjectNoteEditController'
		})
		.when('/project/:id/notes/:idNote/remove', {
			templateUrl: 'build/views/project-note/remove.html',
			controller: 'ProjectNoteRemoveController'
		})
		.when('/project/:id/files', {
			templateUrl: 'build/views/project-file/list.html',
			controller: 'ProjectFileListController'
		})
		.when('/project/:id/files/new', {
			templateUrl: 'build/views/project-file/new.html',
			controller: 'ProjectFileNewController'
		})
		.when('/project/:id/files/:idFile/edit', {
			templateUrl: 'build/views/project-file/edit.html',
			controller: 'ProjectFileEditController'
		})
		.when('/project/:id/files/:idFile/remove', {
			templateUrl: 'build/views/project-file/remove.html',
			controller: 'ProjectFileRemoveController'
		});

	OAuthProvider.configure({
		    baseUrl: appConfigProvider.config.baseUrl,
		    clientId: 'appid1',
		    clientSecret: 'secret', // optional
		    grantPath: 'oauth/access_token' // optional
		});

	OAuthTokenProvider.configure({
		    name: 'token',
		    options: {
		    	secure: false
		    }
		});
}]);

app.run(['$rootScope', '$location', '$window', 'OAuth', function($rootScope, $location, $window, OAuth) {
    
    $rootScope.$on('$routeChangeStart', function(event) {
		$rootScope.currentPage = $location.path();
    });

    $rootScope.$on('oauth:error', function(event, rejection) {
      // Ignore `invalid_grant` error - should be catched on `LoginController`.
      
      if ('invalid_grant' === rejection.data.error) {
        return;
      }

      // Refresh token when a `invalid_token` error occurs.
      if ('invalid_token' === rejection.data.error) {
        return OAuth.getRefreshToken();
      }

      // Redirect to `/login` with the `error_reason`.
      return $window.location.href = '/login?error_reason=' + rejection.data.error;
    });
  }]);