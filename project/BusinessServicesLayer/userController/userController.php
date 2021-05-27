<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once '../../BusinessServicesLayer/userModel/userModel.php';

class userController{
    
    // login //
    function login(){
        $user = new userModel();
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];
        $user->user_type = $_POST['user_type'];

        if($user->check() > 0){
            $pwdb = $user->getPw();

            if(password_verify($user->password, $pwdb)){
                $user->user_id = $user->getId();

                if($user->user_type == "Service Provider"){
                    $status = $user->sp_checkStatus();

                    if($status == "Pass"){
                        session_start();
                        $_SESSION["status"] = "truesp";
                        $_SESSION["loggedin"] = true;
                        $_SESSION["user_id"] = $user->user_id;
                        $iddb = $user->sp_getId();
                        $_SESSION["id"] = $iddb;
                        $namedb = $user->sp_getName();
                        $_SESSION["name"] = $namedb;

                        header("location: ../../ApplicationLayer/ManageUser/SPHomepage.php");
                    }
                    else{
                        $message = "Invalid login. Please check with our customer service. Thank you.";
                                    echo "<script type='text/javascript'>alert('$message');
                                    window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
                                    exit;
                    }
                }
                else if($user->user_type == "Customer"){
                    $_SESSION["status"] = "truecust";
                    $_SESSION["loggedin"] = true;
                    $_SESSION["user_id"] = $user->user_id;
                    if($user->cus_firstCheck() > 0){ 
                        $iddb = $user->cus_getId();
                        $_SESSION["id"] = $iddb;
                        $namedb = $user->cus_getName();
                        $_SESSION["name"] = $namedb;

                        header("location: ../../ApplicationLayer/ManageUser/CustomerHomepage.php");
                    }
                    else{
                        header("location: ../../ApplicationLayer/ManageUser/CustomerFirstProfile.php");
                        exit;
                    }
                }
                else if($user->user_type == "Runner"){
                    $status = $user->rn_checkStatus();

                    if($status == "Pass"){
                        $_SESSION["status"] = "truerun";
                        $_SESSION["loggedin"] = true;
                        $_SESSION["user_id"] = $user->user_id; 
                        $iddb = $user->rn_getId();
                        $_SESSION["id"] = $iddb;
                        $namedb = $user->rn_getName();
                        $_SESSION["name"] = $namedb;

                        header("location: ../../ApplicationLayer/ManageUser/RunnerHomepage.php");
                    }
                    else{
                        $message = "Invalid login. Please check with our customer service. Thank you.";
                                    echo "<script type='text/javascript'>alert('$message');
                                    window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
                                    exit;
                    }
                }
            }
            else {
                $message = "Email or password is wrong.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/Home/Login.php';</script>";
            }
        }
        else {
            $message = "You have not sign up yet. Please sign up now.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
        }

