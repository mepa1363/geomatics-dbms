<?php
include('session_manager.php');
include('gatekeeper.php');
if (viewer_gatekeeper()) {
    header('Location: student_dashboard.php');
}

#Include the connect.php file
include('db_connect.php');
#Connect to the database
//connection String
$connect = mysql_connect($hostname, $username, $password)
or die('Could not connect: ' . mysql_error());
//Select The database
$bool = mysql_select_db($database, $connect);
if ($bool === False) {
    print "can't find $database";
}

//retrieve supervisors info
$data_supervisor = mysql_query('SELECT COUNT(id) AS num FROM supervisor_info') or die(mysql_error());
$row_supervisor = mysql_fetch_assoc($data_supervisor);
$supervisors_no = $row_supervisor['num'];

// get data and store in a json array
$query_supervisor = "SELECT * FROM supervisor_info";
$result_supervisor = mysql_query($query_supervisor) or die("SQL Error 1: " . mysql_error());
while ($row_supervisor = mysql_fetch_array($result_supervisor, MYSQL_ASSOC)) {
    $supervisors[] = array(
        'supervisor_id' => $row_supervisor['id'],
        'first_name' => $row_supervisor['first_name'],
        'last_name' => $row_supervisor['last_name']
    );
}

//retrieve students info
$query_student = "SELECT * FROM student_info WHERE id='" . $_GET['student_id'] . "'";

$result_student = mysql_query($query_student) or die("SQL Error 1: " . mysql_error());

