var app = angular.module("jamLondonApp", [
		"ngRoute",
	]).config(function($routeProvider, $locationProvider) {

		$routeProvider
			.when("/", {
				templateUrl: "views/home.html",
				controller: "HomeController"
			})
			.when("/ooops", {
				templateUrl: "views/ooops.html",
				controller: "OoopsController"
			})
			.when("/making", {
				templateUrl: "views/making.html",
				controller: "MakingController"
			})
			.otherwise({
				redirectTo: "/ooops"
			});

			$locationProvider.html5Mode(true);
	}).run(function($rootScope) {
		$rootScope.siteName = appConfig.siteName;
		$rootScope.siteLanguage = appConfig.siteLanguage;
		$rootScope.description = appConfig.description;
		$rootScope.keywords = appConfig.keywords;
		$rootScope.author = appConfig.author;
	});