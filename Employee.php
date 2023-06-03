<?php
require_once 'DB.php';

class Employee {
    private $employeeId;
    private $branchNumber;
    private $name;
    private $phone;
    private $startDate;
    private $jobDesignation;

    public function __construct($employeeId, $branchNumber, $name, $phone, $startDate, $jobDesignation) {
        $this->employeeId = $employeeId;
        $this->branchNumber = $branchNumber;
        $this->name = $name;
        $this->phone = $phone;
        $this->startDate = $startDate;
        $this->jobDesignation = $jobDesignation;
    }

    public function getEmployeeId() {
        return $this->employeeId;
    }

    public function getBranchNumber() {
        return $this->branchNumber;
    }

    public function getName() {
        return $this->name;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function getJobDesignation() {
        return $this->jobDesignation;
    }
}
?>