while ($row = mysql_fetch_array($result_student, MYSQL_ASSOC)) {
    $student_info = array(
        'student_id' => $row['id'],
        'uc_id' => $row['student_id'],
        'first_name' => $row['first_name'],
        'last_name' => $row['last_name'],
        'gender' => $row['gender'],
        'study_type' => $row['study_type'],
        'supervisor_id' => $row['supervisor_id'],
        'cosupervisor_id' => $row['cosupervisor_id'],
        'degree_type' => $row['degree_type'],
        'status_in_canada' => $row['status_in_canada'],
        'start_date' => $row['start_date'],
        'research_stream' => $row['research_stream'],
        'appointment_of_supervisory_committee' => $row['appointment_of_supervisory_committee'],
        'sin_expiry' => $row['sin_expiry'],
        'email' => $row['email'],
        'office_location' => $row['office_location'],
        'office_tel' => $row['office_tel'],
        'fee_differential_return' => $row['fee_differential_return'],
        'msc_to_phd' => $row['msc_to_phd'],
        'entrance_gpa' => $row['entrance_gpa'],
        'final_gpa' => $row['final_gpa'],
        'course_requirements' => $row['course_requirements'],
        'course_requirement_completed' => $row['course_requirement_completed'],
        'engo605_presentation_complete' => $row['engo605_presentation_complete'],
        'engo607_presentation_complete' => $row['engo607_presentation_complete'],
        'engo609_presentation_complete' => $row['engo609_presentation_complete'],
        'major_awards' => $row['major_awards'],
        'fgs_award_date' => $row['fgs_award_date'],
        'fgs_award_amount' => $row['fgs_award_amount'],
        'travel_award_date' => $row['travel_award_date'],
        'travel_award_amount' => $row['travel_award_amount'],
        'travel_award_claim' => $row['travel_award_claim'],
        'technical_writing_complete' => $row['technical_writing_complete'],
        'engo_605_seminar_report_name' => $row['engo_605_seminar_report_name'],
        'engo_605_seminar_report_date' => $row['engo_605_seminar_report_date'],
        'engo_607_seminar_report_name' => $row['engo_607_seminar_report_name'],
        'engo_607_seminar_report_date' => $row['engo_607_seminar_report_date'],
        'engo_609_seminar_report_name' => $row['engo_609_seminar_report_name'],
        'engo_609_seminar_report_date' => $row['engo_609_seminar_report_date'],
        'thesis_proposal_approve' => $row['thesis_proposal_approve'],
        'candidacy_date' => $row['candidacy_date'],
        'defense_date' => $row['defense_date'],
        'expected_convocation' => $row['expected_convocation'],
        'province_country' => $row['province_country'],
        'last_degree' => $row['last_degree'],
        'end_date' => $row['end_date']
    );
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="shortcut icon" type="image/ico" href="images/favicon.ico"/>

<title>Update Form</title>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery.placeholder.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<style type="text/css">
    @import "css/demo_page.css";
    @import "css/demo_table.css";
    @import "css/demo_table_jui.css";
    @import "css/aristo.css";
    @import "css/style.css";
</style>
<link rel="stylesheet" type="text/css" href="style_template/style_template.css"/>
<link rel="stylesheet" type="text/css" href="css/calendar.css"/>

<script type="text/javascript" src="js/resources.js"></script>
<script type="text/javascript" src="js/config.js"></script>
<script type="text/javascript" src="js/calendar.min.js"></script>

<script>
$(function () {

    $('#contact').validate({
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: 'update_student_process.php',
                success: function (e) {
                    if (e.substring(0, 20) == 'SQL Error: Duplicate') {
                        window.scrollTo(0, 0);
                        $('#notification_error').fadeIn('medium').delay(2000).fadeOut('medium');
                    }
                    else {
                        window.scrollTo(0, 0);
                        $('#notification').fadeIn('medium').delay(2000).fadeOut('medium');
                    }
                }
            });
        }
    });
    <?php
    //major awards
    $major_awards = $student_info['major_awards'];
    $major_awards_array = explode(";", $major_awards);
    $major_awards_count = count($major_awards_array);

    //fgs awards
    $fgs_award_date = $student_info['fgs_award_date'];
    $fgs_award_date_array = explode(";", $fgs_award_date);
    $fgs_award_date_count = count($fgs_award_date_array);

    $fgs_award_amount = $student_info['fgs_award_amount'];
    $fgs_award_amount_array = explode(";", $fgs_award_amount);
    $fgs_award_amount_count = count($fgs_award_amount_array);

    $fgs_award_count = $fgs_award_date_count;
    if ($fgs_award_amount_count > $fgs_award_date_count) {
        $fgs_award_count = $fgs_award_amount_count;
    }

    //travel awards
    $travel_award_date = $student_info['travel_award_date'];
    $travel_award_date_array = explode(";", $travel_award_date);
    $travel_award_date_count = count($travel_award_date_array);

    $travel_award_amount = $student_info['travel_award_amount'];
    $travel_award_amount_array = explode(";", $travel_award_amount);
    $travel_award_amount_count = count($travel_award_amount_array);

    $travel_award_count = $travel_award_date_count;
    if ($travel_award_amount_count > $travel_award_date_count) {
        $travel_award_count = $travel_award_amount_count;
    }

    $travel_claim = $student_info['travel_award_claim'];
    $travel_claim_array = explode(";", $travel_claim);

    //engo605 reports
    $engo605_reports_date = $student_info['engo_605_seminar_report_date'];
    $engo605_reports_date_array = explode(";", $engo605_reports_date);
    $engo605_reports_date_count = count($engo605_reports_date_array);

    $engo605_reports_name = $student_info['engo_605_seminar_report_name'];
    $engo605_reports_name_array = explode(";", $engo605_reports_name);
    $engo605_reports_name_count = count($engo605_reports_name_array);

    $engo605_reports_count = $engo605_reports_date_count;
    if ($engo605_reports_name_count > $engo605_reports_date_count) {
        $engo605_reports_count = $engo605_reports_name_count;
    }

    //engo607 reports
    $engo607_reports_date = $student_info['engo_607_seminar_report_date'];
    $engo607_reports_date_array = explode(";", $engo607_reports_date);
    $engo607_reports_date_count = count($engo607_reports_date_array);

    $engo607_reports_name = $student_info['engo_607_seminar_report_name'];
    $engo607_reports_name_array = explode(";", $engo607_reports_name);
    $engo607_reports_name_count = count($engo607_reports_name_array);

    $engo607_reports_count = $engo607_reports_date_count;
    if ($engo607_reports_name_count > $engo607_reports_date_count) {
        $engo607_reports_count = $engo607_reports_name_count;
    }

    //engo609 reports
    $engo609_reports_date = $student_info['engo_609_seminar_report_date'];
    $engo609_reports_date_array = explode(";", $engo609_reports_date);
    $engo609_reports_date_count = count($engo609_reports_date_array);

    $engo609_reports_name = $student_info['engo_609_seminar_report_name'];
    $engo609_reports_name_array = explode(";", $engo609_reports_name);
    $engo609_reports_name_count = count($engo609_reports_name_array);

    $engo609_reports_count = $engo609_reports_date_count;
    if ($engo609_reports_name_count > $engo609_reports_date_count) {
        $engo609_reports_count = $engo609_reports_name_count;
    }
    ?>
    var major_award_counter = <?php echo $major_awards_count;?>;
    $('#major_awards_count').val(major_award_counter);
    $('#add_major_award').click(function () {
        major_award_counter++;
        $(document.createElement('input')).attr({type: 'text', id: 'major_award_' + major_award_counter, name: 'major_award_' + major_award_counter, placeholder: 'Alberta Ingenuity Award', style: 'display: block; width: 180px;', title: 'Enter the major awards held'}).appendTo('#major_awards_collection');
        $('#major_awards_count').val(major_award_counter);
    });

    $('#remove_major_award').click(function () {
        if (major_award_counter == 1) {
            $('#major_awards_count').val('1');
            $('#major_award_1').val('');
            return false;
        }
        $('#major_award_' + major_award_counter).remove();
        major_award_counter--;
        $('#major_awards_count').val(major_award_counter);
    });

    var fgs_award_counter = <?php echo $fgs_award_count;?>;
    $('#fgs_award_count').val(fgs_award_counter);
    $('#add_fgs_award').click(function () {
        fgs_award_counter++;
        $(document.createElement('div')).attr('id', 'fgs_award_' + fgs_award_counter).appendTo('#fgs_award_collection');
        $(document.createElement('input')).attr({type: 'text', id: 'fgs_award_amount_' + fgs_award_counter, name: 'fgs_award_amount_' + fgs_award_counter, placeholder: '800', style: 'width: 50px;', title: 'Enter the FGS awards amount'}).appendTo('#fgs_award_' + fgs_award_counter);
        $(document.createElement('input')).attr({type: 'text', id: 'fgs_award_date_' + fgs_award_counter, name: 'fgs_award_date_' + fgs_award_counter, placeholder: '2013-01-01', style: 'margin-left: 3px; width: 150px;', title: 'Enter the FGS awards date'}).appendTo('#fgs_award_' + fgs_award_counter);
        $(document.createElement('img')).attr({src: 'css/calendar.png', id: 'fgs_award_calendar_' + fgs_award_counter, name: 'fgs_award_calendar_' + fgs_award_counter, style: 'position:relative;top:2px;left:-22px;', onclick: 'javascript:createPopCalendar("fgs_award_date_' + fgs_award_counter + '","fgs_award_calendar_' + fgs_award_counter + '");'}).appendTo('#fgs_award_' + fgs_award_counter);
        $('#fgs_award_count').val(fgs_award_counter);
    });

    $('#remove_fgs_award').click(function () {
        if (fgs_award_counter == 1) {
            $('#fgs_award_count').val('1');
            $('#fgs_award_amount_1').val('');
            $('#fgs_award_date_1').val('');
            return false;
        }
        $('#fgs_award_' + fgs_award_counter).remove();
        fgs_award_counter--;
        $('#fgs_award_count').val(fgs_award_counter);
    });

    var travel_award_counter = <?php echo $travel_award_amount_count;?>;
    $('#travel_award_count').val(travel_award_counter);
    $('#add_travel_award').click(function () {
        travel_award_counter++;
        $(document.createElement('div')).attr('id', 'travel_award_' + travel_award_counter).appendTo('#travel_award_collection');
        $('#travel_award_' + travel_award_counter).append("<label for='travel_travel_award_" + travel_award_counter + "' style='display: inline-block'>Department Travel Award</label>");
        $(document.createElement('input')).attr({type: 'text', id: 'travel_award_amount_' + travel_award_counter, name: 'travel_award_amount_' + travel_award_counter, placeholder: '800', style: 'width: 50px;', title: 'Enter the travel awards amount'}).appendTo('#travel_award_' + travel_award_counter);
        $(document.createElement('input')).attr({type: 'text', id: 'travel_award_date_' + travel_award_counter, name: 'travel_award_date_' + travel_award_counter, placeholder: '2013-01-01', style: 'margin-left: 3px; width: 150px;', title: 'Enter the travel awards date'}).appendTo('#travel_award_' + travel_award_counter);
        $(document.createElement('img')).attr({src: 'css/calendar.png', id: 'travel_award_calendar_' + travel_award_counter, name: 'travel_award_calendar_' + travel_award_counter, style: 'position:relative;top:2px;left:-22px;', onclick: 'javascript:createPopCalendar("travel_award_date_' + travel_award_counter + '","travel_award_calendar_' + travel_award_counter + '");'}).appendTo('#travel_award_' + travel_award_counter);
        $('#travel_award_' + travel_award_counter).append("<br/>");
        $('#travel_award_' + travel_award_counter).append("<label for='travel_award_claim_" + travel_award_counter + "' style='display: inline-block'>Claim Submitted</label>");
        $('#travel_award_' + travel_award_counter).append("<input type='radio' name='travel_award_claim_" + travel_award_counter + "' style='margin-left: 20px' value='Yes'/> Yes");
        $('#travel_award_' + travel_award_counter).append("<input type='radio' name='travel_award_claim_" + travel_award_counter + "' style='margin-left: 20px' value='No' checked='checked'/> No");
        $('#travel_award_count').val(travel_award_counter);
    });

    $('#remove_travel_award').click(function () {
        if (travel_award_counter == 1) {
            $('#travel_award_count').val('1');
            $('#travel_award_amount_1').val('');
            $('#travel_award_date_1').val('');
            return false;
        }
        $('#travel_award_' + travel_award_counter).remove();
        travel_award_counter--;
        $('#travel_award_count').val(travel_award_counter);
    });

    var engo605_seminar_counter = <?php echo $engo605_reports_count;?>;
    $('#engo605_seminar_count').val(engo605_seminar_counter);
    $('#add_engo605_seminar').click(function () {
        engo605_seminar_counter++;
        if (engo605_seminar_counter >= 7) {
            return false;
        }
        $(document.createElement('div')).attr('id', 'engo605_seminar_' + engo605_seminar_counter).appendTo('#engo605_seminar_reports_collection');
        $(document.createElement('input')).attr({type: 'text', id: 'engo605_seminar_name_' + engo605_seminar_counter, name: 'engo605_seminar_name_' + engo605_seminar_counter, placeholder: 'Mike Coleman', style: 'width: 150px;', title: 'Enter the FGS awards amount'}).appendTo('#engo605_seminar_' + engo605_seminar_counter);
        $(document.createElement('input')).attr({type: 'text', id: 'engo605_seminar_date_' + engo605_seminar_counter, name: 'engo605_seminar_date_' + engo605_seminar_counter, placeholder: '2013-01-01', style: 'margin-left: 3px; width: 150px;', title: 'Enter the ENGO 605 presentation date'}).appendTo('#engo605_seminar_' + engo605_seminar_counter);
        $(document.createElement('img')).attr({src: 'css/calendar.png', id: 'engo605_seminar_calendar_' + engo605_seminar_counter, name: 'engo605_seminar_calendar_' + engo605_seminar_counter, style: 'position:relative;top:2px;left:-22px;', onclick: 'javascript:createPopCalendar("engo605_seminar_date_' + engo605_seminar_counter + '","engo605_seminar_calendar_' + engo605_seminar_counter + '");'}).appendTo('#engo605_seminar_' + engo605_seminar_counter);
        $('#engo605_seminar_count').val(engo605_seminar_counter);
    });

    $('#remove_engo605_seminar').click(function () {
        if (engo605_seminar_counter == 1) {
            $('#engo605_seminar_count').val('1');
            $('#engo605_seminar_name_1').val('');
            $('#engo605_seminar_date_1').val('');
            return false;
        }
        $('#engo605_seminar_' + engo605_seminar_counter).remove();
        engo605_seminar_counter--;
        $('#engo605_seminar_count').val(engo605_seminar_counter);
    });

    var engo607_seminar_counter = <?php echo $engo607_reports_count;?>;
    $('#engo607_seminar_count').val(engo607_seminar_counter);
    $('#add_engo607_seminar').click(function () {
        engo607_seminar_counter++;
        if (engo607_seminar_counter >= 7) {
            return false;
        }
        $(document.createElement('div')).attr('id', 'engo607_seminar_' + engo607_seminar_counter).appendTo('#engo607_seminar_reports_collection');
        $(document.createElement('input')).attr({type: 'text', id: 'engo607_seminar_name_' + engo607_seminar_counter, name: 'engo607_seminar_name_' + engo607_seminar_counter, placeholder: 'Mike Coleman', style: 'width: 150px;', title: 'Enter the FGS awards amount'}).appendTo('#engo607_seminar_' + engo607_seminar_counter);
        $(document.createElement('input')).attr({type: 'text', id: 'engo607_seminar_date_' + engo607_seminar_counter, name: 'engo607_seminar_date_' + engo607_seminar_counter, placeholder: '2013-01-01', style: 'margin-left: 3px; width: 150px;', title: 'Enter the ENGO 607 presentation date'}).appendTo('#engo607_seminar_' + engo607_seminar_counter);
        $(document.createElement('img')).attr({src: 'css/calendar.png', id: 'engo607_seminar_calendar_' + engo607_seminar_counter, name: 'engo607_seminar_calendar_' + engo607_seminar_counter, style: 'position:relative;top:2px;left:-22px;', onclick: 'javascript:createPopCalendar("engo607_seminar_date_' + engo607_seminar_counter + '","engo607_seminar_calendar_' + engo607_seminar_counter + '");'}).appendTo('#engo607_seminar_' + engo607_seminar_counter);
        $('#engo607_seminar_count').val(engo607_seminar_counter);
    });

    $('#remove_engo607_seminar').click(function () {
        if (engo607_seminar_counter == 1) {
            $('#engo607_seminar_count').val('1');
            $('#engo607_seminar_name_1').val('');
            $('#engo607_seminar_date_1').val('');
            return false;
        }
        $('#engo607_seminar_' + engo607_seminar_counter).remove();
        engo607_seminar_counter--;
        $('#engo607_seminar_count').val(engo607_seminar_counter);
    });

    var engo609_seminar_counter = <?php echo $engo609_reports_count;?>;
    $('#engo609_seminar_count').val(engo609_seminar_counter);
    $('#add_engo609_seminar').click(function () {
        engo609_seminar_counter++;
        if (engo609_seminar_counter >= 7) {
            return false;
        }
        $(document.createElement('div')).attr('id', 'engo609_seminar_' + engo609_seminar_counter).appendTo('#engo609_seminar_reports_collection');
        $(document.createElement('input')).attr({type: 'text', id: 'engo609_seminar_name_' + engo609_seminar_counter, name: 'engo609_seminar_name_' + engo609_seminar_counter, placeholder: 'Mike Coleman', style: 'width: 150px;', title: 'Enter the FGS awards amount'}).appendTo('#engo609_seminar_' + engo609_seminar_counter);
        $(document.createElement('input')).attr({type: 'text', id: 'engo609_seminar_date_' + engo609_seminar_counter, name: 'engo609_seminar_date_' + engo609_seminar_counter, placeholder: '2013-01-01', style: 'margin-left: 3px; width: 150px;', title: 'Enter the ENGO 609 presentation date'}).appendTo('#engo609_seminar_' + engo609_seminar_counter);
        $(document.createElement('img')).attr({src: 'css/calendar.png', id: 'engo609_seminar_calendar_' + engo609_seminar_counter, name: 'engo609_seminar_calendar_' + engo609_seminar_counter, style: 'position:relative;top:2px;left:-22px;', onclick: 'javascript:createPopCalendar("engo609_seminar_date_' + engo609_seminar_counter + '","engo609_seminar_calendar_' + engo609_seminar_counter + '");'}).appendTo('#engo609_seminar_' + engo609_seminar_counter);
        $('#engo609_seminar_count').val(engo609_seminar_counter);
    });

    $('#remove_engo609_seminar').click(function () {
        if (engo609_seminar_counter == 1) {
            $('#engo609_seminar_count').val('1');
            $('#engo609_seminar_name_1').val('');
            $('#engo609_seminar_date_1').val('');
            return false;
        }
        $('#engo609_seminar_' + engo609_seminar_counter).remove();
        engo609_seminar_counter--;
        $('#engo609_seminar_count').val(engo609_seminar_counter);
    });

});

