<?php
include('session_manager.php');
include('gatekeeper.php');

if (!admin_gatekeeper()) {
    header('Location: student_dashboard.php');
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link rel="shortcut icon" type="image/ico" href="images/favicon.ico"/>

<title>Users Dashboard</title>

<style type="text/css" title="currentStyle">
    @import "css/demo_page.css";
    @import "css/demo_table.css";
    @import "css/demo_table_jui.css";
    @import "css/aristo.css";
    @import "css/TableTools_JUI.css";
</style>
<link rel="stylesheet" type="text/css" href="style_template/style_template.css"/>
<link rel="stylesheet" type="text/css" href="css/calendar.css"/>
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
<script type="text/javascript" src="js/jquery.placeholder.js"></script>

<script type="text/javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" src="js/TableTools.js"></script>
<script type="text/javascript" src="js/ZeroClipboard.js"></script>

<script type="text/javascript">
var oTable;


$(document).ready(function () {

    $('#user_username_add').keyup(function () {
        checkUsername('user_username_add', 'add');
    });

    $('#user_username_update').keyup(function () {
        checkUsername('user_username_update', 'update');
    });

    $('#user_password2_add').keyup(function () {
        checkPassword('add');
    });

    $('#user_password2_update').keyup(function () {
        checkPassword('update');
    });

    var offset = $("#sidebar_animate").offset();
    var topPadding = 15;
    $(window).scroll(function () {
        if ($(window).scrollTop() > offset.top) {
            $("#sidebar_animate").stop().animate({
                marginTop: $(window).scrollTop() - offset.top + topPadding
            });
        } else {
            $("#sidebar_animate").stop().animate({
                marginTop: 0
            });
        }
    });

    oTable = $('#example').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"sServerMethod": "GET",
        "sPaginationType": "full_numbers",
        "sAjaxSource": "users_process.php",
        "sScrollX": "100%",
        "bScrollCollapse": true,
        "bJQueryUI": true,
        "sDom": '<"H"lTfr>t<"F"ip>',
        "oTableTools": {
            "sSwfPath": "style_template/copy_csv_xls_pdf.swf",
            "aButtons": [
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
        "aaSorting": [
            [ 2, "asc" ]
        ],
        "aoColumns": [
            {"bVisible": false, "bSearchable": false},
            {"sWidth": 120},
            {"sWidth": 110},
            {"sWidth": 110, "bSearchable": false},
            {"sWidth": 200, "bSearchable": false},
            {"sWidth": 200, "bSearchable": false},
            {"sWidth": 110},
            {"sWidth": 200, "bSearchable": false},
            {"sWidth": 140, "bSearchable": false}
        ]


    });

    $("#example tbody").click(function (event) {
        $(oTable.fnSettings().aoData).each(function () {
            $(this.nTr).removeClass('row_selected');
        });
        $(event.target.parentNode).addClass('row_selected');
        $('#user_id_update').val(getSelectedInfo()[0]);
        $('#user_first_name_update').val(getSelectedInfo()[1]);
        $('#user_last_name_update').val(getSelectedInfo()[2]);
        $('#user_email_update').val(getSelectedInfo()[3]);
        $('#user_username_update').val(getSelectedInfo()[6]);
        //$('#user_password_update').val(getSelectedInfo()[7]);
        //$('#user_access_level_update').val(getSelectedInfo()[8]);
        var access_level = getSelectedInfo()[8];
        var index = "";
        switch (access_level) {
            case 'Admin':
                index = 0;
                break;
            case 'Editor':
                index = 1;
                break;
            case 'Viewer':
                index = 2;
                break;
        }
        $('#user_access_level_update')[0].selectedIndex = index;
    });

});

function getSelectedInfo() {
    var anSelected = fnGetSelected(oTable);
    var data = anSelected[0];
    var selected_array = new Array();
    //getting hidden column value
    var selected_id = oTable.fnGetData(data, 0);
    var selected_first_name = oTable.fnGetData(data, 1);
    var selected_last_name = oTable.fnGetData(data, 2);
    var selected_email = oTable.fnGetData(data, 3);
    var selected_signup_date = oTable.fnGetData(data, 4);
    var selected_last_login = oTable.fnGetData(data, 5);
    var selected_username = oTable.fnGetData(data, 6);
    var selected_password = oTable.fnGetData(data, 7);
    var selected_access_level = oTable.fnGetData(data, 8);
    selected_array = [selected_id, selected_first_name, selected_last_name, selected_email, selected_signup_date, selected_last_login, selected_username, selected_password, selected_access_level];
    return selected_array;
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

function checkUsername(user, func) {
    var username = $('#' + user).val();
    if (username == "") {
        //$('#' + user).css('border', '3px #CCC solid');
        $('#tick_user_' + func).hide();
    } else if (username != getSelectedInfo()[6]) {

        $.ajax({
            type: "POST",
            url: "username_check.php",
            data: 'username=' + username,
            cache: false,
            success: function (response) {
                if (response == 1) {
                    $('#' + user).css('border', '3px #C33 solid');
                    $('#tick_user_' + func).hide();
                    $('#cross_user_' + func).fadeIn();
                } else {
                    $('#' + user).css('border', '3px #8DC63F solid');
                    $('#cross_user_' + func).hide();
                    $('#tick_user_' + func).fadeIn();
                }

            }
        });
    }
}

function checkPassword(func) {
    var password = $('#user_password1_' + func).val();
    var password2 = $('#user_password2_' + func).val();
    if (password2 == password) {
        $('#user_password2_' + func).css('border', '3px #8DC63F solid');
        $('#cross_pass_' + func).hide();
        $('#tick_pass_' + func).fadeIn();
    } else {
        $('#user_password2_' + func).css('border', '3px #C33 solid');
        $('#tick_pass_' + func).hide();
        $('#cross_pass_' + func).fadeIn();
    }
}

function deleteUser() {
    if (fnGetSelected(oTable).length == 0) {
        alert('Please select a record from the table first!');
    } else {
        var username = getSelectedInfo()[6];
        if (username != '<?php echo $_SESSION['user_name'] ?>') {
            var r = confirm("Are you sure!?");
            if (r == true) {
                $.ajax({ url: 'delete_user.php',
                    data: {user_id: getSelectedInfo()[0]},
                    type: 'POST',
                    success: function (output) {
                        oTable.fnDeleteRow(getSelectedInfo()[0]);
                    }
                });
            }
        } else {
            alert('You are logged in with this user, you cannot delete it!');
        }
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
                <li><a href="student_dashboard.php">Students</a></li>
                <li><a href="faculty_dashboard.php">user Members</a></li>
                <li class="selected"><a href="#">Users</a></li>
                <li><a href="ip_settings.php">IPs</a></li>
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
                <li><a href="#" id="add_user"
                       onclick="display_items_toggle('add_user_form','add_user')">Add</a></li>
                <form id="add_user_form" method="post" action="users_add_process.php" style="display: none;">
                    <fieldset>
                        First Name: <input type="text" id="user_first_name_add" name="user_first_name"
                                           style="width: 100px;" placeholder="James" pattern="^[A-Za-z .'-]+$"
                                           required="required">
                        Last Name: <input type="text" id="user_last_name_add" name="user_last_name"
                                          style="width: 100px;" placeholder="Paul" pattern="^[A-Za-z .'-]+$"
                                          required="required">
                        Email: <input type="text" id="user_email_add" name="user_email"
                                      style="width: 137px;" placeholder="example@domain.com">
                        Username: <input type="text" id="user_username_add" name="user_username"
                                         style="width: 107px;" placeholder="jpaul" required="required">
                        <img id="tick_user_add" src="images/tick.png" alt="accepted"
                             style="display:none; position: relative; float: right; margin-top: -22px; margin-right: 18px;">
                        <img id="cross_user_add" src="images/cross.png" alt="rejected"
                             style="display:none; position: relative; float: right; margin-top: -22px; margin-right: 18px;">
                        Password: <input type="password" id="user_password1_add" name="user_password1"
                                         style="width: 109px;" placeholder="pjp-12345" required="required">
                        Password: <input type="password" id="user_password2_add" name="user_password2"
                                         style="width: 109px;" placeholder="pjp-12345" required="required">
                        <img id="tick_pass_add" src="images/tick.png" alt="accepted"
                             style="display:none; position: relative; float: right; margin-top: -22px; margin-right: 18px;">
                        <img id="cross_pass_add" src="images/cross.png" alt="rejected"
                             style="display:none; position: relative; float: right; margin-top: -22px; margin-right: 18px;">
                        Access Level:
                        <select id="user_access_level_add" name="user_access_level">
                            <option value="Admin">Admin</option>
                            <option selected="selected" value="Editor">Editor</option>
                            <option value="Viewer">Viewer</option>
                        </select>
                        <input type="submit" name="submit" id="submit_add" class="button" value="Add User"
                               style="margin-left: 50px;">
                    </fieldset>
                </form>
                <li><a href="#" id="update_user"
                       onclick="display_items_toggle('update_user_form','update_user')">Update</a>
                </li>
                <form id="update_user_form" method="post" action="users_update_process.php" style="display: none;">
                    <fieldset>
                        <input type="hidden" id="user_id_update" name="user_id" style="width: 100px;">
                        First Name: <input type="text" id="user_first_name_update" name="user_first_name"
                                           style="width: 100px;" pattern="^[A-Za-z .'-]+$" required="required">
                        Last Name: <input type="text" id="user_last_name_update" name="user_last_name"
                                          style="width: 100px;" pattern="^[A-Za-z .'-]+$" required="required">
                        Email: <input type="text" id="user_email_update" name="user_email"
                                      style="width: 137px;">
                        Username: <input type="text" id="user_username_update" name="user_username"
                                         style="width: 107px;" required="required">
                        <img id="tick_user_update" src="images/tick.png" alt="accepted"
                             style="display:none; position: relative; float: right; margin-top: -22px; margin-right: 18px;">
                        <img id="cross_user_update" src="images/cross.png" alt="rejected"
                             style="display:none; position: relative; float: right; margin-top: -22px; margin-right: 18px;">
                        Password: <input type="password" id="user_password1_update" name="user_password1"
                                         style="width: 109px;" required="required">
                        Password: <input type="password" id="user_password2_update" name="user_password2"
                                         style="width: 109px;" required="required">
                        <img id="tick_pass_update" src="images/tick.png" alt="accepted"
                             style="display:none; position: relative; float: right; margin-top: -22px; margin-right: 18px;">
                        <img id="cross_pass_update" src="images/cross.png" alt="rejected"
                             style="display:none; position: relative; float: right; margin-top: -22px; margin-right: 18px;">
                        Access Level:
                        <select id="user_access_level_update" name="user_access_level">
                            <option value="Admin">Admin</option>
                            <option value="Editor">Editor</option>
                            <option value="Viewer">Viewer</option>
                        </select>
                        <input type="submit" name="submit" class="button" value="Update User"
                               style="margin-left: 45px;">
                    </fieldset>
                </form>
                <li><a href="#" id="delete_user"
                       onclick="deleteUser()">Delete</a>
                </li>
            </ul>
        </div>
        <div id="content">
            <h1>Welcome to Users Dashboard</h1>

            <div id="dynamic">
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Sign-up Date</th>
                        <th>Last Login</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Access Level</th>
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
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Sign-up Date</th>
                        <th>Last Login</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Access Level</th>
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
    <p><a href="student_dashboard.php">Students</a> | <a href="faculty_dashboard.php">Faculty Members</a> | <a
            href="users_dashboard.php">Users</a> | <a href="ip_settings.php">IPs</a>
    </p>

    <p>Copyright &copy; department of geomatics engineering 2012</p>
</div>

</body>
</html>