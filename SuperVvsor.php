<?php

require_once 'DB.php';

class Supervisor {
    private $supervisorId;
    private $employeeId;
    private $branchNumber;
    private $db;

    public function __construct($supervisorId, $employeeId, $branchNumber) {
        $this->supervisorId = $supervisorId;
        $this->employeeId = $employeeId;
        $this->branchNumber = $branchNumber;
        $this->db = new DB();
    }
   
}

?>
