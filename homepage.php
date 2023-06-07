<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Strawberry Field - Rental Management Inc</title>
  
    <link rel="shortcut icon" href="images/logo.png">

    <link rel="stylesheet" href="css/bootstrap.min.css">
 
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <script>
        $(document).ready(function() {

            $("#propertiesAvl").click(function() {
            $('html,body').animate({
                scrollTop: $("#avlProperties").offset().top},
                'slow');
        });

        

        $('#branch').keydown(function (e) {
        console.log('hi')
        if (e.keyCode == 13) {
            var branchName = $('#branch').val();

            if (!branchName ) {
            alert('Please enter the Branch Mame');
            return;
            }

            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: { option: 'show_properties_available', branchName: branchName },
                dataType: 'json',
                success: function(response) {
                    var output = '';

                    if(response.length > 0){
                        output += '<div class="owner-details"; style="display:flex;flex-wrap:wrap;">';
                        response.forEach(function(property) {
                            output += '<div class="property-details" style="border: solid 2px #8b1726; margin:0px 50px 50px 0px;min-width:300px">';
                            output += '<p style="color:gray;font-weight:600;margin:5px 0;text-align:center">Supervisor: <span style="color:#8b1726;font-weight:bold">' +  property.name+ '</span></p>';
                            output += '<p style="color:gray;font-weight:600;text-align:center;margin:5px 0">Property Number: ' + property.propertyNumber + '</p>';
                            output += '<p style="color:gray;font-weight:600;text-align:center;margin:5px 0">Address: ' + property.street + '</p>';
                            output += '<p style="color:gray;font-weight:600;text-align:center;margin:5px 0">         ' + property.city +  ', ' + property.zip  + '</p>';
                            output += '<p style="color:gray;font-weight:600;text-align:center;margin:5px 0">Number of Rooms: ' + property.numRooms + '</p>';
                            output += '<p style="color:gray;font-weight:600;text-align:center;margin:5px 0">Monthly Rent: ' + property.monthlyRent + '</p>';
                            output += '<p style="color:gray;font-weight:600;text-align:center;margin:5px 0">Status: <span style="color:#8b1726;font-weight:bold">' + property.status + '</span></p>';
                            output += '<p style="color:gray;font-weight:600;text-align:center;margin:5px 0">Start Date: ' + property.startDate + '</p>';
                            output += '</div>';
                    });
                    output += '</div>';
                    } else {
                            output = '<p>No properties found.</p>';
                        }

                    
                    $('#availProps').html(output);
                },
                error: function(xhr, status, error) {
                    console.log('AJAX request failed. Error: ' + error);
                }
            });
        
        }
        });

        

        $("#createLease").click(function() {
            $('html,body').animate({
                scrollTop: $("#leaseCreation").offset().top},
                'slow');
        });

        $('#monthlyRent').keydown(function (e) {
       
            if (e.keyCode == 13) {
            var tenantName = $('#renterName').val();
            var propertyNumber = $('#propertyNumber').val();
            var homePhone = $('#homePhone').val();
            var workPhone = $('#workPhone').val();
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            var depositAmount = $('#depositAmount').val();
            var monthlyRent = $('#monthlyRent').val();
    

                if (!tenantName || !propertyNumber || !homePhone || !workPhone || !startDate || !depositAmount || !monthlyRent || !endDate) {
                alert('Please enter all the details for lease creation');
                return;
            }
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
                    option: 'create_lease_agreement',
                    leaseData: leaseData
                },
                dataType: 'json',
                success: function(response) {

                    var leaseDocument = '<div class="lease-agreement" style="border:solid 2px #8b1726">';
                    leaseDocument += '<h2>Lease Agreement</h2>';
                    leaseDocument += '<p class="section-heading" style="color:#8b1726">Tenant Information</p>';
                    leaseDocument += '<p><span class="sub-heading">Tenant Name:</span> ' + response.renterName + '</p>';
                    leaseDocument += '<p><span class="sub-heading">Property Number:</span> ' + response.propertyNumber + '</p>';
                    leaseDocument += '<p><span class="sub-heading">Home Phone:</span> ' + response.homePhone + '</p>';
                    leaseDocument += '<p><span class="sub-heading">Work Phone:</span> ' + response.workPhone + '</p>';
                    leaseDocument += '<p class="section-heading" style="color:#8b1726">Lease Details</p>';
                    leaseDocument += '<p><span class="sub-heading">Start Date:</span> ' + response.startDate + '</p>';
                    leaseDocument += '<p><span class="sub-heading">End Date:</span> ' + response.endDate + '</p>';
                    leaseDocument += '<p><span class="sub-heading">Deposit Amount:</span> ' + response.depositAmount + '</p>';
                    leaseDocument += '<p><span class="sub-heading">Monthly Rent:</span> ' + response.monthlyRent + '</p>';
                    leaseDocument += '<div class="additional-details">';
                    leaseDocument += '<p class="sub-heading" style="color:#8b1726">Additional Lease Agreement Details:</p>';
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

            

            }
        });

        $("#existingLease").click(function() {
            $('html,body').animate({
                scrollTop: $("#existingLeases").offset().top},
                'slow');
        });

        $('#renterLeaseName').keydown(function (e) {

            if (e.keyCode == 13) {
                var tenantName = $('#renterLeaseName').val();
                var renterPhoneNumber = $('#renterPhoneNumber').val();
                if (!tenantName ) {
                    alert('Please enter the renter name');
                    return;
                }

            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: {
                    option: 'show_lease',
                    renterName: tenantName,
                    renterPhoneNumber: renterPhoneNumber
                },
                dataType: 'json',
                success: function(response) {

                    
                    var leaseDocument = '';
                    for (var i = 0; i < response.length; i++) {
                        var lease = response[i];

                        leaseDocument += '<div class="lease-agreement" style="border:solid 2px #8b1726">';
                        leaseDocument += '<h2>Lease Agreement</h2>';
                        leaseDocument += '<p class="section-heading" style="color:#8b1726">Tenant Information</p>';
                        leaseDocument += '<p><span class="sub-heading">Tenant Name:</span> ' + lease.renterName + '</p>';
                        leaseDocument += '<p><span class="sub-heading">Property Number:</span> ' + lease.propertyNumber + '</p>';
                        leaseDocument += '<p><span class="sub-heading">Home Phone:</span> ' + lease.homePhone + '</p>';
                        leaseDocument += '<p><span class="sub-heading">Work Phone:</span> ' + lease.workPhone + '</p>';
                        leaseDocument += '<p class="section-heading" style="color:#8b1726">Lease Details</p>';
                        leaseDocument += '<p><span class="sub-heading">Start Date:</span> ' + lease.startDate + '</p>';
                        leaseDocument += '<p><span class="sub-heading">End Date:</span> ' + lease.endDate + '</p>';
                        leaseDocument += '<p><span class="sub-heading">Deposit Amount:</span> ' + lease.depositAmount + '</p>';
                        leaseDocument += '<p><span class="sub-heading">Monthly Rent:</span> ' + lease.monthlyRent + '</p>';
                        leaseDocument += '<div class="additional-details">';
                        leaseDocument += '<p class="sub-heading" style="color:#8b1726">Additional Lease Agreement Details</p>';
                        leaseDocument += '<p>... Additional lease agreement details ...</p>';
                        leaseDocument += '</div>';
                        leaseDocument += '</div>';
                        leaseDocument += '<hr>';
                    }

                    // Display the lease documents
                    $('#leaseDocumentsContainer').html(leaseDocument);
                    
                },
                error: function(xhr, status, error) {
                    console.log('AJAX request failed. Error: ' + error);
                }
            });
            }
        });

        

        $('#renterLeasePhoneNumber').keydown(function (e) {
            if (e.keyCode == 13) {
                var tenantName = $('#renterLeaseName').val();
                var renterPhoneNumber = $('#renterLeasePhoneNumber').val();
                if (!renterPhoneNumber ) {
                    alert('Please enter the Renter Phone Number');
                    return;
                }

            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: {
                    option: 'show_lease',
                    renterName: tenantName,
                    renterPhoneNumber: renterPhoneNumber
                },
                dataType: 'json',
                success: function(response) {

                    
                    var leaseDocument = '';
                    for (var i = 0; i < response.length; i++) {
                        var lease = response[i];

                        leaseDocument += '<div class="lease-agreement" style="border:solid 2px #8b1726">';
                        leaseDocument += '<h2>Lease Agreement</h2>';
                        leaseDocument += '<p class="section-heading" style="color:#8b1726">Tenant Information</p>';
                        leaseDocument += '<p><span class="sub-heading">Tenant Name:</span> ' + lease.renterName + '</p>';
                        leaseDocument += '<p><span class="sub-heading">Property Number:</span> ' + lease.propertyNumber + '</p>';
                        leaseDocument += '<p><span class="sub-heading">Home Phone:</span> ' + lease.homePhone + '</p>';
                        leaseDocument += '<p><span class="sub-heading">Work Phone:</span> ' + lease.workPhone + '</p>';
                        leaseDocument += '<p class="section-heading" style="color:#8b1726">Lease Details</p>';
                        leaseDocument += '<p><span class="sub-heading">Start Date:</span> ' + lease.startDate + '</p>';
                        leaseDocument += '<p><span class="sub-heading">End Date:</span> ' + lease.endDate + '</p>';
                        leaseDocument += '<p><span class="sub-heading">Deposit Amount:</span> ' + lease.depositAmount + '</p>';
                        leaseDocument += '<p><span class="sub-heading">Monthly Rent:</span> ' + lease.monthlyRent + '</p>';
                        leaseDocument += '<div class="additional-details">';
                        leaseDocument += '<p class="sub-heading" style="color:#8b1726">Additional Lease Agreement Details</p>';
                        leaseDocument += '<p>... Additional lease agreement details ...</p>';
                        leaseDocument += '</div>';
                        leaseDocument += '</div>';
                        leaseDocument += '<hr>';
                    }

                    // Display the lease documents
                    $('#leaseDocumentsContainer').html(leaseDocument);
                    
                },
                error: function(xhr, status, error) {
                    console.log('AJAX request failed. Error: ' + error);
                }
            });
            }
        });

        $("#propertyManagers").click(function() {
            $.ajax({
                    url: 'process.php',
                    type: 'POST',
                    data: { option: 'show_managers_supervisors_properties' },
                    dataType: 'json',
                    success: function(response) {
                        var output = '';
                        for (var i = 0; i < response.length; i++) {
                            var manager = response[i];
                            output += '<h3 style="color:gray">Manager: <span style="color:#8b1726">' + manager.manager_name + '</span></h3>';
                            output += '<ul style="display:flex;flex-wrap:wrap">';
                            for (var j = 0; j < manager.supervisors.length; j++) {
                                var supervisor = manager.supervisors[j];
                                output+= '<div style="border:solid 2px #8b1726;padding:10px;margin: 20px;background:#f9f9f9; padding: 10px;">'
                                output += '<li style="color:gray;font-weight:600;margin:5px 0">Supervisor: <span style="color:#8b1726;font-weight:bold">' + supervisor.supervisor_name + '</li>';
                                output += '<ul>';
                                output += '<li style="color:gray;font-weight:600;margin:5px 0;text-align:center">Property Number: ' + supervisor.property_number + '</li>';
                                output += '<li style="color:gray;font-weight:600;margin:5px 0;text-align:center">' + supervisor.street + ', </li>';
                                output += '<li style="color:gray;font-weight:600;margin:5px 0;text-align:center">' + supervisor.city + ', ' + supervisor.zip+ '</li>';
                                output += '</ul>';
                                output+= '</div>'
                            }
                            output += '</ul>';
                        }
                        $('#managerProps').html(output);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('An error occurred while fetching the data.');
                    }
                });

            $('html,body').animate({
                scrollTop: $("#managerProperties").offset().top},
                'slow');
        });

        $("#propertyOwner").click(function() {
            $('html,body').animate({
                scrollTop: $("#ownerProperties").offset().top},
                'slow');
        });

        $('#ownerBranch').keydown(function (e) {
            if (e.keyCode == 13) {
             var ownerName = $('#ownerName').val();
    
            var ownerPhoneNumber = $('#ownerPhoneNumber').val();
            var branchName = $('#ownerBranch').val();
                if (!ownerName || !ownerPhoneNumber || !branchName) {
                alert('Please enter all the details - Owner Name, Phone Number and Branch Number');
                return;
            }

            $.ajax({
                        url: 'process.php',
                        type: 'POST',
                        data: {
                            option: 'show_properties_by_owner',
                            ownerName: ownerName,
                            ownerPhoneNumber: ownerPhoneNumber,
                            branchName: branchName
                        },
                        dataType: 'json',
                        success: function(response) {
                        var output = '';

                        if (response.numProperties > 0) {
                            output += '<div class="owner-name">' + response.numProperties + ' Properties </div>';

                            output += '<div class="owner-details"; style="display:flex;">';

                            response.properties.forEach(function(property) {
                            output += '<div class="property-details" style="border: solid 2px #8b1726; margin:0px 50px 0px 0px;min-width:300px;flex-wrap:wrap;">';
                            output += '<p style="color:gray;font-weight:600;margin:5px 0;text-align:center">Supervisor: <span style="color:#8b1726;font-weight:bold">' +  property.name+ '</span></p>';
                            output += '<p style="color:gray;font-weight:600;text-align:center;margin:5px 0">Property Number: ' + property.propertyNumber + '</p>';
                            output += '<p style="color:gray;font-weight:600;text-align:center;margin:5px 0">Address: ' + property.street + '</p>';
                            output += '<p style="color:gray;font-weight:600;text-align:center;margin:5px 0">         ' + property.city +  ', ' + property.zip  + '</p>';
                            output += '<p style="color:gray;font-weight:600;text-align:center;margin:5px 0">Number of Rooms: ' + property.numRooms + '</p>';
                            output += '<p style="color:gray;font-weight:600;text-align:center;margin:5px 0">Monthly Rent: ' + property.monthlyRent + '</p>';
                            output += '<p style="color:gray;font-weight:600;text-align:center;margin:5px 0">Status: <span style="color:#8b1726;font-weight:bold">' + property.status + '</span></p>';
                            output += '<p style="color:gray;font-weight:600;text-align:center;margin:5px 0">Start Date: ' + property.startDate + '</p>';
                            output += '</div>';
                            });

                            output += '</div>';
                        } else {
                            output = '<p>No properties found.</p>';
                        }

                        $('#ownerProps').html(output);
                        },
                        error: function(xhr, status, error) {
                            console.log('AJAX request failed. Error: ' + error);
                        }
                    });

              
            }
        });


        $("#propertyBranch").click(function() {

            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: { option: 'show_available_properties_by_branch' },
                dataType: 'json',
                success: function(response) {
                    var output = '';
                    for (var branchName in response) {
                        if (response.hasOwnProperty(branchName)) {
                            var branchData = response[branchName];
                            var properties = branchData.properties;

                            output += '<h3 style="color:gray">Branch: <span style="color:#8b1726">' + branchName+ '</span></h3>';
                            output += '<div style="display:flex;flex-wrap:wrap">';
                            for (var i = 0; i < properties.length; i++) {
                                var property = properties[i];

                                output += '<div class="property" style="border:solid 2px #8b1726;padding:10px;margin: 20px;background:#f9f9f9;text-align:center; padding: 10px;min-width:300px;min-height:200px">';
                                output += '<p style="color:gray;font-weight:600;margin:5px 0">Supervisor: <span style="color:#8b1726">' + property.name + '</span></p>';
                                output += '<p style="color:gray;font-weight:600;margin:5px 0;text-align:center">Property Number: ' + property.property_number + '</p>';
                                output += '<p style="color:gray;font-weight:600;margin:5px 0;text-align:center">' + property.street + ', </p>';
                                output += '<p style="color:gray;font-weight:600;margin:5px 0;text-align:center">' + property.city + ', ' + property.zip+ '</p>';
                                output += '<p style="color:gray;font-weight:600;margin:5px 0;text-align:center">Number of Rooms: ' + property.num_rooms + '</p>';
                                output += '<p style="color:gray;font-weight:600;margin:5px 0;text-align:center">Monthly Rent: ' + property.monthly_rent + '</p>';
                                output += '<p style="color:gray;font-weight:600;margin:5px 0;text-align:center">Status: <span style="color:#8b1726">' + property.status + '</span></p>';
                                output += '<p style="color:gray;font-weight:600;margin:5px 0;text-align:center">Start Date: ' + property.start_date + '</p>';
                                
                                output += '</div>';
                            }
                            output += '</div>';
                        }
                    }
                    $('#branchProps').html(output);
                },
                error: function(xhr, status, error) {
                    console.log('AJAX request failed. Error: ' + error);
                }
            });

            $('html,body').animate({
                scrollTop: $("#branchProperties").offset().top},
                'slow');
        });

        $("#propertyCriteria").click(function() {
            $('html,body').animate({
                scrollTop: $("#criteraProperty").offset().top},
                'slow');
        });

        //---------------------------------------------------
        $('#maxRent').keydown(function (e) {
            if (e.keyCode == 13) {
                var city = $('#city').val();
                var numRooms = $('#numOfRooms').val();
                var minRent = $('#minRent').val();
                var maxRent = $('#maxRent').val();

                if (!city || !numRooms || !minRent || !maxRent) {
                alert('Please enter all the details - City, Rooms, Min & Max Rent');
                return;
            }

            $.ajax({
            url: 'process.php',
            type: 'POST',
            data: {option:'show_properties_by_criteria',city:city,numRooms:numRooms,minRent:minRent,maxRent:maxRent},
            dataType: 'json',
            success: function(response) {
                var properties = response; // Assuming response is an array of Property objects

                // Clear previous listings
                var propertyList = $('#criteriaProps');
                propertyList.empty();

                if (properties.length > 0) {
                    // Iterate over each property and create a listing
                    $.each(properties, function(index, property) {
                        var propertyItem = $('<div class="property-item" style="border:solid 2px #8b1726;padding:10px;margin: 20px;background:#f9f9f9;text-align:center; padding: 10px;min-width:250px;min-height:200px"></div>');

                        // Add property details to the listing
                        propertyItem.append('<p style="color:gray;font-weight:600;margin:5px 0">Supervisor : <span style="color:#8b1726">' + property.name + '</span></p>');
                        propertyItem.append('<p  style="color:gray;font-weight:600;margin:5px 0">Property Number: ' + property.propertyNumber + '</p>');
                        propertyItem.append('<p  style="color:gray;font-weight:600;margin:5px 0">Number of Rooms: ' + property.numRooms + '</p>');
                        propertyItem.append('<p  style="color:gray;font-weight:600;margin:5px 0">Rent: ' + property.monthlyRent + '</p>');
                        propertyItem.append('<p style="color:gray;font-weight:600;margin:5px 0">Address: ' + property.street + ', '  + property.zip  +'</p>');
                        propertyItem.append('<p  style="color:gray;font-weight:600;margin:5px 0">Status: <span style="color:#8b1726">' + property.status + '</span></p>');
                        propertyItem.append('<p  style="color:gray;font-weight:600;margin:5px 0">Start Date: ' + property.startDate + '</p>');
                        
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

            }
        });

        $("#propertyCity").click(function() {
            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: { option: 'show_available_properties_by_city' },
                dataType: 'json',
                success: function(response) {
                    // Parse the JSON data
                    var cityCounts = response;

                    // Display the city count list
                    var cityCountList = '';
                    for (var i = 0; i < cityCounts.length; i++) {
                        var cityCount = cityCounts[i];
                        cityCountList += '<li style="border:solid 2px #8b1726;min-width:150px;min-height:100px;padding 0 10px;margin:20px;padding-top:20px"> <span style="font-size:20px;font-weight:bold">' +  cityCount.count + '</span><br>' + cityCount.city + '</li>';
                    }
                    $('#cityProps').html('<ul style="display:flex;flex-wrap:wrap;text-align:center;">' + cityCountList + '</ul>');
                },
                error: function() {
                    // Handle error
                    $('#cityProps').html('<p>Error occurred. Please try again.</p>');
                }
            });

            $('html,body').animate({
                scrollTop: $("#cityProperties").offset().top},
                'slow');
        });
            
            
            $("#manyLeases").click(function() {
            $.ajax({
            url: "process.php",
            type: "POST",
            dataType: 'json',
            data: { option: 'show_renters_with_more_than_one_lease' },
            success: function(response) {
                $.each(response, function(renter_name, count) {
                        $('#multipleRents').append('<p><span style="font-weight:bold;color:#8b1726" >' + renter_name + ' </span> has <span style="font-weight:bold;color:#8b1726" > ' + count + '</span> Rental Properties'  + '</p>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log('AJAX request failed. Error: ' + error);
                }
        });

            $('html,body').animate({
                scrollTop: $("#multipleLease").offset().top},
                'slow');
        });



        $("#avgRent").click(function() {
            $('html,body').animate({
                scrollTop: $("#avgRentDisplay").offset().top},
                'slow');
        });

        

        $("#monthEarnings").click(function() {
            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: { option: 'calculate_agency_earnings_per_month' },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                    var earningsPerMonth = response.earningsPerMonth;

                    // Clear the existing content
                    $('#monthlyEarningTable').empty();

                    // Create the table headers
                    var tableHeaders = '<tr><th style="color:white;background:#8b1726;">Month</th><th style="color:white;background:#8b1726;">Earnings</th></tr>';

                    // Create the table rows with earnings data
                    var tableRows = '';
                    for (var key in earningsPerMonth) {
                    if (earningsPerMonth.hasOwnProperty(key)) {
                        var monthYear = key;
                        var earnings = parseFloat(earningsPerMonth[key]);

                        // Add the row with data
                        tableRows += '<tr><td <td style="color:black;font-weight:bold">' + monthYear + '</td><td <td style="color:black;font-weight:bold">' + earnings.toFixed(2) + '$</td></tr>';
                    }
                    }

                    // Combine headers and rows into a table
                    var earningsTable = '<table>' + tableHeaders + tableRows + '</table>';

                    // Append the table to the earningsTable div
                    $('#monthlyEarningTable').append(earningsTable);
                } else {
                    // Handle error response
                    $('#monthlyEarningTable').html('<p>Error: ' + response.message + '</p>');
                }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX request failed. Error: ' + error);
                }
            });

            $('html,body').animate({
                scrollTop: $("#monthlyEarning").offset().top},
                'slow');
        });
        

        $("#propComing").click(function() {
            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: { option: 'show_properties_availabe_in_2_months' },
                dataType: 'json',
                success: function(response) {
                    if (response.length > 0) {
                    var html = '<table><thead style="color:white"><tr><th style="background:#8b1726;">Name</th><th style="background:#8b1726;">Street</th><th style="background:#8b1726;">City</th><th style="background:#8b1726;">Zip</th></tr></thead><tbody>';
                    $.each(response, function(index, property) {
                        html += '<tr>';
                        html += '<td style="color:black;font-weight:bold">' + property.name + '</td>';
                        html += '<td style="color:black;font-weight:bold">' + property.street + '</td>';
                        html += '<td style="color:black;font-weight:bold">' + property.city + '</td>';
                        html += '<td style="color:black;font-weight:bold">' + property.zip + '</td>';
                        html += '</tr>';
                    });
                    html += '</tbody></table>';
                    $('#comingPropTable').html(html);
        } else {
            $('#result').html('<p>No properties found</p>');
        }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX request failed. Error: ' + error);
                }
            });

            $('html,body').animate({
                scrollTop: $("#comingProp").offset().top},
                'slow');

            
        });

        $('#cityName').keydown(function (e) {
            if (e.keyCode == 13) {
                var cityName = $('#cityName').val();
                if (!cityName) {
                alert('Please enter the name of the City');
                return;
            }
            console.log("calling ajax");
                $.ajax({
                    url: 'process.php',
                    type: 'POST',
                    data: { option: 'avg_rent_by_city', cityName: cityName },
                    dataType: 'json',
                    success: function(response) {
                        var averageRent = parseFloat(response);
                            if (!isNaN(averageRent)) {
                                var averageRentHTML = '<p>The average rent for managed properties in ' + cityName + ' is <span style="color:#8b1726;font-weight:bold">$' + averageRent.toFixed(2) + '.</p>';
                                $('#avgRentStats').html(averageRentHTML);
                            } else {
                                $('#avgRentStats').html('Unable to calculate the average rent for the given city: '+cityName);
                            }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX request failed. Error: ' + error);
                    }
                });
            }
        })

});

    </script>
