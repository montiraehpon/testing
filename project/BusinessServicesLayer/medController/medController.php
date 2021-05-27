<?php

require_once '../../BusinessServicesLayer/medModel/medModel.php';

class medController{
    // add product//
    function med_addProduct($sp_id){
    	$med = new medModel();
    	$med->sp_id = $sp_id;
    	$med->name = $_POST['name'];
        $med->detail = trim($_POST['detail']);
        $med->price = $_POST['price'];
        $med->quantity = $_POST['quantity'];
        $med->variation = $_POST['med_variation'];

        $token = "abcdefghijklmnopqrstuvwyz0123456789";
        $token = str_shuffle($token);
        $med->imgid = substr($token, 0, 10);

        $med->coverpath = $_FILES['coverpath']['name'];
        $folder = "../../images/MedicineImages/";
        $med->file = $folder.basename($_FILES["coverpath"]["name"]);

        $cover_imageFileType = strtolower(pathinfo($med->file,PATHINFO_EXTENSION));

        if($cover_imageFileType != "jpg" && $cover_imageFileType != "png" && $cover_imageFileType != "jpeg"){
            $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageMedicineDelivery/MedAddProduct.php';</script>";
            exit;
        }

        move_uploaded_file($_FILES['coverpath']['tmp_name'], $folder.$med->coverpath);
        $count = count($_FILES['imgpath']['name']);
        $fileNames = array_filter($_FILES['imgpath']['name']); 

        if($count > 8){
            $message = "Please insert only 8 images.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageMedicineDelivery/MedAddProduct.php';</script>";
            exit;
        }

        if($med->med_addProduct() > 0){
            $med->imgdb = $med->getImg();

            if($count > 0 && !empty($fileNames)){
            for($i=0;$i<$count;$i++){
                $med->imgpath = $_FILES['imgpath']['name'][$i];
                $folder = "../../images/MedicineImages/";
                $med->file = $folder.basename($_FILES["imgpath"]["name"][$i]);
                $imageFileType = strtolower(pathinfo($med->file,PATHINFO_EXTENSION));

                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
                    $message = "Sorry, your product images will not be shown as only JPG, JPEG & PNG files are allowed.";
                    echo "<script type='text/javascript'>alert('$message');
                    window.location = '../../ApplicationLayer/ManageMedicineDelivery/MedAddProduct.php';</script>";
                    exit;
                }
                else{
                    move_uploaded_file($_FILES['imgpath']['tmp_name'][$i], $folder.$med->imgpath);
                    $med->med_addImg();
                }
            }

            $message = "The product is successfully inserted!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageMedicineDelivery/MedProduct.php';</script>";  
            }  
            $message = "The product is successfully inserted!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageMedicineDelivery/MedProduct.php';</script>";  
        }
        else{
        	$message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageMedicineDelivery/MedProduct.php';</script>";
        }
    }

    //view med //
    function med_view($sp_id,$med_idd){
        $med = new medModel();
        $med->sp_id = $sp_id;
        $med_iddd = base64_decode($med_idd);
        $med->id = $med_iddd;
        return $med->med_view();
    }

    //delete med//
    function med_deleteProduct($sp_id){
    	$med = new medModel();
    	$med->sp_id = $sp_id;
    	$med->id = $_POST['med_id'];
    	if($med->med_deleteImg() && $med->med_deleteProduct() > 0){
    		$message = "Product successfully deleted.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageMedicineDelivery/MedProduct.php';</script>";
    	}
    	else {
    		$message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageMedicineDelivery/MedProduct.php';</script>";
    	}
    }

    //edit med//
    function med_editProduct($sp_id){
        $med = new medModel();
        $med->sp_id = $sp_id;
        $med->id = $_POST['cur_med_id'];
        $med->name = $_POST['name'];
        $med->detail = trim($_POST['detail']);
        $med->price = $_POST['price'];
        $med->quantity = $_POST['quantity'];
        $med->variation = $_POST['med_variation'];

        $med->coverpath = $_FILES['coverpath']['name'];
        $folder = "../../images/MedicineImages/";
        $med->file = $folder.basename($_FILES["coverpath"]["name"]);
        $cover_imageFileType = strtolower(pathinfo($med->file,PATHINFO_EXTENSION));

        if($med->coverpath != ""){
            if($cover_imageFileType != "jpg" && $cover_imageFileType != "png" && $cover_imageFileType != "jpeg"){
                $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageMedicineDelivery/MedEditProduct.php?med_id=".$show_med_id."';</script>";
                exit;
            }
        }

        move_uploaded_file($_FILES['coverpath']['tmp_name'], $folder.$med->coverpath);
        $count = count($_FILES['imgpath']['name']);
        $fileNames = array_filter($_FILES['imgpath']['name']); 

        $show_med_id = base64_encode($_POST['cur_med_id']);

        if($count > 8){
            $message = "Please insert only 8 images.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageMedicineDelivery/MedEditProduct.php?med_id=".$show_med_id."';</script>";
            exit;
        }

        if($med->med_editProduct() > 0 || $count > 0){ 
            if($count > 0 && !empty($fileNames)){

                for($i=0;$i<$count;$i++){
                    $med->imgpath = $_FILES['imgpath']['name'][$i];
                    $folder = "../../images/MedicineImages/";

                    $med->file = $folder.basename($_FILES["imgpath"]["name"][$i]);
                    $imageFileType = strtolower(pathinfo($med->file,PATHINFO_EXTENSION));

                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
                        $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
                        echo "<script type='text/javascript'>alert('$message');
                        window.location = '../../ApplicationLayer/ManageMedicineDelivery/MedEditProduct.php?med_id=".$show_med_id."';</script>";
                        exit;
                    }
                }

                $med->med_deleteImg();

                for($i=0;$i<$count;$i++){
                    $med->imgpath = $_FILES['imgpath']['name'][$i];
                    $folder = "../../images/MedicineImages/";
                    move_uploaded_file($_FILES['imgpath']['tmp_name'][$i], $folder.$med->imgpath);
                    $med->med_editImg();
                }

            
                $message = "The product is successfully inserted!";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageMedicineDelivery/MedViewProduct.php?med_id=".$show_med_id."';</script>"; 
                exit;
            }
            else{
                $message = "The product is successfully inserted!";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageMedicineDelivery/MedViewProduct.php?med_id=".$show_med_id."';</script>"; 
                exit;
            }
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageMedicineDelivery/MedProduct.php';</script>";
        }
    }

    //show all med//
    function med_showData($sp_id){
        $med = new medModel();
        $med->sp_id = $sp_id;
        $med->limit = 5;
        $page = 1;

        if($_POST['page'] > 1){
            $med->start = (($_POST['page'] - 1) * $med->limit);
            $page = $_POST['page'];
        }
        else{
            $med->start = 0;   
        }

        $endrow = $med->start + $med->limit;

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
                    $data = $med->viewList();
                    $datano = $med->allList();
                }
                else if($sort_before == 1 && $sortQuantity_before == 0){
                    $data = $med->viewListPrice_asc();
                    $datano = $med->allList();
                }
                else if($sort_before == 2 && $sortQuantity_before == 0){
                    $data = $med->viewListPrice_desc();
                    $datano = $med->allList();
                }
                else if($sort_before == 0 && $sortQuantity_before == 1){
                    $data = $med->viewListQuan_asc();
                    $datano = $med->allList();
                }
                else if($sort_before == 0 && $sortQuantity_before == 2){
                    $data = $med->viewListQuan_desc();
                    $datano = $med->allList();
                }
            }
            else if($_POST['search'] != ""){
                $med->search = $_POST['search'];
                if($sort_before == 0 && $sortQuantity_before == 0){
                    $data = $med->viewSpecSearch();
                    $datano = $med->allSpecSearch();
                }
                else if($sort_before == 1 && $sortQuantity_before == 0){
                    $data = $med->viewSpecSearchPrice_asc();
                    $datano = $med->allSpecSearch();
                }
                else if($sort_before == 2 && $sortQuantity_before == 0){
                    $data = $med->viewSpecSearchPrice_desc();
                    $datano = $med->allSpecSearch();
                }
                else if($sort_before == 0 && $sortQuantity_before == 1){
                    $data = $med->viewSpecSearchQuan_asc();
                    $datano = $med->allSpecSearch();
                }
                else if($sort_before == 0 && $sortQuantity_before == 2){
                    $data = $med->viewSpecSearchQuan_desc();
                    $datano = $med->allSpecSearch();
                }
            }
        }
        else{ 
            $med->med_variation = $_POST['variation'];
            if($_POST['search'] == ""){
                if($sort_before == 0 && $sortQuantity_before == 0){
                    $data = $med->viewSpecList();
                    $datano = $med->allSpecList();
                }
                else if($sort_before == 1 && $sortQuantity_before == 0){
                    $data = $med->viewSpecListPrice_asc();
                    $datano = $med->allSpecList();
                }
                else if($sort_before == 2 && $sortQuantity_before == 0){
                    $data = $med->viewSpecListPrice_desc();
                    $datano = $med->allSpecList();
                }
                else if($sort_before == 0 && $sortQuantity_before == 1){
                    $data = $med->viewSpecListQuan_asc();
                    $datano = $med->allSpecList();
                }
                else if($sort_before == 0 && $sortQuantity_before == 2){
                    $data = $med->viewSpecListQuan_desc();
                    $datano = $med->allSpecList();
                }
            }
            else if($_POST['search'] != ""){
                $med->search = $_POST['search'];
                if($sort_before == 0 && $sortQuantity_before == 0){
                    $data = $med->viewSpec();
                    $datano = $med->allSpec();
                }
                else if($sort_before == 1 && $sortQuantity_before == 0){
                    $data = $med->viewSpecPrice_asc();
                    $datano = $med->allSpec();
                }
                else if($sort_before == 2 && $sortQuantity_before == 0){
                    $data = $med->viewSpecPrice_desc();
                    $datanoc = $med->allSpec();
                }
                else if($sort_before == 0 && $sortQuantity_before == 1){
                    $data = $med->viewSpecQuan_asc();
                    $datano = $med->allSpec();
                }
                else if($sort_before == 0 && $sortQuantity_before == 2){
                    $data = $med->viewSpecQuan_desc();
                    $datano = $med->allSpec();
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
            $i = ($med->start+1);
            foreach($data as $row){
                $show_med_id =  base64_encode($row['med_id']);

                $location1 = '"../../ApplicationLayer/ManageMedicineDelivery/MedViewProduct.php?med_id='.$show_med_id.'"';
                $location2 = '"../../ApplicationLayer/ManageMedicineDelivery/MedEditProduct.php?med_id='.$show_med_id.'"';
                $output .= '
                <tr style="border-bottom:1px solid black;">
                <td align="center">'.$i.'</td>
                <td align="center">'.$row["med_name"].'</td>
                <td align="center">'.$row["med_price"].'</td>
                <td align="center">'.$row["med_quantity"].'</td>
                <td align="center"><form action="" method="POST"><br>
                  <button type="button" style="border:transparent;background:none;vertical-align:middle;" onclick=\'location.href='.$location1.'\'>' .$image1. '</button>
                  <button type="button" style="border:transparent;background:none;vertical-align:middle;" onclick=\'location.href='.$location2.'\'>' .$image2. '</button>
                  <input type="hidden" name="med_id" value='.$row["med_id"].'>
                  <button type="submit" name="delete" style="border:transparent;background:none;vertical-align:middle;" onclick="return confirm(\'Are you sure you want to delete?\')">' .$image3. '</button></form>
                </td>';
                $i++; 
            }

        $total_links = ceil($datano/$med->limit);

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
                <td><h3> Showing ' .($med->start+1). ' to ' . $datano. ' from ' .$datano. '</h3></td>
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
                <td><h3>Showing ' .($med->start+1). ' to ' . $endrow. ' from ' .$datano. '</h3></td>
                <td style="width:40%"></td>
                <td><ul class="pagination"> '.$previous_link.'' .$page_link. '' .$next_link.'</ul></td></tr>
                </table>
                ';
        }
        }

        echo $output;
    }

    //view med image//
    function med_imgView($sp_id,$med_idd){
        $med = new medModel();
        $med->sp_id = $sp_id;
        $med_iddd = base64_decode($med_idd);
        $med->id = $med_iddd;
        return $med->med_imgView();
    }

     //get variation//
    function med_getVariation(){
        $med = new medModel();
        $med_variation = $_POST['variation'];
        header("location: ViewProduct.php?med_variation=$med_variation");
    }

        //view variation//
    function med_viewVariation(){
        $med = new medModel();
        $med->med_variation = $_POST['variation'];
        $med->limit = 50;
        $page = 1;

        if($_POST['page'] > 1){
            $med->start = (($_POST['page'] - 1) * $med->limit);
            $page = $_POST['page'];
        }
        else{
            $med->start = 0;   
        }

        $endrow = $med->start + $med->limit;

        if($_POST['search'] == ""){
            if($_POST['sortPrice'] == "none"){
                $data = $med->viewNormal();
                $datano = $med->countNone();
            }
            else if($_POST['sortPrice'] == "asc"){
                $data = $med->viewLow();
                $datano = $med->countNone();
            }
            else if($_POST['sortPrice'] == "desc"){
                $data = $med->viewHigh();
                $datano = $med->countNone();
            }
        }
        else if($_POST['search'] != ""){
            $med->search = $_POST['search'];
            if($_POST['sortPrice'] == "none"){
                $data = $med->viewSearchNormal();
                $datano = $med->countSearch();
            }
            else if($_POST['sortPrice'] == "asc"){
                $data = $med->viewSearchLow();
                $datano = $med->countSearch();
            }
            else if($_POST['sortPrice'] == "desc"){
                $data = $med->viewSearchHigh();
                $datano = $med->countSearch();
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
            $i = ($med->start+1);
            foreach($data as $row){
                $image = $row['med_coverpath'];
                $image_src = "../../images/MedicineImages/".$image;

                $show_med_id =  base64_encode($row['med_id']);

                $location = '"../../ApplicationLayer/ManageMedicineDelivery/Product.php?med_id='.$show_med_id.'"';

                $output .= '
                    <form action="" method="POST">
                    <td style="padding: 5px;"><button type="button" id="seeProduct_btn" style="width: 180px;height: 230px;border:transparent;" onclick=\'location.href='.$location.'\'><img src='.$image_src.' style="width:160px;height:140px;padding-left:5px;padding-right:7px;"> <br><br> '.$row['med_name'].' <br><br> RM '.$row['med_price'].'</button></td>';

                if($i % 5 == 0){
                    $output .='</tr><tr>';
                }
                $i++; 
                
            }

        $total_links = ceil($datano/$med->limit);

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
    function med_viewProduct($med_idd){
        $med = new medModel();
        $id = base64_decode($med_idd);
        $med->med_id = $id;
        return $med->viewProduct();
    }

    //customer view med image//
    function med_viewImgProduct($med_idd){
        $med = new medModel();
        $id = base64_decode($med_idd);
        $med->id = $id;
        return $med->med_viewImgProduct();
    }
}
?>
