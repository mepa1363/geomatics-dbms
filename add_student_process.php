<?php
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

//This code runs if the form has been submitted
if (isset($_POST['submit'])) {

    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $study_type = $_POST['study_type'];
    $supervisor_id = $_POST['supervisor'];
    $co_supervisor_id = $_POST['co_supervisor'];
    $degree_type = $_POST['degree_type'];
    $status_in_canada = $_POST['status_in_canada'];
    $original_start_date = $_POST['original_start_date'];
    $research_stream = $_POST['research_stream'];
    $appointment_supervisory_committee = $_POST['appointment_supervisory_committee'];
    $sin_expiry_date = $_POST['sin_expiry_date'];
    $email = $_POST['email'];
    //$email = !empty($email) ? "'$email'" : "NULL";
    $office_location = $_POST['office_location'];
    $office_location = !empty($office_location) ? "$office_location" : "NULL";
    $office_tel = $_POST['office_tel'];
    $office_tel = !empty($office_tel) ? "$office_tel" : "NULL";
    $fee_differential = $_POST['fee_differential_return'];
    $transfer_msc_phd = $_POST['transfer_msc_phd'];
    $entrance_gpa = $_POST['entrance_gpa'];
    $entrance_gpa = !empty($entrance_gpa) ? "$entrance_gpa" : "NULL";
    $final_gpa = $_POST['final_gpa'];
    $final_gpa = !empty($final_gpa) ? "$final_gpa" : "NULL";
    $course_requirements = $_POST['course_requirements'];
    $course_requirements_completed = $_POST['course_requirements_completed'];
    if ($course_requirements_completed == 'Yes') {
        $course_requirements_completed = $_POST['course_requirements_completed_date'];
    }
    $engo605_complete = $_POST['engo605_complete'];
    if ($engo605_complete == 'Yes') {
        $engo605_complete = $_POST['engo605_date'];
    }
    $engo607_complete = $_POST['engo607_complete'];
    if ($engo607_complete == 'Yes') {
        $engo607_complete = $_POST['engo607_date'];
    }
    $engo609_complete = $_POST['engo609_complete'];
    if ($engo609_complete == 'Yes') {
        $engo609_complete = $_POST['engo609_date'];
    }
    $major_award_count = $_POST['major_awards_count'];
    if ($major_award_count == 1) {
        $major_award_collection = $_POST['major_award_1'];
    } else {
        for ($i = 1; $i < $major_award_count; $i++) {
            if ($_POST['major_award_' . $i] != "") {
                $major_award_array[$i] = $_POST['major_award_' . $i];
            }
        }
        $major_award_collection = implode($major_award_array, ';');
    }
    $fgs_award_count = $_POST['fgs_award_count'];
    if ($fgs_award_count == 1) {
        $fgs_award_collection_amount = $_POST['fgs_award_amount_1'];
    } else {
        for ($i = 1; $i < $fgs_award_count; $i++) {
            if ($_POST['fgs_award_amount_' . $i] != "") {
                $fgs_award_array_amount[$i] = $_POST['fgs_award_amount_' . $i];
            }
        }
        $fgs_award_collection_amount = implode($fgs_award_array_amount, ';');
    }
    if ($fgs_award_count == 1) {
        $fgs_award_collection_date = $_POST['fgs_award_date_1'];
    } else {
        for ($i = 1; $i < $fgs_award_count; $i++) {
            if ($_POST['fgs_award_date_' . $i] != "") {
                $fgs_award_array_date[$i] = $_POST['fgs_award_date_' . $i];
            }
        }
        $fgs_award_collection_date = implode($fgs_award_array_date, ';');
    }
    $travel_award_count = $_POST['travel_award_count'];
    if ($travel_award_count == 1) {
        $travel_award_collection_amount = $_POST['travel_award_amount_1'];
    } else {
        for ($i = 1; $i < $travel_award_count; $i++) {
            if ($_POST['travel_award_amount_' . $i] != "") {
                $travel_award_array_amount[$i] = $_POST['travel_award_amount_' . $i];
            }
        }
        $travel_award_collection_amount = implode($travel_award_array_amount, ';');
    }
    if ($travel_award_count == 1) {
        $travel_award_collection_date = $_POST['travel_award_date_1'];
    } else {
        for ($i = 1; $i < $travel_award_count; $i++) {
            if ($_POST['travel_award_date_' . $i] != "") {
                $travel_award_array_date[$i] = $_POST['travel_award_date_' . $i];
            }
        }
        $travel_award_collection_date = implode($travel_award_array_date, ';');
    }
    if ($travel_award_count == 1) {
        $travel_award_collection_claim = $_POST['travel_award_claim_1'];
    } else {
        for ($i = 1; $i < $travel_award_count; $i++) {
            if ($_POST['travel_award_claim_' . $i] != "") {
                $travel_award_array_claim[$i] = $_POST['travel_award_claim_' . $i];
            }
        }
        $travel_award_collection_claim = implode($travel_award_array_claim, ';');
    }
    $writing_complete = $_POST['writing_complete'];
    if ($writing_complete == 'Completed') {
        $writing_complete = $_POST['technical_writing_completed'];
    }
    $engo605_seminar_count = $_POST['engo605_seminar_count'];
    if ($engo605_seminar_count == 1) {
        $engo605_seminar_collection_name = $_POST['engo605_seminar_name_1'];
    } else {
        for ($i = 1; $i < $engo605_seminar_count; $i++) {
            if ($_POST['engo605_seminar_name_' . $i] != "") {
                $engo605_seminar_array_name[$i] = $_POST['engo605_seminar_name_' . $i];
            }
        }
        $engo605_seminar_collection_name = implode($engo605_seminar_array_name, ';');
    }
    if ($engo605_seminar_count == 1) {
        $engo605_seminar_collection_date = $_POST['engo605_seminar_date_1'];
    } else {
        for ($i = 1; $i < $engo605_seminar_count; $i++) {
            if ($_POST['engo605_seminar_date_' . $i] != "") {
                $engo605_seminar_array_date[$i] = $_POST['engo605_seminar_date_' . $i];
            }
        }
        $engo605_seminar_collection_date = implode($engo605_seminar_array_date, ';');
    }
    $engo607_seminar_count = $_POST['engo607_seminar_count'];
    if ($engo607_seminar_count == 1) {
        $engo607_seminar_collection_name = $_POST['engo607_seminar_name_1'];
    } else {
        for ($i = 1; $i < $engo607_seminar_count; $i++) {
            if ($_POST['engo607_seminar_name_' . $i] != "") {
                $engo607_seminar_array_name[$i] = $_POST['engo607_seminar_name_' . $i];
            }
        }
        $engo607_seminar_collection_name = implode($engo607_seminar_array_name, ';');
    }
    if ($engo607_seminar_count == 1) {
        $engo607_seminar_collection_date = $_POST['engo607_seminar_date_1'];
    } else {
        for ($i = 1; $i < $engo607_seminar_count; $i++) {
            if ($_POST['engo607_seminar_date_' . $i] != "") {
                $engo607_seminar_array_date[$i] = $_POST['engo607_seminar_date_' . $i];
            }
        }
        $engo607_seminar_collection_date = implode($engo607_seminar_array_date, ';');
    }
    $engo609_seminar_count = $_POST['engo609_seminar_count'];
    if ($engo609_seminar_count == 1) {
        $engo609_seminar_collection_name = $_POST['engo609_seminar_name_1'];
    } else {
        for ($i = 1; $i < $engo609_seminar_count; $i++) {
            if ($_POST['engo609_seminar_name_' . $i] != "") {
                $engo609_seminar_array_name[$i] = $_POST['engo609_seminar_name_' . $i];
            }
        }
        $engo609_seminar_collection_name = implode($engo609_seminar_array_name, ';');
    }

    if ($engo609_seminar_count == 1) {
        $engo609_seminar_collection_date = $_POST['engo609_seminar_date_1'];
    } else {
        for ($i = 1; $i < $engo609_seminar_count; $i++) {
            if ($_POST['engo609_seminar_date_' . $i] != "") {
                $engo609_seminar_array_date[$i] = $_POST['engo609_seminar_date_' . $i];
            }
        }
        $engo609_seminar_collection_date = implode($engo609_seminar_array_date, ';');
    }
    $thesis_approved = $_POST['thesis_approved'];
    if ($thesis_approved == 'Yes') {
        $thesis_approved = $_POST['thesis_proposal_approved'];
    }
    $candidacy_exam_date = $_POST['candidacy_exam_date'];
    $candidacy_exam_date = !empty($candidacy_exam_date) ? "$candidacy_exam_date" : "NULL";
    $final_defense_date = $_POST['final_defense_date'];
    $final_defense_date = !empty($final_defense_date) ? "$final_defense_date" : "NULL";
    $expected_convocation_date = $_POST['expected_convocation_date'];
    $expected_convocation_date = !empty($expected_convocation_date) ? "$expected_convocation_date" : "NULL";
    $original_country = $_POST['original_country'];
    $original_country = !empty($original_country) ? "$original_country" : "NULL";
    $last_degree = $_POST['last_degree'];
    $last_degree = !empty($last_degree) ? "$last_degree" : "NULL";
    $end_date = $_POST['end_date'];
    $end_date = !empty($end_date) ? "$end_date" : "NULL";

    $insert_query = "INSERT INTO student_info (student_id,
     first_name, last_name, gender, study_type, supervisor_id,
     cosupervisor_id, degree_type, status_in_canada, start_date,
     research_stream, appointment_of_supervisory_committee,
     sin_expiry, email, office_location, office_tel, fee_differential_return,
     msc_to_phd, entrance_gpa, final_gpa, course_requirements,
     course_requirement_completed, engo605_presentation_complete,
     engo607_presentation_complete, engo609_presentation_complete,
     major_awards, fgs_award_date, fgs_award_amount, travel_award_date,
     travel_award_amount, travel_award_claim, technical_writing_complete,
     engo_605_seminar_report_name, engo_605_seminar_report_date,
     engo_607_seminar_report_name, engo_607_seminar_report_date,
     engo_609_seminar_report_name, engo_609_seminar_report_date,
     thesis_proposal_approve, candidacy_date, defense_date,
     expected_convocation, province_country, last_degree, end_date)
      VALUES ('" . $student_id . "','" . $first_name . "','" . $last_name . "','" . $gender . "','" . $study_type . "','" .
        $supervisor_id . "','" . $co_supervisor_id . "','" . $degree_type . "','" . $status_in_canada . "','" .
        $original_start_date . "','" . $research_stream . "','" . $appointment_supervisory_committee . "','" .
        $sin_expiry_date . "','" . $email . "','" . $office_location . "','" . $office_tel . "','" . $fee_differential . "','" .
        $transfer_msc_phd . "','" . $entrance_gpa . "','" . $final_gpa . "','" . $course_requirements . "','" .
        $course_requirements_completed . "','" . $engo605_complete . "','" . $engo607_complete . "','" . $engo609_complete . "','" .
        $major_award_collection . "','" . $fgs_award_collection_date . "','" . $fgs_award_collection_amount . "','" .
        $travel_award_collection_date . "','" . $travel_award_collection_amount . "','" . $travel_award_collection_claim . "','" .
        $writing_complete . "','" . $engo605_seminar_collection_name . "','" . $engo605_seminar_collection_date . "','" .
        $engo607_seminar_collection_name . "','" . $engo607_seminar_collection_date . "','" . $engo609_seminar_collection_name . "','" .
        $engo609_seminar_collection_date . "','" . $thesis_approved . "','" .
        $candidacy_exam_date . "','" . $final_defense_date . "','" . $expected_convocation_date . "','" . $original_country . "','" .
        $last_degree . "','" . $end_date . "')";

    $add_member = mysql_query($insert_query) or die("SQL Error: " . mysql_error());
    print_r($add_member);
}

?>