</head>
<body id="home">
    <div class="body">
        <!-- HEADER -->
        <header>
            <nav class=" navbar-lg navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                    <a href="index.php" class="navbar-brand brand" ><img style="width:250px" src="images/logo2.png" alt="logo"></a> 
                    </div>

                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right navbar-login">
                            <li>
                                <a><i class="ilmosys-headphone"></i> 1-800-123-4567</a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown mm-menu">
                                <a class="page-scroll" href="homepage.php">Home</a>
                            </li>

                            <li class="dropdown mm-menu">
                                <a class="page-scroll" href="homepage.php">Properties</a>
                            </li>

                            <li class="dropdown mm-menu">
                                <a class="page-scroll" href="#contact-info">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <!-- INTRO -->
        <div class="intro intro15">
            <div class="container">
                <div class="row center-content">
                    

                        <div class="hl-container pull-right">
                        <div class="options">
                            <div class="tile" id="propertiesAvl" >Properties <br> Available</div>
                            <div class="tile" id="createLease">Create New <br> Lease</div>

                            <div class="tile" id="existingLease">Show Existing <br> Lease</div>
                            <div class="tile" id="manyLeases">>1 Lease <br> Renters</div>
                        </div>

                        <div class="options">
                        <div class="tile" id="propertyManagers">Properties <br> By Manager</div>
                        <div class="tile"  id="propertyOwner">Properties <br> By Owner</div>

                            <div class="tile" id="propertyBranch">Properties <br> By Branch</div>
                            <div class="tile" id="propertyCriteria">Properties <br> By Criteria</div>
                        </div>

                        <div class="options" >
                            <div class="tile" id="propertyCity">Properties <br> By City</div>
                            <div class="tile"  id="avgRent">Average Rent <br> by City</div>
                            <div class="tile" id="propComing">Properties  <br> Coming Soon!</div>
                            <div class="tile" id="monthEarnings"> Earnings <br> per Month</div>
                        </div>

                        
                        </div>
                </div>
            </div>
        </div>

