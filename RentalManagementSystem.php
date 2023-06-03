<?php

require_once 'DB.php';
require_once 'LeaseAgreement.php';
require_once 'Property.php';

class RentalManagementSystem {
    /**
     * Summary of db
     * @var 
     */
    private $db;

    /**
     * Summary of __construct
     */
    public function __construct() {
        $this->db = new DB();
    }

    /**
     * Summary of getAvailablePropertiesByBranch
     * @param mixed $branchName
     * @return array<Property>
     */
    public function getvailablePropertiesByBranch() {
        $query = "SELECT b.branch AS branchName, COUNT(*) AS numPropertiesAvailable
                    FROM rentalproperty rp
                    INNER JOIN supervisor s ON rp.supervisor_id = s.supervisor_id
                    INNER JOIN branch b ON s.branch_number = b.branch_number
                    WHERE rp.status = 'Available'
                    GROUP BY b.branch";

        $params = array();

        $result = $this->db->executeQuery($query, $params);
        $properties = array();

        while ($row = $result->fetch_assoc()) {
            $properties[$row['branchName']] = $row['numPropertiesAvailable'];   
        }

        return $properties;
    }

    public function generateLeaseAgreement($tenantName, $propertyNumber, $homePhone, $workPhone, $startDate, $endDate, $depositAmount, $monthlyRent) {
        // Convert the non-string fields to their respective data types
        $propNumber = (int) $propertyNumber;
        $startDt = $startDate;
        $endDt = $endDate;
        $depositAmt = (float) $depositAmount;
        $monthlyRnt = (float) $monthlyRent;
    
        // Insert lease details into LeaseAgreement table
        $query = "INSERT INTO LeaseAgreement (property_number, renter_name, home_phone, work_phone, start_date, end_date, deposit_amount, monthly_rent) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
        // Prepare the statement
        $stmt = $this->db->prepare($query);
    
        // Bind the parameters
        $stmt->bind_param("isssssdd", $propNumber, $tenantName, $homePhone, $workPhone, $startDt, $endDt, $depositAmt, $monthlyRnt);
    
        // Execute the statement
        $result = $stmt->execute();
    
        // Check if the execution was successful
        if ($result) {
            $leaseAgreement = new LeaseAgreement($propNumber, $tenantName, $homePhone, $workPhone, $startDt, $endDt, $depositAmt, $monthlyRnt);
    
            return $leaseAgreement;
        } else {
            // Handle the case where the insertion failed
            // You can throw an exception or return an error message as needed
        }
    }
    
    
    
    

    /**
     * Summary of getManagersAndSupervisorsByBranch
     * @param mixed $branchName
     * @return array
     */
    public function getManagersAndSupervisorsByBranch($branchName) {
        $query = "SELECT e.*, s.supervisor_id FROM Employee e JOIN Supervisor s ON e.employee_id = s.employee_id WHERE e.branch = :branch";
        $params = array(':branch' => $branchName);

        $result = $this->db->executeQuery($query, $params);
        $managers = array();

        while ($row = $result->fetch_assoc()) {
            // Create Employee objects and add them to the array
            $manager = new Employee($row['employee_id'], $row['branch'], $row['name'], $row['phone'], $row['start_date'], $row['job_designation']);
            $supervisorId = $row['supervisor_id'];

            if (!isset($managers[$manager->getEmployeeId()])) {
                // If the manager is not already added to the array, add them with an empty supervisors array
                $managers[$manager->getEmployeeId()] = array('manager' => $manager, 'supervisors' => array());
            }

            if ($supervisorId) {
                // If the supervisor id is not empty, fetch the supervisor details and add them to the respective manager's supervisors array
                $supervisor = $this->getSupervisorById($supervisorId);
                $managers[$manager->getEmployeeId()]['supervisors'][] = $supervisor;
            }
        }

        return $managers;
    }

    /**
     * Summary of getSupervisorById
     * @param mixed $supervisorId
     * @return Supervisor
     */
    public function getSupervisorById($supervisorId) {
        $query = "SELECT * FROM Supervisor WHERE supervisor_id = :supervisor_id";
        $params = array(':supervisor_id' => $supervisorId);

        $result = $this->db->executeQuery($query, $params);
        $row = $result->fetch_assoc();

        // Create Supervisor object and return it
        $supervisor = new Supervisor($row['supervisor_id'], $row['employee_id'], $row['branch_number']);
        return $supervisor;
    }

    /**
     * Summary of getPropertiesByOwnerAndBranch
     * @param mixed $ownerName
     * @param mixed $ownerPhone
     * @param mixed $branchName
     * @return array<Property>
     */
    public function getPropertiesByBranch($branchName) {
        $query = "SELECT rp.*
                    FROM RentalProperty rp
                    JOIN PropertyOwner po ON rp.owner_id = po.owner_id
                    JOIN Supervisor s ON rp.supervisor_id = s.supervisor_id
                    JOIN Branch b ON s.branch_number = b.branch_number
                    WHERE b.branch = ? and rp.status='Available'";

    
        $params = array($branchName);
        
        $result = $this->db->executeQuery($query, $params);
        $properties = array();
        while ($row = $result->fetch_assoc()) {
            // Create Property objects and add them to the array
            $property = new Property(
                $row['property_number'],
                $row['owner_id'],
                $row['supervisor_id'],
                $row['street'],
                $row['city'],
                $row['zip'],
                $row['num_rooms'],
                $row['monthly_rent'],
                $row['status'],
                $row['start_date']
            );
            $properties[] = $property;
        }
        

        return $properties;
    }