function createPopCalendar(date, calendar) {
    var cal = new JSCalender.PopCalender(date, calendar);
    cal.setPrintFarmat("YYYY-MM-DD");
    cal.show();
}

function radioFunction(div, num) {
    if ($('#' + div).is(':visible') && num == 0) {
        $('#' + div).fadeOut('fast');
    } else if ($('#' + div).is(':hidden') && num == 1) {
        $('#' + div).fadeIn('fast');
    }
    //$('#course_date').fadeToggle('fast');
}

</script>
</head>

<body id="dt_example">

<div id="main">
<div id="header">
    <div id="logo">
        <img src="images/ucalgary2.png" style="width: 100px;">
        <img src="images/geoamtics2.png" style="width: 90px; position: relative; float: right; margin-top: 3px;">

        <div id="logo_text">
            <img src="images/logo6.png" style="height: 120px; margin-left: 0px;">
        </div>
    </div>
    <div id="menubar">
        <ul id="menu">
            <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
            <li class="selected"><a href="student_dashboard.php">Students</a></li>
            <? if (admin_gatekeeper()) {
                echo "<li><a href='faculty_dashboard.php'>Faculty Members</a></li>
                <li><a href='users_dashboard.php'>Users</a></li>
                <li><a href='ip_settings.php'>IPs</a></li>";
            }
            ?>
        </ul>
        <ul id="menu_logout">
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>
<div id="content_header"></div>
<div id="site_content">

<div id="content" style="width: 900px;">

<h1><a href="student_dashboard.php" class="breadcrumbs">Student Dashboard</a> > Update</h1>

<div id="contact-form">

<div id="notification" class="notification">
    <p style="margin: 10px; text-align: center;">Student information has been updated</p></div>

<div id="notification_error" class="notification_error">
    <p style="margin: 10px; text-align: center;">Error: this Student ID has already been registered</p></div>

<form id="contact" method="post" action="update_student_process.php">
<fieldset>
<input type="hidden" name="id" value="<?php echo $student_info['student_id'] ?>"/>

<label for="student_id">Student ID</label>
<input type="text" name="student_id" style="width:150px" value="<?php echo $student_info['uc_id'] ?>"
       title="Enter the Student ID#" class="required">

<label for="first_name">First Name</label>
<input type="text" name="first_name" value="<?php echo $student_info['first_name'] ?>" title="Enter the first name"
       pattern="^[A-Za-z .'-]+$" class="required">

<label for="last_name">Last Name</label>
<input type="text" name="last_name" value="<?php echo $student_info['last_name'] ?>" title="Enter the last name"
       pattern="^[A-Za-z .'-]+$" class="required">

<label for="gender">Gender</label>
<select name="gender">
    <option value="Male" <?php if ($student_info['gender'] == 'Male') {
        echo 'selected="selected"';
    } ?>>Male
    </option>
    <option value="Female" <?php if ($student_info['gender'] == 'Female') {
        echo 'selected="selected"';
    } ?>>Female
    </option>
</select>

<label for="study_type">Study Type</label>
<select name="study_type">
    <option value="Full-time" <?php if ($student_info['study_type'] == 'Full-time') {
        echo 'selected="selected"';
    } ?>>Full-time
    </option>
    <option value="Part-time" <?php if ($student_info['study_type'] == 'Part-time') {
        echo 'selected="selected"';
    } ?>>Part-time
    </option>
</select>

<label for="supervisor">Supervisor</label>
<select name="supervisor">
    <?php
    $i = 0;
    while ($i < $supervisors_no) {
        $supervisor_name = $supervisors[$i]['first_name'] . " " . $supervisors[$i]['last_name'];
        $select = "";
        if ($student_info['supervisor_id'] == $supervisor_name) {
            $select = 'selected="selected"';
        }
        echo "<option value='" . $supervisor_name . "' " . $select . ">" . $supervisor_name . "</option>";
        $i++;
    }
    ?>
