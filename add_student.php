<?php
include('session_manager.php');
include('gatekeeper.php');

if (!admin_gatekeeper()) {
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

$data = mysql_query('SELECT COUNT(id) AS num FROM supervisor_info') or die(mysql_error());
$row = mysql_fetch_assoc($data);
$supervisors_no = $row['num'];

// get data and store in a json array
$query = "SELECT * FROM supervisor_info";
$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $supervisors[] = array(
        'supervisor_id' => $row['id'],
        'first_name' => $row['first_name'],
        'last_name' => $row['last_name']
    );
}


//print_r($supervisors['0']['name']);
//print_r($supervisors_no);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link rel="shortcut icon" type="image/ico" href="images/favicon.ico"/>

<title>Add Student Form</title>
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


<script type="text/javascript">
    $(function () {

        $('#contact').validate({
            submitHandler:function (form) {
                $(form).ajaxSubmit({
                    url:'add_student_process.php',
                    success:function (e) {
                        //$('#contact').hide();
                        //$('#contact-form').append("<p class='thanks'>Thanks! Your message has been sent.</p>")
                        if (e.substring(0, 20) == 'SQL Error: Duplicate') {
                            window.scrollTo(0, 0);
                            $('#notification_error').fadeIn('medium').delay(2000).fadeOut('medium');
                        }
                        else {
                            window.scrollTo(0, 0);
                            $('#notification').fadeIn('medium').delay(2000).fadeOut('medium');
                            $('#contact').find(':input').each(function () {
                                switch (this.type) {
                                    case 'password':
                                    case 'select-multiple':
                                    case 'select-one':
                                    case 'text':
                                    case 'textarea':
                                    case 'email':
                                    case 'tel':
                                        $(this).val('');
                                        break;
                                    case 'checkbox':
                                    case 'radio':
                                    //this.checked = false;
                                }
                            });
                        }
                    }
                });
            }
        });

        var major_award_counter = 2;
        $('#major_awards_count').val('1');
        $('#add_major_award').click(function () {
            $(document.createElement('input')).attr({type:'text', id:'major_award_' + major_award_counter, name:'major_award_' + major_award_counter, placeholder:'Alberta Ingenuity Award', style:'display: block; width: 180px;', title:'Enter the major awards held'}).appendTo('#major_awards_collection');
            major_award_counter++;
            $('#major_awards_count').val(major_award_counter);
        });

        $('#remove_major_award').click(function () {
            if (major_award_counter == 1) {
                $('#major_awards_count').val('1');
                return false;
            }
            major_award_counter--;
            $('#major_award_' + major_award_counter).remove();
            $('#major_awards_count').val(major_award_counter);
        });

        var fgs_award_counter = 2;
        $('#fgs_award_count').val('1');
        $('#add_fgs_award').click(function () {
            $(document.createElement('div')).attr('id', 'fgs_award_' + fgs_award_counter).appendTo('#fgs_award_collection');
            $(document.createElement('input')).attr({type:'text', id:'fgs_award_amount_' + fgs_award_counter, name:'fgs_award_amount_' + fgs_award_counter, placeholder:'800', style:'width: 50px;', title:'Enter the FGS awards amount'}).appendTo('#fgs_award_' + fgs_award_counter);
            $(document.createElement('input')).attr({type:'text', id:'fgs_award_date_' + fgs_award_counter, name:'fgs_award_date_' + fgs_award_counter, placeholder:'01-01-2013', style:'margin-left: 3px; width: 150px;', title:'Enter the FGS awards date'}).appendTo('#fgs_award_' + fgs_award_counter);
            $(document.createElement('img')).attr({src:'css/calendar.png', id:'fgs_award_calendar_' + fgs_award_counter, name:'fgs_award_calendar_' + fgs_award_counter, style:'position:relative;top:2px;left:-22px;', onclick:'javascript:createPopCalendar("fgs_award_date_' + fgs_award_counter + '","fgs_award_calendar_' + fgs_award_counter + '");'}).appendTo('#fgs_award_' + fgs_award_counter);
            fgs_award_counter++;
            $('#fgs_award_count').val(fgs_award_counter);
        });

        $('#remove_fgs_award').click(function () {
            if (fgs_award_counter == 1) {
                $('#fgs_award_count').val('1');
                return false;
            }
            fgs_award_counter--;
            $('#fgs_award_' + fgs_award_counter).remove();
            $('#fgs_award_count').val(fgs_award_counter);
        });

        var travel_award_counter = 2;
        $('#travel_award_count').val('1');
        $('#add_travel_award').click(function () {
            $(document.createElement('div')).attr('id', 'travel_award_' + travel_award_counter).appendTo('#travel_award_collection');
            $('#travel_award_' + travel_award_counter).append("<label for='travel_travel_award_" + travel_award_counter + "' style='display: inline-block'>Department Travel Award</label>");
            $(document.createElement('input')).attr({type:'text', id:'travel_award_amount_' + travel_award_counter, name:'travel_award_amount_' + travel_award_counter, placeholder:'800', style:'width: 50px;', title:'Enter the travel awards amount'}).appendTo('#travel_award_' + travel_award_counter);
            $(document.createElement('input')).attr({type:'text', id:'travel_award_date_' + travel_award_counter, name:'travel_award_date_' + travel_award_counter, placeholder:'01-01-2013', style:'margin-left: 3px; width: 150px;', title:'Enter the travel awards date'}).appendTo('#travel_award_' + travel_award_counter);
            $(document.createElement('img')).attr({src:'css/calendar.png', id:'travel_award_calendar_' + travel_award_counter, name:'travel_award_calendar_' + travel_award_counter, style:'position:relative;top:2px;left:-22px;', onclick:'javascript:createPopCalendar("travel_award_date_' + travel_award_counter + '","travel_award_calendar_' + travel_award_counter + '");'}).appendTo('#travel_award_' + travel_award_counter);
            $('#travel_award_' + travel_award_counter).append("<br/>");
            $('#travel_award_' + travel_award_counter).append("<label for='travel_award_claim_" + travel_award_counter + "' style='display: inline-block'>Claim Submitted</label>");
            $('#travel_award_' + travel_award_counter).append("<input type='radio' name='travel_award_claim_" + travel_award_counter + "' style='margin-left: 20px' value='Yes'/> Yes");
            $('#travel_award_' + travel_award_counter).append("<input type='radio' name='travel_award_claim_" + travel_award_counter + "' style='margin-left: 20px' value='No' checked='checked'/> No");
            travel_award_counter++;
            $('#travel_award_count').val(travel_award_counter);
        });

        $('#remove_travel_award').click(function () {
            if (travel_award_counter == 1) {
                $('#travel_award_count').val('1');
                return false;
            }
            travel_award_counter--;
            $('#travel_award_' + travel_award_counter).remove();
            $('#travel_award_count').val(travel_award_counter);
        });

        var engo605_seminar_counter = 2;
        $('#engo605_seminar_count').val('1');
        $('#add_engo605_seminar').click(function () {
            if (engo605_seminar_counter == 7) {
                return false;
            }
            $(document.createElement('div')).attr('id', 'engo605_seminar_' + engo605_seminar_counter).appendTo('#engo605_seminar_reports_collection');
            $(document.createElement('input')).attr({type:'text', id:'engo605_seminar_name_' + engo605_seminar_counter, name:'engo605_seminar_name_' + engo605_seminar_counter, placeholder:'Mike Coleman', style:'width: 150px;', title:'Enter the FGS awards amount'}).appendTo('#engo605_seminar_' + engo605_seminar_counter);
            $(document.createElement('input')).attr({type:'text', id:'engo605_seminar_date_' + engo605_seminar_counter, name:'engo605_seminar_date_' + engo605_seminar_counter, placeholder:'01-01-2013', style:'margin-left: 3px; width: 150px;', title:'Enter the ENGO 605 presentation date'}).appendTo('#engo605_seminar_' + engo605_seminar_counter);
            $(document.createElement('img')).attr({src:'css/calendar.png', id:'engo605_seminar_calendar_' + engo605_seminar_counter, name:'engo605_seminar_calendar_' + engo605_seminar_counter, style:'position:relative;top:2px;left:-22px;', onclick:'javascript:createPopCalendar("engo605_seminar_date_' + engo605_seminar_counter + '","engo605_seminar_calendar_' + engo605_seminar_counter + '");'}).appendTo('#engo605_seminar_' + engo605_seminar_counter);
            engo605_seminar_counter++;
            $('#engo605_seminar_count').val(engo605_seminar_counter);
        });

        $('#remove_engo605_seminar').click(function () {
            if (engo605_seminar_counter == 1) {
                $('#engo605_seminar_count').val('1');
                return false;
            }
            engo605_seminar_counter--;
            $('#engo605_seminar_' + engo605_seminar_counter).remove();
            $('#engo605_seminar_count').val(engo605_seminar_counter);
        });

        var engo607_seminar_counter = 2;
        $('#engo607_seminar_count').val('1');
        $('#add_engo607_seminar').click(function () {
            if (engo607_seminar_counter == 7) {
                return false;
            }
            $(document.createElement('div')).attr('id', 'engo607_seminar_' + engo607_seminar_counter).appendTo('#engo607_seminar_reports_collection');
            $(document.createElement('input')).attr({type:'text', id:'engo607_seminar_name_' + engo607_seminar_counter, name:'engo607_seminar_name_' + engo607_seminar_counter, placeholder:'Mike Coleman', style:'width: 150px;', title:'Enter the FGS awards amount'}).appendTo('#engo607_seminar_' + engo607_seminar_counter);
            $(document.createElement('input')).attr({type:'text', id:'engo607_seminar_date_' + engo607_seminar_counter, name:'engo607_seminar_date_' + engo607_seminar_counter, placeholder:'01-01-2013', style:'margin-left: 3px; width: 150px;', title:'Enter the ENGO 607 presentation date'}).appendTo('#engo607_seminar_' + engo607_seminar_counter);
            $(document.createElement('img')).attr({src:'css/calendar.png', id:'engo607_seminar_calendar_' + engo607_seminar_counter, name:'engo607_seminar_calendar_' + engo607_seminar_counter, style:'position:relative;top:2px;left:-22px;', onclick:'javascript:createPopCalendar("engo607_seminar_date_' + engo607_seminar_counter + '","engo607_seminar_calendar_' + engo607_seminar_counter + '");'}).appendTo('#engo607_seminar_' + engo607_seminar_counter);
            engo607_seminar_counter++;
            $('#engo607_seminar_count').val(engo607_seminar_counter);
        });

        $('#remove_engo607_seminar').click(function () {
            if (engo607_seminar_counter == 1) {
                return false;
                $('#engo607_seminar_count').val('1');
            }
            engo607_seminar_counter--;
            $('#engo607_seminar_' + engo607_seminar_counter).remove();
            $('#engo607_seminar_count').val(engo607_seminar_counter);
        });

        var engo609_seminar_counter = 2;
        $('#engo609_seminar_count').val('1');
        $('#add_engo609_seminar').click(function () {
            if (engo609_seminar_counter == 7) {
                return false;
            }
            $(document.createElement('div')).attr('id', 'engo609_seminar_' + engo609_seminar_counter).appendTo('#engo609_seminar_reports_collection');
            $(document.createElement('input')).attr({type:'text', id:'engo609_seminar_name_' + engo609_seminar_counter, name:'engo609_seminar_name_' + engo609_seminar_counter, placeholder:'Mike Coleman', style:'width: 150px;', title:'Enter the FGS awards amount'}).appendTo('#engo609_seminar_' + engo609_seminar_counter);
            $(document.createElement('input')).attr({type:'text', id:'engo609_seminar_date_' + engo609_seminar_counter, name:'engo609_seminar_date_' + engo609_seminar_counter, placeholder:'01-01-2013', style:'margin-left: 3px; width: 150px;', title:'Enter the ENGO 609 presentation date'}).appendTo('#engo609_seminar_' + engo609_seminar_counter);
            $(document.createElement('img')).attr({src:'css/calendar.png', id:'engo609_seminar_calendar_' + engo609_seminar_counter, name:'engo609_seminar_calendar_' + engo609_seminar_counter, style:'position:relative;top:2px;left:-22px;', onclick:'javascript:createPopCalendar("engo609_seminar_date_' + engo609_seminar_counter + '","engo609_seminar_calendar_' + engo609_seminar_counter + '");'}).appendTo('#engo609_seminar_' + engo609_seminar_counter);
            engo609_seminar_counter++;
            $('#engo609_seminar_count').val(engo609_seminar_counter);
        });

        $('#remove_engo609_seminar').click(function () {
            if (engo609_seminar_counter == 1) {
                $('#engo609_seminar_count').val('1');
                return false;
            }
            engo609_seminar_counter--;
            $('#engo609_seminar_' + engo609_seminar_counter).remove();
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
            <li><a href='faculty_dashboard.php'>Faculty Members</a></li>
            <li><a href='users_dashboard.php'>Users</a></li>
            <li><a href='ip_settings.php'>IPs</a></li>
        </ul>
        <ul id="menu_logout">
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>
<div id="content_header"></div>
<div id="site_content">

<div id="content" style="width: 900px;">

<h1><a href="student_dashboard.php" class="breadcrumbs">Student
    Dashboard</a> > Add</h1>

<div id="contact-form">

<div id="notification" class="notification">
    <p style="margin: 10px; text-align: center;">New student has been added</p></div>

<div id="notification_error" class="notification_error">
    <p style="margin: 10px; text-align: center;">Error: this Student ID has already been registered</p></div>

<form id="contact" method="post" action="add_student_process.php">
<fieldset>

<label for="student_id">Student ID</label>
<input type="text" name="student_id" style="width:150px" placeholder="10089974"
       title="Enter the student ID#" class="required">

<label for="first_name">First Name</label>
<input type="text" name="first_name" placeholder="Mike" title="Enter the first name"
       pattern="^[A-Za-z .'-]+$" class="required">

<label for="last_name">Last Name</label>
<input type="text" name="last_name" placeholder="Barry" title="Enter the last name"
       pattern="^[A-Za-z .'-]+$" class="required">

<label for="gender">Gender</label>
<select name="gender">
    <option value="Male">Male</option>
    <option value="Female">Female</option>
</select>

<label for="study_type">Study Type</label>
<select name="study_type">
    <option value="Full-time">Full-time</option>
    <option value="Part-time">Part-time</option>
</select>

<label for="supervisor">Supervisor</label>
<select name="supervisor">
    <?php
    $i = 0;
    while ($i < $supervisors_no) {
        echo "<option value='" . $supervisors[$i]['first_name'] . " " . $supervisors[$i]['last_name'] . "'>" . $supervisors[$i]['first_name'] . " " . $supervisors[$i]['last_name'] . "</option>";
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
        echo "<option value='" . $supervisors[$i]['first_name'] . " " . $supervisors[$i]['last_name'] . "'>" . $supervisors[$i]['first_name'] . " " . $supervisors[$i]['last_name'] . "</option>";
        $i++;
    }
    ?>
</select>

<label for="degree_type">Degree Type</label>
<select name="degree_type">
    <option value="MSc">MSc</option>
    <option value="PhD">PhD</option>
    <option value="MEng (Course-based)">MEng (Course-based)</option>
    <option value="MEng (Thesis-based)">MEng (Thesis-based)</option>
</select>

<label for="status_in_canada">Status in Canada</label>
<select name="status_in_canada">
    <option value="Visa">Visa</option>
    <option value="PR">PR</option>
    <option value="Canadian">Canadian</option>
</select>

<label for="original_start_date">Original Start Date</label>
<img src="css/calendar.png" id="original_start_calendar" style="position:relative;top:2px;left:145px;z-index: 1;"
     onclick="createPopCalendar('original_start_date','original_start_calendar');">
<input type="text" name="original_start_date" id="original_start_date" style="width:150px; position:relative;left:-20px;"
       placeholder="2012-09-01"
       title="Enter the original start date" class="required">



<label for="research_stream">Research Stream</label>
<select name="research_stream">
    <option value="Earth Observation">Earth Observation</option>
    <option value="Positioning, Navigation and Wireless Location">Positioning, Navigation and Wireless
        Location
    </option>
    <option value="Digital Imaging">Digital Imaging</option>
    <option value="GIS and Land Tenure">GIS and Land Tenure</option>
</select>

<label for="appointment_supervisory_committee">Appointment of Supervisory Committee</label>
<input type="radio" name="appointment_supervisory_committee" value="Yes"/> Yes
<input type="radio" name="appointment_supervisory_committee" style="margin-left: 20px" value="No" checked="checked"/> No

<label for="sin_expiry_date">SIN Expiry Date</label>
<img src="css/calendar.png" id="sin_calendar" style="position:relative;top:2px;left:145px;z-index: 1;"
     onclick="createPopCalendar('sin_date','sin_calendar');">
<input type="text" name="sin_expiry_date" id="sin_date" style="width:150px; position:relative;left:-20px;"
       placeholder="01-01-2013"
       title="Enter the SIN expiry date">


<label for="email">Email</label>
<input type="email" name="email" placeholder="user@domain.com" title="Enter the email address">

<label for="office_location">Office Location</label>
<input type="text" name="office_location" placeholder="Trailer H" title="Enter the office location">

<label for="office_tel">Office Telephone</label>
<input type="tel" name="office_tel" placeholder="222-222-2222" title="Enter the office telephone"
       pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">

<label for="fee_differential_return">Fee Differential Return</label>
<input type="radio" name="fee_differential_return" value="Yes"/> Yes
<input type="radio" name="fee_differential_return" style="margin-left: 20px" value="No" checked="checked"/> No

<label for="transfer_msc_phd">Transfer from MSc to PhD</label>
<input type="radio" name="transfer_msc_phd" value="Yes"/> Yes
<input type="radio" name="transfer_msc_phd" style="margin-left: 20px" value="No" checked="checked"/> No

<label for="entrance_gpa">Entrance GPA</label>
<input type="text" name="entrance_gpa" placeholder="3.7" style="width: 50px;" title="Enter the GPA">

<label for="final_gpa">Final GPA</label>
<input type="text" name="final_gpa" placeholder="3.75" style="width: 50px;" title="Enter the GPA">

<label for="course_requirements">Course Requirements</label>
<select name="course_requirements">
    <option value="MEng 10 half-courses (at least 6 are graduate courses)">MEng 10 half-courses (at least 6
        are graduate courses)
    </option>
    <option value="MSc 5 half-courses (at least 4 are graduate courses)">MSc 5 half-courses (at least 4 are
        graduate courses)
    </option>
    <option value="PhD 3 graduate half-courses">PhD: 3 graduate half-courses</option>
    <option value="PhD 2 graduate half-courses after transfer from MSc program (7 courses in total)">PhD: 2
        graduate half-courses after transfer from MSc program (7 courses in total)
    </option>
</select>

<label for="course_requirements_completed">Course Requirements Completed</label>
<input type="radio" name="course_requirements_completed" value="Yes"
       onclick="radioFunction('course_date',1);"/> Yes
<input type="radio" name="course_requirements_completed" style="margin-left: 20px" value="No"
       onclick="radioFunction('course_date',0);" checked="checked"/> No

<div id='course_date' style="display: none;">
    <input type="text" name="course_requirements_completed_date" id="course_completed_date"
           style="width:150px"
           placeholder="01-01-2013"
           title="Enter the course requirements completed date">
    <img src="css/calendar.png" id="course_completed_calendar" style="position:relative;top:2px;left:-25px;"
         onclick="createPopCalendar('course_completed_date','course_completed_calendar');">
</div>

<label for="engo605_complete">ENGO 605 Presentation Completed</label>
<input type="radio" name="engo605_complete" value="Yes"
       onclick="radioFunction('engo605_date',1);"/> Yes
<input type="radio" name="engo605_complete" style="margin-left: 20px" value="No"
       onclick="radioFunction('engo605_date',0);" checked="checked"/> No

<div id='engo605_date' style="display: none;">
    <input type="text" name="engo605_date" id="engo605_complete_date"
           style="width:150px"
           placeholder="01-01-2013"
           title="Enter the ENGO 605 presentation date">
    <img src="css/calendar.png" id="engo605_completed_calendar"
         style="position:relative;top:2px;left:-25px;"
         onclick="createPopCalendar('engo605_complete_date','engo605_completed_calendar');">
</div>

<label for="engo607_complete">ENGO 607 Presentation Completed</label>
<input type="radio" name="engo607_complete" value="Yes"
       onclick="radioFunction('engo607_date',1);"/> Yes
<input type="radio" name="engo607_complete" style="margin-left: 20px" value="No"
       onclick="radioFunction('engo607_date',0);" checked="checked"/> No

<div id='engo607_date' style="display: none;">
    <input type="text" name="engo607_date" id="engo607_complete_date"
           style="width:150px"
           placeholder="01-01-2013"
           title="Enter the ENGO 607 presentation date">
    <img src="css/calendar.png" id="engo607_completed_calendar"
         style="position:relative;top:2px;left:-25px;"
         onclick="createPopCalendar('engo607_complete_date','engo607_completed_calendar');">
</div>

<label for="engo609_complete">ENGO 609 Presentation Completed</label>
<input type="radio" name="engo609_complete" value="Yes"
       onclick="radioFunction('engo609_date',1);"/> Yes
<input type="radio" name="engo609_complete" style="margin-left: 20px" value="No"
       onclick="radioFunction('engo609_date',0);" checked="checked"> No

<div id='engo609_date' style="display: none;">
    <input type="text" name="engo609_date" id="engo609_complete_date"
           style="width:150px"
           placeholder="01-01-2013"
           title="Enter the ENGO 609 presentation date">
    <img src="css/calendar.png" id="engo609_completed_calendar"
         style="position:relative;top:2px;left:-25px;"
         onclick="createPopCalendar('engo609_complete_date','engo609_completed_calendar');">
</div>

<label for="major_awards">Major Awards Held</label>
<input type="hidden" id="major_awards_count" name="major_awards_count">

<div id="major_awards_collection">
    <input type="text" name="major_award_1" placeholder="Alberta Ingenuity Award" style="width: 180px;"
           title="Enter the major awards held">
    <img src="css/add.png" id="add_major_award" style="width: 20px;position:relative;top:5px; left: 2px;">
    <img src="css/close.png" id="remove_major_award" style="width: 20px;position:relative;top:5px; left: 2px;">
</div>

<label for="fgs_award">Department FGS Award</label>
<input type="hidden" id="fgs_award_count" name="fgs_award_count">

<div id="fgs_award_collection" style="width: 400px;">
    <input type="text" name="fgs_award_amount_1" style="width:50px" placeholder="800"
           title="Enter the FGS award amount">
    <input type="text" name="fgs_award_date_1" id="fgs_award_date_1"
           style="width:150px"
           placeholder="01-01-2013"
           title="Enter the FGS award date">
    <img src="css/calendar.png" id="fgs_award_calendar_1"
         style="position:relative;top:2px;left:-25px;"
         onclick="createPopCalendar('fgs_award_date_1','fgs_award_calendar_1');">
    <img src="css/add.png" id="add_fgs_award" style="width: 20px;position:relative;top:5px; left: -18px;">
    <img src="css/close.png" id="remove_fgs_award" style="width: 20px;position:relative;top:5px; left: -18px;">
</div>

<label for="travel_award">Department Travel Award</label>
<input type="hidden" id="travel_award_count" name="travel_award_count">

<div id="travel_award_collection" style="width: 400px;">
    <input type="text" name="travel_award_amount_1" style="width:50px" placeholder="800"
           title="Enter the travel award amount">
    <input type="text" name="travel_award_date_1" id="travel_award_date_1"
           style="width:150px"
           placeholder="01-01-2013"
           title="Enter the travel award date">
    <img src="css/calendar.png" id="travel_award_calendar_1"
         style="position:relative;top:2px;left:-25px;"
         onclick="createPopCalendar('travel_award_date_1','travel_award_calendar_1');">
    <img src="css/add.png" id="add_travel_award" style="width: 20px;position:relative;top:5px; left: -18px;">
    <img src="css/close.png" id="remove_travel_award" style="width: 20px;position:relative;top:5px; left: -18px;">
    <br/>
    <label for="travel_award_claim_1" style="display: inline-block;">Claim Submitted</label>
    <input type="radio" name="travel_award_claim_1" style="display: inline;margin-left: 20px;" value="Yes"/> Yes
    <input type="radio" name="travel_award_claim_1" style="display: inline;margin-left: 20px;" value="No"
           checked="checked"/> No
</div>

<label for="technical_writing_completed">Technical Writing Course</label>
<input type="radio" name="writing_complete" value="Completed"
       onclick="radioFunction('writing_date',1);"/> Completed
<input type="radio" name="writing_complete" style="margin-left: 20px" value="Waived"
       onclick="radioFunction('writing_date',0);"/> Waived
<input type="radio" name="writing_complete" style="margin-left: 20px" value="Waived"
       onclick="radioFunction('writing_date',0);" checked="checked"/> N/A

<div id='writing_date' style="display: none;">
    <input type="text" name="technical_writing_completed" id="writing_complete_date" style="width:150px"
           placeholder="01-01-2013"
           title="Enter the technical writing course completed date">
    <img src="css/calendar.png" id="writing_calendar" style="position:relative;top:2px;left:-25px;"
         onclick="createPopCalendar('writing_complete_date','writing_calendar');">
</div>

<label for="engo605_seminar_reports">ENGO 605 Seminar Reports</label>
<input type="hidden" id="engo605_seminar_count" name="engo605_seminar_count">

<div id="engo605_seminar_reports_collection" style="width: 450px;">
    <input type="text" name="engo605_seminar_name_1" style="width:150px" placeholder="Mike Coleman"
           title="Enter the ENGO 605 seminar name">
    <input type="text" name="engo605_seminar_date_1" id="engo605_seminar_date_1"
           style="width:150px"
           placeholder="01-01-2013"
           title="Enter the ENGO 605 seminar date">
    <img src="css/calendar.png" id="engo605_seminar_calendar_1"
         style="position:relative;top:2px;left:-25px;"
         onclick="createPopCalendar('engo605_seminar_date_1','engo605_seminar_calendar_1');">
    <img src="css/add.png" id="add_engo605_seminar" style="width: 20px;position:relative;top:5px; left: -18px;">
    <img src="css/close.png" id="remove_engo605_seminar" style="width: 20px;position:relative;top:5px; left: -18px;">
</div>

<label for="engo607_seminar_reports">ENGO 607 Seminar Reports</label>
<input type="hidden" id="engo607_seminar_count" name="engo607_seminar_count">

<div id="engo607_seminar_reports_collection" style="width: 450px;">
    <input type="text" name="engo607_seminar_name_1" style="width:150px" placeholder="Mike Coleman"
           title="Enter the ENGO 607 seminar name">
    <input type="text" name="engo607_seminar_date_1" id="engo607_seminar_date_1"
           style="width:150px"
           placeholder="01-01-2013"
           title="Enter the ENGO 607 seminar date">
    <img src="css/calendar.png" id="engo607_seminar_calendar_1"
         style="position:relative;top:2px;left:-25px;"
         onclick="createPopCalendar('engo607_seminar_date_1','engo607_seminar_calendar_1');">
    <img src="css/add.png" id="add_engo607_seminar" style="width: 20px;position:relative;top:5px; left: -18px;">
    <img src="css/close.png" id="remove_engo607_seminar" style="width: 20px;position:relative;top:5px; left: -18px;">
</div>

<label for="engo609_seminar_reports">ENGO 609 Seminar Reports</label>
<input type="hidden" id="engo609_seminar_count" name="engo609_seminar_count">

<div id="engo609_seminar_reports_collection" style="width: 450px;">
    <input type="text" name="engo609_seminar_name_1" style="width:150px" placeholder="Mike Coleman"
           title="Enter the ENGO 609 seminar name">
    <input type="text" name="engo609_seminar_date_1" id="engo609_seminar_date_1"
           style="width:150px"
           placeholder="01-01-2013"
           title="Enter the ENGO 609 seminar date">
    <img src="css/calendar.png" id="engo609_seminar_calendar_1"
         style="position:relative;top:2px;left:-25px;"
         onclick="createPopCalendar('engo609_seminar_date_1','engo609_seminar_calendar_1');">
    <img src="css/add.png" id="add_engo609_seminar" style="width: 20px;position:relative;top:5px; left: -18px;">
    <img src="css/close.png" id="remove_engo609_seminar" style="width: 20px;position:relative;top:5px; left: -18px;">
</div>

<label for="thesis_approval">Thesis Proposal Approved</label>
<input type="radio" name="thesis_approved" value="Yes"
       onclick="radioFunction('approval_date',1);"/> Yes
<input type="radio" name="thesis_approved" style="margin-left: 20px" value="No"
       onclick="radioFunction('approval_date',0);"/> No
<input type="radio" name="thesis_approved" style="margin-left: 20px" value="N/A"
       onclick="radioFunction('approval_date',0);" checked="checked"/> N/A

<div id='approval_date' style="display: none;">
    <input type="text" name="thesis_proposal_approved" id="thesis_approval_date" style="width:150px"
           placeholder="01-01-2013"
           title="Enter the thesis approval date">
    <img src="css/calendar.png" id="thesis_approval_calendar" style="position:relative;top:2px;left:-25px;"
         onclick="createPopCalendar('thesis_approval_date','thesis_approval_calendar');">
</div>

<label for="candidacy_exam">Candidacy Exam Date</label>
<input type="text" name="candidacy_exam_date" id="candidacy_exam_date" style="width:150px"
       placeholder="01-01-2013"
       title="Enter the candidacy exam date">
<img src="css/calendar.png" id="candidacy_exam_calendar" style="position:relative;top:2px;left:-25px;"
     onclick="createPopCalendar('candidacy_exam_date','candidacy_exam_calendar');">

<label for="final_defense">Final Defense Date</label>
<input type="text" name="final_defense_date" id="final_defense_date" style="width:150px"
       placeholder="01-01-2013"
       title="Enter the final defense date">
<img src="css/calendar.png" id="final_defense_calendar" style="position:relative;top:2px;left:-25px;"
     onclick="createPopCalendar('final_defense_date','final_defense_calendar');">

<label for="expected_convocation">Expected Convocation Date</label>
<input type="text" name="expected_convocation_date" id="expected_convocation_date" style="width:150px"
       placeholder="01-01-2013"
       title="Enter the expected convocation date">
<img src="css/calendar.png" id="expected_convocation_calendar" style="position:relative;top:2px;left:-25px;"
     onclick="createPopCalendar('expected_convocation_date','expected_convocation_calendar');">

<label for="original_country">Original Province/Country</label>
<input type="text" name="original_country" placeholder="Iran"
       title="Enter the original province/country">

<label for="last_degree">Where Last Degree Obtained</label>
<input type="text" name="last_degree" placeholder="Germany"
       title="Enter where last degree obtained">

<label for="end_date">End Date</label>
<input type="text" name="end_date" id="end_date" style="width:150px"
       placeholder="01-01-2013"
       title="Enter the end date">
<img src="css/calendar.png" id="end_date_calendar" style="position:relative;top:2px;left:-25px;"
     onclick="createPopCalendar('end_date','end_date_calendar');">

<br/>
<input type="submit" name="submit" class="button" id="submit" value="Add Student" style="margin: 50px 0 0 150px;"/>

</fieldset>
</form>
</div>
<!-- /end #contact-form -->

</div>
</div>
</div>
<div id="content_footer"></div>
<div id="footer">
    <p><a href="student_dashboard.php">Students</a> | <a href="faculty_dashboard.php">Faculty Members</a> | <a
            href="users_dashboard.php">Users</a> | <a href="ip_settings.php">IPs</a>
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