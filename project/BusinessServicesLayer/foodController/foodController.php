<?php

require_once '../../BusinessServicesLayer/foodModel/foodModel.php';

class foodController{
    // add product//
    function food_addProduct($sp_id){
    	$food = new foodModel();
    	$food->sp_id = $sp_id;
    	$food->name = $_POST['name'];
        $food->detail = trim($_POST['detail']);
        $food->price = $_POST['price'];
        $food->quantity = $_POST['quantity'];
        $food->variation = $_POST['food_variation'];

        $token = "abcdefghijklmnopqrstuvwyz0123456789";
        $token = str_shuffle($token);
        $food->imgid = substr($token, 0, 10);

        $food->coverpath = $_FILES['coverpath']['name'];
        $folder = "../../images/FoodImages/";
        $food->file = $folder.basename($_FILES["coverpath"]["name"]);

        $cover_imageFileType = strtolower(pathinfo($food->file,PATHINFO_EXTENSION));

        if($cover_imageFileType != "jpg" && $cover_imageFileType != "png" && $cover_imageFileType != "jpeg"){
            $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageFoodDelivery/FoodAddProduct.php';</script>";
            exit;
        }

        move_uploaded_file($_FILES['coverpath']['tmp_name'], $folder.$food->coverpath);
        $count = count($_FILES['imgpath']['name']);
        $fileNames = array_filter($_FILES['imgpath']['name']); 

        if($count > 8){
            $message = "Please insert only 8 images.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageFoodDelivery/FoodAddProduct.php';</script>";
            exit;
        }

        if($food->food_addProduct() > 0){
            $food->imgdb = $food->getImg();

            if($count > 0 && !empty($fileNames)){
            for($i=0;$i<$count;$i++){
                $food->imgpath = $_FILES['imgpath']['name'][$i];
                $folder = "../../images/FoodImages/";
                $food->file = $folder.basename($_FILES["imgpath"]["name"][$i]);
                $imageFileType = strtolower(pathinfo($food->file,PATHINFO_EXTENSION));

                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
                    $message = "Sorry, your product images will not be shown as only JPG, JPEG & PNG files are allowed.";
                    echo "<script type='text/javascript'>alert('$message');
                    window.location = '../../ApplicationLayer/ManageFoodDelivery/FoodAddProduct.php';</script>";
                    exit;
                }
                else{
                    move_uploaded_file($_FILES['imgpath']['tmp_name'][$i], $folder.$food->imgpath);
                    $food->food_addImg();
                }
            }

            $message = "The product is successfully inserted!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageFoodDelivery/FoodProduct.php';</script>";  
            }  
            $message = "The product is successfully inserted!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageFoodDelivery/FoodProduct.php';</script>";  
        }
        else{
        	$message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageFoodDelivery/FoodProduct.php';</script>";
        }
    }

    //view food //
    function food_view($sp_id,$fd_idd){
        $food = new foodModel();
        $food->sp_id = $sp_id;
        $fd_iddd = base64_decode($fd_idd);
        $food->id = $fd_iddd;
        return $food->food_view();
    }

    //delete food//
    function food_deleteProduct($sp_id){
    	$food = new foodModel();
    	$food->sp_id = $sp_id;
    	$food->id = $_POST['fd_id'];
    	if($food->food_deleteImg() && $food->food_deleteProduct() > 0){
    		$message = "Product successfully deleted.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageFoodDelivery/FoodProduct.php';</script>";
    	}
    	else {
    		$message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageFoodDelivery/FoodProduct.php';</script>";
    	}
    }

    //edit food//
    function food_editProduct($sp_id){
        $food = new foodModel();
        $food->sp_id = $sp_id;
        $food->id = $_POST['cur_fd_id'];
        $food->name = $_POST['name'];
        $food->detail = trim($_POST['detail']);
        $food->price = $_POST['price'];
        $food->quantity = $_POST['quantity'];
        $food->variation = $_POST['food_variation'];

        $food->coverpath = $_FILES['coverpath']['name'];
        $folder = "../../images/FoodImages/";
        $food->file = $folder.basename($_FILES["coverpath"]["name"]);
        $cover_imageFileType = strtolower(pathinfo($food->file,PATHINFO_EXTENSION));

        $show_fd_id = base64_encode($_POST['cur_fd_id']);

        if($food->coverpath != ""){
            if($cover_imageFileType != "jpg" && $cover_imageFileType != "png" && $cover_imageFileType != "jpeg"){
                $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageFoodDelivery/FoodEditProduct.php?fd_id=".$show_fd_id."';</script>";
                exit;
            }
        }

        move_uploaded_file($_FILES['coverpath']['tmp_name'], $folder.$food->coverpath);
        $count = count($_FILES['imgpath']['name']);
        $fileNames = array_filter($_FILES['imgpath']['name']); 

        if($count > 8){
            $message = "Please insert only 8 images.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageFoodDelivery/FoodEditProduct.php?fd_id=".$show_fd_id."';</script>";
            exit;
        }

        if($food->food_editProduct() > 0 || $count > 0){ 
            if($count > 0 && !empty($fileNames)){

                for($i=0;$i<$count;$i++){
                    $food->imgpath = $_FILES['imgpath']['name'][$i];
                    $folder = "../../images/FoodImages/";

                    $food->file = $folder.basename($_FILES["imgpath"]["name"][$i]);
                    $imageFileType = strtolower(pathinfo($food->file,PATHINFO_EXTENSION));

                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
                        $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
                        echo "<script type='text/javascript'>alert('$message');
                        window.location = '../../ApplicationLayer/ManageFoodDelivery/FoodEditProduct.php?fd_id=".$show_fd_id."';</script>";
                        exit;
                    }
                }

                $food->food_deleteImg();

                for($i=0;$i<$count;$i++){
                    $food->imgpath = $_FILES['imgpath']['name'][$i];
                    $folder = "../../images/FoodImages/";
                    move_uploaded_file($_FILES['imgpath']['tmp_name'][$i], $folder.$food->imgpath);
                    $food->food_editImg();
                }

            
                $message = "The product is successfully inserted!";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageFoodDelivery/FoodViewProduct.php?fd_id=".$show_fd_id."';</script>"; 
                exit;
            }
            else{
                $message = "The product is successfully inserted!";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageFoodDelivery/FoodViewProduct.php?fd_id=".$show_fd_id."';</script>"; 
                exit;
            }
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageFoodDelivery/FoodProduct.php';</script>";
        }
    }

    //show all food//
    function food_showData($sp_id){
        $food = new foodModel();
        $food->sp_id = $sp_id;
        $food->limit = 5;
        $page = 1;

        if($_POST['page'] > 1){
            $food->start = (($_POST['page'] - 1) * $food->limit);
            $page = $_POST['page'];
        }
        else{
            $food->start = 0;   
        }

        $endrow = $food->start + $food->limit;

        if($_POST['sortPrice'] == 0){
            if($_POST['sortQuantity'] == 0){
                $sort = 1;
                $sort_before = 0;
                $sortQuantity = 1;
                $sortQuantity_before = 0;
            }
            else if($_POST['sortQuantity'] == 1){
                $sort = 1;
                $sort_before = 0;
                $sortQuantity = 2;
                $sortQuantity_before = 1;
            }
            else if($_POST['sortQuantity'] == 2){
                $sort = 1;
                $sort_before = 0;
                $sortQuantity = 0;
                $sortQuantity_before = 2;
            }
        }
        else if($_POST['sortPrice'] == 1){
            if($_POST['sortQuantity'] == 0){
            $sort = 2;
            $sort_before = 1;
            $sortQuantity = 1;
            $sortQuantity_before = 0;
            }   
        }
        else if($_POST['sortPrice'] == 2){
            if($_POST['sortQuantity'] == 0){
            $sort = 0;
            $sort_before = 2;
            $sortQuantity = 1;
            $sortQuantity_before = 0;
            }   
        }
        
        if($_POST['variation'] == "none"){
            if($_POST['search'] == ""){
                if($sort_before == 0 && $sortQuantity_before == 0){
                    $data = $food->viewList();
                    $datano = $food->allList();
                }
                else if($sort_before == 1 && $sortQuantity_before == 0){
                    $data = $food->viewListPrice_asc();
                    $datano = $food->allList();
                }
                else if($sort_before == 2 && $sortQuantity_before == 0){
                    $data = $food->viewListPrice_desc();
                    $datano = $food->allList();
                }
                else if($sort_before == 0 && $sortQuantity_before == 1){
                    $data = $food->viewListQuan_asc();
                    $datano = $food->allList();
                }
                else if($sort_before == 0 && $sortQuantity_before == 2){
                    $data = $food->viewListQuan_desc();
                    $datano = $food->allList();
                }
            }
            else if($_POST['search'] != ""){
                $food->search = $_POST['search'];
                if($sort_before == 0 && $sortQuantity_before == 0){
                    $data = $food->viewSpecSearch();
                    $datano = $food->allSpecSearch();
                }
                else if($sort_before == 1 && $sortQuantity_before == 0){
                    $data = $food->viewSpecSearchPrice_asc();
                    $datano = $food->allSpecSearch();
                }
                else if($sort_before == 2 && $sortQuantity_before == 0){
                    $data = $food->viewSpecSearchPrice_desc();
                    $datano = $food->allSpecSearch();
                }
                else if($sort_before == 0 && $sortQuantity_before == 1){
                    $data = $food->viewSpecSearchQuan_asc();
                    $datano = $food->allSpecSearch();
                }
                else if($sort_before == 0 && $sortQuantity_before == 2){
                    $data = $food->viewSpecSearchQuan_desc();
                    $datano = $food->allSpecSearch();
                }
            }
        }
        else{ 
            $food->fd_variation = $_POST['variation'];
            if($_POST['search'] == ""){
                if($sort_before == 0 && $sortQuantity_before == 0){
                    $data = $food->viewSpecList();
                    $datano = $food->allSpecList();
                }
                else if($sort_before == 1 && $sortQuantity_before == 0){
                    $data = $food->viewSpecListPrice_asc();
                    $datano = $food->allSpecList();
                }
                else if($sort_before == 2 && $sortQuantity_before == 0){
                    $data = $food->viewSpecListPrice_desc();
                    $datano = $food->allSpecList();
                }
                else if($sort_before == 0 && $sortQuantity_before == 1){
                    $data = $food->viewSpecListQuan_asc();
                    $datano = $food->allSpecList();
                }
                else if($sort_before == 0 && $sortQuantity_before == 2){
                    $data = $food->viewSpecListQuan_desc();
                    $datano = $food->allSpecList();
                }
            }
            else if($_POST['search'] != ""){
                $food->search = $_POST['search'];
                if($sort_before == 0 && $sortQuantity_before == 0){
                    $data = $food->viewSpec();
                    $datano = $food->allSpec();
                }
                else if($sort_before == 1 && $sortQuantity_before == 0){
                    $data = $food->viewSpecPrice_asc();
                    $datano = $food->allSpec();
                }
                else if($sort_before == 2 && $sortQuantity_before == 0){
                    $data = $food->viewSpecPrice_desc();
                    $datanoc = $food->allSpec();
                }
                else if($sort_before == 0 && $sortQuantity_before == 1){
                    $data = $food->viewSpecQuan_asc();
                    $datano = $food->allSpec();
                }
                else if($sort_before == 0 && $sortQuantity_before == 2){
                    $data = $food->viewSpecQuan_desc();
                    $datano = $food->allSpec();
                }
            }
        }

        $image1 = '<img src="../../images/GUIImages/interface.png" style="width:30px;height:30px;border:0"/>';
        $image2 = '<img src="../../images/GUIImages/pencil.png" style="width:30px;height:30px;border:0"/>';
        $image3 = '<img src="../../images/GUIImages/rubbish.png" style="width:30px;height:30px;border:0"/>';
        $image4 = '<img src="../../images/GUIImages/sort.png" style="width:18px;height:18px;border:0"/>';

        $output = '
        <input type="hidden" id="sortPrice" value="'.$sort.'">
        <input type="hidden" id="sortPrice_before" value="'.$sort_before.'">
        <input type="hidden" id="sortQuantity" value="'.$sortQuantity.'">
        <input type="hidden" id="sortQuantity_before" value="'.$sortQuantity_before.'">
        <input type="hidden" id="show_variation" value="'.$_POST['variation'].'">
        <table id="product_tb" border="1" style="width:75%;" align="center">
        <tr style="border-bottom:1px solid black;">
        <th>No</th>
        <th>Name</th>
        <th>Price  <button type="button" id="sortPriceBtn" style="border:transparent;background:none;vertical-align:middle;">'.$image4.'</button></th>
        <th>Quantity <button type="button" id="sortQuantityBtn" style="border:transparent;background:none;vertical-align:middle;">'.$image4.'</button></th>
        <th>Action</th>
        </tr>';

        if($datano == 0){
            $output .= '
                <tr style="border-bottom:1px solid black;">
                <td align="center" colspan="5"><h3> No data found </h3></td>
                ';
        }
        else{
            $i = ($food->start+1);
            foreach($data as $row){
                $show_fd_id =  base64_encode($row['fd_id']);

                $location1 = '"../../ApplicationLayer/ManageFoodDelivery/FoodViewProduct.php?fd_id='.$show_fd_id.'"';
                $location2 = '"../../ApplicationLayer/ManageFoodDelivery/FoodEditProduct.php?fd_id='.$show_fd_id.'"';
                $output .= '
                <tr style="border-bottom:1px solid black;">
                <td align="center">'.$i.'</td>
                <td align="center">'.$row["fd_name"].'</td>
                <td align="center">'.$row["fd_price"].'</td>
                <td align="center">'.$row["fd_quantity"].'</td>
                <td align="center"><form action="" method="POST"><br>
                  <button type="button" style="border:transparent;background:none;vertical-align:middle;" onclick=\'location.href='.$location1.'\'>' .$image1. '</button>
                  <button type="button" style="border:transparent;background:none;vertical-align:middle;" onclick=\'location.href='.$location2.'\'>' .$image2. '</button>
                  <input type="hidden" name="fd_id" value='.$row["fd_id"].'>
                  <button type="submit" name="delete" style="border:transparent;background:none;vertical-align:middle;" onclick="return confirm(\'Are you sure you want to delete?\')">' .$image3. '</button></form>
                </td>';
                $i++; 
            }

        $total_links = ceil($datano/$food->limit);

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
                <td><h3> Showing ' .($food->start+1). ' to ' . $datano. ' from ' .$datano. '</h3></td>
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
                <td><h3>Showing ' .($food->start+1). ' to ' . $endrow. ' from ' .$datano. '</h3></td>
                <td style="width:40%"></td>
                <td><ul class="pagination"> '.$previous_link.'' .$page_link. '' .$next_link.'</ul></td></tr>
                </table>
                ';
        }
        }

        echo $output;
    }

    //view food image//
    function food_imgView($sp_id,$fd_idd){
        $food = new foodModel();
        $food->sp_id = $sp_id;
        $fd_iddd = base64_decode($fd_idd);
        $food->id = $fd_iddd;
        return $food->food_imgView();
    }

    //get variation//
    function food_getVariation(){
        $food = new foodModel();
        $fd_variation = $_POST['variation'];
        header("location: ViewProduct.php?fd_variation=$fd_variation");
    }

    //view variation//
    function food_viewVariation(){
        $food = new foodModel();
        $food->fd_variation = $_POST['variation'];
        $food->limit = 50;
        $page = 1;

        if($_POST['page'] > 1){
            $food->start = (($_POST['page'] - 1) * $food->limit);
            $page = $_POST['page'];
        }
        else{
            $food->start = 0;   
        }

        $endrow = $food->start + $food->limit;

        if($_POST['search'] == ""){
            if($_POST['sortPrice'] == "none"){
                $data = $food->viewNormal();
                $datano = $food->countNone();
            }
            else if($_POST['sortPrice'] == "asc"){
                $data = $food->viewLow();
                $datano = $food->countNone();
            }
            else if($_POST['sortPrice'] == "desc"){
                $data = $food->viewHigh();
                $datano = $food->countNone();
            }
        }
        else if($_POST['search'] != ""){
            $food->search = $_POST['search'];
            if($_POST['sortPrice'] == "none"){
                $data = $food->viewSearchNormal();
                $datano = $food->countSearch();
            }
            else if($_POST['sortPrice'] == "asc"){
                $data = $food->viewSearchLow();
                $datano = $food->countSearch();
            }
            else if($_POST['sortPrice'] == "desc"){
                $data = $food->viewSearchHigh();
                $datano = $food->countSearch();
            }
        }

        $output = '
        <table id="seeProduct_tb" style="border-spacing: 10px;" align="center">
        <tr>
        ';

        if($datano == 0){
            $output .= '
                <tr style="border-bottom:1px solid black;">
                <td align="center" colspan="5"><h3> No data found </h3></td>
                ';
        }
        else{
            $i = ($food->start+1);
            foreach($data as $row){
                $image = $row['fd_coverpath'];
                $image_src = "../../images/FoodImages/".$image;

                $show_fd_id =  base64_encode($row['fd_id']);

                $location = '"../../ApplicationLayer/ManageFoodDelivery/Product.php?fd_id='.$show_fd_id.'"';

                $output .= '
                    <form action="" method="POST">
                    <td style="padding: 5px;"><button type="button" id="seeProduct_btn" style="width: 180px;height: 230px;border:transparent;" onclick=\'location.href='.$location.'\'><img src='.$image_src.' style="width:160px;height:140px;padding-left:5px;padding-right:7px;"> <br><br> '.$row['fd_name'].' <br><br> RM '.$row['fd_price'].'</button></td>';

                if($i % 5 == 0){
                    $output .='</tr><tr>';
                }
                $i++; 
                
            }

        $total_links = ceil($datano/$food->limit);

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
            $output .= '
                </form>
                </tr>
                </table>
                <table id="t4" style="width:100%">
                <tr>
                <td><h3> Showing ' .$datano. ' product</h3></td>
                <td style="width:40%"></td>
                <td><ul class="pagination"> '.$previous_link.'' .$page_link. '' .$next_link.'</ul></td></tr> 
                </table>
                ';
        }

        echo $output;
    }
    
    //customer view product//
    function food_viewProduct($fd_idd){
        $food = new foodModel();
        $id = base64_decode($fd_idd);
        $food->fd_id = $id;
        return $food->viewProduct();
    }

    //customer view food image//
    function food_viewImgProduct($fd_idd){
        $food = new foodModel();
        $id = base64_decode($fd_idd);
        $food->id = $id;
        return $food->food_viewImgProduct();
    }
}   
?>
