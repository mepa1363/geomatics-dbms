<?php
include('session_manager.php');
include('gatekeeper.php');

$from_date = $_GET['from'];
$to_date = $_GET['to'];

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" type="image/ico" href="images/favicon.ico"/>

    <link rel="stylesheet" type="text/css" href="css/calendar.css"/>
    <title>Current Student Report</title>
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
    <script type="text/javascript" src="js/resources.js"></script>
    <script type="text/javascript" src="js/config.js"></script>
    <script type="text/javascript" src="js/calendar.min.js"></script>
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
                "sAjaxSource":"current_students_process.php",
                "fnServerParams":function (aoData) {
                    aoData.push({"name":"from_date", "value":"<?php echo $from_date ?>"}, {"name":"to_date", "value":"<?php echo $to_date ?>"});
                },
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
                    {"bVisible":false, "bSearchable":false}
                ]
            });

            $('#submit').attr("disabled", false);

            $("#example tbody").click(function (event) {
                $(oTable.fnSettings().aoData).each(function () {
                    $(this.nTr).removeClass('row_selected');
                });
                $(event.target.parentNode).addClass('row_selected');
            });

            $('#current_students_query').click(function () {
                var from_date = $('#start_date_student').val();
                var to_date = $('#end_date_student').val();
                window.location = 'current_students_report.php?from=' + from_date + '&to=' + to_date;
            });
        });

        function getSelectedId() {
            var anSelected = fnGetSelected(oTable);
            var data = anSelected[0];
            //getting hidden column value
            var selected_id = oTable.fnGetData(data, 0);
            return selected_id;
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

        function createPopCalendar(date, calendar) {
            var cal = new JSCalender.PopCalender(date, calendar);
            cal.setPrintFarmat("YYYY-MM-DD");
            cal.show();
        }

        function updateStudent() {
            if (fnGetSelected(oTable).length == 0) {
                alert('Please select a record from the table first!');
                return false;
            } else {
                return document.location.href = 'update_student.php?student_id=' + getSelectedId();
            }
        }

        function display_items_toggle(div1, div2) {
            if ($('#' + div1).is(':visible')) {
                $('#' + div1).fadeOut('fast');
                $('#' + div2).css('color', '#67686A');
                $('#' + div2).css('background', '#F1F1F1');
                $('#' + div2).css('border-radius', '5px');
                $('#' + div2).css('font-weight', 'normal');
            } else if ($('#' + div1).is(':hidden')) {
                $('#' + div1).fadeIn('fast');
                $('#' + div2).css('color', '#ffffff');
                $('#' + div2).css('background', '#8DC63F');
                $('#' + div2).css('border-radius', '5px');
                $('#' + div2).css('font-weight', 'bold');
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
                <li><a id="current_student_form_selected"
                       onclick="display_items_toggle('current_student_form','current_student_form_selected')">Current
                    Students</a></li>
                <div id="current_student_form" style="display: none;">
                    <label for="student_from_date">From</label>
                    <input type="text" name="start_date_student" id="start_date_student" style="width:120px"
                           placeholder="2012-09-01"
                           title="Enter the start date">
                    <img src="css/calendar.png" id="start_calendar_student"
                         style="position:relative;top:2px;margin-left:-25px;"
                         onclick="javascript:createPopCalendar('start_date_student','start_calendar_student');">

                    <label for="student_to_date">&nbsp;To</label>
                    <input type="text" name="end_date_student" id="end_date_student"
                           style="width:120px; margin-left: 10px;"
                           placeholder="2012-09-01"
                           title="Enter the start date">
                    <img src="css/calendar.png" id="end_calendar_student"
                         style="position:relative;top:2px;margin-left:-25px;"
                         onclick="javascript:createPopCalendar('end_date_student','end_calendar_student');">

                    <input type="button" value="Current Students" id="current_students_query" class="button"
                           style="margin-left: 40px;">

                </div>
            </ul>
        </div>
        <div id="content">

            <h1><a href="student_dashboard.php" class="breadcrumbs">Student
                Dashboard</a> > Current Students Report</h1>

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