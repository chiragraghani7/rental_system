<!DOCTYPE html>
<html>
<head>
    <title>Rental Management System</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <script>
        $(document).ready(function() {
        $('#myForm').submit(function(e) {
        e.preventDefault();
        clearResult();

        var option = $('#option').val();

        if (option === 'show_properties_available') {

            var branchName = $('#branchName').val();
            if (!branchName) {
                alert('Please enter the name of the branch');
                return;
            }
            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: { option: option, branchName: branchName },
                dataType: 'json',
                success: function(response) {
                    var output = '';
                    response.forEach(function(property) {
                        output += '<p>Property Number: ' + property.propertyNumber + '</p>';
                        output += '<p>Owner ID: ' + property.ownerId + '</p>';
                        output += '<p>Supervisor ID: ' + property.supervisorId + '</p>';
                        output += '<p>Street: ' + property.street + '</p>';
                        output += '<p>City: ' + property.city + '</p>';
                        output += '<p>Zip: ' + property.zip + '</p>';
                        output += '<p>Number of Rooms: ' + property.numRooms + '</p>';
                        output += '<p>Monthly Rent: ' + property.monthlyRent + '</p>';
                        output += '<p>Status: ' + property.status + '</p>';
                        output += '<p>Start Date: ' + property.startDate + '</p>';
                    });
                    $('#result').html(output);
                },
                error: function(xhr, status, error) {
                    console.log('AJAX request failed. Error: ' + error);
                }
            });

        }else if (option === 'show_managers_supervisors_properties') {
                $.ajax({
                    url: 'process.php',
                    type: 'POST',
                    data: { option: option },
                    dataType: 'json',
                    success: function(response) {
                        var output = '';
                        for (var i = 0; i < response.length; i++) {
                            var manager = response[i];
                            output += '<h3>Manager ID: ' + manager.manager_id + ', Name: ' + manager.manager_name + '</h3>';
                            output += '<ul>';
                            for (var j = 0; j < manager.supervisors.length; j++) {
                                var supervisor = manager.supervisors[j];
                                output += '<li>Supervisor ID: ' + supervisor.supervisor_id + ', Name: ' + supervisor.supervisor_name + '</li>';
                                output += '<ul>';
                                output += '<li>Property Number: ' + supervisor.property_number + '</li>';
                                output += '<li>Street: ' + supervisor.street + '</li>';
                                output += '<li>City: ' + supervisor.city + '</li>';
                                output += '<li>ZIP: ' + supervisor.zip + '</li>';
                                output += '</ul>';
                            }
                            output += '</ul>';
                        }
                        $('#result').html(output);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('An error occurred while fetching the data.');
                    }
                });
    }else if (option === 'show_properties_by_owner') {
                    var ownerName = $('#ownerName').val();
                    var ownerPhoneNumber = $('#ownerPhoneNumber').val();
                    var branchName = $('#branchNameForOwner').val();

                    $.ajax({
                        url: 'process.php',
                        type: 'POST',
                        data: {
                            option: option,
                            ownerName: ownerName,
                            ownerPhoneNumber: ownerPhoneNumber,
                            branchName: branchName
                        },
                        dataType: 'json',
                        success: function(response) {
                        var output = '';

                        if (response.numProperties > 0) {
                            output += '<div class="owner-details">';
                            output += '<div class="owner-name">' + response.ownerName + ' (' + response.numProperties + ' properties)</div>';

                            response.properties.forEach(function(property) {
                            output += '<div class="property-details">';
                            output += '<p><strong>Property Number:</strong> ' + property.propertyNumber + '</p>';
                            output += '<p><strong>Supervisor ID:</strong> ' + property.supervisorId + '</p>';
                            output += '<p><strong>Street:</strong> ' + property.street + '</p>';
                            output += '<p><strong>City:</strong> ' + property.city + '</p>';
                            output += '<p><strong>Zip:</strong> ' + property.zip + '</p>';
                            output += '<p><strong>Number of Rooms:</strong> ' + property.numRooms + '</p>';
                            output += '<p><strong>Monthly Rent:</strong> ' + property.monthlyRent + '</p>';
                            output += '<p><strong>Status:</strong> ' + property.status + '</p>';
                            output += '<p><strong>Start Date:</strong> ' + property.startDate + '</p>';
                            output += '</div>';
                            });

                            output += '</div>';
                        } else {
                            output = '<p>No properties found.</p>';
                        }

                        $('#result').html(output);
                        },
                        error: function(xhr, status, error) {
                            console.log('AJAX request failed. Error: ' + error);
                        }
                    });
    }
    else if(option === 'show_properties_by_criteria'){
        var formData = $(this).serialize();

        // Send the AJAX request
        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                var properties = response; // Assuming response is an array of Property objects

                // Clear previous listings
                var propertyList = $('#result');
                propertyList.empty();

                if (properties.length > 0) {
                    // Iterate over each property and create a listing
                    $.each(properties, function(index, property) {
                        var propertyItem = $('<div class="property-item"></div>');

                        // Add property details to the listing
                        propertyItem.append('<p><strong>Property Number:</strong> ' + property.propertyNumber + '</p>');
                        propertyItem.append('<p><strong>City:</strong> ' + property.city + '</p>');
                        propertyItem.append('<p><strong>Number of Rooms:</strong> ' + property.numRooms + '</p>');
                        propertyItem.append('<p><strong>Rent:</strong> ' + property.monthlyRent + '</p>');
                        propertyItem.append('<p><strong>Status:</strong> ' + property.status + '</p>');
                        propertyItem.append('<p><strong>Owner ID:</strong> ' + property.ownerId + '</p>');
                        propertyItem.append('<p><strong>Supervisor ID:</strong> ' + property.supervisorId + '</p>');
                        propertyItem.append('<p><strong>Street:</strong> ' + property.street + '</p>');
                        propertyItem.append('<p><strong>Zip:</strong> ' + property.zip + '</p>');
                        propertyItem.append('<p><strong>Start Date:</strong> ' + property.startDate + '</p>');
                        // Add more property details as needed

                        // Append the listing to the property list
                        propertyList.append(propertyItem);
                    });
                } else {
                    propertyList.append('<p>No properties found.</p>');
                }
            },
            error: function() {
                alert('Error occurred. Please try again.');
            }
        });

    }else if(option === 'show_available_properties_by_branch'){
        $.ajax({
                url: 'process.php',
                type: 'POST',
                data: { option: option },
                dataType: 'json',
                success: function(response) {
                    $.each(response, function(branchName, count) {
                        $('#result').append('<p>Number of properties available for rent in ' + branchName + ': ' + count + '</p>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log('AJAX request failed. Error: ' + error);
                }
            });

    } else if (option === 'create_lease_agreement') {
            // Collect the lease agreement data
            var tenantName = $('#tenantName').val();
            var propertyNumber = $('#propertyNumber').val();
            var homePhone = $('#homePhone').val();
            var workPhone = $('#workPhone').val();
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            var depositAmount = $('#depositAmount').val();
            var monthlyRent = $('#monthlyRent').val();

            // Create an object to hold the lease agreement data
            var leaseData = {
                tenantName: tenantName,
                propertyNumber: propertyNumber,
                homePhone: homePhone,
                workPhone: workPhone,
                startDate: startDate,
                endDate: endDate,
                depositAmount: depositAmount,
                monthlyRent: monthlyRent
            };

            // Send the lease agreement data to the server using Ajax
            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: {
                    option: option,
                    leaseData: leaseData
                },
                dataType: 'json',
                success: function(response) {
                    alert('Lease generated successfully.');

                    var leaseDocument = '<div class="lease-agreement">';
                    leaseDocument += '<h2>Lease Agreement</h2>';
                    leaseDocument += '<p class="section-heading">Tenant Information</p>';
                    leaseDocument += '<p><span class="sub-heading">Tenant Name:</span> ' + response.renterName + '</p>';
                    leaseDocument += '<p><span class="sub-heading">Property Number:</span> ' + response.propertyNumber + '</p>';
                    leaseDocument += '<p><span class="sub-heading">Home Phone:</span> ' + response.homePhone + '</p>';
                    leaseDocument += '<p><span class="sub-heading">Work Phone:</span> ' + response.workPhone + '</p>';
                    leaseDocument += '<p class="section-heading">Lease Details</p>';
                    leaseDocument += '<p><span class="sub-heading">Start Date:</span> ' + response.startDate + '</p>';
                    leaseDocument += '<p><span class="sub-heading">End Date:</span> ' + response.endDate + '</p>';
                    leaseDocument += '<p><span class="sub-heading">Deposit Amount:</span> ' + response.depositAmount + '</p>';
                    leaseDocument += '<p><span class="sub-heading">Monthly Rent:</span> ' + response.monthlyRent + '</p>';
                    leaseDocument += '<div class="additional-details">';
                    leaseDocument += '<p class="sub-heading">Additional Lease Agreement Details:</p>';
                    leaseDocument += '<p>... Additional lease agreement details ...</p>';
                    leaseDocument += '</div>';
                    leaseDocument += '</div>';

                    // Display the lease document
                    $('#leaseDocumentContainer').html(leaseDocument);
                },
                error: function(xhr, status, error) {
                    console.log('AJAX request failed. Error: ' + error);
                }
            });
    } else if (option === 'show_lease') {
            // Collect the lease agreement data
            var renterName = $('#renterName').val();
            var renterPhoneNumber = $('#renterPhoneNumber').val();

            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: {
                    option: option,
                    renterName: renterName,
                    renterPhoneNumber: renterPhoneNumber
                },
                dataType: 'json',
                success: function(response) {

                    var leaseDocument = '';
                    for (var i = 0; i < response.length; i++) {
                        var lease = response[i];

                        leaseDocument += '<div class="lease-agreement">';
                        leaseDocument += '<h2>Lease Agreement</h2>';
                        leaseDocument += '<p class="section-heading">Tenant Information</p>';
                        leaseDocument += '<p><span class="sub-heading">Tenant Name:</span> ' + lease.renterName + '</p>';
                        leaseDocument += '<p><span class="sub-heading">Property Number:</span> ' + lease.propertyNumber + '</p>';
                        leaseDocument += '<p><span class="sub-heading">Home Phone:</span> ' + lease.homePhone + '</p>';
                        leaseDocument += '<p><span class="sub-heading">Work Phone:</span> ' + lease.workPhone + '</p>';
                        leaseDocument += '<p class="section-heading">Lease Details</p>';
                        leaseDocument += '<p><span class="sub-heading">Start Date:</span> ' + lease.startDate + '</p>';
                        leaseDocument += '<p><span class="sub-heading">End Date:</span> ' + lease.endDate + '</p>';
                        leaseDocument += '<p><span class="sub-heading">Deposit Amount:</span> ' + lease.depositAmount + '</p>';
                        leaseDocument += '<p><span class="sub-heading">Monthly Rent:</span> ' + lease.monthlyRent + '</p>';
                        leaseDocument += '<div class="additional-details">';
                        leaseDocument += '<p class="sub-heading">Additional Lease Agreement Details:</p>';
                        leaseDocument += '<p>... Additional lease agreement details ...</p>';
                        leaseDocument += '</div>';
                        leaseDocument += '</div>';
                        leaseDocument += '<hr>';
                    }

                    // Display the lease documents
                    $('#leaseDocumentContainer').html(leaseDocument);
                },
                error: function(xhr, status, error) {
                    console.log('AJAX request failed. Error: ' + error);
                }
            });
    } else if(option === 'show_renters_with_more_than_one_lease'){
        $.ajax({
            url: "process.php",
            type: "POST",
            dataType: 'json',
            data: { option: option },
            success: function(response) {
                $.each(response, function(renter_name, count) {
                        $('#result').append('<p>Renter : ' + renter_name + ' has Rental Properties:' + count + '</p>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log('AJAX request failed. Error: ' + error);
                }
        });
    } 
    else {
                    $.ajax({
                        url: 'process.php',
                        type: 'POST',
                        data: { option: option },
                        dataType: 'json',
                        success: function(response) {
                            $('#result').html(response);
                        }
                    });
    }
    });

    function clearResult() {
        $('#result').html('');
        $('#leaseDocumentContainer').html('');
    }

    // Function to hide and clear input fields
    function hideAndClearInputFields() {
        $('.input-field').val('').hide();
        $('.input-field2').val('').hide();
        $('#propertyFilter').hide();
        $('#branchInput').hide();
        $('#leaseFields').hide();
    }

    $('#option').change(function() {
            clearResult();
            hideAndClearInputFields();

            var option = $(this).val();

            // Show the corresponding input fields based on the selected option
            if (option === 'show_properties_available') {
                $('#branchInput').show();
            } else if (option === 'show_properties_by_owner') {
                $('.input-field').show();
            } else if (option === 'show_lease') {
                $('.input-field2').show();
            } else if (option === 'show_properties_by_criteria') {
                $('#propertyFilter').show();
            } else if (option === 'create_lease_agreement') {
                $('#leaseFields').show();
            }
        });

});

    </script>
