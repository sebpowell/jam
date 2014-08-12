app.controller("GlobalController", function($scope, $location) {
	console.log("lichi is now running");

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

app.controller("SassController", function($scope, $rootScope, $location){
	$rootScope.title = "SASS Library";
});