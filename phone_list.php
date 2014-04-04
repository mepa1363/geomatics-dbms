<?php
include('session_manager.php');
include('gatekeeper.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" type="image/ico" href="images/favicon.ico"/>

    <title>Graduate Phone List</title>
    <style type="text/css" title="currentStyle">
        @import "css/demo_page.css";
        @import "css/demo_table.css";
        @import "css/demo_table_jui.css";
        @import "css/aristo.css";
        @import "css/style.css";
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
    <script type="text/javascript" src="js/jquery.placeholder.js"></script>
    <script type="text/javascript" src="js/jquery.form.js"></script>
    <script type="text/javascript" src="js/jquery.jeditable.js"></script>
    <script type="text/javascript" src="js/TableTools.js"></script>
    <script type="text/javascript" src="js/ZeroClipboard.js"></script>
    <script type="text/javascript">
        var oTable;
        $(document).ready(function () {

            oTable = $('#example').dataTable({
                "fnDrawCallback":function () {
                    $('#example tbody td:not(.noteditable)').editable('phone_editable_ajax.php', {
                        "callback":function (sValue, y) {
                            oTable.fnDraw();
                        },
                        "submitdata":function (value, settings) {
                            return {
                                //"column":oTable.fnGetPosition(this)[2],
                                //"row_info":oTable.fnGetData(oTable.fnGetPosition(this)[0]).toString()
                                "id":oTable.fnGetData(oTable.fnGetPosition(this)[0], 0).toString()
                            };
                        },
                        "height":"14px"
                    });
                },
                "bProcessing":true,
                "bServerSide":true,
                //"sServerMethod": "GET",
                "sPaginationType":"full_numbers",
                "sAjaxSource":"phone_list_process.php",
                //"sScrollX":"100%",
                //"sScrollXInner": "150%",
                //"bScrollCollapse":true,
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
                    [ 1, "asc" ]
                ],
                "aoColumnDefs":[
                    { "sClass":"noteditable", "aTargets":[1] },
                    { "sClass":"noteditable", "aTargets":[2] },
                    { "sClass":"noteditable", "aTargets":[4] },
                    { "sClass":"noteditable", "aTargets":[5] },
                    { "sClass":"noteditable", "aTargets":[6] }
                ],
                "aoColumns":[
                    {"bVisible":false, "bSearchable":false},
                    {"sWidth":110},
                    {"sWidth":110},
                    {"sWidth":110},
                    {"sWidth":140, "bSearchable":false},
                    {"sWidth":160, "bSearchable":false},
                    {"sWidth":140, "bSearchable":false},
                    {"bVisible":false, "bSearchable":false}
                ]
            });

        });
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

            <h1><a href="student_dashboard.php" class="breadcrumbs">Student
                Dashboard</a> > Graduate Phone List</h1>

            <div id="dynamic" style="width: 800px; margin: auto;">
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Telephone</th>
                        <th>Supervisor</th>
                        <th>Office Location</th>
                        <th>Email</th>
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
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Telephone</th>
                        <th>Supervisor</th>
                        <th>Office Location</th>
                        <th>Email</th>
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