    public function getPropertiesBySupervisor(){
        $query = "
        SELECT
            mgr.employee_id AS manager_id,
            mgr.name AS manager_name,
            sup.employee_id AS supervisor_id,
            sup.name AS supervisor_name,
            rp.property_number,
            rp.street,
            rp.city,
            rp.zip
        FROM
            Employee AS mgr
        JOIN
            Employee AS sup ON sup.manager_id = mgr.employee_id
        JOIN
            Supervisor AS s ON s.employee_id = sup.employee_id
        JOIN
            RentalProperty AS rp ON rp.supervisor_id = s.supervisor_id
        WHERE
            mgr.job_designation = 'Manager'
    ";

    $params = array();
        
    $result = $this->db->executeQuery($query, $params);

    $data = array();

    while ($row = $result->fetch_assoc()) {
        $managerId = $row['manager_id'];
        $supervisorId = $row['supervisor_id'];
    
        // Check if the manager already exists in the data array
        if (!isset($data[$managerId])) {
            // If the manager doesn't exist, create a new entry
            $data[$managerId] = array(
                'manager_id' => $row['manager_id'],
                'manager_name' => $row['manager_name'],
                'supervisors' => array()
            );
        }
    
        // Add the supervisor and property information under the manager
        $data[$managerId]['supervisors'][] = array(
            'supervisor_id' => $supervisorId,
            'supervisor_name' => $row['supervisor_name'],
            'property_number' => $row['property_number'],
            'street' => $row['street'],
            'city' => $row['city'],
            'zip' => $row['zip']
        );
    }
    
    // Convert the data array to indexed array format
    $data = array_values($data);
    
    return $data;
}


public function getPropertiesByOwner($ownerName, $ownerPhoneNumber, $branchName) {
    $query = "SELECT rp.property_number, rp.owner_id, rp.supervisor_id, rp.street, rp.city, rp.zip, rp.num_rooms, rp.monthly_rent, rp.status, rp.start_date
              FROM RentalProperty rp
              JOIN PropertyOwner po ON rp.owner_id = po.owner_id
              JOIN Supervisor s ON rp.supervisor_id = s.supervisor_id
              JOIN Branch b ON s.branch_number = b.branch_number
              WHERE po.name = ? AND po.phone = ? AND b.branch = ?";

    $params = array($ownerName, $ownerPhoneNumber, $branchName);

    $result = $this->db->executeQuery($query, $params);
    $properties = array();
    while ($row = $result->fetch_assoc()) {
        // Create an array with the property details
        $property = array(
            'propertyNumber' => $row['property_number'],
            'ownerId' => $row['owner_id'],
            'supervisorId' => $row['supervisor_id'],
            'street' => $row['street'],
            'city' => $row['city'],
            'zip' => $row['zip'],
            'numRooms' => $row['num_rooms'],
            'monthlyRent' => $row['monthly_rent'],
            'status' => $row['status'],
            'startDate' => $row['start_date']
        );

        // Add the property to the array
        $properties[] = $property;
    }

    // Get the count of properties
    $numProperties = count($properties);

    // Create an array with owner details and properties count
    $ownerData = array(
        'ownerName' => $ownerName,
        'numProperties' => $numProperties,
        'properties' => $properties
    );

    return $ownerData;
}

function getPropertiesByCriteria($city, $numRooms, $minRent, $maxRent) {
    $query = "SELECT rp.property_number, rp.owner_id, rp.supervisor_id, rp.street, rp.city, rp.zip, rp.num_rooms, rp.monthly_rent, rp.status, rp.start_date
              FROM RentalProperty rp
              WHERE 1=1";

    $params = array();

    if ($city) {
        $query .= " AND rp.city = ?";
        $params[] = $city;
    }

    if ($numRooms) {
        $query .= " AND rp.num_rooms = ?";
        $params[] = $numRooms;
    }

    if ($minRent) {
        $query .= " AND rp.monthly_rent >= ?";
        $params[] = $minRent;
    }

    if ($maxRent) {
        $query .= " AND rp.monthly_rent <= ?";
        $params[] = $maxRent;
    }

    $result = $this->db->executeQuery($query, $params);
    $properties = array();
    while ($row = $result->fetch_assoc()) {
        // Create a Property object with the property details
        $property = new Property(
            $row['property_number'],
            $row['owner_id'],
            $row['supervisor_id'],
            $row['street'],
            $row['city'],
            $row['zip'],
            $row['num_rooms'],
            $row['monthly_rent'],
            $row['status'],
            $row['start_date']
        );

        // Add the property to the array
        $properties[] = $property;
    }

    return $properties;
}

