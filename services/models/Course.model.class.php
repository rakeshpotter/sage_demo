<?php

require_once dirname(__FILE__) . "/PDOHelper.class.php";

class CourseModel {

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
        $this->db->query("select * from courses order by id desc limit $size offset $offset");
        return $this->db->resultset();
    }

    public function getOne($id) {
        $this->db->query("select * from courses where id=:id");
        $this->db->bind(':id', $id);
        $course = $this->db->single();
        if (!is_array($course))
            $this->errors[] = "No course found with id: $id.";
        return $course;
    }

    public function getAll() {
        $this->db->query("select * from courses");
        return $this->db->resultset();
    }

    public function getTotalCount() {
        $this->db->query('SELECT COUNT(id) as total FROM courses');
        return $this->db->single()['total'];
    }

    public function add($values) {
        $this->db->query("insert into courses (name,details) values (:name,:details)");
        $this->db->bind(':name', $values['name']);
        $this->db->bind(':details', $values['details']);
        if ($this->db->execute() != 1) {
            $this->errors[] = "Failed to add course record.";
            return 0;
        }
        return $this->db->lastInsertId();
    }

    public function update($id, $values) {
        $this->db->query("update courses set name=:name, details=:details where id=:id");
        $this->db->bind(':name', $values['name']);
        $this->db->bind(':details', $values['details']);
        $this->db->bind(':id', $id);
        if ($this->db->execute() != 1) {
            $this->errors[] = "Failed to update course record.";
            return 0;
        }
        return $id;
    }

    public function remove($id) {
        $this->db->query("delete from courses where id=:id");
        $this->db->bind(":id", $id);
        if ($this->db->execute() != 1) {
            $this->errors[] = "Failed to remove course record.";
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
