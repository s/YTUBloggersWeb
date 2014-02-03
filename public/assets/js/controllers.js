var module = angular.module('SearchHub', [], function($interpolateProvider) {

	$interpolateProvider.startSymbol('<%');

	$interpolateProvider.endSymbol('%>');

})
.factory('SearchHubService', function () {
    return {
        show_tooltip: function () {
            return "Hello World";
        },
        hide_tooltip: function () {
        	return "123";
        }
    }
});


function IndexCntrl ($scope, $log) {

	$scope.$log = $log;	
}

function FormCntrl ( $scope, $http, $log, SearchHubService ){

	$scope.$log = $log;
	
	$scope.select_values = [
	    {id: 0, name: 'Repositories'},
	    {id: 1, name: 'Users'}
	];	
	
	$scope.submit = function(form) {
		
		select_value = angular.element('.search_form_select_box .dropdown-menu .selected').attr('rel');

		if( form.$valid && 0 != select_value){

			SearchHubService.hide_tooltip();

			angular.element('#ajax_result_loading').removeClass('hide');
			
			$http({
		        method  : 'POST',
		        url     : '/search',
		        data    : {q:$scope.search_form.q,type:$scope.search_form.type_select.$viewValue}
		    })
	        .success(function(data) {	            

	            if (!data.err) {
	            	angular.element('#ajax_result').html(data.html);
	            } else {
	            	
	            }
	            //angular.element('#ajax_result_loading').addClass('hide');
	        });
	    }else{
			//tooltip must be written
			SearchHubService.show_tooltip();

	    }
	}

	$scope.check_issues = function(){

	}
}