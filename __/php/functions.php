<?php
    function validate($data) {
        $data = trim($data);
        $data = htmlentities($data);
        $data = stripslashes($data);

        return $data;
    }
?>