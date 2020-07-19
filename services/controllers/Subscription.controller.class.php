<?php

require_once dirname(__FILE__) . "/../models/Subscription.model.class.php";
require_once dirname(__FILE__) . "/../models/Student.model.class.php";
require_once dirname(__FILE__) . "/../models/Course.model.class.php";

class SubscriptionController {

    private $subscription;
    private $errors;
    private $output;

    public function __construct() {
        $this->output = ['status' => 1];
        $this->errors = [];
        $this->subscription = new SubscriptionModel($this->errors);
    }

    public function find() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $this->output['data'] = $this->subscription->getOne($id);
        $this->json();
    }

    public function getList() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if (!is_numeric($page))
            $page = 1;
        $this->output['data'] = $this->subscription->getList($page);
        $this->output['total_page'] = ceil($this->subscription->getTotalCount() / 10);
        if ($this->output['total_page'] == 0)
            $this->output['total_page'] = 1;
        $this->output['current_page'] = +$page;
        $this->json();
    }

    public function courses() {
        $student_id = $_GET['id'];
        $this->output['data'] = $this->subscription->getFilterSubscriptions($student_id);
        $this->json();
    }

    public function subscribe() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $courses = isset($_POST['courses']) ? $_POST['courses'] : '';
        if (!is_array($courses))
            return $this->json("Invalid data provided.");

        $subscriptions = $this->subscription->getFilterSubscriptions($id);
        $courseIds = [];
        foreach ($subscriptions as $sub) {
            $courseIds[$sub['course_id']] = $sub['course_name'];
        }
        
        foreach ($courses as $course_id) {
            if (isset($courseIds[$course_id]))
                continue;

            $values = ['student_id' => $id, 'course_id' => $course_id];
            $this->inputValidation($values);
            if (count($this->errors) > 0)
                break;
            $this->subscription->add($values);
            if (count($this->errors) > 0)
                break;
        }
        return $this->json();
    }

    public function add() {
        $values = $_POST;
        $this->inputValidation($values);

        if (count($this->errors) > 0)
            return $this->json();

        $this->output['data'] = ['id' => $this->subscription->add($values)];
        $this->json();
    }

    public function update() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $subscription = $this->subscription->getOne($id);
        if (count($this->errors) > 0)
            return $this->json();

        $values = $_POST;
        $this->inputValidation($values);
        if (count($this->errors) > 0)
            return $this->json();

        $this->output['data'] = ['id' => $this->subscription->update($id, $values)];
        $this->json();
    }

    public function remove() {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $subscription = $this->subscription->getOne($id);
        if (count($this->errors) > 0)
            return $this->json();

        $this->output['data'] = ['id' => $this->subscription->remove($id)];
        $this->json();
    }

    private function inputValidation(&$values) {
        foreach ($values as $key => $val) {
            $values[$key] = trim($val);
        }

        $student = new StudentModel($this->errors, $this->subscription->getDb());
        $course = new CourseModel($this->errors, $this->subscription->getDb());
        $student->getOne($values['student_id']);
        $course->getOne($values['course_id']);
    }

    private function json($err = NULL) {
        if ($err)
            $this->errors[] = $err;
        if (count($this->errors) > 0) {
            $this->output['status'] = 0;
            $this->output['errors'] = $this->errors;
        }
        echo json_encode($this->output);
    }

}
