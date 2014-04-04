<?php

$id = $_POST['id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$final_gpa = $_POST['final_gpa'];
$course_requirement = $_POST['course_requirement'];
$technical_writing = $_POST['technical_writing'];
$supervisor = $_POST['supervisor'];
$engo609_reports = $_POST['engo609_reports'];
$engo609_reports = explode(';', $engo609_reports);
$engo607_seminar = $_POST['engo607_seminar'];
$engo609_seminar = $_POST['engo609_seminar'];
$candidacy_exam = $_POST['candidacy_exam'];
$final_defense = $_POST['final_defense'];
$what_course_requirement = $_POST['what_course_requirement'];

$today_date = date("F j, Y");

?>
<style>
    @font-face {
        font-family: 'Optima';
        src: url('font/Optima LT Std Roman.ttf');
    }

    body {
        width: 1000px;
        /*margin: 100px;*/
    }

    #content {
        /*border: 1px #808080 solid;*/
        width: 920px;
        height: 1250px;
        margin: 50px;
    }

    #header_border {
        border: 0;
        border-top: 1px solid #f00;
        width: 900px;
        margin-top: -70px;
    }

    #sign_border {
        border: 0;
        border-top: 1px solid #000;
        width: 900px;
    }

    #department {
        float: right;
        margin-right: 30px;
        margin-top: 50px;
        font-size: 25px;
        font-family: 'Optima', 'Arial';
    }

    #letter_header {
        width: 900px;
        height: 170px;
        margin: 10px;
    }

    #letter_body {
        width: 900px;
        height: 980px;
        margin: 10px;
        font-family: 'Arial';
        font-size: 18px;
    }

    #letter_title {
        margin-top: 40px;
        font-weight: bold;
        text-align: center;
    }

    #letter_text {
        margin-top: 40px;
    }

    #requirement_title {
        margin-top: 20px;
        margin-left: 60px;
    }

    #requirements {
        display: inline-block;
        margin-left: 40px;
    }

    #requirements_section {
        margin-top: -10px;
    }

    #signature {
        margin-top: 30px;
    }

    #supervisor {
        float: left;
        margin-top: -5px;
        display: inline-block;
    }

    #sign_date {
        float: right;
        margin-top: -5px;
        display: inline-block;
        margin-right: 150px;
    }

    #letter_footer {
        font-family: 'Optima', 'Arial';
        font-size: 16px;
        word-spacing: 10px;
        margin-left: 10px;
        margin-top: 110px;
    }

    #footer_text {
        margin-top: -5px;
        margin-left: 10px;
        display: inline;
    }

    #footer_image {
        margin-left: 100px;
        margin-right: 100px;
    }

</style>

