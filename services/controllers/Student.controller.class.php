<?php

require_once dirname(__FILE__) . "/../models/Student.model.class.php";

class StudentController {

    private $student;
    private $errors;
    private $output;

    public function __construct() {
        $this->output = ['status' => 1];
        $this->errors = [];
        $this->student = new StudentModel($this->errors);
    }

    public function find() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $this->output['data'] = $this->student->getOne($id);
        $this->json();
    }

    public function getList() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if (!is_numeric($page))
            $page = 1;
        $this->output['data'] = $this->student->getList($page);
        $this->output['total_page'] = ceil($this->student->getTotalCount() / 10);
        if ($this->output['total_page'] == 0)
            $this->output['total_page'] = 1;
        $this->output['current_page'] = +$page;
        $this->json();
    }

    public function add() {
        $values = $_POST;
        $this->inputValidation($values);

        if (count($this->errors) > 0)
            return $this->json();

        $this->output['data'] = ['id' => $this->student->add($values)];
        $this->json();
    }

    public function update() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $student = $this->student->getOne($id);
        if (count($this->errors) > 0)
            return $this->json();

        $values = $_POST;
        $this->inputValidation($values);
        if (count($this->errors) > 0)
            return $this->json();

        $this->output['data'] = ['id' => $this->student->update($id, $values)];
        $this->json();
    }

    public function remove() {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $student = $this->student->getOne($id);
        if (count($this->errors) > 0)
            return $this->json();

        $this->output['data'] = ['id' => $this->student->remove($id)];
        $this->json();
    }

    private function inputValidation(&$values) {
        foreach ($values as $key => $val) {
            $values[$key] = trim($val);
        }
        if (empty($values['first_name']))
            $this->errors['first_name'] = "First name is required.";
        else if(preg_match("/^([a-zA-Z' ]+)$/",$values['first_name'])==0)
            $this->errors['first_name'] = "First name must have only alphabets.";
        if (empty($values['last_name']))
            $this->errors['last_name'] = "Last name is required.";
        else if(preg_match("/^([a-zA-Z' ]+)$/",$values['last_name'])==0)
            $this->errors['last_name'] = "Last name must have only alphabets.";
        if (empty($values['dob']))
            $this->errors['dob'] = "Date of birth is required.";
        else if(!$this->isValidDate($values['dob']))
            $this->errors['dob'] = "Date of birth is not a valid date.";
        if (empty($values['contact']))
            $this->errors['contact'] = "Contact is required.";
        else if (strlen($values['contact']) < 6)
            $this->errors['contact'] = "Contact must have atleast 6 digits.";
    }
    
    private function isValidDate($date){
        $parts = explode('-', $date);
        if(count($parts) != 3)
            return FALSE;
        return checkdate($parts[1], $parts[2], $parts[0]);
    }

    private function json() {
        if (count($this->errors) > 0) {
            $this->output['status'] = 0;
            $this->output['errors'] = $this->errors;
        }
        echo json_encode($this->output);
    }

}
