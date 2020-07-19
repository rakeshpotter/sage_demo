<?php

require_once dirname(__FILE__) . "/PDOHelper.class.php";

class StudentModel {

    private $db = NULL;
    private $startedTransaction = FALSE;
    private $pageSize = 10;
    private $errors;

    public function __construct(&$errors, PDOHelper $db = NULL) {
        if ($db === NULL) {
            $this->db = new PDOHelper ();
            $this->db->beginTransaction();
            $this->startedTransaction = TRUE;
        } else {
            $this->db = $db;
        }
        $this->errors = &$errors;
    }

    public function getList($page = 1, $size = 10) {
        $offset = ($page - 1 < 0) ? 0 : ($page - 1) * $size;
        $this->db->query("select * from students order by id desc limit $size offset $offset");
//        $this->db->query("select * from students where 1=0 order by id desc limit $size offset $offset");
        return $this->db->resultset();
    }

    public function getOne($id) {
        $this->db->query("select * from students where id=:id");
        $this->db->bind(':id', $id);
        $student = $this->db->single();
        if (!is_array($student))
            $this->errors[] = "No student found with id: $id.";
        return $student;
    }

    public function getTotalCount() {
        $this->db->query('SELECT COUNT(id) as total FROM students');
        return $this->db->single()['total'];
    }

    public function add($values) {
        $this->db->query("insert into students (first_name,last_name,dob,contact) values (:fName,:lName,:dob,:contact)");
        $this->db->bind(':fName', $values['first_name']);
        $this->db->bind(':lName', $values['last_name']);
        $this->db->bind(':dob', $values['dob']);
        $this->db->bind(':contact', $values['contact']);
        if ($this->db->execute() != 1) {
            $this->errors[] = "Failed to add student record.";
            return 0;
        }
        return $this->db->lastInsertId();
    }

    public function update($id, $values) {
        $this->db->query("update students set first_name=:fName, last_name=:lName, dob=:dob, contact=:contact where id=:id");
        $this->db->bind(':fName', $values['first_name']);
        $this->db->bind(':lName', $values['last_name']);
        $this->db->bind(':dob', $values['dob']);
        $this->db->bind(':contact', $values['contact']);
        $this->db->bind(':id', $id);
        if ($this->db->execute() != 1) {
            $this->errors[] = "Failed to update student record.";
            return 0;
        }
        return $id;
    }

    public function remove($id) {
        $this->db->query("delete from students where id=:id");
        $this->db->bind(":id", $id);
        if ($this->db->execute() != 1) {
            $this->errors[] = "Failed to remove student record.";
            return 0;
        }
        return $id;
    }

    public function getDb() {
        return $this->db;
    }

    public function __destruct() {
        if ($this->startedTransaction) {
            if (count($this->errors) > 0)
                $this->db->cancelTransaction();
            else
                $this->db->endTransaction();

            $this->db->closeConnection();
        }
    }

}
