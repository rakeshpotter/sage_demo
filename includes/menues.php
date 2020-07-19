<?php
$pages = [
    'Students' => './students.php',
    'Courses' => './courses.php',
    'Report' => './report.php'
];
$page_path = explode('/', $_SERVER['PHP_SELF']);
$page = $page_path[count($page_path) - 1];
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="./index.php">Sage Demo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
            <ul class="navbar-nav mr-auto">
                <?php
                foreach ($pages as $name => $path) {
                    $active = ($path == './' . $page) ? 'active' : '';
                    ?>
                    <li class="nav-item <?= $active ?>">
                        <a class="nav-link" href="<?= $path ?>"><?= $name ?></a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>