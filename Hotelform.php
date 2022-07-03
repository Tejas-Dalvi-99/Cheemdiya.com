<?php

    $Firstname = $_POST['Firstname']; 
    $Phonenumber = $_POST['Phonenumber']; 
    $DepartureDate = $_POST['DepartureDate']; 
    $Guests = $_POST['Guests']; 
    $Lastname = $_POST['Lastname']; 
    $Email = $_POST['Email']; 
    $ArrivalDate = $_POST['ArrivalDate']; 
    $RoomType = $_POST['RoomType']; 

    if (!empty($Firstname) || !empty($Phonenumber) || !empty($DepartureDate) || !empty($Guests) || !empty($Lastname) || !empty(Email) || !empty($ArrivalDate) || !empty($RoomType)) {
        $host = "localhost" ; 
        $dbUsername = "root" ; 
        $dbPassword = "" ; 
        $dbname = "mydb" ;
        
        $conn = new mysqli($host , $dbUsername , $dbPassword , $dbname) ; 
        if(mysqli_connect_error()){
            die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error()) ; 
        }
        else {
            $SELECT = "SELECT Email from hotelform Where Email = ? Limit 1 "; 
            $INSERT = "INSERT Into hotelform(Firstname , Phonenumber , DepartureDate , Guests , Lastname , Email , ArrivalDate , RoomType) values( ? , ? , ? , ? , ? , ? , ? , ?) " ; 

            $stmt = $conn->prepare($SELECT) ; 
            $stmt->bind_param("s" , $Email);
            $stmt->execute();
            $stmt->bind_result($Email);
            $stmt->store_result(); 
            
            $rnum = $stmt->num_rows ; 
            if($rnum == 0 ){
                $stmt->close();
                
                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("ssssssss" , $Firstname , $Phonenumber , $DepartureDate , $Guests , $Lastname , $Email , $ArrivalDate , $RoomType );  
                $stmt->execute();
                echo "Details Submitted Successfully ! " ;  
            }
            else {
                echo "This Email is already registered" ; 
            }
            $stmt->close() ; 
            $conn->close() ; 
        }
    }
    else{
        echo "Please fill all fields" ; 
        die() ; 
    }

?>
