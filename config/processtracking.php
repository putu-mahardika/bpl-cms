<?php
    if(isset($_POST['track'])){
        $spk = $_POST['spk'];
        header("location:../tracking.php?lacak=$spk");
    }
?>