</select>

<label for="co_supervisor">Co-Supervisor</label>
<select name="co_supervisor">
    <option value="">N/A</option>
    <?php
    $i = 0;
    while ($i < $supervisors_no) {
        $supervisor_name = $supervisors[$i]['first_name'] . " " . $supervisors[$i]['last_name'];
        $select = "";
        if ($student_info['cosupervisor_id'] == $supervisor_name) {
            $select = 'selected="selected"';
        }
        echo "<option value='" . $supervisor_name . "' " . $select . ">" . $supervisor_name . "</option>";
        $i++;
    }
    ?>
</select>

<label for="degree_type">Degree Type</label>
<select name="degree_type">
    <option value="MSc" <?php if ($student_info['degree_type'] == 'MSc') {
        echo 'selected="selected"';
    } ?>>MSc
    </option>
    <option value="PhD" <?php if ($student_info['degree_type'] == 'PhD') {
        echo 'selected="selected"';
    } ?>>PhD
    </option>
    <option value="MEng (Course-based)" <?php if ($student_info['degree_type'] == 'MEng (Course-based)') {
        echo 'selected="selected"';
    } ?>>MEng (Course-based)
    </option>
    <option value="MEng (Thesis-based)" <?php if ($student_info['degree_type'] == 'MEng (Thesis-based)') {
        echo 'selected="selected"';
    } ?>>MEng (Thesis-based)
    </option>
</select>

<label for="status_in_canada">Status in Canada</label>
<select name="status_in_canada">
    <option value="Visa" <?php if ($student_info['status_in_canada'] == 'Visa') {
        echo 'selected="selected"';
    } ?>>Visa
    </option>
    <option value="PR" <?php if ($student_info['status_in_canada'] == 'PR') {
        echo 'selected="selected"';
    } ?>>PR
    </option>
    <option value="Canadian" <?php if ($student_info['status_in_canada'] == 'Canadian') {
        echo 'selected="selected"';
    } ?>>Canadian
    </option>
</select>

<label for="original_start_date">Original Start Date</label>
<img src="css/calendar.png" id="original_start_calendar" style="position:relative;top:2px;left:145px;z-index: 1;"
     onclick="createPopCalendar('original_start_date','original_start_calendar');">
<input type="text" name="start_date" id="original_start_date" style="width:150px; position:relative;left:-20px;"
       value="<?php echo $student_info['start_date'] ?>"
       title="Enter the original start date" class="required">


<label for="research_stream">Research Stream</label>
<select name="research_stream">
    <option value="Earth Observation" <?php if ($student_info['research_stream'] == 'Earth Observation') {
        echo 'selected="selected"';
    } ?>>Earth Observation
    </option>
    <option
        value="Positioning, Navigation and Wireless Location" <?php if ($student_info['research_stream'] == 'Positioning, Navigation and Wireless Location') {
        echo 'selected="selected"';
    } ?>>Positioning, Navigation and Wireless
        Location
    </option>
    <option value="Digital Imaging" <?php if ($student_info['research_stream'] == 'Digital Imaging') {
        echo 'selected="selected"';
    } ?>>Digital Imaging
    </option>
    <option value="GIS and Land Tenure" <?php if ($student_info['research_stream'] == 'GIS and Land Tenure') {
        echo 'selected="selected"';
    } ?>>GIS and Land Tenure
    </option>
</select>

<label for="appointment_supervisory_committee">Appointment of Supervisory Committee</label>
<input type="radio" name="appointment_supervisory_committee"
       value="Yes" <?php if ($student_info['appointment_of_supervisory_committee'] == 'Yes') {
    echo 'checked="checked"';
} ?>/> Yes
<input type="radio" name="appointment_supervisory_committee" style="margin-left: 20px"
       value="No" <?php if ($student_info['appointment_of_supervisory_committee'] == 'No') {
    echo 'checked="checked"';
} ?>/> No

<label for="sin_expiry_date">SIN Expiry Date</label>
<img src="css/calendar.png" id="sin_calendar" style="position:relative;top:2px;left:145px;z-index: 1;"
     onclick="createPopCalendar('sin_date','sin_calendar');">
<input type="text" name="sin_expiry_date" id="sin_date" style="width:150px; position:relative;left:-20px;"
       value="<?php if ($student_info['sin_expiry'] == '0000-00-00') {
           echo '';
       } else {
           echo $student_info['sin_expiry'];
       } ?>"
       title="Enter the original start date">

<label for="email">Email</label>
<input type="email" name="email" value="<?php if ($student_info['email'] == 'NULL') {
    echo "";
} else {
    echo $student_info['email'];
} ?>" title="Enter the email address">

<label for="office_location">Office Location</label>
<input type="text" name="office_location" value="<?php if ($student_info['office_location'] == 'NULL') {
    echo "";
} else {
    echo $student_info['office_location'];
} ?>"
       title="Enter the office location">

<label for="office_tel">Office Telephone</label>
<input type="tel" name="office_tel" value="<?php if ($student_info['office_tel'] == 'NULL') {
    echo "";
} else {
    echo $student_info['office_tel'];
} ?>" title="Enter the office telephone"
       pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">

<label for="fee_differential_return">Fee Differential Return</label>
<input type="radio" name="fee_differential_return"
       value="Yes" <?php if ($student_info['fee_differential_return'] == 'Yes') {
    echo 'checked="checked"';
} ?>/> Yes
<input type="radio" name="fee_differential_return" style="margin-left: 20px"
       value="No" <?php if ($student_info['fee_differential_return'] == 'No') {
    echo 'checked="checked"';
} ?>/> No

<label for="transfer_msc_phd">Transfer from MSc to PhD</label>
<input type="radio" name="transfer_msc_phd" value="Yes" <?php if ($student_info['msc_to_phd'] == 'Yes') {
    echo 'checked="checked"';
} ?>/> Yes
<input type="radio" name="transfer_msc_phd" style="margin-left: 20px"
       value="No" <?php if ($student_info['msc_to_phd'] == 'No') {
    echo 'checked="checked"';
} ?>/> No

<label for="entrance_gpa">Entrance GPA</label>
<input type="text" name="entrance_gpa" value="<?php if ($student_info['entrance_gpa'] == 'NULL') {
    echo "";
} else {
    echo $student_info['entrance_gpa'];
} ?>" style="width: 50px;"
       title="Enter the GPA">

<label for="final_gpa">Final GPA</label>
<input type="text" name="final_gpa" value="<?php if ($student_info['final_gpa'] == 'NULL') {
    echo "";
} else {
    echo $student_info['final_gpa'];
} ?>" style="width: 50px;"
       title="Enter the GPA">

<label for="course_requirements">Course Requirements</label>
<select name="course_requirements">
    <option
        value="MEng 10 half-courses (at least 6 are graduate courses)" <?php if ($student_info['course_requirements'] == 'MEng 10 half-courses (at least 6 are graduate courses)') {
        echo 'selected="selected"';
    } ?>>MEng 10 half-courses (at least 6
        are graduate courses)
    </option>
    <option
        value="MSc 5 half-courses (at least 4 are graduate courses)" <?php if ($student_info['course_requirements'] == 'MSc 5 half-courses (at least 4 are graduate courses)') {
        echo 'selected="selected"';
    } ?>>MSc 5 half-courses (at least 4 are
        graduate courses)
    </option>
    <option
        value="PhD 3 graduate half-courses" <?php if ($student_info['course_requirements'] == 'PhD 3 graduate half-courses') {
        echo 'selected="selected"';
    } ?>>PhD: 3 graduate half-courses
    </option>
    <option
        value="PhD 2 graduate half-courses after transfer from MSc program (7 courses in total)" <?php if ($student_info['course_requirements'] == 'PhD 2 graduate half-courses after transfer from MSc program (7 courses in total)') {
        echo 'selected="selected"';
    } ?>>PhD: 2
        graduate half-courses after transfer from MSc program (7 courses in total)
    </option>
</select>

