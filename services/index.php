<?php

$controllers = ['student', 'course', 'subscription'];

$ctrl = isset($_GET['c']) ? $_GET['c'] : '';
$action = isset($_GET['a']) ? $_GET['a'] : '';

$output = ['status' => 1];

if (!in_array($ctrl, $controllers))
    exit(json_encode(['status' => 0, 'errors' => ["Invalid Controller: $ctrl"]]));


$ctrlFile = __DIR__ . "/controllers/" . ucfirst($ctrl) . ".controller.class.php";
if (!file_exists($ctrlFile)) {
    exit(json_encode(['status' => 0, 'errors' => ["Controller file does not exist."]]));
} else {
    require_once $ctrlFile;
    $className = ucfirst($ctrl) . "Controller";
    $ctrlObj = new $className();
    if (empty($action) || !method_exists($ctrlObj, $action) || substr($action, 0, 2) == '__') {
        exit(json_encode(['status' => 0, 'errors' => ["Invalid Action: $action"]]));
    } else {
        $r = new ReflectionMethod($ctrlObj, $action);
        if (!$r->isPublic()) {
            exit(json_encode(['status' => 0, 'errors' => ["Invalid Action: $action"]]));
        } else {
            try {
                $ctrlObj->{$action}();
            } catch (Exception $e) {
                exit(json_encode(['status' => 0, 'errors' => [$e->getMessage()]]));
            }
        }
    }
}