<div class="bg-pattern">
<br>

<div class="container"  id="avlProperties">
            <div class="clearfix space90"></div>
            <div class="about-inline">
                <h3>— Properties Available</h3>
                <input class="cityName" name="senderName" id="branch" placeholder="Enter Branch" required type="text">
                <div id="availProps"></div>
            </div>
    </div>


<div class="container"  id="leaseCreation">
            <div class="clearfix space90"></div>
            <div class="about-inline">
                <h3>— Create New Lease</h3>
                <input class="cityName" name="senderName" id="propertyNumber" placeholder="Enter Property Number" required type="text">
                <input class="cityName" name="senderName" id="renterName" placeholder="Enter Renter Name" required type="text">
                <input class="cityName" name="senderName" id="homePhone" placeholder="Enter Home Phone" required type="tel">
                <input class="cityName" name="senderName" id="workPhone" placeholder="Enter Work Phone" required type="tel">
                <div style="display:flex;align-items:center"> <p style="width:100px;margin-top:-10px;font-size:14px;font-weight:700"; > Start Date </p> <input class="cityName" name="senderName" id="startDate" required type="date"></div>
                <div style="display:flex;align-items:center"> <p style="width:100px;margin-top:-10px;font-size:14px;font-weight:700"; > End Date </p> <input class="cityName" name="senderName" id="endDate" required type="date"></div>
                <input class="cityName" name="senderName" id="depositAmount" placeholder="Enter Deposit Amount" required type="number">
                <input class="cityName" name="senderName" id="monthlyRent" placeholder="Enter Monthly Rent" required type="number">
            </div>
            <div id="leaseDocumentContainer"></div>
    </div>

    <div class="container"  id="existingLeases">
            <div class="clearfix space90"></div>
            <div class="about-inline">
                <h3>— Show Existing Lease</h3>

                <input class="cityName" name="senderName" id="renterLeaseName" placeholder="Enter Renter Name" required type="text">
                <p style="text-align:center;margin-bottom:20px;color:#8b1726"><b>OR</b></p>
                <input class="cityName" name="senderName" id="renterLeasePhoneNumber" placeholder="Enter Renter Phone Number" required type="text">
            </div>

            <div id="leaseDocumentsContainer"></div>
    </div>

    <div class="container"  id="multipleLease">
            <div class="clearfix space90"></div>
            <div class="about-inline">
                <h3>— Multiple Lease Renters</h3>
                <div id="multipleRents"></div>
            </div>
    </div>

    <div class="container"  id="managerProperties">
            <div class="clearfix space90"></div>
            <div class="about-inline">
                <h3>— Properties By Manager</h3>
                <div id="managerProps"></div>
            </div>
    </div>

    <div class="container"  id="ownerProperties">
            <div class="clearfix space90"></div>
            <div class="about-inline">
                <h3>— Properties By Owner</h3>
                <input class="cityName" name="senderName" id="ownerName" placeholder="Enter Owner Name" required type="text">
                <input class="cityName" name="senderName" id="ownerPhoneNumber" placeholder="Enter Owner Phone Number" required type="text">
                <input class="cityName" name="senderName" id="ownerBranch" placeholder="Enter Owner Branch" required type="text">
                <div id="ownerProps"></div>
            </div>
    </div>

    <div class="container"  id="branchProperties">
            <div class="clearfix space90"></div>
            <div class="about-inline">
                <h3>— Properties By Branch</h3>
                <div id="branchProps"></div>
            </div>
    </div>
    

    <div class="container"  id="criteraProperty">
            <div class="clearfix space90"></div>
            <div class="about-inline">
                <h3>— Properties By Criteria</h3>
                <input class="cityName" name="senderName" id="city" placeholder="Enter City" required type="text">
                <input class="cityName" name="senderName" id="numOfRooms" placeholder="Enter Number of Rooms" required type="number">
                <input class="cityName" name="senderName" id="minRent" placeholder="Enter Min. Rent" required type="number">
                <input class="cityName" name="senderName" id="maxRent" placeholder="Enter Max. Rent" required type="number">
                <div id="criteriaProps"  style="display:flex;flex-wrap:wrap"></div>
            </div>
    </div>

    <div class="container"  id="cityProperties">
            <div class="clearfix space90"></div>
            <div class="about-inline">
                <h3>— Properties By City</h3>
                <div id="cityProps"></div>
            </div>
    </div>



    <div class="container"  id="avgRentDisplay">
            <div class="clearfix space90"></div>
            <div class="about-inline">
                <h3>— Average Rent By City </h3>
                    <input class="cityName" name="senderName" id="cityName" placeholder="Enter City" required type="text">
                <p id="avgRentStats"></p>
            </div>
    </div>


    <div class="container"  id="comingProp">
            <div class="clearfix space90"></div>
            <div class="about-inline">
                <h3>— Properties Coming Soon! </h3>
                <div id="comingPropTable"></div>
            </div>
    </div>

    <div class="container"  id="monthlyEarning">
            <div class="clearfix space90"></div>
            <div class="about-inline">
                <h3>— Earnings per Month </h3>
                <div id="monthlyEarningTable"></div>
            </div>
    </div>
    <div class="clear"></div>

    <!-- Copyright -->
    <div class="footer-copy">
        <div class="container">
            &copy; 2023. Strawberry Field. All rights reserved.
        </div>
    </div>
</div>
</body>
    

</html>
