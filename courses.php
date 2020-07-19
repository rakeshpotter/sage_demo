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
                <li class="breadcrumb-item active">Courses</li>
            </ol>
        </nav>
        <div class="container">
            <main role="main">
                <button class="btn btn-primary mb-3" data-toggle="modal" ng-click="openNewRegistration()">New Course</button>
                <div class="table-responsive" style="min-height: 400px;">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th></th>
                                <th>#</th>
                                <th>Course Name</th>
                                <th>Course Details</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="(i, row) in list" ng-class="{deleted: row.deleted}" ng-cloak>
                                <td>
                                    <button class="btn btn-outline-info btn-sm font-weight-bold" 
                                            ng-click="openEditRegistration(i)"
                                            ng-disabled="row.deleted">
                                        Edit
                                    </button>
                                </td>
                                <td ng-cloak>{{row.id}}</td>
                                <td ng-cloak>{{row.name}}</td>
                                <td ng-cloak>{{row.details}}</td>
                                <td class="text-right" ng-cloak>
                                    <button class="btn btn-outline-danger btn-sm font-weight-bold" 
                                            ng-click="confirmRemove(i)"
                                            ng-disabled="row.deleted">Delete</button>
                                </td>
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
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">{{course.id?'Edit':'New'}} Course Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="course-name" class="col-form-label col-md-4">Course Name:</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="first-name" ng-model="course.name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="course-details" class="col-form-label col-md-4">Course Details:</label>
                            <div class="col-md-8">
                                <textarea type="text" class="form-control" id="last-name" ng-model="course.details">
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" ng-click="saveModelData()">Save {{course.id?'Changes':'New'}}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirm Modal -->
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Course Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure to delete 
                        <strong>{{course.name}}</strong> course?
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" ng-click="deleteCourse()">Yes Delete</button>
                    </div>
                </div>
            </div>
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
        <script src="./static/js_custom/courses.js" type="text/javascript"></script>
    </body>
</html>
