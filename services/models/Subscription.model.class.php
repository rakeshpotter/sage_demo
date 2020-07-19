<?php

require_once dirname(__FILE__) . "/PDOHelper.class.php";

class SubscriptionModel {

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
        $this->db->query('SELECT subscriptions.*, concat(students.first_name, " ", students.last_name) as student_name, courses.name as course_name FROM subscriptions
INNER JOIN students on subscriptions.student_id=students.id
INNER JOIN courses on subscriptions.course_id=courses.id order by subscriptions.id desc limit ' . $size . ' offset ' . $offset);
        return $this->db->resultset();
    }

    public function getOne($id) {
        $this->db->query("select * from subscriptions where id=:id");
        $this->db->bind(':id', $id);
        $subscription = $this->db->single();
        if (!is_array($subscription))
            $this->errors[] = "No subscription found with id: $id.";
        return $subscription;
    }

    public function getFilterSubscriptions($student_id = 0, $course_id = 0) {
        $bind = [];
        if ($student_id > 0)
            $bind['student_id'] = $student_id;
        if ($course_id > 0)
            $bind['course_id'] = $course_id;

        if (count($bind) == 0)
            return [];

        $where = '';
        foreach ($bind as $key => $val) {
            $where = ($where == '') ? " where subscriptions.$key=:$key " : " and subscriptions.$key=:$key";
        }

        $this->db->query('SELECT subscriptions.*, concat(students.first_name, " ", students.last_name) as student_name, courses.name as course_name FROM subscriptions
INNER JOIN students on subscriptions.student_id=students.id
INNER JOIN courses on subscriptions.course_id=courses.id ' . $where);
        foreach ($bind as $key => $val) {
            $this->db->bind(":$key", $val);
        }
        return $this->db->resultset();
    }

    public function getTotalCount() {
        $this->db->query('SELECT COUNT(id) as total FROM subscriptions');
        return $this->db->single()['total'];
    }

    public function add($values) {
        $this->db->query("insert into subscriptions (student_id,course_id,sub_date) values (:sid,:cid,:date)");
        $this->db->bind(':sid', $values['student_id']);
        $this->db->bind(':cid', $values['course_id']);
        $this->db->bind(':date', date('Y-m-d'));
        if ($this->db->execute() != 1) {
            $this->errors[] = "Failed to add subscription record.";
            return 0;
        }
        return $this->db->lastInsertId();
    }

    public function update($id, $values) {
        $this->db->query("update subscriptions set student_id=:sid, course_id=:cid where id=:id");
        $this->db->bind(':sid', $values['student_id']);
        $this->db->bind(':cid', $values['course_id']);
        $this->db->bind(':id', $id);
        if ($this->db->execute() != 1) {
            $this->errors[] = "Failed to update subscription record.";
            return 0;
        }
        return $id;
    }

    public function remove($id) {
        $this->db->query("delete from subscriptions where id=:id");
        $this->db->bind(":id", $id);
        if ($this->db->execute() != 1) {
            $this->errors[] = "Failed to remove subscription record.";
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
