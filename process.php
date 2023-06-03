<?php
require_once 'RentalManagementSystem.php';
require_once 'CreateLease.php';
require_once 'ShowLease.php';
require_once 'ShowProperty.php';
require_once 'ShowRenter.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $option = $_POST['option'] ?? '';

    switch ($option) {
        case 'create_lease':
            $createLease = new CreateLease();
            $response = $createLease->processForm();
            break;
        case 'show_lease':
            $renterName = $_POST['renterName'];
            $renterPhoneNumber = $_POST['renterPhoneNumber'];
            $showLease = new ShowLease();
            $response = $showLease->showLease($renterName,$renterPhoneNumber);
            break;
        case 'show_properties_available':
            $branchName = $_POST['branchName'];
            $showProperty = new ShowProperty();
            $response = $showProperty->showPropertiesByBranch($branchName);
            break;
        case 'show_managers_supervisors_properties':
            $showProperty = new ShowProperty();
            $response = $showProperty->showPropertiesBySupervisor();
            break;
        case 'show_properties_by_owner':
            $ownerName = $_POST['ownerName'];
            $ownerPhoneNumber = $_POST['ownerPhoneNumber'];
            $branchName = $_POST['branchName'];
            $showProperty = new ShowProperty();
            $response = $showProperty->showPropertiesByOwner($ownerName,$ownerPhoneNumber,$branchName);
            break;
        case 'show_properties_by_criteria':
            $city = $_POST['city'] ?? null;
            $numRooms = $_POST['numRooms'] ?? null;
            $minRent = $_POST['minRent'] ?? null;
            $maxRent = $_POST['maxRent'] ?? null;
            $showProperty = new ShowProperty();
            $response = $showProperty->showPropertiesByCriteria($city,$numRooms,$minRent,$maxRent);
            break;
        case 'show_available_properties_by_branch':
            $showProperty = new ShowProperty();
            $response = $showProperty->showAvailablePropertiesByBranch();
            break;
        case 'create_lease_agreement':
            $leaseData = $_POST['leaseData'];
            $createLease = new CreateLease();
            $response = $createLease->createLeaseAgreement($leaseData);
            break;
        case 'show_renters_with_more_than_one_lease':
            $renters = new ShowRenter();
            $response = $renters->showRenterWithMoreThanOneLease();
            break;
        default:
            $response = 'Invalid optionsss';
            break;
    }

    echo json_encode($response);
}
?>
