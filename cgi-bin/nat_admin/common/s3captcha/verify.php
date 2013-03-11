<?php
session_start();

if($_POST['s3capcha'] == $_SESSION['s3capcha'] && $_POST['s3capcha'] != '') {
    unset($_SESSION['s3capcha']);
    echo 'success!';
} else {
    echo 'fail';
}

?>