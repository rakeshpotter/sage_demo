<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <title>Sage Demo</title>

        <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/navbars/">

        <!-- Bootstrap core CSS -->
        <link href="./static/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

    </head>

    <body>

        <?php include_once './includes/menues.php'; ?>

        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Home</li>
                </ol>
            </nav>
            <main role="main">
                <div class="jumbotron">
                    <div class="col-sm-8 mx-auto">
                        <h1>Students Course Registration</h1>
                        <h4>(Demo App)</h4>
                    </div>
                </div>
                <hr>
                <h3>Features</h3>
                <hr>
                <div class="row mb-5">
                    <div class="col-md-4">
                        <div class="media">
                            <img src="..." class="mr-3" alt="...">
                            <div class="media-body">
                                <h5 class="mt-0">Students</h5>
                                <div class="media mt-3">
                                    <a class="mr-3" href="#">
                                        <img src="..." class="mr-3" alt="...">
                                    </a>
                                    <div class="media-body">
                                        <h6 class="mt-0">List with pagination</h6>
                                    </div>
                                </div>
                                <div class="media mt-3">
                                    <a class="mr-3" href="#">
                                        <img src="..." class="mr-3" alt="...">
                                    </a>
                                    <div class="media-body">
                                        <h6 class="mt-0">Add</h6>
                                    </div>
                                </div>
                                <div class="media mt-3">
                                    <a class="mr-3" href="#">
                                        <img src="..." class="mr-3" alt="...">
                                    </a>
                                    <div class="media-body">
                                        <h6 class="mt-0">Update</h6>
                                    </div>
                                </div>
                                <div class="media mt-3">
                                    <a class="mr-3" href="#">
                                        <img src="..." class="mr-3" alt="...">
                                    </a>
                                    <div class="media-body">
                                        <h6 class="mt-0">Delete</h6>
                                    </div>
                                </div>
                                <div class="media mt-3">
                                    <a class="mr-3" href="#">
                                        <img src="..." class="mr-3" alt="...">
                                    </a>
                                    <div class="media-body">
                                        <h6 class="mt-0">Subscriptions</h6>
                                        <div class="media mt-3">
                                            <a class="mr-3" href="#">
                                                <img src="..." class="mr-3" alt="...">
                                            </a>
                                            <div class="media-body">
                                                <h6 class="mt-0">View Subscriptions</h6>
                                            </div>
                                        </div>
                                        <div class="media mt-3">
                                            <a class="mr-3" href="#">
                                                <img src="..." class="mr-3" alt="...">
                                            </a>
                                            <div class="media-body">
                                                <h6 class="mt-0">Add Subscriptions</h6>
                                            </div>
                                        </div>
                                        <div class="media mt-3">
                                            <a class="mr-3" href="#">
                                                <img src="..." class="mr-3" alt="...">
                                            </a>
                                            <div class="media-body">
                                                <h6 class="mt-0">Remove Subscriptions</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                    <div class="col-md-4 border-left">
                        <div class="media">
                            <img src="..." class="mr-3" alt="...">
                            <div class="media-body">
                                <h5 class="mt-0">Courses</h5>
                                <div class="media mt-3">
                                    <a class="mr-3" href="#">
                                        <img src="..." class="mr-3" alt="...">
                                    </a>
                                    <div class="media-body">
                                        <h6 class="mt-0">List with pagination</h6>
                                    </div>
                                </div>
                                <div class="media mt-3">
                                    <a class="mr-3" href="#">
                                        <img src="..." class="mr-3" alt="...">
                                    </a>
                                    <div class="media-body">
                                        <h6 class="mt-0">Add</h6>
                                    </div>
                                </div>
                                <div class="media mt-3">
                                    <a class="mr-3" href="#">
                                        <img src="..." class="mr-3" alt="...">
                                    </a>
                                    <div class="media-body">
                                        <h6 class="mt-0">Update</h6>
                                    </div>
                                </div>
                                <div class="media mt-3">
                                    <a class="mr-3" href="#">
                                        <img src="..." class="mr-3" alt="...">
                                    </a>
                                    <div class="media-body">
                                        <h6 class="mt-0">Delete</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 border-left">
                        <div class="media">
                            <img src="..." class="mr-3" alt="...">
                            <div class="media-body">
                                <h5 class="mt-0">Report</h5>
                                <div class="media mt-3">
                                    <a class="mr-3" href="#">
                                        <img src="..." class="mr-3" alt="...">
                                    </a>
                                    <div class="media-body">
                                        <h6 class="mt-0">List with pagination</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>


        <?php
        include_once './includes/footer.php';
        ?>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="static/js/jquery-3.4.1.slim.min.js" type="text/javascript"></script>
        <script src="static/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>
