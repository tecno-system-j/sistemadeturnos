<?php 
if(isset($_SESSION['rol'])){
    if ($_SESSION['rol'] == "0") {
        $data['header'] = 'header.php';
    } else {
        $data['header'] = 'header2.php';
    }
}else{
    $data['header'] = 'headererror.php';
}


include_once 'Views/Templates/'.$data['header']; ?>