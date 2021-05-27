<?php

require_once '../../BusinessServicesLayer/petModel/petModel.php';

class petController{
    // add product//
    function pet_addProduct($sp_id){
    	$pet = new petModel();
    	$pet->sp_id = $sp_id;
    	$pet->name = $_POST['name'];
        $pet->detail = trim($_POST['detail']);
        $pet->price = $_POST['price'];
        $pet->quantity = $_POST['quantity'];
        $pet->variation = $_POST['pet_variation'];

        $token = "abcdefghijklmnopqrstuvwyz0123456789";
        $token = str_shuffle($token);
        $pet->imgid = substr($token, 0, 10);

        $pet->coverpath = $_FILES['coverpath']['name'];
        $folder = "../../images/PetImages/";
        $pet->file = $folder.basename($_FILES["coverpath"]["name"]);

        $cover_imageFileType = strtolower(pathinfo($pet->file,PATHINFO_EXTENSION));

        if($cover_imageFileType != "jpg" && $cover_imageFileType != "png" && $cover_imageFileType != "jpeg"){
            $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManagePetAssist/PetAddProduct.php';</script>";
            exit;
        }

        move_uploaded_file($_FILES['coverpath']['tmp_name'], $folder.$pet->coverpath);
        $count = count($_FILES['imgpath']['name']);
        $fileNames = array_filter($_FILES['imgpath']['name']); 

        if($count > 8){
            $message = "Please insert only 8 images.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManagePetAssist/PetAddProduct.php';</script>";
            exit;
        }

        if($pet->pet_addProduct() > 0){
            $pet->imgdb = $pet->getImg();

            if($count > 0 && !empty($fileNames)){
            for($i=0;$i<$count;$i++){
                $pet->imgpath = $_FILES['imgpath']['name'][$i];
                $folder = "../../images/PetImages/";
                $pet->file = $folder.basename($_FILES["imgpath"]["name"][$i]);
                $imageFileType = strtolower(pathinfo($pet->file,PATHINFO_EXTENSION));

                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
                    $message = "Sorry, your product images will not be shown as only JPG, JPEG & PNG files are allowed.";
                    echo "<script type='text/javascript'>alert('$message');
                    window.location = '../../ApplicationLayer/ManagePetAssist/PetAddProduct.php';</script>";
                    exit;
                }
                else{
                    move_uploaded_file($_FILES['imgpath']['tmp_name'][$i], $folder.$pet->imgpath);
                    $pet->pet_addImg();
                }
            }

            $message = "The product is successfully inserted!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManagePetAssist/PetProduct.php';</script>";  
            }  
            $message = "The product is successfully inserted!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManagePetAssist/PetProduct.php';</script>";  
        }
        else{
        	$message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManagePetAssist/PetProduct.php';</script>";
        }
    }

    //view pet //
    function pet_view($sp_id,$pet_idd){
        $pet = new petModel();
        $pet->sp_id = $sp_id;
        $pet_iddd = base64_decode($pet_idd);
        $pet->id = $pet_iddd;
        return $pet->pet_view();
    }

    //delete pet//
    function pet_deleteProduct($sp_id){
    	$pet = new petModel();
    	$pet->sp_id = $sp_id;
    	$pet->id = $_POST['pet_id'];
    	if($pet->pet_deleteImg() && $pet->pet_deleteProduct() > 0){
    		$message = "Product successfully deleted.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManagePetAssist/PetProduct.php';</script>";
    	}
    	else {
    		$message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManagePetAssist/PetProduct.php';</script>";
    	}
    }

    //edit pet//
    function pet_editProduct($sp_id){
        $pet = new petModel();
        $pet->sp_id = $sp_id;
        $pet->id = $_POST['cur_pet_id'];
        $pet->name = $_POST['name'];
        $pet->detail = trim($_POST['detail']);
        $pet->price = $_POST['price'];
        $pet->quantity = $_POST['quantity'];
        $pet->variation = $_POST['pet_variation'];

        $pet->coverpath = $_FILES['coverpath']['name'];
        $folder = "../../images/PetImages/";
        $pet->file = $folder.basename($_FILES["coverpath"]["name"]);
        $cover_imageFileType = strtolower(pathinfo($pet->file,PATHINFO_EXTENSION));

        if($pet->coverpath != ""){
            if($cover_imageFileType != "jpg" && $cover_imageFileType != "png" && $cover_imageFileType != "jpeg"){
                $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManagePetAssist/PetEditProduct.php?pet_id=".$show_pet_id."';</script>";
                exit;
            }
        }

        move_uploaded_file($_FILES['coverpath']['tmp_name'], $folder.$pet->coverpath);
        $count = count($_FILES['imgpath']['name']);
        $fileNames = array_filter($_FILES['imgpath']['name']); 

        $show_pet_id = base64_encode($_POST['cur_pet_id']);

        if($count > 8){
            $message = "Please insert only 8 images.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManagePetAssist/PetEditProduct.php?pet_id=".$show_pet_id."';</script>";
            exit;
        }

        if($pet->pet_editProduct() > 0 || $count > 0){ 
            if($count > 0 && !empty($fileNames)){

                for($i=0;$i<$count;$i++){
                    $pet->imgpath = $_FILES['imgpath']['name'][$i];
                    $folder = "../../images/PetImages/";

                    $pet->file = $folder.basename($_FILES["imgpath"]["name"][$i]);
                    $imageFileType = strtolower(pathinfo($pet->file,PATHINFO_EXTENSION));

                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
                        $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
                        echo "<script type='text/javascript'>alert('$message');
                        window.location = '../../ApplicationLayer/ManagePetAssist/PetEditProduct.php?pet_id=".$show_pet_id."';</script>";
                        exit;
                    }
                }

                $pet->pet_deleteImg();

                for($i=0;$i<$count;$i++){
                    $pet->imgpath = $_FILES['imgpath']['name'][$i];
                    $folder = "../../images/PetImages/";
                    move_uploaded_file($_FILES['imgpath']['tmp_name'][$i], $folder.$pet->imgpath);
                    $pet->pet_editImg();
                }

            
                $message = "The product is successfully inserted!";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManagePetAssist/PetViewProduct.php?pet_id=".$show_pet_id."';</script>"; 
                exit;
            }
            else{
                $message = "The product is successfully inserted!";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManagePetAssist/PetViewProduct.php?pet_id=".$show_pet_id."';</script>"; 
                exit;
            }
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManagePetAssist/PetProduct.php';</script>";
        }
    }

    //show all pet//
    function pet_showData($sp_id){
        $pet = new petModel();
        $pet->sp_id = $sp_id;
        $pet->limit = 5;
        $page = 1;

        if($_POST['page'] > 1){
            $pet->start = (($_POST['page'] - 1) * $pet->limit);
            $page = $_POST['page'];
        }
        else{
            $pet->start = 0;   
        }

        $endrow = $pet->start + $pet->limit;

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
                    $data = $pet->viewList();
                    $datano = $pet->allList();
                }
                else if($sort_before == 1 && $sortQuantity_before == 0){
                    $data = $pet->viewListPrice_asc();
                    $datano = $pet->allList();
                }
                else if($sort_before == 2 && $sortQuantity_before == 0){
                    $data = $pet->viewListPrice_desc();
                    $datano = $pet->allList();
                }
                else if($sort_before == 0 && $sortQuantity_before == 1){
                    $data = $pet->viewListQuan_asc();
                    $datano = $pet->allList();
                }
                else if($sort_before == 0 && $sortQuantity_before == 2){
                    $data = $pet->viewListQuan_desc();
                    $datano = $pet->allList();
                }
            }
            else if($_POST['search'] != ""){
                $pet->search = $_POST['search'];
                if($sort_before == 0 && $sortQuantity_before == 0){
                    $data = $pet->viewSpecSearch();
                    $datano = $pet->allSpecSearch();
                }
                else if($sort_before == 1 && $sortQuantity_before == 0){
                    $data = $pet->viewSpecSearchPrice_asc();
                    $datano = $pet->allSpecSearch();
                }
                else if($sort_before == 2 && $sortQuantity_before == 0){
                    $data = $pet->viewSpecSearchPrice_desc();
                    $datano = $pet->allSpecSearch();
                }
                else if($sort_before == 0 && $sortQuantity_before == 1){
                    $data = $pet->viewSpecSearchQuan_asc();
                    $datano = $pet->allSpecSearch();
                }
                else if($sort_before == 0 && $sortQuantity_before == 2){
                    $data = $pet->viewSpecSearchQuan_desc();
                    $datano = $pet->allSpecSearch();
                }
            }
        }
        else{ 
            $pet->pet_variation = $_POST['variation'];
            if($_POST['search'] == ""){
                if($sort_before == 0 && $sortQuantity_before == 0){
                    $data = $pet->viewSpecList();
                    $datano = $pet->allSpecList();
                }
                else if($sort_before == 1 && $sortQuantity_before == 0){
                    $data = $pet->viewSpecListPrice_asc();
                    $datano = $pet->allSpecList();
                }
                else if($sort_before == 2 && $sortQuantity_before == 0){
                    $data = $pet->viewSpecListPrice_desc();
                    $datano = $pet->allSpecList();
                }
                else if($sort_before == 0 && $sortQuantity_before == 1){
                    $data = $pet->viewSpecListQuan_asc();
                    $datano = $pet->allSpecList();
                }
                else if($sort_before == 0 && $sortQuantity_before == 2){
                    $data = $pet->viewSpecListQuan_desc();
                    $datano = $pet->allSpecList();
                }
            }
            else if($_POST['search'] != ""){
                $pet->search = $_POST['search'];
                if($sort_before == 0 && $sortQuantity_before == 0){
                    $data = $pet->viewSpec();
                    $datano = $pet->allSpec();
                }
                else if($sort_before == 1 && $sortQuantity_before == 0){
                    $data = $pet->viewSpecPrice_asc();
                    $datano = $pet->allSpec();
                }
                else if($sort_before == 2 && $sortQuantity_before == 0){
                    $data = $pet->viewSpecPrice_desc();
                    $datanoc = $pet->allSpec();
                }
                else if($sort_before == 0 && $sortQuantity_before == 1){
                    $data = $pet->viewSpecQuan_asc();
                    $datano = $pet->allSpec();
                }
                else if($sort_before == 0 && $sortQuantity_before == 2){
                    $data = $pet->viewSpecQuan_desc();
                    $datano = $pet->allSpec();
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
            $i = ($pet->start+1);
            foreach($data as $row){
                $show_pet_id =  base64_encode($row['pet_id']);

                $location1 = '"../../ApplicationLayer/ManagePetAssist/PetViewProduct.php?pet_id='.$show_pet_id.'"';
                $location2 = '"../../ApplicationLayer/ManagePetAssist/PetEditProduct.php?pet_id='.$show_pet_id.'"';
                $output .= '
                <tr style="border-bottom:1px solid black;">
                <td align="center">'.$i.'</td>
                <td align="center">'.$row["pet_name"].'</td>
                <td align="center">'.$row["pet_price"].'</td>
                <td align="center">'.$row["pet_quantity"].'</td>
                <td align="center"><form action="" method="POST"><br>
                  <button type="button" style="border:transparent;background:none;vertical-align:middle;" onclick=\'location.href='.$location1.'\'>' .$image1. '</button>
                  <button type="button" style="border:transparent;background:none;vertical-align:middle;" onclick=\'location.href='.$location2.'\'>' .$image2. '</button>
                  <input type="hidden" name="pet_id" value='.$row["pet_id"].'>
                  <button type="submit" name="delete" style="border:transparent;background:none;vertical-align:middle;" onclick="return confirm(\'Are you sure you want to delete?\')">' .$image3. '</button></form>
                </td>';
                $i++; 
            }

        $total_links = ceil($datano/$pet->limit);

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
                <td><h3> Showing ' .($pet->start+1). ' to ' . $datano. ' from ' .$datano. '</h3></td>
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
                <td><h3>Showing ' .($pet->start+1). ' to ' . $endrow. ' from ' .$datano. '</h3></td>
                <td style="width:40%"></td>
                <td><ul class="pagination"> '.$previous_link.'' .$page_link. '' .$next_link.'</ul></td></tr>
                </table>
                ';
        }
        }

        echo $output;
    }

    //view pet image//
    function pet_imgView($sp_id,$pet_idd){
        $pet = new petModel();
        $pet->sp_id = $sp_id;
        $pet_iddd = base64_decode($pet_idd);
        $pet->id = $pet_iddd;
        return $pet->pet_imgView();
    }

     //get variation//
    function pet_getVariation(){
        $pet = new petModel();
        $pet_variation = $_POST['variation'];
        header("location: ViewProduct.php?pet_variation=$pet_variation");
    }

    //view variation//
    function pet_viewVariation(){
        $pet = new petModel();
        $pet->pet_variation = $_POST['variation'];
        $pet->limit = 50;
        $page = 1;

        if($_POST['page'] > 1){
            $pet->start = (($_POST['page'] - 1) * $pet->limit);
            $page = $_POST['page'];
        }
        else{
            $pet->start = 0;   
        }

        $endrow = $pet->start + $pet->limit;

        if($_POST['search'] == ""){
            if($_POST['sortPrice'] == "none"){
                $data = $pet->viewNormal();
                $datano = $pet->countNone();
            }
            else if($_POST['sortPrice'] == "asc"){
                $data = $pet->viewLow();
                $datano = $pet->countNone();
            }
            else if($_POST['sortPrice'] == "desc"){
                $data = $pet->viewHigh();
                $datano = $pet->countNone();
            }
        }
        else if($_POST['search'] != ""){
            $pet->search = $_POST['search'];
            if($_POST['sortPrice'] == "none"){
                $data = $pet->viewSearchNormal();
                $datano = $pet->countSearch();
            }
            else if($_POST['sortPrice'] == "asc"){
                $data = $pet->viewSearchLow();
                $datano = $pet->countSearch();
            }
            else if($_POST['sortPrice'] == "desc"){
                $data = $pet->viewSearchHigh();
                $datano = $pet->countSearch();
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
            $i = ($pet->start+1);
            foreach($data as $row){
                $image = $row['pet_coverpath'];
                $image_src = "../../images/PetImages/".$image;

                $show_pet_id =  base64_encode($row['pet_id']);

                $location = '"../../ApplicationLayer/ManagePetAssist/Product.php?pet_id='.$show_pet_id.'"';

                $output .= '
                    <form action="" method="POST">
                    <td style="padding: 5px;"><button type="button" id="seeProduct_btn" style="width: 180px;height: 230px;border:transparent;" onclick=\'location.href='.$location.'\'><img src='.$image_src.' style="width:160px;height:140px;padding-left:5px;padding-right:7px;"> <br><br> '.$row['pet_name'].' <br><br> RM '.$row['pet_price'].'</button></td>';

                if($i % 5 == 0){
                    $output .='</tr><tr>';
                }
                $i++; 
                
            }

        $total_links = ceil($datano/$pet->limit);

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
    function pet_viewProduct($pet_idd){
        $pet = new petModel();
        $id = base64_decode($pet_idd);
        $pet->pet_id = $id;
        return $pet->viewProduct();
    }

    //customer view pet image//
    function pet_viewImgProduct($pet_idd){
        $pet = new petModel();
        $id = base64_decode($pet_idd);
        $pet->id = $id;
        return $pet->pet_viewImgProduct();
    }

    function pet_getquantity($pet_idd){
        $pet = new petModel();
        $id=$pet_idd;
        $pet->pet_id = $id;
        //$pet->pet_name = $_POST['product_name'];
        
        echo "c $id c";
        //echo "$pet_name";
        return $pet->pet_quantity();
        
    }


}
?>
