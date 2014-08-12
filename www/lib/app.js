var app = angular.module("litchiApp", [
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
			.when("/sass", {
				templateUrl: "views/sass.html",
				controller: "SassController"
			})
			.otherwise({
				redirectTo: "/ooops"
			});

			$locationProvider.html5Mode(true);
	});

app.run(function($rootScope) {
	$rootScope.siteName = appConfig.siteName;
	$rootScope.siteLanguage = appConfig.siteLanguage;
	$rootScope.description = appConfig.description;
	$rootScope.keywords = appConfig.keywords;
	$rootScope.author = appConfig.author;
});





/*
app.factory("myService", function($http){

return {
  getData : function(){
	return $http.get("/myData");
  }
}

});
app.controller("AboutCtrl", function($scope, $location){
  $scope.message = "Zoltan is great";
  console.log($location.path());

  myService.getData()
  .then(function(data){
	$scope.message = data;
  });
  var k = 8;


});

app.controller("OoopsCtrl", function(){});*/