<label for="course_requirements_completed">Course Requirements Completed</label>
<input type="radio" name="course_requirements_completed" value="Yes"
       onclick="radioFunction('course_date',1);" <?php if ($student_info['course_requirement_completed'] != 'No') {
    echo 'checked="checked"';
} ?>/> Yes
<input type="radio" name="course_requirements_completed" style="margin-left: 20px" value="No"
       onclick="radioFunction('course_date',0);"  <?php if ($student_info['course_requirement_completed'] == 'No') {
    echo 'checked="checked"';
} ?>/> No

<?php
if ($student_info['course_requirement_completed'] != 'No') {
    $course_date = $student_info['course_requirement_completed'];
    echo "<div id='course_date'>";
    echo "<input type='text' name='course_requirements_completed_date' id='course_completed_date' value='$course_date' style='width:150px' title='Enter the course requirements completed date'>";
    echo "<img src='css/calendar.png' id='course_completed_calendar' style='position:relative;top:2px;left:-25px;' onclick=\"createPopCalendar('course_completed_date','course_completed_calendar');\">";
    echo "</div>";
} else {
    echo "<div id='course_date' style='display: none;'>";
    echo "<input type='text' name='course_requirements_completed_date' id='course_completed_date' placeholder='2013-01-01' style='width:150px' title='Enter the course requirements completed date'>";
    echo "<img src='css/calendar.png' id='course_completed_calendar' style='position:relative;top:2px;left:-25px;' onclick=\"createPopCalendar('course_completed_date','course_completed_calendar');\">";
    echo "</div>";
}
?>

<label for="engo605_complete">ENGO 605 Presentation Completed</label>
<input type="radio" name="engo605_complete" value="Yes"
       onclick="radioFunction('engo605_date', 1);" <?php if ($student_info['engo605_presentation_complete'] != 'No') {
    echo 'checked="checked"';
} ?>/> Yes

<input type="radio" name="engo605_complete" style="margin-left: 20px" value="No"
       onclick="radioFunction('engo605_date', 0);" <?php if ($student_info['engo605_presentation_complete'] == 'No') {
    echo 'checked="checked"';
} ?>/> No

<?php
if ($student_info['engo605_presentation_complete'] != 'No') {
    echo "<div id ='engo605_date' >";
    $engo605_presentation = explode(';', $student_info['engo605_presentation_complete']);
    $engo605_count = count($engo605_presentation);
    for ($i = 0; $i < $engo605_count; $i++) {
        echo "<input type = 'text' name = 'engo605_date' id = 'engo605_complete_date' style = 'width:150px' title = 'Enter the ENGO 605 presentation date' value = '$engo605_presentation[$i]' />";
        echo "<img src = 'css/calendar.png' id = 'engo605_completed_calendar' style = 'position:relative;top:2px;left:-25px;' onclick = \"createPopCalendar('engo605_complete_date','engo605_completed_calendar');\">";
    }
    echo "</div>";
} else {
    echo "<div id='engo605_date' style='display: none;'>";
    echo "<input type='text' name='engo605_date' id='engo605_complete_date' style='width:150px' title='Enter the ENGO 605 presentation date' placeholder='2013-01-01'/>";
    echo "<img src='css/calendar.png' id='engo605_completed_calendar' style='position:relative;top:2px;left:-25px;' onclick=\"createPopCalendar('engo605_complete_date','engo605_completed_calendar');\">";
    echo "</div>";
}
?>

<label for="engo607_complete">ENGO 607 Presentation Completed</label>
<input type="radio" name="engo607_complete" value="Yes"
       onclick="radioFunction('engo607_date',1);" <?php if ($student_info['engo607_presentation_complete'] != 'No') {
    echo 'checked="checked"';
} ?>/> Yes

<input type="radio" name="engo607_complete" style="margin-left: 20px" value="No"
       onclick="radioFunction('engo607_date',0);" <?php if ($student_info['engo607_presentation_complete'] == 'No') {
    echo 'checked="checked"';
} ?>/> No

<?php
if ($student_info['engo607_presentation_complete'] != 'No') {
    echo "<div id='engo607_date'>";
    $engo607_presentation = explode(';', $student_info['engo607_presentation_complete']);
    $engo607_count = count($engo607_presentation);
    for ($i = 0; $i < $engo607_count; $i++) {
        echo "<input type='text' name='engo607_date' id='engo607_complete_date' style='width:150px' title='Enter the ENGO 607 presentation date' value='$engo607_presentation[$i]' />";
        echo "<img src='css/calendar.png' id='engo607_completed_calendar' style='position:relative;top:2px;left:-25px;' onclick=\"createPopCalendar('engo607_complete_date','engo607_completed_calendar');\">";
    }
    echo "</div>";
} else {
    echo "<div id='engo607_date' style='display: none;'>";
    echo "<input type='text' name='engo607_date' id='engo607_complete_date' style='width:150px' title='Enter the ENGO 607 presentation date' placeholder='2013-01-01'/>";
    echo "<img src='css/calendar.png' id='engo607_completed_calendar' style='position:relative;top:2px;left:-25px;' onclick=\"createPopCalendar('engo607_complete_date','engo607_completed_calendar');\">";
    echo "</div>";
}
?>

<label for="engo609_complete">ENGO 609 Presentation Completed</label>
<input type="radio" name="engo609_complete" value="Yes"
       onclick="radioFunction('engo609_date',1);" <?php if ($student_info['engo609_presentation_complete'] != 'No') {
    echo 'checked="checked"';
} ?>/> Yes

<input type="radio" name="engo609_complete" style="margin-left: 20px" value="No"
       onclick="radioFunction('engo609_date',0);" <?php if ($student_info['engo609_presentation_complete'] == 'No') {
    echo 'checked="checked"';
} ?>/> No

<?php
if ($student_info['engo609_presentation_complete'] != 'No') {
    echo "<div id='engo609_date'>";
    $engo609_presentation = explode(';', $student_info['engo609_presentation_complete']);
    $engo609_count = count($engo609_presentation);
    for ($i = 0; $i < $engo609_count; $i++) {
        echo "<input type='text' name='engo609_date' id='engo609_complete_date' style='width:150px' title='Enter the ENGO 609 presentation date' value='$engo609_presentation[$i]' />";
        echo "<img src='css/calendar.png' id='engo609_completed_calendar' style='position:relative;top:2px;left:-25px;' onclick=\"createPopCalendar('engo609_complete_date','engo609_completed_calendar');\">";
    }
    echo "</div>";
} else {
    echo "<div id='engo609_date' style='display: none;'>";
    echo "<input type='text' name='engo609_date' id='engo609_complete_date' style='width:150px' title='Enter the ENGO 609 presentation date' placeholder='2013-01-01'/>";
    echo "<img src='css/calendar.png' id='engo609_completed_calendar' style='position:relative;top:2px;left:-25px;' onclick=\"createPopCalendar('engo609_complete_date','engo609_completed_calendar');\">";
    echo "</div>";
}
?>

<label for="major_awards">Major Awards Held</label>
<input type="hidden" id="major_awards_count" name="major_awards_count">

<?php
echo "<div id='major_awards_collection'>";
//$major_awards_count--;//because it is ++ at the top!
if ($major_awards_count == 1) {
    echo "<input type='text' name='major_award_1' id='major_award_1' placeholder='Alberta Ingenuity Award' value='$major_awards' style='width: 180px;' title='Enter the major awards held'>";
    echo "<img src='css/add.png' id='add_major_award' style='width: 20px;position:relative;top:5px; left: 2px;'>";
    echo "<img src='css/close.png' id='remove_major_award' style='width: 20px;position:relative;top:5px; left: 2px;'>";
} else if ($major_awards_count > 1) {
    echo "<input type='text' name='major_award_1' id='major_award_1' value='$major_awards_array[0]' style='width: 180px;' title='Enter the major awards held'>";
    echo "<img src='css/add.png' id='add_major_award' style='width: 20px;position:relative;top:5px; left: 2px;'>";
    echo "<img src='css/close.png' id='remove_major_award' style='width: 20px;position:relative;top:5px; left: 2px;'>";
    //echo "<br/>";
    for ($i = 1; $i < $major_awards_count; $i++) {
        $num = $i + 1;
        echo "<input type='text' name='major_award_$num' id='major_award_$num' value='$major_awards_array[$i]' style='width: 180px; display: block;' title='Enter the major awards held'>";
        //echo "<br/>";
    }
}
echo "</div>";
?>

