<?php

include('session_manager.php');
include('gatekeeper.php');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" type="image/ico" href="images/favicon.ico"/>

    <title>Length of Time Report</title>
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

            oTable = $('#example').dataTable({
                "bProcessing":true,
                "bServerSide":true,
                //"sServerMethod": "GET",
                "sPaginationType":"full_numbers",
                "sAjaxSource":"length_of_time_process.php",
                "sScrollX":"100%",
                //"sScrollXInner": "150%",
                "bScrollCollapse":true,
                "bJQueryUI":true,
                //"bAutoWidth": false
                "sDom":'<"H"lTfr>t<"F"ip>',
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
                    {"bSearchable":false, "sWidth":110},
                    {"bSearchable":false, "sWidth":110},
                    {"bSearchable":false, "sWidth":120},
                    {"bSearchable":false, "sWidth":150},
                    {"bSearchable":false, "sWidth":160},
                    {"bSearchable":false, "sWidth":110},
                    {"bSearchable":false, "sWidth":130}
                ]
            });

            $("#example tbody").click(function (event) {
                $(oTable.fnSettings().aoData).each(function () {
                    $(this.nTr).removeClass('row_selected');
                });
                $(event.target.parentNode).addClass('row_selected');
                $('#time_status').fadeIn('fast');
                getTimeToGo();
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

        function getTimeToGo() {
            var rowSelected = fnGetSelected(oTable);
            var rowId = rowSelected[0];
            //var selected_id = oTable.fnGetData(rowId, 0);
            var name = oTable.fnGetData(rowId, 2) + ' ' + oTable.fnGetData(rowId, 3);
            var start_date = oTable.fnGetData(rowId, 9);
            var end_date = oTable.fnGetData(rowId, 10);
            var time_to_go;
            var one_day = 1000 * 60 * 60 * 24;
            if (end_date == 'NULL' || end_date == '0000-00-00') {
                var today = new Date();
                time_to_go = Math.abs(Date.parse(today) - Date.parse(start_date));
                time_to_go = Math.round(time_to_go / one_day);
                if (time_to_go < 31) {
                    $('#student_name').text(name);
                    $('#explanation').text(' has been in the school for ');
                    $('#time_to_go').text(time_to_go + ' days');
                } else {
                    time_to_go = Math.round(time_to_go / 30);
                    $('#student_name').text(name);
                    $('#explanation').text(' has been in the school for ');
                    $('#time_to_go').text(time_to_go + ' months');
                }
            } else {
                time_to_go = Date.parse(end_date) - Date.parse(start_date);
                time_to_go = Math.round(time_to_go / one_day);
                if (time_to_go < 31) {
                    $('#student_name').text(name);
                    $('#explanation').text(' has been graduated in ');
                    $('#time_to_go').text(time_to_go + ' days');
                } else {
                    time_to_go = Math.round(time_to_go / 30);
                    $('#student_name').text(name);
                    $('#explanation').text(' has been graduated in ');
                    $('#time_to_go').text(time_to_go + ' months');
                }
            }

        }

        function updateStudent() {
            if (fnGetSelected(oTable).length == 0) {
                alert('Please select a record from the table first!');
                return false;
            } else {
                return document.location.href = 'update_student.php?student_id=' + getSelectedId();
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
            <?php
            if (!viewer_gatekeeper()) {
                echo "<h1>Tools</h1>
                <ul>
                    <li><a href='#' onclick='updateStudent()'>Update</a></li>
                </ul>";
            }
            ?>

            <h1>Tips</h1>
            <ul>
                <li id="time_status" style="display: none;">
                    <a href="#"><label for="time_to_go">Time in School: </label><br/>
                        <label id="student_name" style="font-weight: bold;"></label>
                        <label id="explanation"></label>
                        <label id="time_to_go" style="font-weight: bold;"></label>
                    </a>
                </li>
            </ul>
        </div>
        <div id="content">

            <h1><a href="student_dashboard.php" class="breadcrumbs">Student
                Dashboard</a> > Length of Time Report</h1>

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
                        <th>Status in Canada</th>
                        <th>Original Start Date</th>
                        <th>End Date</th>
                        <th>Length of Time</th>
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
                        <th>Status in Canada</th>
                        <th>Original Start Date</th>
                        <th>End Date</th>
                        <th>Length of Time</th>
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