            if($user->user_type == "Admin"){
                if($user->password == $pwdb){
                    $_SESSION["status"] = "truead";
                    $_SESSION["loggedin"] = true;
                    $_SESSION["user_id"] = $user->user_id; 
                    $_SESSION["name"] = "Sec4Group5";
                    header("location: ../../ApplicationLayer/ManageUser/AdminHomepage.php");
                }
                else {
                    $message = "Email or password is wrong.";
                    echo "<script type='text/javascript'>alert('$message');
                    window.location = '../../ApplicationLayer/Home/Login.php';</script>";
                }
            }
    }

    // sign up // 
    function signup(){
        $user = new userModel();
        $user->email = $_POST['email'];
        $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user->user_type = $_POST['user_type'];

        if(!filter_var($user->email, FILTER_VALIDATE_EMAIL)){
            $message = "Please insert proper email!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/Home/CustomerSignup.php';</script>";
            exit;
        }

        if($user->check() > 0){
            $message = "Email has been used. Please use another email!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/Home/CustomerSignup.php';</script>";
            exit;
        }

        if($user->signup() > 0){
            $message = "Successfully Registered!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/Home/Login.php';</script>";
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/Home/CustomerSignup.php';</script>";
        }
    }

    //sign up for sp and runner//
    function signup_other(){
        $user = new userModel();
        $user->email = $_POST['email'];
        $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user->user_type = $_POST['user_type'];
        if(!filter_var($user->email, FILTER_VALIDATE_EMAIL)){
            $message = "Please insert proper email!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
            exit;
        }

        if($user->check() > 0){
            $message = "Email has been used. Please use another email!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
            exit;
        }

        if($user->signup() > 0){

            $user->user_id = $user->getId();
            $getId = base64_encode($user->user_id);

            $token = "abcdefghijklmnopqrstuvwyz0123456789";
            $token = str_shuffle($token);
            $user->token = substr($token, 0, 10);

            if($user->addId() > 0){

                require_once "../../PHPMailer/PHPMailer.php";
                require_once "../../PHPMailer/SMTP.php";
                require_once "../../PHPMailer/Exception.php";

                $mail = new PHPMailer();

                $mail->isSMTP();
                $mail->Host =  "smtp.gmail.com";
                $mail->SMTPAuth = true;
                $mail->Username = "sdwsec4grp5@gmail.com";
                $mail->Password = "SEC4@grp5";
                $mail->Port = 465;
                $mail->SMTPSecure = "ssl";

                if($_POST['user_type'] == "Runner"){
                    
                    $mail->isHTML(true);
                    $mail->addAddress($user->email);
                    $mail->setFrom("sdwsec4grp5@gmail.com", "Mr/Mrs/Ms");
                    $mail->Subject = "Fill in Your Personal Details";                
                    $mail->Body = "Hi, <br><br> 
                               Please click on the link below to fill in your details: <br> 
                               <a href='http://localhost/project/ApplicationLayer/ManageUser/RunnerFirstProfile.php?user_id=$getId&token=$user->token'> http://localhost/project/ApplicationLayer/ManageUser/RunnerFirstProfile?user_id=$getId&token=$user->token </a> 
                               <br> <br>
                               Kindly Regards,<br> 
                               AskRunner.";

                    if($mail->send()){
                        $message = "Done! Please check your email inbox.";
                        echo "<script type='text/javascript'>alert('$message');
                        window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
                    }
                    else{
                        $message = "Error! Please try again.";
                        echo "<script type='text/javascript'>alert('$message');
                        window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
                    }
                }
                else if($_POST['user_type'] == "Service Provider"){

                    $mail->isHTML(true);
                    $mail->addAddress($user->email);
                    $mail->setFrom("sdwsec4grp5@gmail.com", "Mr/Mrs/Ms");
                    $mail->Subject = "Fill in Your Personal Details";                
                    $mail->Body = "Hi, <br><br> 
                               Please click on the link below to fill in your details: <br> 
                               <a href='http://localhost/project/ApplicationLayer/ManageUser/SPFirstProfile.php?user_id=$getId&token=$user->token'> http://localhost/project/ApplicationLayer/ManageUser/SPFirstProfile.php?user_id=$getId&token=$user->token </a> 
                               <br> <br>
                               Kindly Regards,<br> 
                               AskRunner.";

                    if($mail->send()){
                        $message = "Done! Please check your email inbox.";
                        echo "<script type='text/javascript'>alert('$message');
                        window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
                    }
                    else{
                        $message = "Error! Please try again.";
                        echo "<script type='text/javascript'>alert('$message');
                        window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
                    }
                }
            }
            else{
                $message = "Error! Please try again.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
            }
        }
        else{
                $message = "Sign up failed! Please try again.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
        }
    }   

    // reset password //
    function reset(){
        $user = new userModel();
        $user->email = $_POST['email'];
        $user->user_type = $_POST['user_type'];
        if($user->check() > 0){
            $token = "abcdefghijklmnopqrstuvwyz0123456789";
            $token = str_shuffle($token);
            $user->token = substr($token, 0, 10);

            $user->user_id = $user->getId();
            $getId = base64_encode($user->user_id);

            if($user->addId() > 0){

                require_once "../../PHPMailer/PHPMailer.php";
                require_once "../../PHPMailer/SMTP.php";
                require_once "../../PHPMailer/Exception.php";

                $mail = new PHPMailer();

                $mail->isSMTP();
                $mail->Host =  "smtp.gmail.com";
                $mail->SMTPAuth = true;
                $mail->Username = "sdwsec4grp5@gmail.com";
                $mail->Password = "SEC4@grp5";
                $mail->Port = 465;
                $mail->SMTPSecure = "ssl";

                $mail->isHTML(true);
                $mail->addAddress($user->email);
                $mail->setFrom("sdwsec4grp5@gmail.com", "Mr/Mrs/Ms");
                $mail->Subject = "Reset Password";                
                $mail->Body = "Hi, <br><br> 
                               In order to reset your password, please click on the link below: <br> 
                               <a href='http://localhost/project/ApplicationLayer/Home/SetPassword.php?user_id=$getId&token=$user->token'> http://localhost/project/ApplicationLayer/Home/SetPassword.php?user_id=$getId&token=$user->token </a> 
                               <br> <br>
                               Kindly Regards,<br> 
                               AskRunner.";

                if($mail->send()){
                    $message = "Please check your email inbox.";
                    echo "<script type='text/javascript'>alert('$message');
                    window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
                }
                else{
                    $message = "Error!";
                    echo "<script type='text/javascript'>alert('$message');
                    window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
            }

            }
            else{
                $message = "Error! Please try again.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
            }
        }
        else{
            $message = "Email does not exist.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
        }
    }

    function setPw($user_idd,$tokenn){
        $user = new userModel();
        $user_idd = base64_decode($user_idd);
        $user->user_id = $user_idd;
        $user->token = $tokenn;

        if($user->checkId() > 0){
            $set_pw = "abcdefghijklmnopqrstuvwyz0123456789";
            $set_pw = str_shuffle($set_pw);
            $set_pw = substr($set_pw, 0, 10);
            $user->set_pw = password_hash($set_pw, PASSWORD_DEFAULT);

            $set_token = "abcdefghijklmnopqrstuvwyz0123456789";
            $set_token = str_shuffle($set_token);
            $user->new_token = substr($set_token, 0, 10);

            if($user->set_newPw() > 0){
                $message = 'Your new password is '.$set_pw.'. Please change the password after login.';
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
            }
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
        }
    }

    function view($user_idd,$tokenn){
        $user = new userModel();
        $user_id = base64_decode($user_idd);
        $user->user_id = $user_id;
        $user->token = $tokenn;
        if($user->checkId() > 0){
            return $user->view();
            exit;
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
        }     
    }

    // change password // 
    function changePw($user_idd,$statuss){
        $user = new userModel();
        $user->user_id = $user_idd;
        $user->status = $statuss;
        $user->curr_pw = $_POST['curr_pw'];
        $user->new_pw = $_POST['new_pw'];
        $user->new_pw2 = $_POST['new_cfm_pw'];
        $user->new_cfm_pw = password_hash($_POST['new_pw'], PASSWORD_DEFAULT);
        $pwdb = $user->pwCheck();

        if($user->status == "truesp"){
            if(!(password_verify($user->curr_pw, $pwdb)) || $user->new_pw != $user->new_pw2){
                $message = "Current password or new password does not match. Please try again.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageUser/SPChangePassword.php';</script>"; 
                exit;  
            }

            if($user->curr_pw == $user->new_pw){
                $message = "Current password cannot be same with new password. Please try again.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageUser/SPChangePassword.php';</script>";
                exit;   
            }

            if(password_verify($user->curr_pw, $pwdb) && $user->new_pw == $user->new_pw2){
                if($user->changePw() > 0){
                    $message = "Password successfully changed!";
                    echo "<script type='text/javascript'>alert('$message');
                    window.location = '../../ApplicationLayer/ManageUser/SPChangePassword.php';</script>";
                }
            }
            else{
                $message = "Error! Please try again.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageUser/SPChangePassword.php';</script>";
            }
        }
        else if($user->status == "truecust"){
            if(!(password_verify($user->curr_pw, $pwdb)) || $user->new_pw != $user->new_pw2){
                $message = "Current password or new password does not match. Please try again.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageUser/CustomerChangePassword.php';</script>"; 
                exit;  
            }

            if($user->curr_pw == $user->new_pw){
                $message = "Current password cannot be same with new password. Please try again.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageUser/CustomerChangePassword.php';</script>";
                exit;   
            }

            if(password_verify($user->curr_pw, $pwdb) && $user->new_pw == $user->new_pw2){
                if($user->changePw() > 0){
                    $message = "Password successfully changed!";
                    echo "<script type='text/javascript'>alert('$message');
                    window.location = '../../ApplicationLayer/ManageUser/CustomerChangePassword.php';</script>";
                }
            }
            else{
                $message = "Error! Please try again.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageUser/CustomerChangePassword.php';</script>";
            }
        }
        else if($user->status == "truerun"){
            if(!(password_verify($user->curr_pw, $pwdb)) || $user->new_pw != $user->new_pw2){
                $message = "Current password or new password does not match. Please try again.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageUser/RunnerChangePassword.php';</script>"; 
                exit;  
            }

            if($user->curr_pw == $user->new_pw){
                $message = "Current password cannot be same with new password. Please try again.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageUser/RunnerChangePassword.php';</script>";
                exit;   
            }

            if(password_verify($user->curr_pw, $pwdb) && $user->new_pw == $user->new_pw2){
                if($user->changePw() > 0){
                    $message = "Password successfully changed!";
                    echo "<script type='text/javascript'>alert('$message');
                    window.location = '../../ApplicationLayer/ManageUser/RunnerChangePassword.php';</script>";
                }
            }
            else{
                $message = "Error! Please try again.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageUser/RunnerChangePassword.php';</script>";
            }
        }
    }

    // admin update sp status // 
    function ad_viewSp($sp_id){
        $user = new userModel();
        $user->sp_id = $sp_id;
        return $user->ad_viewSp();
    }

    function ad_spData(){
        $user = new userModel();

        $user->limit = 5;
        $page = 1;

        if($_POST['page'] > 1){
            $user->start = (($_POST['page'] - 1) * $user->limit);
            $page = $_POST['page'];
        }
        else{
            $user->start = 0; 
            
        }

        $endrow = $user->start + $user->limit;

        if($_POST['search'] == ""){
            $data = $user->ad_spList();
            $datano = $user->ad_allSPList();
        }
        else if($_POST['search'] != ""){
            $user->search = $_POST['search'];
            $data = $user->ad_spSpec();
            $datano = $user->ad_allSPSpec();
        }

        $output = '
        <table id="product_tb" border="1" style="width:75%;" align="center">
        <tr style="border-bottom:1px solid black;">
        <th>No</th>
        <th>Name</th>
        <th>Phone Number</th>
        <th>Status</th>
        </tr>';

        if($datano == 0){
            $output .= '
                <tr style="border-bottom:1px solid black;">
                <td align="center" colspan="5"><h3> No data found </h3></td>
                ';
        }
        else{
            $i = ($user->start+1);
            foreach($data as $row){
                $image = '<img src="../../images/GUIImages/pencil.png" style="width:25px;height:25px;border:0"/>';
                $location = '"AdminEditSP.php?sp_id='.$row["sp_id"].'"';

                $output .= '
                <tr style="border-bottom:1px solid black;">
                <td align="center">'.$i.'</td>
                <td align="center" width="50%">'.$row["sp_name"].'</td>
                <td align="center">'.$row["phone_num"].'</td>
                <td align="center">
                    <button type="button" style="border:transparent;background:none;vertical-align:middle;" onclick=\'location.href='.$location.'\'>' .$image. '</button>
                </td>';
                $i++; 
            }

        $total_links = ceil($datano/$user->limit);

        $previous_link = '';
        $next_link = '';
        $page_link = '';

        if($total_links > 4){
            if($page < 5){
                for($count = 1; $count < 5; $count++){
                    $page_array[] = $count;
                }
                $page_array[] = '...';
                $page_array[] = $total_links;
            }
            else {
                $end_limit = $total_links - 5;
                if($end_limit == 0){
                        $page_array[] = '...';
                        for($count = 2; $count <= $total_links; $count++){
                            $page_array[] = $count;
                        }
                }
                else if($page > $end_limit){
                    $page_array[] = 1;
                    $page_array[] = '...';
                        for($count = $end_limit; $count <= $total_links; $count++){
                            $page_array[] = $count;
                        }
                }
                else{
                    $page_array[] = 1;
                    $page_array[] = '...';
                        for($count = $page - 1; $count <= $page + 1; $count++){
                            $page_array[] = $count;
                        }
                    $page_array[] = '...';
                    $page_array[] = $total_links;
                }
            }
        }
        else{
            for($count = 1; $count <= $total_links; $count++){
                $page_array[] = $count;
            }
        }

        for($count = 0; $count < count($page_array); $count++){
            if($page == $page_array[$count]){
                $page_link .= '
                <li class="active">
                <a class="page-link" href="#">'.$page_array[$count].'</a>
                </li>
                ';

                $previous_id = $page_array[$count] - 1;
                if($previous_id > 0){
                    $previous_link = '<li><a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
                }
                else{
                    $previous_link = '
                        <li class="disabled">
                        <a class="page-link" href="#">Previous</a>
                        </li>
                        ';
                }
                $next_id = $page_array[$count] + 1;
                if($next_id > $total_links){
                    $next_link = '
                    <li class="disabled">
                    <a class="page-link" href="#">Next</a>
                    </li>
                    ';
                }
                else{
                    $next_link = '<li><a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
                }
            }
            else{
                if($page_array[$count] == '...'){
                    $page_link .= '
                        <li class="disabled">
                        <a class="page-link" href="#">...</a>
                        </li>
                        ';
                }
                else{
                    $page_link .= '
                        <li><a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
                    ';
                }
            }
        }
        }

        if($datano == 0){
            $output .= '
                </tr>
                </table>
                <table id="t4" style="width:100%">
                <tr>
                <td><h3> Showing 0 result</h3></td>
                </tr> 
                </table>
                ';
        }
        else{
            if($datano < $endrow){
            $output .= '
                </tr>
                </table>
                <table id="t4" style="width:100%">
                <tr>
                <td><h3> Showing ' .($user->start+1). ' to ' . $datano. ' from ' .$datano. '</h3></td>
                <td style="width:40%"></td>
                <td><ul class="pagination"> '.$previous_link.'' .$page_link. '' .$next_link.'</ul></td></tr> 
                </table>
                ';
            }
            else{
            $output .= '
                </tr>
                </table>
                <table id="t4" style="width:100%">
                <tr>
                <td><h3>Showing ' .($user->start+1). ' to ' . $endrow. ' from ' .$datano. '</h3></td>
                <td style="width:40%"></td>
                <td><ul class="pagination"> '.$previous_link.'' .$page_link. '' .$next_link.'</ul></td></tr>
                </table>
                ';
            }
        }

        echo $output;
    }

    function ad_spStatus(){
        $user = new userModel();
        $user->sp_id = $_POST['sp_id'];
        $user->status = $_POST['status'];

        if($user->ad_spStatus() > 0){
            $message = "Done.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/AdminViewSP.php';</script>";
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/AdminViewSP.php';</script>";
        }
    }

    // admin update runner status // 
    function ad_viewRn($rn_id){
        $user = new userModel();
        $user->rn_id = $rn_id;
        return $user->ad_viewRn();
    }

    function ad_rnData(){
        $user = new userModel();

        $user->limit = 5;
        $page = 1;

        if($_POST['page'] > 1){
            $user->start = (($_POST['page'] - 1) * $user->limit);
            $page = $_POST['page'];
        }
        else{
            $user->start = 0;   
        }

        $endrow = $user->start + $user->limit;

        if($_POST['search'] == ""){
            $data = $user->ad_rnList();
            $datano = $user->ad_allRNList();
        }
        else{
            $user->search = $_POST['search'];
            $data = $user->ad_rnSpec();
            $datano = $user->ad_allRNSpec();
        }

        $output = '
        <table id="product_tb" border="1" style="width:75%;" align="center">
        <tr style="border-bottom:1px solid black;">
        <th>No</th>
        <th>Name</th>
        <th>Phone Number</th>
        <th>Status</th>
        </tr>';

        if($datano == 0){
            $output .= '
                <tr style="border-bottom:1px solid black;">
                <td align="center" colspan="5"><h3> No data found </h3></td>
                ';
        }
        else{
            $i = ($user->start+1);
            foreach($data as $row){
                $image = '<img src="../../images/GUIImages/pencil.png" style="width:25px;height:25px;border:0"/>';
                $location = '"AdminEditRunner.php?rn_id='.$row["rn_id"].'"';

                $output .= '
                <tr style="border-bottom:1px solid black;">
                <td align="center">'.$i.'</td>
                <td align="center">'.$row["rn_name"].'</td>
                <td align="center">'.$row["phone_num"].'</td>
                <td align="center">
                    <button type="button" style="border:transparent;background:none;vertical-align:middle;" onclick=\'location.href='.$location.'\'>' .$image. '</button>
                </td>';
                $i++; 
            }

        $total_links = ceil($datano/$user->limit);

        $previous_link = '';
        $next_link = '';
        $page_link = '';

        if($total_links > 4){
            if($page < 5){
                for($count = 1; $count < 5; $count++){
                    $page_array[] = $count;
                }
                $page_array[] = '...';
                $page_array[] = $total_links;
            }
            else {
                $end_limit = $total_links - 5;
                if($end_limit == 0){
                        $page_array[] = '...';
                        for($count = 2; $count <= $total_links; $count++){
                            $page_array[] = $count;
                        }
                }
                else if($page > $end_limit){
                    $page_array[] = 1;
                    $page_array[] = '...';
                        for($count = $end_limit; $count <= $total_links; $count++){
                            $page_array[] = $count;
                        }
                }
                else{
                    $page_array[] = 1;
                    $page_array[] = '...';
                        for($count = $page - 1; $count <= $page + 1; $count++){
                            $page_array[] = $count;
                        }
                    $page_array[] = '...';
                    $page_array[] = $total_links;
                }
            }
        }
        else{
            for($count = 1; $count <= $total_links; $count++){
                $page_array[] = $count;
            }
        }

        for($count = 0; $count < count($page_array); $count++){
            if($page == $page_array[$count]){
                $page_link .= '
                <li class="active">
                <a class="page-link" href="#">'.$page_array[$count].'</a>
                </li>
                ';

                $previous_id = $page_array[$count] - 1;
                if($previous_id > 0){
                    $previous_link = '<li><a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
                }
                else{
                    $previous_link = '
                        <li class="disabled">
                        <a class="page-link" href="#">Previous</a>
                        </li>
                        ';
                }
                $next_id = $page_array[$count] + 1;
                if($next_id > $total_links){
                    $next_link = '
                    <li class="disabled">
                    <a class="page-link" href="#">Next</a>
                    </li>
                    ';
                }
                else{
                    $next_link = '<li><a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
                }
            }
            else{
                if($page_array[$count] == '...'){
                    $page_link .= '
                        <li class="disabled">
                        <a class="page-link" href="#">...</a>
                        </li>
                        ';
                }
                else{
                    $page_link .= '
                        <li><a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
                    ';
                }
            }
        }
        }

        if($datano == 0){
            $output .= '
                </tr>
                </table>
                <table id="t4" style="width:100%">
                <tr>
                <td><h3> Showing 0 result</h3></td>
                </tr> 
                </table>
                ';
        }
        else{
            if($datano < $endrow){
            $output .= '
                </tr>
                </table>
                <table id="t4" style="width:100%">
                <tr>
                <td><h3> Showing ' .($user->start+1). ' to ' . $datano. ' from ' .$datano. '</h3></td>
                <td style="width:40%"></td>
                <td><ul class="pagination"> '.$previous_link.'' .$page_link. '' .$next_link.'</ul></td></tr> 
                </table>
                ';
            }
            else{
            $output .= '
                </tr>
                </table>
                <table id="t4" style="width:100%">
                <tr>
                <td><h3>Showing ' .($user->start+1). ' to ' . $endrow. ' from ' .$datano. '</h3></td>
                <td style="width:40%"></td>
                <td><ul class="pagination"> '.$previous_link.'' .$page_link. '' .$next_link.'</ul></td></tr>
                </table>
                ';
            }
        }

        echo $output;
    }

    function ad_rnStatus(){
        $user = new userModel();
        $user->rn_id = $_POST['rn_id'];
        $user->status = $_POST['status'];

        if($user->ad_rnStatus() > 0){
            $message = "Done.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/AdminViewRunner.php';</script>";
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/AdminViewRunner.php';</script>";
        }
    }

    //admin download file//
    function ad_downloadIc($id){
        $user = new userModel();
        $user->id = $id;
        $photopath = $user->ad_getIc();
        $filepath = 'images/'.$photopath;
   
        if (file_exists($filepath)){
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '.filesize($filepath));
        readfile($filepath);
    
        exit;
        }
    }

    function ad_downloadLicense($id){
        $user = new userModel();
        $user->id = $id;
        $photopath = $user->ad_getLicense();
        $filepath = 'images/'.$photopath;
   
        if(file_exists($filepath)){
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '.filesize($filepath));
        readfile($filepath);
    
        exit;
        }
    }

    function ad_downloadSPIc($id){
        $user = new userModel();
        $user->id = $id;
        $photopath = $user->ad_getSPIc();
        $filepath = 'images/'.$photopath;
   
        if (file_exists($filepath)){
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '.filesize($filepath));
        readfile($filepath);
    
        exit;
        }
    }
    // service provider profile //
    function sp_view($sp_id){
        $user = new userModel();
        $user->sp_id = $sp_id;
        return $user->sp_view();
    }

    // service provider save first profile//
    function sp_save($user_idd,$tokenn){
        $user = new userModel();

        $user->sp_icpath = $_FILES['sp_icpath']['name'];
        $folder = "../../images/UserImages/";
        $user->file = $folder.basename($_FILES["sp_icpath"]["name"]);
        

        $user->sp_name = $_POST['sp_name'];
        $user->sp_ic = $_POST['sp_ic'];
        $user->phone_num = $_POST['sp_phone_num'];
        $user->sp_address = $_POST['sp_address'];
        $user->sp_shop_name = $_POST['sp_name'];
        $user->email = $_POST['email'];
        $user_idd = $user_idd;
        $user_id = base64_decode($user_idd);
        $user->user_id = $user_id;
        $token = $tokenn;

        $imageFileType = strtolower(pathinfo($user->file,PATHINFO_EXTENSION));

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
            $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/SPFirstProfile.php?user_id=$user_idd&token=$token';</script>";
            exit;
        }

        move_uploaded_file($_FILES['sp_icpath']['tmp_name'], $folder.$user->sp_icpath);

        if($user->sp_save() > 0){
            $token = "abcdefghijklmnopqrstuvwyz0123456789";
            $token = str_shuffle($token);
            $user->token = substr($token, 0, 10);

            if($user->addId() > 0){
                $message = "Thank you!";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
                exit;
            }
            
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
        }
    }

    // service provider update profile//
    function sp_update($sp_id){
        $user = new userModel();
        $user->sp_imgpath = $_FILES['sp_imgpath']['name'];
        $folder = "../../images/UserImages/";
        $user->file = $folder.basename($_FILES["sp_imgpath"]["name"]);
        $user->sp_name = $_POST['sp_name'];
        $user->phone_num = $_POST['sp_phone_num'];
        $user->sp_address = $_POST['sp_address'];
        $user->sp_shop_name = $_POST['sp_shop_name'];
        $user->email = $_POST['email'];
        $user->sp_id = $sp_id;

        $imageFileType = strtolower(pathinfo($user->file,PATHINFO_EXTENSION));

        if($user->sp_imgpath != ""){
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
                $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageUser/SPProfile.php';</script>";
                exit;
            }
        }
        move_uploaded_file($_FILES['sp_imgpath']['tmp_name'], $folder.$user->sp_imgpath);

        if($user->sp_update() > 0){
            $message = "Successfully updated!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/SPProfile.php';</script>";
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/SPProfile.php';</script>";
        }
    }

    // service provider add bank//
    function sp_bankAdd($sp_id){
        $user = new userModel();
        $user->sp_id = $sp_id;
        $user->accname = $_POST['accname'];
        $user->accnum = $_POST['accnum'];
        $user->bankname = $_POST['bankname'];
        
        if($user->sp_bankAdd() > 0){
            $message = "Bank info successfully saved!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/SPBank.php';</script>";
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/SPBank.php';</script>";
        }
    }

    // service provider delete bank//
    function sp_bankDelete($sp_id){
        $user = new userModel();
        $user->sp_id = $sp_id;
        $user->acc_id = $_POST["acc_id"];
        if($user->sp_bankDelete() > 0){
            $message = "Bank info successfully deleted!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/SPBank.php';</script>";
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/SPBank.php';</script>";
        }
    }

    // service provider view bank//
    function sp_bankView($sp_id){
        $user = new userModel();
        $user->sp_id = $sp_id;
        return $user->sp_bankView();
    }

    function sp_bankCheck($sp_id){
        $user = new userModel();
        $user->sp_id = $sp_id;
        return $user->sp_bankCheck();
    }

    // runner view profile //
    function rn_view($rn_id){
        $user = new userModel();
        $user->rn_id = $rn_id;
        return $user->rn_view();
    }

    // runner save first profile //
    function rn_save($user_idd,$tokenn){
        $user = new userModel();

        $user->rn_icpath = $_FILES['rn_icpath']['name'];
        $folder = "../../images/UserImages/";
        $user->file = $folder.basename($_FILES["rn_icpath"]["name"]);
        
        $user->rn_licensepath = $_FILES['rn_licensepath']['name'];
        $folder = "../../images/UserImages/";
        $user->file2 = $folder.basename($_FILES["rn_licensepath"]["name"]);
        
        $user->rn_name = $_POST['rn_name'];
        $user->rn_ic = $_POST['rn_ic'];
        $user->phone_num = $_POST['rn_phone_num'];
        $user->rn_address = $_POST['rn_address'];
        $user->rn_gender = $_POST['rn_gender'];
        $user->email = $_POST['email'];
        $user_idd = $user_idd;
        $user_id = base64_decode($user_idd);
        $user->user_id = $user_id;
        $token = $tokenn;

        $imageFileType = strtolower(pathinfo($user->file,PATHINFO_EXTENSION));
        $imageFileType2 = strtolower(pathinfo($user->file2,PATHINFO_EXTENSION));

        if(($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") || ($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg")) {
            $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/RunnerFirstProfile.php?user_id=$user_idd&token=$token';</script>";
            exit;
        }

        move_uploaded_file($_FILES['rn_licensepath']['tmp_name'], $folder.$user->rn_licensepath);
        move_uploaded_file($_FILES['rn_icpath']['tmp_name'], $folder.$user->rn_icpath);

        if($user->rn_save() > 0){
            $token = "abcdefghijklmnopqrstuvwyz0123456789";
            $token = str_shuffle($token);
            $user->token = substr($token, 0, 10);

            if($user->addId() > 0){
                $message = "Thank you!";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
                exit;
            }

        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/Home/Homepage.php';</script>";
        }
    }

    // runner update profile //
    function rn_update($rn_id){
        $user = new userModel();
        $user->rn_imgpath = $_FILES['rn_imgpath']['name'];
        $folder = "../../images/UserImages/";
        $user->file = $folder.basename($_FILES["rn_imgpath"]["name"]);
        $user->rn_name = $_POST['rn_name'];
        $user->phone_num = $_POST['rn_phone_num'];
        $user->rn_address = $_POST['rn_address'];
        $user->rn_gender = $_POST['rn_gender'];
        $user->email = $_POST['email'];
        $user->rn_id = $rn_id;

        $imageFileType = strtolower(pathinfo($user->file,PATHINFO_EXTENSION));

        if($user->rn_imgpath != ""){
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
                $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageUser/RunnerProfile.php';</script>";
                exit;
            }
        }

        move_uploaded_file($_FILES['rn_imgpath']['tmp_name'], $folder.$user->rn_imgpath);

        if($user->rn_update() > 0){
            $message = "Successfully updated!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/RunnerProfile.php';</script>";
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/RunnerProfile.php';</script>";
        }
    }

    // runner add bank //
    function rn_bankAdd($rn_id){
        $user = new userModel();
        $user->rn_id = $rn_id;
        $user->accname = $_POST['accname'];
        $user->accnum = $_POST['accnum'];
        $user->bankname = $_POST['bankname'];
        
        if($user->rn_bankAdd() > 0){
            $message = "Bank info successfully saved!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/RunnerBank.php';</script>";
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/RunnerBank.php';</script>";
        }
    }

    // runner delete bank//
    function rn_bankDelete($rn_id){
        $user = new userModel();
        $user->rn_id = $rn_id;
        $user->acc_id = $_POST["acc_id"];
        if($user->rn_bankDelete() > 0){
            $message = "Bank info successfully deleted!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/RunnerBank.php';</script>";
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/RunnerBank.php';</script>";
        }
    }

    // runner view bank //
    function rn_bankView($rn_id){
        $user = new userModel();
        $user->rn_id = $rn_id;
        return $user->rn_bankView();
    }

    function rn_bankCheck($rn_id){
        $user = new userModel();
        $user->rn_id = $rn_id;
        return $user->rn_bankCheck();
    }

    // customer view profile //
    function cus_firstView($user_idd){
        $user = new userModel();
        $user->user_id = $user_idd;
        return $user->cus_firstView();     
    }

    function cus_view($cus_id){
        $user = new userModel();
        $user->cus_id = $cus_id;
        return $user->cus_view();     
    }

    // customer save first profile //
    function cus_save($user_idd){
        $user = new userModel();

        $user->cus_imgpath = $_FILES['cus_imgpath']['name'];
        $folder = "../../images/UserImages/";
        $user->file = $folder.basename($_FILES["cus_imgpath"]["name"]);

        $user->cus_name = $_POST['cus_name'];
        $user->username = $_POST['username'];
        $user->phone_num = $_POST['cus_phone_num'];
        $user->cus_address = $_POST['cus_address'];
        $user->cus_dob = $_POST['cus_dob'];
        $user->cus_gender = $_POST['cus_gender'];
        $user->email = $_POST['email'];
        $user->user_id = $user_idd;

        $imageFileType = strtolower(pathinfo($user->file,PATHINFO_EXTENSION));

        if($user->cus_imgpath != ""){
            if(($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")) {
                $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageUser/CustomerFirstProfile.php';</script>";
                exit;
            }
        }

        move_uploaded_file($_FILES['cus_imgpath']['tmp_name'], $folder.$user->cus_imgpath);

        if($user->cus_save() > 0){
                $iddb = $user->cus_getId();
                $_SESSION["id"] = $iddb;
                $_SESSION['name'] = $user->username;
                
                $message = "Thank you!";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageUser/CustomerHomepage.php';</script>";
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/CustomerFirstProfile.php';</script>";
        }
    }

    // customer update profile //
    function cus_update($cus_id){
        $user = new userModel();
        $user->cus_imgpath = $_FILES['cus_imgpath']['name'];
        $folder = "../../images/UserImages/";
        $user->file = $folder.basename($_FILES["cus_imgpath"]["name"]);

        $user->username = $_POST['username'];
        $user->cus_name = $_POST['cus_name'];
        $user->phone_num = $_POST['cus_phone_num'];
        $user->cus_address = $_POST['cus_address'];
        $user->cus_gender = $_POST['cus_gender'];
        $user->cus_dob = $_POST['cus_dob'];
        $user->email = $_POST['email'];
        $user->cus_id = $cus_id;

        $imageFileType = strtolower(pathinfo($user->file,PATHINFO_EXTENSION));
        
        if($user->cus_imgpath != ""){
            if(($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")) {
                $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageUser/CustomerProfile.php';</script>";
                exit;
            }
        }

        move_uploaded_file($_FILES['cus_imgpath']['tmp_name'], $folder.$user->cus_imgpath);
        
        if($user->cus_update() > 0){
            $message = "Successfully updated!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/CustomerProfile.php';</script>";
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/CustomerProfile.php';</script>";
        }
    }

    // customer add bank //
    function cus_bankAdd($cus_id){
        $user = new userModel();
        $user->cus_id = $cus_id;
        $user->accname = $_POST['accname'];
        $user->accnum = $_POST['accnum'];
        $user->bankname = $_POST['bankname'];
        
        if($user->cus_bankAdd() > 0){
            $message = "Bank info successfully saved!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/CustomerBank.php';</script>";
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/CustomerBank.php';</script>";
        }
    }

    // customer delete bank//
    function cus_bankDelete($cus_id){
        $user = new userModel();
        $user->cus_id = $cus_id;
        $user->acc_id = $_POST["acc_id"];
        if($user->cus_bankDelete() > 0){
            $message = "Bank info successfully deleted!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/CustomerBank.php';</script>";
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/CustomerBank.php';</script>";
        }
    }

    // customer view bank //
    function cus_bankView($cus_id){
        $user = new userModel();
        $user->cus_id = $cus_id;
        return $user->cus_bankView();
    }

    function cus_bankCheck($cus_id){
        $user = new userModel();
        $user->cus_id = $cus_id;
        return $user->cus_bankCheck();
    }
}
?>