<label for="fgs_award">Department FGS Award</label>
<input type='hidden' id='fgs_award_count' name='fgs_award_count' value='fgs_award_count'>

<?php
echo "<div id='fgs_award_collection' style='width: 400px;'>";
if ($fgs_award_count == 1) {
    echo "<div id='fgs_award_1'>";
    echo "<input type='text' name='fgs_award_amount_1' id='fgs_award_amount_1' style='width:50px' placeholder='800' value='$fgs_award_amount' title='Enter the FGS award amount'>";
    echo "<input type='text' name='fgs_award_date_1' id='fgs_award_date_1' style='width:150px; margin-left:3px;' placeholder='2013-01-01' value='$fgs_award_date' title='Enter the FGS award date'>";
    echo "<img src='css/calendar.png' id='fgs_award_calendar_1' style='position:relative;top:2px;left:-22px;' onclick=\"createPopCalendar('fgs_award_date_1','fgs_award_calendar_1');\">";
    echo "<img src='css/add.png' id='add_fgs_award' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "<img src='css/close.png' id='remove_fgs_award' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "</div>";
} else if ($fgs_award_count > 1) {
    echo "<div id='fgs_award_1'>";
    echo "<input type='text' name='fgs_award_amount_1' id='fgs_award_amount_1' style='width:50px' value='$fgs_award_amount_array[0]' title='Enter the FGS award amount'>";
    echo "<input type='text' name='fgs_award_date_1' id='fgs_award_date_1' style='width:150px; margin-left:3px;' value='$fgs_award_date_array[0]' title='Enter the FGS award date'>";
    echo "<img src='css/calendar.png' id='fgs_award_calendar_1' style='position:relative;top:2px;left:-22px;' onclick=\"createPopCalendar('fgs_award_date_1','fgs_award_calendar_1');\">";
    echo "<img src='css/add.png' id='add_fgs_award' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "<img src='css/close.png' id='remove_fgs_award' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "</div>";
    for ($i = 1; $i < $fgs_award_count; $i++) {
        $num = $i + 1;
        echo "<div id='fgs_award_$num'>";
        echo "<input type='text' name='fgs_award_amount_$num' id='fgs_award_amount_$num' style='width:50px;' value='$fgs_award_amount_array[$i]' title='Enter the FGS award amount'>";
        echo "<input type='text' name='fgs_award_date_$num' id='fgs_award_date_$num' style='width:150px; margin-left:3px;' value='$fgs_award_date_array[$i]' title='Enter the FGS award date'>";
        echo "<img src='css/calendar.png' id='fgs_award_calendar_$num' style='position:relative;top:2px;left:-22px;' onclick=\"createPopCalendar('fgs_award_date_$num','fgs_award_calendar_$num');\">";
        echo "</div>";
    }
}
echo "</div>";

?>


<label for="travel_award">Department Travel Award</label>
<input type="hidden" id="travel_award_count" name="travel_award_count">

<?php
echo "<div id='travel_award_collection' style='width: 400px;'>";
if ($travel_award_count == 1) {
    $checked_no = "";
    $checked_yes = "";
    echo "<div id='travel_award_1'>";
    echo "<input type='text' name='travel_award_amount_1' id='travel_award_amount_1' style='width:50px' placeholder='800' value='$travel_award_amount' title='Enter the travel award amount'>";
    echo "<input type='text' name='travel_award_date_1' id='travel_award_date_1' style='width:150px; margin-left:3px;' placeholder='2013-01-01' value='$travel_award_date' title='Enter the FGS award date'>";
    echo "<img src='css/calendar.png' id='travel_award_calendar_1' style='position:relative;top:2px;left:-22px;' onclick=\"createPopCalendar('travel_award_date_1','travel_award_calendar_1');\">";
    echo "<img src='css/add.png' id='add_travel_award' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "<img src='css/close.png' id='remove_travel_award' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo("<br/>");
    echo "<label for='travel_award_claim_1' style='display: inline-block;'>Claim Submitted</label>";
    if ($travel_claim_array[0] == 'Yes') {
        echo "<input type='radio' name='travel_award_claim_1' style='display: inline;margin-left: 20px;' value='Yes' checked='checked' /> Yes";
        echo "<input type='radio' name='travel_award_claim_1' style='display: inline;margin-left: 20px;' value='No' /> No";
    } else if ($travel_claim_array[0] == 'No') {
        echo "<input type='radio' name='travel_award_claim_1' style='display: inline;margin-left: 20px;' value='Yes' /> Yes";
        echo "<input type='radio' name='travel_award_claim_1' style='display: inline;margin-left: 20px;' value='No' checked='checked' /> No";
    } else {
        echo "<input type='radio' name='travel_award_claim_1' style='display: inline;margin-left: 20px;' value='Yes' /> Yes";
        echo "<input type='radio' name='travel_award_claim_1' style='display: inline;margin-left: 20px;' value='No'/> No";
    }
    echo "</div>";
} else if ($travel_award_count > 1) {
    echo "<div id='travel_award_1'>";
    echo "<input type='text' name='travel_award_amount_1' id='travel_award_amount_1' style='width:50px' value='$travel_award_amount_array[0]' title='Enter the travel award amount'>";
    echo "<input type='text' name='travel_award_date_1' id='travel_award_date_1' style='width:150px; margin-left:3px;' value='$travel_award_date_array[0]' title='Enter the travel award date'>";
    echo "<img src='css/calendar.png' id='travel_award_calendar_1' style='position:relative;top:2px;left:-22px;' onclick=\"createPopCalendar('travel_award_date_1','travel_award_calendar_1');\">";
    echo "<img src='css/add.png' id='add_travel_award' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "<img src='css/close.png' id='remove_travel_award' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo("<br/>");
    echo "<label for='travel_award_claim_1' style='display: inline-block;'>Claim Submitted</label>";
    if ($travel_claim_array[0] == 'Yes') {
        echo "<input type='radio' name='travel_award_claim_1' style='display: inline;margin-left: 20px;' value='Yes' checked='checked' /> Yes";
        echo "<input type='radio' name='travel_award_claim_1' style='display: inline;margin-left: 20px;' value='No' /> No";
    } else if ($travel_claim_array[0] == 'No') {
        echo "<input type='radio' name='travel_award_claim_1' style='display: inline;margin-left: 20px;' value='Yes' /> Yes";
        echo "<input type='radio' name='travel_award_claim_1' style='display: inline;margin-left: 20px;' value='No' checked='checked' /> No";
    }

    echo "</div>";
    for ($i = 1; $i < $travel_award_count; $i++) {
        $num = $i + 1;
        echo "<div id='travel_award_$num'>";
        echo "<input type='text' name='travel_award_amount_$num' id='travel_award_amount_$num' style='width:50px;' value='$travel_award_amount_array[$i]' title='Enter the travel award amount'>";
        echo "<input type='text' name='travel_award_date_$num' id='travel_award_date_$num' style='width:150px; margin-left:3px;' value='$travel_award_date_array[$i]' title='Enter the travel award date'>";
        echo "<img src='css/calendar.png' id='travel_award_calendar_$num' style='position:relative;top:2px;left:-22px;' onclick=\"createPopCalendar('travel_award_date_$num','travel_award_calendar_$num');\">";
        echo("<br/>");
        echo "<label for='travel_award_claim_$num' style='display: inline-block;'>Claim Submitted</label>";
        if ($travel_claim_array[$i] == 'Yes') {
            echo "<input type='radio' name='travel_award_claim_$num' style='display: inline;margin-left: 20px;' value='Yes' checked='checked' /> Yes";
            echo "<input type='radio' name='travel_award_claim_$num' style='display: inline;margin-left: 20px;' value='No' /> No";
        } else if ($travel_claim_array[$i] == 'No') {
            echo "<input type='radio' name='travel_award_claim_$num' style='display: inline;margin-left: 20px;' value='Yes' /> Yes";
            echo "<input type='radio' name='travel_award_claim_$num' style='display: inline;margin-left: 20px;' value='No' checked='checked' /> No";
        }
        echo "</div>";
    }
}
echo "</div>";

?>

