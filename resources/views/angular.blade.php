<!DOCTYPE html>
<html>
    <head>
        <title>Music Archive</title>
        <meta charset="UTF-8">
        <script src="js/libs/angular.js/angular.min.js" type="text/javascript"></script> 
        <script src="js/libs/angular.js/angular-route.min.js" type="text/javascript"></script>
        <script src="js/libs/angular.js/angular-animate.min.js" type="text/javascript"></script>
        <script src="js/libs/angular.js/angular-touch.min.js" type="text/javascript"></script>
        <script src="js/libs/angular.js/ui-bootstrap-tpls.min.js" type="text/javascript"></script>
        <script src="js/libs/angular.js/ng-file-upload-shim.js"></script>
        <script src="js/libs/angular.js/ng-file-upload.js"></script>
        
        <script src="js/module/module_spa.js" type="text/javascript"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"/>
        <link rel="stylesheet" href="css/style.css"/>

    </head>
    <body ng-app="singlePageApp">
        <div class="col-lg-6 col-lg-offset-3 text-center">
            <music-Header></music-Header>
            <a href="#artists/create">Add new record</a> |
            <a href="#artists">List of records</a>
            <br/>
            <div ng-view></div>
            <music-Footer></music-Footer>
        </div>
    </body>
</html>