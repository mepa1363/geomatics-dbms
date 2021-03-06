<?php
include('session_manager.php');
include ('gatekeeper.php');

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" type="image/ico" href="images/favicon.ico"/>

    <title>Candidacy Examination Report</title>
    <style type="text/css" title="currentStyle">
        @import "css/demo_page.css";
        @import "css/demo_table.css";
        @import "css/demo_table_jui.css";
        @import "css/aristo.css";
        @import "css/TableTools_JUI.css";
    </style>
    <link rel="stylesheet" type="text/css" href="style_template/style_template.css"/>
    <style type="text/css">
        tr.odd {
            background-color: #E9E9E9;
        }

        tr.even {
            background-color: #F2F2F2;
        }

        tr.odd td.sorting_1 {
            background-color: #C8EFFE;
        }

        tr.even td.sorting_1 {
            background-color: #91E0FE;
        }
        .dataTables_filter {
            width: 40%;
        }
        .dataTables_length {
            width: 30%;
        }
    </style>
    <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <script type="text/javascript" src="js/jquery.placeholder.js"></script>
    <script type="text/javascript" src="js/jquery.form.js"></script>
    <script type="text/javascript" src="js/TableTools.js"></script>
    <script type="text/javascript" src="js/ZeroClipboard.js"></script>
    <script type="text/javascript">
        var oTable;
        $(document).ready(function () {

            var offset = $("#sidebar_animate").offset();
            var topPadding = 15;
            $(window).scroll(function () {
                if ($(window).scrollTop() > offset.top) {
                    $("#sidebar_animate").stop().animate({
                        marginTop:$(window).scrollTop() - offset.top + topPadding
                    });
                } else {
                    $("#sidebar_animate").stop().animate({
                        marginTop:0
                    });
                }
            });

            oTable = $('#example').dataTable({
                "bProcessing":true,
                "bServerSide":true,
                //"sServerMethod": "GET",
                "sPaginationType":"full_numbers",
                "sAjaxSource":"candidacy_examination_process.php",
                "sScrollX":"100%",
                //"sScrollXInner": "150%",
                "bScrollCollapse":true,
                "bJQueryUI":true,
                //"bAutoWidth": false
                "sDom": '<"H"lTfr>t<"F"ip>',
                "oTableTools":{
                    "sSwfPath":"style_template/copy_csv_xls_pdf.swf",
                    "aButtons":[
                        {
                            "sExtends": "xls",
                            "bHeader": true,
                            "bFooter": false,
                            "mColumns": "visible"
                        },
                        {
                            "sExtends": "pdf",
                            "sPdfOrientation": "landscape",
                            "bHeader": true,
                            "bFooter": false,
                            "mColumns": "visible"
                        },
                        "print"
                    ]
                },
                "aaSorting":[
                    [ 3, "asc" ]
                ],
                "aoColumns":[
                    {"bVisible":false, "bSearchable":false},
                    {"sWidth":110},
                    {"sWidth":110},
                    {"sWidth":110},
                    {"bSearchable":false},
                    {"sWidth":110, "bSearchable":false},
                    null,
                    {"sWidth":120, "bSearchable":false},
                    {"sWidth":160, "bSearchable":false},
                    {"sWidth":90, "bSearchable":false},
                    {"sWidth":250, "bSearchable":false},
                    {"sWidth":150, "bSearchable":false},
                    {"sWidth":220, "bSearchable":false},
                    {"sWidth":280, "bSearchable":false},
                    {"sWidth":220, "bSearchable":false},
                    {"sWidth":220, "bSearchable":false},
                    {"bVisible":false, "bSearchable":false}
                ]
            });

            $("#example tbody").click(function (event) {
                $(oTable.fnSettings().aoData).each(function () {
                    $(this.nTr).removeClass('row_selected');
                });
                $(event.target.parentNode).addClass('row_selected');
                $('#id').val(getSelectedInfo()[0]);
                $('#first_name').val(getSelectedInfo()[1]);
                $('#last_name').val(getSelectedInfo()[2]);
                $('#final_gpa').val(getSelectedInfo()[3]);
                $('#course_requirement').val(getSelectedInfo()[4]);
                $('#technical_writing').val(getSelectedInfo()[5]);
                $('#supervisor').val(getSelectedInfo()[6]);
                $('#engo609_reports').val(getSelectedInfo()[7]);
                $('#engo607_seminar').val(getSelectedInfo()[8]);
                $('#proposal_approval').val(getSelectedInfo()[10]);
                $('#what_course_requirement').val(getSelectedInfo()[9]);
            });
        });

        function getSelectedInfo() {
            var anSelected = fnGetSelected(oTable);
            var data = anSelected[0];
            var selected_id = oTable.fnGetData(data, 0);
            var selected_first_name = oTable.fnGetData(data, 2);
            var selected_last_name = oTable.fnGetData(data, 3);
            var selected_final_gpa = oTable.fnGetData(data, 9);
            var selected_course_requirement = oTable.fnGetData(data, 10);
            var selected_technical_writing = oTable.fnGetData(data, 11);
            var selected_supervisor = oTable.fnGetData(data, 6);
            var selected_engo609_reports = oTable.fnGetData(data, 12);
            var selected_engo607_seminar = oTable.fnGetData(data, 13);
            var selected_proposal_approval = oTable.fnGetData(data, 14);
            var selected_what_course_requirement = oTable.fnGetData(data, 15);
            var infoArray = [selected_id, selected_first_name, selected_last_name, selected_final_gpa,
                selected_course_requirement, selected_technical_writing, selected_supervisor, selected_engo609_reports,
                selected_engo607_seminar, selected_what_course_requirement, selected_proposal_approval];
            return infoArray;
        }

        function fnGetSelected(oTableLocal) {
            var aReturn = new Array();
            var aTrs = oTableLocal.fnGetNodes();
            for (var i = 0; i < aTrs.length; i++) {
                if ($(aTrs[i]).hasClass('row_selected')) {
                    aReturn.push(aTrs[i]);
                }
            }
            return aReturn;
        }

        function updateStudent() {
            if (fnGetSelected(oTable).length == 0) {
                alert('Please select a record from the table first!');
                return false;
            } else {
                return document.location.href = 'update_student.php?student_id=' + getSelectedInfo()[0];
            }
        }

        function submitForm() {
            if (fnGetSelected(oTable).length == 0) {
                alert('Please select a record from the table first!');
            } else {
                document.forms["report"].submit();
            }
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
        <div id="sidebar_animate" class="sidebar">
            <!-- insert your sidebar items here -->
            <h1>Tools</h1>
            <ul>
                <?php
                if (!viewer_gatekeeper()) {
                    echo "<li><a href='#' onclick='updateStudent()'>Update</a></li>";
                }
                ?>

                <li><a href="#" onclick="submitForm()">Generate Report</a></li>
                <form id="report" method="post" target="_blank" action="candidacy_report_generator.php">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="first_name" name="first_name">
                    <input type="hidden" id="last_name" name="last_name">
                    <input type="hidden" id="final_gpa" name="final_gpa">
                    <input type="hidden" id="what_course_requirement" name="what_course_requirement">
                    <input type="hidden" id="course_requirement" name="course_requirement">
                    <input type="hidden" id="technical_writing" name="technical_writing">
                    <input type="hidden" id="supervisor" name="supervisor">
                    <input type="hidden" id="engo609_reports" name="engo609_reports">
                    <input type="hidden" id="engo607_seminar" name="engo607_seminar">
                    <input type="hidden" id="proposal_approval" name="proposal_approval">
                </form>
            </ul>
        </div>
        <div id="content">

            <h1><a href="student_dashboard.php" class="breadcrumbs">Student
                Dashboard</a> > Candidacy Examination Clearance Report</h1>

            <div id="dynamic">
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student ID#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Study Type</th>
                        <th>Supervisor</th>
                        <th>Degree Type</th>
                        <th>Original Start Date</th>
                        <th>Final GPA</th>
                        <th>Course Requirement Completed</th>
                        <th>Technical Writing</th>
                        <th>ENGO 609 Seminar Reports</th>
                        <th>ENGO 607 Presentation Completed</th>
                        <th>Thesis Proposal Approved</th>
                        <th>What Course Requirement</th>
                        <th>End Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="5" class="dataTables_empty">Loading data from server</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Student ID#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Study Type</th>
                        <th>Supervisor</th>
                        <th>Degree Type</th>
                        <th>Original Start Date</th>
                        <th>Final GPA</th>
                        <th>Course Requirement Completed</th>
                        <th>Technical Writing</th>
                        <th>ENGO 609 Seminar Reports</th>
                        <th>ENGO 607 Presentation Completed</th>
                        <th>Thesis Proposal Approved</th>
                        <th>What Course Requirement</th>
                        <th>End Date</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="spacer"></div>
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
</body>
</html>