<label for="technical_writing_completed">Technical Writing Course</label>
<input type="radio" name="writing_complete" value="Completed"
       onclick="radioFunction('writing_date',1);" <?php if ($student_info['technical_writing_complete'] != 'Waived' || $student_info['technical_writing_complete'] != 'N/A') {
    echo "checked='checked'";
} ?>/> Completed
<input type="radio" name="writing_complete" style="margin-left: 20px" value="Waived"
       onclick="radioFunction('writing_date',0);" <?php if ($student_info['technical_writing_complete'] == 'Waived') {
    echo "checked='checked'";
} ?>/> Waived
<input type="radio" name="writing_complete" style="margin-left: 20px" value="N/A"
       onclick="radioFunction('writing_date',0);" <?php if ($student_info['technical_writing_complete'] == 'N/A') {
    echo "checked='checked'";
} ?>/> N/A

<?php
if ($student_info['technical_writing_complete'] != 'Waived' && $student_info['technical_writing_complete'] != 'N/A') {
    $technical_writing_date = $student_info['technical_writing_complete'];
    //print_r($technical_writing_date);
    echo "<div id='writing_date'>";
    echo "<input type='text' name='technical_writing_completed' id='writing_complete_date' style='width:150px' value='$technical_writing_date' title='Enter the technical writing course completed date'>";
    echo "<img src='css/calendar.png' id='writing_calendar' style='position:relative;top:2px;left:-25px;' onclick = \"createPopCalendar('writing_complete_date','writing_calendar');\">";
    echo "</div>";
} else {
    echo "<div id='writing_date' style='display: none;'>";
    echo "<input type='text' name='technical_writing_completed' id='writing_complete_date' style='width:150px' placeholder='2013-01-01' title='Enter the technical writing course completed date'>";
    echo "<img src='css/calendar.png' id='writing_calendar' style='position:relative;top:2px;left:-25px;' onclick = \"createPopCalendar('writing_complete_date','writing_calendar');\">";
    echo "</div>";
}
?>

<label for="engo605_seminar_reports">ENGO 605 Seminar Reports</label>
<input type="hidden" id="engo605_seminar_count" name="engo605_seminar_count">

<?php
echo "<div id='engo605_seminar_reports_collection' style='width: 400px;'>";
if ($engo605_reports_count == 1) {
    echo "<div id='engo605_seminar_1'>";
    echo "<input type='text' name='engo605_seminar_name_1' id='engo605_seminar_name_1' style='width:150px' value='$engo605_reports_name' title='Enter the ENGO 605 seminar name'>";
    echo "<input type='text' name='engo605_seminar_date_1' id='engo605_seminar_date_1' style='width:150px; margin-left: 3px;' value='$engo605_reports_date' title='Enter the ENGO 605 seminar date'>";
    echo "<img src='css/calendar.png' id='engo605_seminar_calendar_1' style='position:relative;top:2px;left:-22px;' onclick=\"createPopCalendar('engo605_seminar_date_1','engo605_seminar_calendar_1');\">";
    echo "<img src='css/add.png' id='add_engo605_seminar' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "<img src='css/close.png' id='remove_engo605_seminar' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "</div>";
} else if ($engo605_reports_count > 1) {
    echo "<div id='engo605_seminar_1'>";
    echo "<input type='text' name='engo605_seminar_name_1' id='engo605_seminar_name_1' style='width:150px' value='$engo605_reports_name_array[0]' title='Enter the ENGO 605 seminar name'>";
    echo "<input type='text' name='engo605_seminar_date_1' id='engo605_seminar_date_1' style='width:150px; margin-left: 3px;' value='$engo605_reports_date_array[0]' title='Enter the ENGO 605 seminar date'>";
    echo "<img src='css/calendar.png' id='engo605_seminar_calendar_1' style='position:relative;top:2px;left:-22px;' onclick=\"createPopCalendar('engo605_seminar_date_1','engo605_seminar_calendar_1');\">";
    echo "<img src='css/add.png' id='add_engo605_seminar' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "<img src='css/close.png' id='remove_engo605_seminar' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "</div>";
    for ($i = 1; $i < $engo605_reports_count; $i++) {
        $num = $i + 1;
        echo "<div id='engo605_seminar_$num'>";
        echo "<input type='text' name='engo605_seminar_name_$num' id='engo605_seminar_name_$num' style='width:150px' value='$engo605_reports_name_array[$i]' title='Enter the ENGO 605 seminar name'>";
        echo "<input type='text' name='engo605_seminar_date_$num' id='engo605_seminar_date_$num' style='width:150px; margin-left: 3px;' value='$engo605_reports_date_array[$i]' title='Enter the ENGO 605 seminar date'>";
        echo "<img src='css/calendar.png' id='engo605_seminar_calendar_$num' style='position:relative;top:2px;left:-22px;' onclick=\"createPopCalendar('engo605_seminar_date_$num','engo605_seminar_calendar_$num');\">";
        echo "</div>";
    }
}
echo "</div>";

?>

<label for="engo607_seminar_reports">ENGO 607 Seminar Reports</label>
<input type="hidden" id="engo607_seminar_count" name="engo607_seminar_count">

<?php
echo "<div id='engo607_seminar_reports_collection' style='width: 400px;'>";
if ($engo607_reports_count == 1) {
    echo "<div id='engo607_seminar_1'>";
    echo "<input type='text' name='engo607_seminar_name_1' id='engo607_seminar_name_1' style='width:150px' value='$engo607_reports_name' title='Enter the ENGO 607 seminar name'>";
    echo "<input type='text' name='engo607_seminar_date_1' id='engo607_seminar_date_1' style='width:150px; margin-left: 3px;' value='$engo607_reports_date' title='Enter the ENGO 607 seminar date'>";
    echo "<img src='css/calendar.png' id='engo607_seminar_calendar_1' style='position:relative;top:2px;left:-22px;' onclick=\"createPopCalendar('engo607_seminar_date_1','engo607_seminar_calendar_1');\">";
    echo "<img src='css/add.png' id='add_engo607_seminar' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "<img src='css/close.png' id='remove_engo607_seminar' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "</div>";
} else if ($engo607_reports_count > 1) {
    echo "<div id='engo607_seminar_1'>";
    echo "<input type='text' name='engo607_seminar_name_1' id='engo607_seminar_name_1' style='width:150px' value='$engo607_reports_name_array[0]' title='Enter the ENGO 607 seminar name'>";
    echo "<input type='text' name='engo607_seminar_date_1' id='engo607_seminar_date_1' style='width:150px; margin-left: 3px;' value='$engo607_reports_date_array[0]' title='Enter the ENGO 607 seminar date'>";
    echo "<img src='css/calendar.png' id='engo607_seminar_calendar_1' style='position:relative;top:2px;left:-22px;' onclick=\"createPopCalendar('engo607_seminar_date_1','engo607_seminar_calendar_1');\">";
    echo "<img src='css/add.png' id='add_engo607_seminar' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "<img src='css/close.png' id='remove_engo607_seminar' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "</div>";
    for ($i = 1; $i < $engo607_reports_count; $i++) {
        $num = $i + 1;
        echo "<div id='engo607_seminar_$num'>";
        echo "<input type='text' name='engo607_seminar_name_$num' id='engo607_seminar_name_$num' style='width:150px' value='$engo607_reports_name_array[$i]' title='Enter the ENGO 607 seminar name'>";
        echo "<input type='text' name='engo607_seminar_date_$num' id='engo607_seminar_date_$num' style='width:150px; margin-left: 3px;' value='$engo607_reports_date_array[$i]' title='Enter the ENGO 607 seminar date'>";
        echo "<img src='css/calendar.png' id='engo607_seminar_calendar_$num' style='position:relative;top:2px;left:-22px;' onclick=\"createPopCalendar('engo607_seminar_date_$num','engo607_seminar_calendar_$num');\">";
        echo "</div>";
    }
}
echo "</div>";

?>

<label for="engo609_seminar_reports">ENGO 609 Seminar Reports</label>
<input type="hidden" id="engo609_seminar_count" name="engo609_seminar_count">