</head>
<body>
    <h1>Rental Management System</h1>
    <form id="myForm" method="POST">
    <label for="option">Select an option:</label>
    <select name="option" id="option">
        <option value="">Select any option</option>
        <option value="show_lease">Show Lease</option>
        <option value="show_properties_available">Show Properties Available</option>
        <option value="show_managers_supervisors_properties">Show Properties by Managers</option>
        <option value="show_properties_by_owner">Show Properties by Owner</option>
        <option value="show_properties_by_criteria">Show Properties by Criteria</option>
        <option value="show_available_properties_by_branch">Show Available Properties by Branch</option>
        <option value="create_lease_agreement">Create Lease Agreement</option>
        <option value="show_renters_with_more_than_one_lease">Show Renters with more than one Lease Agreement</option>
        <!-- Add more options as needed -->
    </select>
    <br>
    <div id="propertyFilter" style="display: none;">
        
            <label for="city">City:</label>
            <input type="text" id="city" name="city">

            <label for="numRooms">Number of Rooms:</label>
            <input type="number" id="numRooms" name="numRooms">

            <label for="minRent">Minimum Rent:</label>
            <input type="number" id="minRent" name="minRent">

            <label for="maxRent">Maximum Rent:</label>
            <input type="number" id="maxRent" name="maxRent">

    </div>
    <div id="branchInput" style="display: none;">
        <label for="branchName">Enter the name of the branch:</label>
        <input type="text" name="branchName" id="branchName">
    </div>
    <br>
    <div class="input-field" style="display: none;">
        <label for="ownerName">Owner Name:</label>
        <input type="text" name="ownerName" id="ownerName">
    </div>
    <div class="input-field" style="display: none;">
        <label for="ownerPhoneNumber">Owner Phone Number:</label>
        <input type="text" name="ownerPhoneNumber" id="ownerPhoneNumber">
    </div>
    <div class="input-field" style="display: none;">
        <label for="branchName">Branch Name:</label>
        <input type="text" name="branchName" id="branchNameForOwner">
    </div>

    <div class="input-field2" style="display: none;">
        <label for="renterName">Renter Name:</label>
        <input type="text" name="renterName" id="renterName">
    </div>
    <div class="input-field2" style="display: none;">
        <label for="renterPhoneNumber">Renter Phone Number:</label>
        <input type="text" name="renterPhoneNumber" id="renterPhoneNumber">
    </div>
    
    
    <div id="leaseFields" style="display: none;">

    <label for="propertyNumber">Property Number:</label>
    <input type="text" id="propertyNumber" name="propertyNumber">

    <label for="tenantName">Renter Name:</label>
    <input type="text" id="tenantName" name="tenantName">
    
    <label for="homePhone">Home Phone:</label>
    <input type="tel" id="homePhone" name="homePhone">
    
    <label for="workPhone">Work Phone:</label>
    <input type="tel" id="workPhone" name="workPhone">
    
    <label for="startDate">Start Date:</label>
    <input type="date" id="startDate" name="startDate">
    
    <label for="endDate">End Date:</label>
    <input type="date" id="endDate" name="endDate">
    
    <label for="depositAmount">Deposit Amount:</label>
    <input type="number" id="depositAmount" name="depositAmount" step="0.01">
    
    <label for="monthlyRent">Monthly Rent:</label>
    <input type="number" id="monthlyRent" name="monthlyRent" step="0.01">
    
    <!-- Add more lease agreement input fields as needed -->
    </div>
    <input type="submit" value="Submit">
</form>
<div id="result"></div>
<div id="leaseDocumentContainer"></div>

</body>
</html>
