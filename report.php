<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Sage Demo</title>
        <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/navbars/">
        <!-- Bootstrap core CSS -->
        <link href="./static/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="./static/css/style.css" rel="stylesheet" type="text/css"/>
    </head>

    <body ng-app="app" ng-controller="ctrl">

        <?php include_once './includes/menues.php'; ?>
        <nav class="bg-light">
            <ol class="breadcrumb container bg-light">
                <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                <li class="breadcrumb-item active">Report</li>
            </ol>
        </nav>
        <div class="container">
            <main role="main">
                <h2 class="mb-4 text-center">Student-Course registration report</h2>
                <div class="table-responsive" style="min-height: 400px;">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Student Name</th>
                                <th>Course Name</th>
                                <th class="text-right">Subscription Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="(i, row) in list" ng-class="{deleted: row.deleted}" ng-cloak>
                                <td ng-cloak class="text-center">{{(i + 1)}}</td>
                                <td ng-cloak>{{row.student_name}}</td>
                                <td ng-cloak>{{row.course_name}}</td>
                                <td ng-cloak class="text-right">{{row.sub_date}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <ul class="pagination justify-content-end">
                    <li class="page-item" ng-class="{'disabled':current_page - 1 < 1}" 
                        ng-click="getPageList(current_page - 1)">
                        <a class="page-link" href="javascript:;">Previous</a>
                    </li>
                    <li class="page-item" ng-repeat="n in getPageNumbers()"  ng-cloak
                        ng-class="{'active':n == current_page}" ng-click="getPageList(n)">
                        <a class="page-link" href="javascript:;">{{n}}</a>
                    </li>
                    <li class="page-item" ng-class="{'disabled':current_page == total_page}" 
                        ng-click="getPageList(current_page + 1)">
                        <a class="page-link" href="javascript:;">Next</a>
                    </li>
                </ul>
            </main>
        </div>


        <!--Toast-->
        <div style="position: absolute;top: 50px; right: 0;z-index: 9999;" id="toastPlaceHolder">

        </div>


        <?php
        include_once './includes/footer.php';
        ?>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="./static/js/jquery-3.4.1.slim.min.js" type="text/javascript"></script>
        <script src="./static/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="./static/bootstrap/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        <script src="./static/js/angular.min.js" type="text/javascript"></script>
        <script src="./static/js_custom/common.js" type="text/javascript"></script>
        <script src="./static/js_custom/report.js" type="text/javascript"></script>
    </body>
</html>
