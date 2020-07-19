<?php

require_once dirname(__FILE__) . "/../models/Course.model.class.php";

class CourseController {

    private $course;
    private $errors;
    private $output;

    public function __construct() {
        $this->output = ['status' => 1];
        $this->errors = [];
        $this->course = new CourseModel($this->errors);
    }

    public function find() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $this->output['data'] = $this->course->getOne($id);
        $this->json();
    }

    public function getList() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if (!is_numeric($page))
            $page = 1;
        $this->output['data'] = $this->course->getList($page);
        $this->output['total_page'] = ceil($this->course->getTotalCount() / 10);
        if ($this->output['total_page'] == 0)
            $this->output['total_page'] = 1;
        $this->output['current_page'] = +$page;
        $this->json();
    }

    public function getAll() {
        $this->output['data'] = $this->course->getAll();
        $this->json();
    }

    public function add() {
        $values = $_POST;
        $this->inputValidation($values);

        if (count($this->errors) > 0)
            return $this->json();

        $this->output['data'] = ['id' => $this->course->add($values)];
        $this->json();
    }

    public function update() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $course = $this->course->getOne($id);
        if (count($this->errors) > 0)
            return $this->json();

        $values = $_POST;
        $this->inputValidation($values);
        if (count($this->errors) > 0)
            return $this->json();

        $this->output['data'] = ['id' => $this->course->update($id, $values)];
        $this->json();
    }

    public function remove() {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $course = $this->course->getOne($id);
        if (count($this->errors) > 0)
            return $this->json();

        $this->output['data'] = ['id' => $this->course->remove($id)];
        $this->json();
    }

    private function inputValidation(&$values) {
        foreach ($values as $key => $val) {
            $values[$key] = trim($val);
        }
        if (empty($values['name']))
            $this->errors['name'] = "Course name is required.";
        if (empty($values['details']))
            $this->errors['details'] = "Course details are required.";
    }

    private function json() {
        if (count($this->errors) > 0) {
            $this->output['status'] = 0;
            $this->output['errors'] = $this->errors;
        }
        echo json_encode($this->output);
    }

}