    /**
     * Summary of getPropertiesCountByBranch
     * @return array
     */
    public function getPropertiesCountByBranch() {
        $query = "SELECT branch, COUNT(*) AS property_count FROM RentalProperty GROUP BY branch";
        $result = $this->db->executeQuery($query);
        $propertyCount = array();

        while ($row = $result->fetch_assoc()) {
            $propertyCount[$row['branch']] = $row['property_count'];
        }

        return $propertyCount;
    }

    /**
     * Summary of createLeaseAgreement
     * @param mixed $propertyNumber
     * @param mixed $renterName
     * @param mixed $homePhone
     * @param mixed $workPhone
     * @param mixed $startDate
     * @param mixed $endDate
     * @param mixed $depositAmount
     * @param mixed $monthlyRent
     * @return void
     */
    public function createLeaseAgreement($propertyNumber, $renterName, $homePhone, $workPhone, $startDate, $endDate, $depositAmount, $monthlyRent) {
        // Validate the lease agreement data

        // Create the lease agreement in the database

        // Update the property status to 'leased' or 'not_available'

        // Update the rent for the property

        // Create and return the LeaseAgreement object
    }

    /**
     * Summary of getLeaseAgreementByRenter
     * @param mixed $renterName
     * @return LeaseAgreement|null
     */
    function getLeaseByRenterNameOrPhoneNumber($renterName, $renterPhoneNumber) {
        $query = "SELECT la.property_number, la.renter_name, la.home_phone, la.work_phone, la.start_date, la.end_date, la.deposit_amount, la.monthly_rent
                  FROM LeaseAgreement la
                  WHERE la.renter_name = ? OR la.home_phone = ?";
    
    $params = array($renterName, $renterPhoneNumber);

    $result = $this->db->executeQuery($query, $params);
    $leases = array();
    while ($row = $result->fetch_assoc()) {
            // Create a LeaseAgreement object with the lease details
            $lease = new LeaseAgreement(
                $row['property_number'],
                $row['renter_name'],
                $row['home_phone'],
                $row['work_phone'],
                $row['start_date'],
                $row['end_date'],
                $row['deposit_amount'],
                $row['monthly_rent']
            );
    
            // Add the lease to the array
            $leases[] = $lease;
        }
    
        return $leases;
    }

    /**
     * Summary of getRentersWithMultipleProperties
     * @return array
     */
    public function getRentersWithMultipleProperties() {
        $query = "SELECT renter_name, COUNT(*) AS property_count FROM LeaseAgreement GROUP BY renter_name HAVING property_count > 1";
        $result = $this->db->executeQuery($query);
        $renters = array();

        while ($row = $result->fetch_assoc()) {
            $renters[] = $row['renter_name'];
        }

        return $renters;
    }

    /**
     * Summary of getAverageRentByTown
     * @param mixed $town
     * @return mixed
     */
    public function getAverageRentByTown($town) {
        $query = "SELECT AVG(monthly_rent) AS average_rent FROM RentalProperty WHERE city = :town";
        $params = array(':town' => $town);

        $result = $this->db->executeQuery($query, $params);
        $row = $result->fetch_assoc();

        return $row['average_rent'];
    }

    public function getRenterWithMoreThanOneLease(){
        $query = "SELECT renter_name, COUNT(property_Number) AS numProperties
                  FROM LeaseAgreement
                  GROUP BY renter_name
                  HAVING numProperties > 1";
        $params = array();
        $result = $this->db->executeQuery($query,$params);
        $renters = array();
        while ($row = $result->fetch_assoc()) {
            $renters[$row['renter_name']] = $row['numProperties'];   
        }

        return $renters;

        
    }

    /**
     * Summary of getExpiringLeaseAgreements
     * @param mixed $months
     * @return array<LeaseAgreement>
     */
    public function getExpiringLeaseAgreements($months) {
        $currentDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime("+{$months} months"));

        $query = "SELECT * FROM LeaseAgreement WHERE end_date BETWEEN :current_date AND :end_date";
        $params = array(':current_date' => $currentDate, ':end_date' => $endDate);

        $result = $this->db->executeQuery($query, $params);
        $leaseAgreements = array();

        while ($row = $result->fetch_assoc()) {
            // Create LeaseAgreement objects and add them to the array
            $leaseAgreement = new LeaseAgreement($row['lease_id'], $row['property_number'], $row['renter_name'], $row['home_phone'], $row['work_phone'], $row['start_date'], $row['end_date'], $row['deposit_amount'], $row['monthly_rent']);
            $leaseAgreements[] = $leaseAgreement;
        }

        return $leaseAgreements;
    }

    /**
     * Summary of getMonthlyEarnings
     * @return float
     */
    public function getMonthlyEarnings() {
        $query = "SELECT SUM(monthly_rent) AS total_earnings FROM LeaseAgreement";
        $result = $this->db->executeQuery($query);
        $row = $result->fetch_assoc();

        return $row['total_earnings'] * 0.1;
    }
}

?>