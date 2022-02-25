<?php


function inputValidation($FirstName,$LastName, $Username, $Address1, $Contact,$City,$State,$Email,$PostalCode,$Privilege,$DOB){
    $FirstNameValidation='/^[a-zA-Z\s]+$/'; //Name to allow capital + small letter alphabets
    $LastNameValidation='/^[a-zA-Z\s]+$/'; //Name to allow capital + small letter alphabets
    $UsernameValidation='/^[a-zA-Z0-9]+$/'; //ID to allow integer and captial + small letter alphabets
    $AddressValidation='/^[a-zA-Z0-9]+$/'; //Name to allow capital + small letter alphabets
    $ContactValidation='/^[0-9]+$/'; //Contact to allow only integers
    $CityValidation='/^[a-zA-Z0-9]+$/'; //ID to allow integer and captial + small letter alphabets
    $StateValidation='/^[a-zA-Z0-9]+$/'; //ID to allow integer and captial + small letter alphabets
    $EmailValidation='/^[a-zA-Z0-9]+$/'; //Email allow any strings before domain and specify the email domain to only end with @0E1FD651.MTF
    $PostalCodeValidation='/^[0-9]+$/'; //Contact to allow only integers
    //$PasswordValidation='/^[a-zA-Z\s]+$/'; //Name to allow capital + small letter alphabets
    $PrivilegeValidation='/^[0-9]+$/'; //Name to allow capital + small letter alphabets
    $DOBValidation='/^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[012])-\d\d\d\d$/';
    
    
    if(preg_match($FirstNameValidation,$FirstName)){  //check each input form with the specified regex pattern above
        if(preg_match($LastNameValidation,$LastName)){
            if(preg_match($UsernameValidation,$Username)){
                if(preg_match($AddressValidation,$Address1)){
                    if(preg_match($ContactValidation,$Contact)){
                        if(preg_match($CityValidation,$City)){
                            if(preg_match($StateValidation,$State)){
                                if(preg_match($EmailValidation,$Email)){
                                    if(preg_match($PostalCodeValidation,$PostalCode)){
                                        //if(preg_match($PasswordValidation,$Password)){
                                            if(preg_match($PrivilegeValidation,$Privilege)){
                                                if(preg_match($DOBValidation,$DOB)){
                                                    echo '<b><h4>User is successfully created</h4></b><br>'; // replies if correct
                                                    return true;
                                                    
                                                }
                                                
                                            }
                                            else{
                                                echo '<b><h4>Invalid Privilege, please try again</h4></b><br>'; //replies if form have errors if starting from ID then to DOB
                                            }
                                        //}
                                        //else{
                                            ///echo '<b><h4>Invalid Password, please try again</h4></b><br>'; //replies if form have errors if starting from ID then to DOB
                                        //}
                                    }
                                    else{
                                        echo '<b><h4>Invalid PostalCode, please try again</h4></b><br>'; //replies if form have errors if starting from ID then to DOB
                                    }
                                }
                                else{
                                    echo '<b><h4>Invalid Email, please try again</h4></b><br>'; //replies if form have errors if starting from ID then to DOB
                                }
                            }
                            else{
                                echo '<b><h4>Invalid State, please try again</h4></b><br>'; //replies if form have errors if starting from ID then to DOB
                            }
                        }
                        else{
                            echo '<b><h4>Invalid City, please try again</h4></b><br>'; //replies if form have errors if starting from ID then to DOB
                        }
                    }
                    else{
                        echo '<b><h4>Invalid Contact, please try again</h4></b><br>'; //replies if form have errors if starting from ID then to DOB
                    }
                }
                else{
                    echo '<b><h4>Invalid Address, please try again</h4></b><br>'; //replies if form have errors if starting from ID then to DOB
                }
            }
            else{
                echo '<b><h4>Invalid Username, please try again</h4></b><br>'; //replies if form have errors if starting from ID then to DOB
            }
        }
        else{
            echo '<b><h4>Invalid LastName, please try again</h4></b><br>'; //replies if form have errors if starting from ID then to DOB
        }
    }
    else{
        echo '<b><h4>Invalid FirstName, please try again</h4></b><br>'; //replies if form have errors if starting from ID then to DOB
    }
}
?>