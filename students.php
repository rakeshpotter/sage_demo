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
                <li class="breadcrumb-item active">Students</li>
            </ol>
        </nav>
        <div class="container">
            <main role="main">
                <button class="btn btn-primary mb-3" data-toggle="modal" ng-click="openNewRegistration()">New Registration</button>
                <div class="table-responsive" style="min-height: 400px;">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th></th>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>DOB</th>
                                <th>Contact</th>
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
                                    </button></td>
                                <td ng-cloak>{{row.id}}</td>
                                <td ng-cloak>{{row.first_name}}</td>
                                <td ng-cloak>{{row.last_name}}</td>
                                <td ng-cloak>{{row.dob}}</td>
                                <td ng-cloak>{{row.contact}}</td>
                                <td class="text-right" ng-cloak>
                                    <button class="btn btn-outline-success btn-sm font-weight-bold" 
                                            ng-click="subscriptions.openModel(i)"
                                            ng-disabled="row.deleted">Subscribe</button>
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
        <div class="modal fade" id="editModal" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">{{student.id?'Edit':'New'}} Student Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="first-name" class="col-form-label col-md-4">First Name:</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="first-name" ng-model="student.first_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last-name" class="col-form-label col-md-4">Last Name:</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="last-name" ng-model="student.last_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dob" class="col-form-label col-md-4">Date Of Birth:</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="dob" ng-model="student.dob">
                                <small class="text-muted">YYYY-MM-DD</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="contact" class="col-form-label col-md-4">Contact:</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="contact" ng-model="student.contact">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" ng-click="saveModelData()">Save {{student.id?'Changes':'New'}}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription Modal -->
        <div class="modal fade" id="subscriptionModal" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">Student Course Registration</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="first-name" class="col-form-label col-md-4">Student Name:</label>
                            <div class="col-md-8">
                                <strong>{{subscriptions.student.first_name}} {{subscriptions.student.last_name}}</strong>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <h5 class="modal-title" id="exampleModalLabel">Subscriptions</h5>
                                <hr>
                                <div style="min-height: 200px;">
                                    <table class="table table-striped table-sm">
                                        <tr ng-repeat="(i,sub) in subscriptions.list">
                                            <td class="pl-3">
                                                <span class="badge badge-primary mr-2">{{(i + 1)}}</span>
                                                {{sub.course_name}}
                                                <button type="button" class="close text-danger" ng-click="subscriptions.confirmUnsub(i)">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr ng-if="subscriptions.list.length == 0">
                                            <td>Not Subscribed</td>
                                        </tr>
                                    </table>
                                </div>                                
                            </div>
                            <div class="col-md-6">
                                <h5 class="modal-title" id="exampleModalLabel">Select courses to subscribe</h5>
                                <hr>
                                <select ng-model="subscriptions.course" 
                                        class="form-control" ng-change="subscriptions.courseSelected()">
                                    <option ng-repeat="course in subscriptions.getCourseList()" ng-value="course">
                                        {{course.name}}
                                    </option>
                                </select>
                                <table class="table table-striped table-sm">
                                    <tr ng-repeat="(i,course) in subscriptions.newList">
                                        <td class="pl-3">
                                            <span class="badge badge-primary mr-2">{{(i + 1)}}</span>
                                            {{course.name}} 
                                            <span class="badge badge-success" 
                                                  ng-if="subscriptions.isSubscribed(i)">Subscribed</span>
                                            <button type="button" class="close text-danger" ng-click="subscriptions.removeNewCourse(i)">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" ng-click="subscriptions.save()">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirm Modal -->
        <div class="modal fade" id="confirmModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Student Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure to delete 
                        <strong>{{student.first_name}} {{student.last_name}}</strong> student?
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" ng-click="deleteStudent()">Yes Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Un-Subscription Confirm Modal -->
        <div class="modal fade" id="confirmUnSubModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Un-Subscription</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure to un-subscribe from 
                        <strong>{{subscriptions.list[subscriptions.selectedIndex].course_name}}</strong> course?
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" ng-click="subscriptions.unsubscribe()">Yes Un-Subscribe</button>
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
        <script src="./static/js_custom/students.js" type="text/javascript"></script>
    </body>
</html>