<div id="content">
    <div id="letter_header">
        <img src='images/schulichlogo.jpg' style='width: 250px;'>
        <hr id="header_border">
        <p id="department">Department of GEOMATICS ENGINEERING</p>
    </div>
    <div id="letter_body">
        <p><?php echo $today_date; ?></p>

        <p id="letter_title">The Department of Geomatics Engineering Clearance Memorandum<br>
            for<br>Final Oral Examinations Ph.D. Degree
        </p>

        <p id="letter_text"><b>The Department of Geomatics Engineering</b> endorses that the progress of
            <?php echo $first_name; ?> <?php echo $last_name; ?>, in all relevant aspects, to date,
            is deemed satisfactory and that the student has:</p>

        <p id="requirement_title">Met all departmental requirements:</p>

        <div id="requirements_section">
            <label id="numbers">1.</label>

            <p id="requirements">Completed ENGO 609 Grad Seminar Reports:</p>
            <br>
            <?php
            for ($i = 0; $i < count($engo609_reports); $i++) {
                $num = $i + 1;
                echo "<p id='requirements' style='margin-left: 60px; margin-top: -10px;'>Seminar $num: $engo609_reports[$i]</p>";
                echo "<br>";
            }
            ?>
        </div>

        <div id="requirements_section">
            <label id="numbers">2.</label>

            <p id="requirements">GPA: <?php echo $final_gpa; ?></p>
        </div>
        <div id="requirements_section">
            <label id="numbers">3.</label>

            <?php
            if ($course_requirement != 'No') {
                if ($what_course_requirement == 'PhD 3 graduate half-courses') {
                    echo "<p id='requirements'>Completed 3 graduate half-courses</p>";
                } else if ($what_course_requirement == 'PhD 2 graduate half-courses after transfer from MSc program (7 courses in total)'){
                    echo "<p id='requirements'>Completed 2 half-courses beyond MSc requirements</p>";
                }
                echo "</div>";

                echo "<div id='requirements_section'>";
                echo "<label id='numbers'>4.</label>";
                echo "<p id='requirements'>ENGO 607 Seminars Complete: $engo607_seminar</p>";
                echo "</div>";

                echo "<div id='requirements_section'>";
                echo "<label id='numbers'>5.</label>";
                echo "<p id='requirements'>ENGO 609 Seminars Complete: $engo609_seminar</p>";
                echo "</div>";

                echo "<div id='requirements_section'>";
                echo "<label id='numbers'>6.</label>";
                if ($technical_writing != 'Waived' && $technical_writing != 'N/A') {
                    echo "<p id='requirements'>Technical Writing: Completed on $technical_writing</p>";
                } else {
                    echo "<p id='requirements'>Technical Writing: $technical_writing</p>";
                }
                echo "</div>";

                echo "<div id='requirements_section'>";
                echo "<label id='numbers'>7.</label>";
                echo "<p id='requirements'>Successfully completed candidacy examination on $candidacy_exam</p>";
                echo "</div>";

                echo "<div id='requirements_section'>";
                echo "<label id='numbers'>8.</label>";
                echo "<p id='requirements'>Successfully completed a final oral examination related to the thesis work on $final_defense</p>";
                echo "</div>";
            } else {
                echo "<p id='requirements'>ENGO 607 Seminars Complete: $engo607_seminar</p>";
                echo "</div>";

                echo "<div id='requirements_section'>";
                echo "<label id='numbers'>4.</label>";
                echo "<p id='requirements'>ENGO 609 Seminars Complete: $engo609_seminar</p>";
                echo "</div>";

                echo "<div id='requirements_section'>";
                echo "<label id='numbers'>5.</label>";
                if ($technical_writing != 'Waived' && $technical_writing != 'N/A') {
                    echo "<p id='requirements'>Technical Writing: Completed on $technical_writing</p>";
                } else {
                    echo "<p id='requirements'>Technical Writing: $technical_writing</p>";
                }
                echo "</div>";

                echo "<div id='requirements_section'>";
                echo "<label id='numbers'>6.</label>";
                echo "<p id='requirements'>Successfully completed candidacy examination on $candidacy_exam</p>";
                echo "</div>";

                echo "<div id='requirements_section'>";
                echo "<label id='numbers'>7.</label>";
                echo "<p id='requirements'>Successfully completed a final oral examination related to the thesis work on $final_defense</p>";
                echo "</div>";
            }
            ?>
            <div id="signature">
                <hr id="sign_border">
                <p id="supervisor">Supervisor: <?php echo $supervisor; ?></p>

                <p id="sign_date">Date</p>
                <br>
                <br>
                <br>
                <hr id="sign_border">
                <p id="supervisor">Department Head/Graduate Coordinator</p>

                <p id="sign_date">Date</p>
            </div>
        </div>
        <div id="letter_footer">
            <hr id="header_border">
            <p id="footer_text">2500 University Drive N.W., Calgary, Alberta, Canada T2N 1N4</p>
            <img id="footer_image" src="images/black-circle.png">

            <p id="footer_text">www.ucalgary.ca</P>
        </div>
    </div>