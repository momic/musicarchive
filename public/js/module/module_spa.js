var app = angular.module("singlePageApp", 
                        ['ngRoute', 'ngAnimate', 'ngTouch', 'ui.bootstrap', 'ngFileUpload']);

app.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider.
                when('/artists/create', {
                    templateUrl: 'templates/insert_songs.html',
                    controller: 'insertMusicController'
                })
                .when('/artists/:artistId', {
                    templateUrl: 'templates/artist_details.html',
                    controller: 'detailsMusicController'
                }).when('/artists', {
                    templateUrl: 'templates/artist_list_with_albums.html',
                    controller: 'listOfRecordsMusicController'
                })
                .otherwise({
                    redirectTo: '/artists'
                });
    }
]);

app.controller("insertMusicController", function ($scope, $http, Upload, $location, $log) {
    $scope.addMusicRecord = function () {
        Upload.upload({
          url: 'api/artists',
          method: 'POST',
          file: $scope.artistFile,
          sendFieldsAs: 'form',
          data: $scope.music_record
        });

        $location.path('/artists');
    };
});

app.controller("listOfRecordsMusicController", function ($scope, $http, $log, $route) {
    $scope.deleteArtist = function (id) {
        $http({
           method: "DELETE",
           url: "api/artists/" + id
        }).then(function successCallback(response) {
            $route.reload();
        }, function errorCallback(response) {
            $log.log('Error deleting artist');
        });
    };

    $scope.pageChanged = function() {
        $log.log('Page changed to: ' + $scope.currentPage);

        $http({
           method: "GET",
           url: "api/artists?page=" + $scope.currentPage
        }).then(function successCallback(response) {            
            $scope.totalItems = response.data.total;
            $scope.itemsPerPage = response.data.per_page;
            $scope.currentPage = response.data.current_page;

            $scope.musicArray = response.data.data;
            $scope.numberOfMusicRecords = $scope.musicArray.length;
        }, function errorCallback(response) {
            $log.log('Error fetching data for page: ' + $scope.currentPage);
        });

    };

    $scope.currentPage = 1;
    $scope.pageChanged();
});

app.controller("detailsMusicController", function ($scope, $routeParams, $http) {
    $http({
       method: "GET",
       url: "api/artists/" + $routeParams.artistId
    }).then(function successCallback(response) {
        $scope.artistDetails = response.data.data;
    }, function errorCallback(response) {
       console.log("Error");
    });    
});

app.directive("musicHeader", function () {
    return {
        restrict: "E",
        template: "<h1 style='color: white; background-color:#178AB0'>Music Archive</h1>"
    };
});

app.directive("musicFooter", function () {
    return {
        restrict: "E",
        template: "<h4 style='color: white; background-color:#178AB0'>General Public Licence (" + new Date().toJSON().slice(0, 10) + ")</h4>"
    };
});