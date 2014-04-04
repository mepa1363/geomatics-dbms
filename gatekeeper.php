<?php

function admin_gatekeeper()
{
    if ($_SESSION['access_level'] == 'Admin') {
        return true;
    }
}

function viewer_gatekeeper(){
    if ($_SESSION['access_level'] == 'Viewer') {
        return true;
    }
}

function editor_gatekeeper(){
    if ($_SESSION['access_level'] == 'Editor') {
        return true;
    }
}

?>