<?php

if(isset($_POST['submit'])) {

    $password = $_POST['password'];

    $phone_number = $_POST['phone_num'];

    $first_name = $_POST['firstname'];

    $last_name = $_POST['lastname'];

    $gender = $_POST['sex'];

    $email = $_POST['mail'];

    if (strcmp($password, $_POST['password-re']) == 0)
    {
        echo 'Password Matched';

        if(strength_check($password) == 0)
        {
            header("location: index.php?error_message=Password Too Weak, Please Use Another Password [More Info: https://www.strongpasswordgenerator.org/]");
        }
        else{

            // encryption password
            $password = md5($_POST['password']);

            if((mobile_numberValidation($phone_number) AND (mail_Validation($email) AND string_Validation($first_name) AND string_Validation($last_name))) == 1)
            {
                file_write($first_name, $last_name, $phone_number, $gender, $email, $password);

                header("location: index.php?message=Register Successful, Data Store in Server");
            }
        }

    }else
    {
        header("location: index.php?error_message=Error Occurred, Password Mismatch");
    }

}else {
    header("location: index.php");
}
    // that php function help to check strong password for user

    function strength_check($password): int
    {
        $uppercase = preg_match('@[A-Z]@', $password);

        $lowercase = preg_match('@[a-z]@', $password);

        $number    = preg_match('@[0-9]@', $password);

        $specialChars = preg_match('@[^\w]@', $password);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {

            return 0;
        }else{
            return 1;
        }
    }

    // that function write data on the text file

    function file_write($firstName, $lastName, $mobile, $sex, $mail, $password): void
    {
        $file = fopen("register.txt", "a") or die("Unable to open file!");

        $data = "First Name : $firstName\nLast Name : $lastName\nEmail : $mail\nMobile Number : $mobile\nSex : $sex\nPassword : $password\n\n";

        fwrite($file, $data);

        fclose($file);
    }

    // that function validation strings

    function string_Validation($string_data): int
    {
        if (!preg_match("/^[a-zA-Z ]*$/",$string_data))
        {
            header("location: index.php?error_message=Some Strings Can't Be Accepted (A-Z, a-z accepted)");
            return 0;
        }else{
            return 1;
        }
    }

    // that function helps validation e-mails

    function mail_Validation($mail_address): int
    {
        if (!filter_var($mail_address, FILTER_VALIDATE_EMAIL))
        {
            header("location: index.php?error_message=Wrong E-Mail Format");

            return 0;
        }else{
            return 1;
        }
    }

    // that function helps validate mobile numbers

    function mobile_numberValidation($number): int
    {
        if (!preg_match("/^[0-9]*$/", $number))
        {
            header("location: index.php?error_message=Wrong With Mobile Number");

            return 0;
        }else
        {
            if(strlen ($number) != 10)
            {
                header("location: index.php?error_message=Mobile no must contain 10 digits");

                return 0;
            }else{
                return 1;
            }
        }
    }
