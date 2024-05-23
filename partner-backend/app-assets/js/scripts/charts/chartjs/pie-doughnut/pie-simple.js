/*=========================================================================================
    File Name: pie.js
    Description: Chartjs pie chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.1
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Pie chart
// ------------------------------
$(window).on("load", function(){

    //Get the context of the Chart canvas element we want to select
    var ctx = $("#simple-pie-chart");

    // Chart Options
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
    };

    // Chart Data
    var Processing=$("#Processing").val();
    var Pending=$("#Pending").val();
    var Verified=$("#Verified").val();
    var Invalid=$("#Invalid").val();
    
    var chartData = {
        labels: ["Processing", "Pending", "Verified", "Invalid"],
        datasets: [{
            label: "Status for Leads",
            data: [Processing, Pending, Verified, Invalid],
            backgroundColor: ['#98ddca', '#ffaaa7', '#d5ecc2','#f8ede3'],
        }]
    };

    var config = {
        type: 'pie',

        // Chart Options
        options : chartOptions,

        data : chartData
    };

    // Create the chart
    var pieSimpleChart = new Chart(ctx, config);
	
	
	
	
	
	
	
    //Get the context of the Chart canvas element we want to select
    var ctx = $("#simple-pie-chart-2");

    // Chart Options
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
    };

    // Chart Data
    var Contact=$("#Contact").val();
    var RFP=$("#RFP").val();
    var POC=$("#POC").val();
    var Confirmed=$("#Confirmed").val();
    var Dropped=$("#Dropped").val();
    var chartData = {
        //labels: ["Contact", "RFP", "Assessment", "RFQ", "Audit", "POC", "Award", "Confirmed", "Dropped"],
        labels: ["Contact", "RFP", "POC", "Confirmed", "Dropped"],
        datasets: [{
            label: "Status for Projects",
            data: [Contact, RFP, POC, Confirmed, Dropped],
            backgroundColor: ['#98ddca', '#ffaaa7', '#8fd6e1', '#fc6a65', '#626262'],
        }]
    };

    var config = {
        type: 'pie',

        // Chart Options
        options : chartOptions,

        data : chartData
    };

    // Create the chart
    var pieSimpleChart = new Chart(ctx, config);
	
	
	
	
	
});