app.controller("GlobalController", function($scope, $location) {
	console.log("JAM London is now running");

	$scope.$watch(function(){
		return $location.path();
	}, assignClass);

	function assignClass() {
		var splitUrl = $location.url().split("/");
		$scope.path = splitUrl[1] == "" ? "home" : splitUrl[1];
	}
});

app.controller("HomeController", function($scope, $rootScope){
	$rootScope.title = "Home";
});

app.controller("OoopsController", function($scope, $rootScope){
	$rootScope.title = "Ooops";
});

app.controller("MakingController", function($scope, $rootScope, $location){
	$rootScope.title = "Making";
});