<?php
echo "<div id='engo609_seminar_reports_collection' style='width: 400px;'>";
if ($engo609_reports_count == 1) {
    echo "<div id='engo609_seminar_1'>";
    echo "<input type='text' name='engo609_seminar_name_1' id='engo609_seminar_name_1' style='width:150px' value='$engo609_reports_name' title='Enter the ENGO 609 seminar name'>";
    echo "<input type='text' name='engo609_seminar_date_1' id='engo609_seminar_date_1' style='width:150px; margin-left: 3px;' value='$engo609_reports_date' title='Enter the ENGO 609 seminar date'>";
    echo "<img src='css/calendar.png' id='engo609_seminar_calendar_1' style='position:relative;top:2px;left:-22px;' onclick=\"createPopCalendar('engo609_seminar_date_1','engo609_seminar_calendar_1');\">";
    echo "<img src='css/add.png' id='add_engo609_seminar' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "<img src='css/close.png' id='remove_engo609_seminar' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "</div>";
} else if ($engo609_reports_count > 1) {
    echo "<div id='engo609_seminar_1'>";
    echo "<input type='text' name='engo609_seminar_name_1' id='engo609_seminar_name_1' style='width:150px' value='$engo609_reports_name_array[0]' title='Enter the ENGO 609 seminar name'>";
    echo "<input type='text' name='engo609_seminar_date_1' id='engo609_seminar_date_1' style='width:150px; margin-left: 3px;' value='$engo609_reports_date_array[0]' title='Enter the ENGO 609 seminar date'>";
    echo "<img src='css/calendar.png' id='engo609_seminar_calendar_1' style='position:relative;top:2px;left:-22px;' onclick=\"createPopCalendar('engo609_seminar_date_1','engo609_seminar_calendar_1');\">";
    echo "<img src='css/add.png' id='add_engo609_seminar' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "<img src='css/close.png' id='remove_engo609_seminar' style='width: 20px;position:relative;top:5px; left: -10px;'>";
    echo "</div>";
    for ($i = 1; $i < $engo609_reports_count; $i++) {
        $num = $i + 1;
        echo "<div id='engo609_seminar_$num'>";
        echo "<input type='text' name='engo609_seminar_name_$num' id='engo609_seminar_name_$num' style='width:150px' value='$engo609_reports_name_array[$i]' title='Enter the ENGO 609 seminar name'>";
        echo "<input type='text' name='engo609_seminar_date_$num' id='engo609_seminar_date_$num' style='width:150px; margin-left: 3px;' value='$engo609_reports_date_array[$i]' title='Enter the ENGO 609 seminar date'>";
        echo "<img src='css/calendar.png' id='engo609_seminar_calendar_$num' style='position:relative;top:2px;left:-22px;' onclick=\"createPopCalendar('engo609_seminar_date_$num','engo609_seminar_calendar_$num');\">";
        echo "</div>";
    }
}
echo "</div>";

?>

<label for="thesis_approval">Thesis Proposal Approved</label>
<input type="radio" name="thesis_approved" value="Yes"
       onclick="radioFunction('approval_date',1);" <?php if ($student_info['thesis_proposal_approve'] != 'No' || $student_info['thesis_proposal_approve'] != 'N/A') {
    echo "checked='checked'";
} ?>/> Yes
<input type="radio" name="thesis_approved" style="margin-left: 20px" value="No"
       onclick="radioFunction('approval_date',0);" <?php if ($student_info['thesis_proposal_approve'] == 'No') {
    echo "checked='checked'";
} ?>/> No
<input type="radio" name="thesis_approved" style="margin-left: 20px" value="N/A"
       onclick="radioFunction('approval_date',0);" <?php if ($student_info['thesis_proposal_approve'] == 'N/A') {
    echo "checked='checked'";
} ?>/> N/A

<?php
if ($student_info['thesis_proposal_approve'] != 'No' && $student_info['thesis_proposal_approve'] != 'N/A') {
    $thesis_approval_date = $student_info['thesis_proposal_approve'];
    //print_r($technical_writing_date);
    echo "<div id='approval_date'>";
    echo "<input type='text' name='thesis_proposal_approved' id='thesis_approval_date' style='width:150px' value='$thesis_approval_date' title='Enter the thesis approval date'>";
    echo "<img src='css/calendar.png' id='thesis_approval_calendar' style='position:relative;top:2px;left:-25px;' onclick = \"createPopCalendar('thesis_approval_date','thesis_approval_calendar');\">";
    echo "</div>";
} else {
    echo "<div id='approval_date' style='display: none;'>";
    echo "<input type='text' name='thesis_proposal_approved' id='thesis_approval_date' style='width:150px' placeholder='2013-01-01' title='Enter the thesis approval date'>";
    echo "<img src='css/calendar.png' id='thesis_approval_calendar' style='position:relative;top:2px;left:-25px;' onclick = \"createPopCalendar('thesis_approval_date','thesis_approval_calendar');\">";
    echo "</div>";
}
?>

<label for="candidacy_exam">Candidacy Exam Date</label>
<input type="text" name="candidacy_exam_date" id="candidacy_exam_date" style="width:150px"
       value='<?php if ($student_info['candidacy_date'] == 'NULL') {
           echo "";
       } else {
           echo $student_info['candidacy_date'];
       } ?>'
       title="Enter the candidacy exam date">
<img src="css/calendar.png" id="candidacy_exam_calendar" style="position:relative;top:2px;left:-25px;"
     onclick="createPopCalendar('candidacy_exam_date','candidacy_exam_calendar');">

<label for="final_defense">Final Defense Date</label>
<input type="text" name="final_defense_date" id="final_defense_date" style="width:150px"
       value='<?php if ($student_info['defense_date'] == 'NULL') {
           echo "";
       } else {
           echo $student_info['defense_date'];
       } ?>'
       title="Enter the final defense date">
<img src="css/calendar.png" id="final_defense_calendar" style="position:relative;top:2px;left:-25px;"
     onclick="createPopCalendar('final_defense_date','final_defense_calendar');">

<label for="expected_convocation">Expected Convocation Date</label>
<input type="text" name="expected_convocation_date" id="expected_convocation_date" style="width:150px"
       value='<?php if ($student_info['expected_convocation'] == 'NULL') {
           echo "";
       } else {
           echo $student_info['expected_convocation'];
       } ?>'
       title="Enter the expected convocation date">
<img src="css/calendar.png" id="expected_convocation_calendar" style="position:relative;top:2px;left:-25px;"
     onclick="createPopCalendar('expected_convocation_date','expected_convocation_calendar');">

<label for="original_country">Original Province/Country</label>
<input type="text" name="original_country" value='<?php if ($student_info['province_country'] == 'NULL') {
    echo "";
} else {
    echo $student_info['province_country'];
} ?>'
       title="Enter the original province/country">

<label for="last_degree">Where Last Degree Obtained</label>
<input type="text" name="last_degree" value='<?php if ($student_info['last_degree'] == 'NULL') {
    echo "";
} else {
    echo $student_info['last_degree'];
} ?>'
       title="Enter where last degree obtained">

<label for="end_date">End Date</label>
<input type="text" name="end_date" id="end_date" style="width:150px"
       value='<?php if ($student_info['end_date'] == null) {
           echo "";
       } else {
           echo $student_info['end_date'];
       } ?>'
       title="Enter the end date">
<img src="css/calendar.png" id="end_date_calendar" style="position:relative;top:2px;left:-25px;"
     onclick="createPopCalendar('end_date','end_date_calendar');">

<br/>
<input type="submit" name="submit" class="button" id="submit" value="Update Student" style="margin: 50px 0 0 150px;"/>

</fieldset>
</form>
</div>
<!-- /end #contact-form -->

</div>
</div>
</div>
<div id="content_footer"></div>
<div id="footer">
    <p><a href='student_dashboard.php'>Students</a>
        <? if (admin_gatekeeper()) {
            echo " | <a href='faculty_dashboard.php'>Faculty Members</a> | <a href='users_dashboard.php' > Users</a > | <a href = 'ip_settings.php' > IPs</a>";
        }
        ?>
    </p>

    <p>Copyright &copy; department of geomatics engineering 2012</p>
</div>
<script src="js/modernizr-min.js"></script>
<script>
    if (!Modernizr.input.placeholder) {
        $('input[placeholder], textarea[placeholder]').placeholder();
    }
</script>
</body>
</html>