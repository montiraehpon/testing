<?php

require_once '../../BusinessServicesLayer/goodsModel/goodsModel.php';

class goodsController{
    // add product//
    function goods_addProduct($sp_id){
    	$goods = new goodsModel();
    	$goods->sp_id = $sp_id;
    	$goods->name = $_POST['name'];
        $goods->detail = trim($_POST['detail']);
        $goods->price = $_POST['price'];
        $goods->quantity = $_POST['quantity'];
        $goods->variation = $_POST['goods_variation'];

        $token = "abcdefghijklmnopqrstuvwyz0123456789";
        $token = str_shuffle($token);
        $goods->imgid = substr($token, 0, 10);

        $goods->coverpath = $_FILES['coverpath']['name'];
        $folder = "../../images/GoodsImages/";
        $goods->file = $folder.basename($_FILES["coverpath"]["name"]);

        $cover_imageFileType = strtolower(pathinfo($goods->file,PATHINFO_EXTENSION));

        if($cover_imageFileType != "jpg" && $cover_imageFileType != "png" && $cover_imageFileType != "jpeg"){
            $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageGoodsDelivery/GoodsAddProduct.php';</script>";
            exit;
        }

        move_uploaded_file($_FILES['coverpath']['tmp_name'], $folder.$goods->coverpath);
        $count = count($_FILES['imgpath']['name']);
        $fileNames = array_filter($_FILES['imgpath']['name']); 

        if($count > 8){
            $message = "Please insert only 8 images.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageGoodsDelivery/GoodsAddProduct.php';</script>";
            exit;
        }

        if($goods->goods_addProduct() > 0){
            $goods->imgdb = $goods->getImg();

            if($count > 0 && !empty($fileNames)){
            for($i=0;$i<$count;$i++){
                $goods->imgpath = $_FILES['imgpath']['name'][$i];
                $folder = "../../images/GoodsImages/";
                $goods->file = $folder.basename($_FILES["imgpath"]["name"][$i]);
                $imageFileType = strtolower(pathinfo($goods->file,PATHINFO_EXTENSION));

                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
                    $message = "Sorry, your product images will not be shown as only JPG, JPEG & PNG files are allowed.";
                    echo "<script type='text/javascript'>alert('$message');
                    window.location = '../../ApplicationLayer/ManageGoodsDelivery/GoodsAddProduct.php';</script>";
                    exit;
                }
                else{
                    move_uploaded_file($_FILES['imgpath']['tmp_name'][$i], $folder.$goods->imgpath);
                    $goods->goods_addImg();
                }
            }

            $message = "The product is successfully inserted!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageGoodsDelivery/GoodsProduct.php';</script>";  
            }  
            $message = "The product is successfully inserted!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageGoodsDelivery/GoodsProduct.php';</script>";  
        }
        else{
        	$message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageGoodsDelivery/GoodsProduct.php';</script>";
        }
    }

    //view goods //
    function goods_view($sp_id,$gd_idd){
        $goods = new goodsModel();
        $goods->sp_id = $sp_id;
        $gd_iddd = base64_decode($gd_idd);
        $goods->id = $gd_iddd;
        return $goods->goods_view();
    }

    //delete goods//
    function goods_deleteProduct($sp_id){
    	$goods = new goodsModel();
    	$goods->sp_id = $sp_id;
    	$goods->id = $_POST['gd_id'];
    	if($goods->goods_deleteImg() && $goods->goods_deleteProduct() > 0){
    		$message = "Product successfully deleted.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageGoodsDelivery/GoodsProduct.php';</script>";
    	}
    	else {
    		$message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageGoodsDelivery/GoodsProduct.php';</script>";
    	}
    }

    //edit goods//
    function goods_editProduct($sp_id){
        $goods = new goodsModel();
        $goods->sp_id = $sp_id;
        $goods->id = $_POST['cur_gd_id'];
        $goods->name = $_POST['name'];
        $goods->detail = trim($_POST['detail']);
        $goods->price = $_POST['price'];
        $goods->quantity = $_POST['quantity'];
        $goods->variation = $_POST['goods_variation'];

        $goods->coverpath = $_FILES['coverpath']['name'];
        $folder = "../../images/GoodsImages/";
        $goods->file = $folder.basename($_FILES["coverpath"]["name"]);
        $cover_imageFileType = strtolower(pathinfo($goods->file,PATHINFO_EXTENSION));

        if($goods->coverpath != ""){
            if($cover_imageFileType != "jpg" && $cover_imageFileType != "png" && $cover_imageFileType != "jpeg"){
                $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageGoodsDelivery/GoodsEditProduct.php?gd_id=".$show_gd_id."';</script>";
                exit;
            }
        }

        move_uploaded_file($_FILES['coverpath']['tmp_name'], $folder.$goods->coverpath);
        $count = count($_FILES['imgpath']['name']);
        $fileNames = array_filter($_FILES['imgpath']['name']); 

        $show_gd_id = base64_encode($_POST['cur_gd_id']);

        if($count > 8){
            $message = "Please insert only 8 images.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManagegGoodsDelivery/GoodsEditProduct.php?gd_id=".$show_gd_id."';</script>";
            exit;
        }

        if($goods->goods_editProduct() > 0 || $count > 0){ 
            if($count > 0 && !empty($fileNames)){

                for($i=0;$i<$count;$i++){
                    $goods->imgpath = $_FILES['imgpath']['name'][$i];
                    $folder = "../../images/GoodsImages/";

                    $goods->file = $folder.basename($_FILES["imgpath"]["name"][$i]);
                    $imageFileType = strtolower(pathinfo($goods->file,PATHINFO_EXTENSION));

                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
                        $message = "Sorry, only JPG, JPEG & PNG files are allowed.";
                        echo "<script type='text/javascript'>alert('$message');
                        window.location = '../../ApplicationLayer/ManageGoodsDelivery/GoodsEditProduct.php?gd_id=".$show_gd_id."';</script>";
                        exit;
                    }
                }

                $goods->goods_deleteImg();

                for($i=0;$i<$count;$i++){
                    $goods->imgpath = $_FILES['imgpath']['name'][$i];
                    $folder = "../../images/GoodsImages/";
                    move_uploaded_file($_FILES['imgpath']['tmp_name'][$i], $folder.$goods->imgpath);
                    $goods->goods_editImg();
                }

            
                $message = "The product is successfully inserted!";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageGoodsDelivery/GoodsViewProduct.php?gd_id=".$show_gd_id."';</script>"; 
                exit;
            }
            else{
                $message = "The product is successfully inserted!";
                echo "<script type='text/javascript'>alert('$message');
                window.location = '../../ApplicationLayer/ManageGoodsDelivery/GoodsViewProduct.php?gd_id=".$show_gd_id."';</script>"; 
                exit;
            }
        }
        else{
            $message = "Error! Please try again.";
            echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageGoodsDelivery/GoodsProduct.php';</script>";
        }
    }

    //show all goods//
    function goods_showData($sp_id){
        $goods = new goodsModel();
        $goods->sp_id = $sp_id;
        $goods->limit = 5;
        $page = 1;

        if($_POST['page'] > 1){
            $goods->start = (($_POST['page'] - 1) * $goods->limit);
            $page = $_POST['page'];
        }
        else{
            $goods->start = 0;   
        }

        $endrow = $goods->start + $goods->limit;

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
                    $data = $goods->viewList();
                    $datano = $goods->allList();
                }
                else if($sort_before == 1 && $sortQuantity_before == 0){
                    $data = $goods->viewListPrice_asc();
                    $datano = $goods->allList();
                }
                else if($sort_before == 2 && $sortQuantity_before == 0){
                    $data = $goods->viewListPrice_desc();
                    $datano = $goods->allList();
                }
                else if($sort_before == 0 && $sortQuantity_before == 1){
                    $data = $goods->viewListQuan_asc();
                    $datano = $goods->allList();
                }
                else if($sort_before == 0 && $sortQuantity_before == 2){
                    $data = $goods->viewListQuan_desc();
                    $datano = $goods->allList();
                }
            }
            else if($_POST['search'] != ""){
                $goods->search = $_POST['search'];
                if($sort_before == 0 && $sortQuantity_before == 0){
                    $data = $goods->viewSpecSearch();
                    $datano = $goods->allSpecSearch();
                }
                else if($sort_before == 1 && $sortQuantity_before == 0){
                    $data = $goods->viewSpecSearchPrice_asc();
                    $datano = $goods->allSpecSearch();
                }
                else if($sort_before == 2 && $sortQuantity_before == 0){
                    $data = $goods->viewSpecSearchPrice_desc();
                    $datano = $goods->allSpecSearch();
                }
                else if($sort_before == 0 && $sortQuantity_before == 1){
                    $data = $goods->viewSpecSearchQuan_asc();
                    $datano = $goods->allSpecSearch();
                }
                else if($sort_before == 0 && $sortQuantity_before == 2){
                    $data = $goods->viewSpecSearchQuan_desc();
                    $datano = $goods->allSpecSearch();
                }
            }
        }
        else{ 
            $goods->gd_variation = $_POST['variation'];
            if($_POST['search'] == ""){
                if($sort_before == 0 && $sortQuantity_before == 0){
                    $data = $goods->viewSpecList();
                    $datano = $goods->allSpecList();
                }
                else if($sort_before == 1 && $sortQuantity_before == 0){
                    $data = $goods->viewSpecListPrice_asc();
                    $datano = $goods->allSpecList();
                }
                else if($sort_before == 2 && $sortQuantity_before == 0){
                    $data = $goods->viewSpecListPrice_desc();
                    $datano = $goods->allSpecList();
                }
                else if($sort_before == 0 && $sortQuantity_before == 1){
                    $data = $goods->viewSpecListQuan_asc();
                    $datano = $goods->allSpecList();
                }
                else if($sort_before == 0 && $sortQuantity_before == 2){
                    $data = $goods->viewSpecListQuan_desc();
                    $datano = $goods->allSpecList();
                }
            }
            else if($_POST['search'] != ""){
                $goods->search = $_POST['search'];
                if($sort_before == 0 && $sortQuantity_before == 0){
                    $data = $goods->viewSpec();
                    $datano = $goods->allSpec();
                }
                else if($sort_before == 1 && $sortQuantity_before == 0){
                    $data = $goods->viewSpecPrice_asc();
                    $datano = $goods->allSpec();
                }
                else if($sort_before == 2 && $sortQuantity_before == 0){
                    $data = $goods->viewSpecPrice_desc();
                    $datanoc = $goods->allSpec();
                }
                else if($sort_before == 0 && $sortQuantity_before == 1){
                    $data = $goods->viewSpecQuan_asc();
                    $datano = $goods->allSpec();
                }
                else if($sort_before == 0 && $sortQuantity_before == 2){
                    $data = $goods->viewSpecQuan_desc();
                    $datano = $goods->allSpec();
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
            $i = ($goods->start+1);
            foreach($data as $row){
                $show_gd_id =  base64_encode($row['gd_id']);

                $location1 = '"../../ApplicationLayer/ManageGoodsDelivery/GoodsViewProduct.php?gd_id='.$show_gd_id.'"';
                $location2 = '"../../ApplicationLayer/ManageGoodsDelivery/GoodsEditProduct.php?gd_id='.$show_gd_id.'"';
                $output .= '
                <tr style="border-bottom:1px solid black;">
                <td align="center">'.$i.'</td>
                <td align="center">'.$row["gd_name"].'</td>
                <td align="center">'.$row["gd_price"].'</td>
                <td align="center">'.$row["gd_quantity"].'</td>
                <td align="center"><form action="" method="POST"><br>
                  <button type="button" style="border:transparent;background:none;vertical-align:middle;" onclick=\'location.href='.$location1.'\'>' .$image1. '</button>
                  <button type="button" style="border:transparent;background:none;vertical-align:middle;" onclick=\'location.href='.$location2.'\'>' .$image2. '</button>
                  <input type="hidden" name="gd_id" value='.$row["gd_id"].'>
                  <button type="submit" name="delete" style="border:transparent;background:none;vertical-align:middle;" onclick="return confirm(\'Are you sure you want to delete?\')">' .$image3. '</button></form>
                </td>';
                $i++; 
            }

        $total_links = ceil($datano/$goods->limit);

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
                <td><h3> Showing ' .($goods->start+1). ' to ' . $datano. ' from ' .$datano. '</h3></td>
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
                <td><h3>Showing ' .($goods->start+1). ' to ' . $endrow. ' from ' .$datano. '</h3></td>
                <td style="width:40%"></td>
                <td><ul class="pagination"> '.$previous_link.'' .$page_link. '' .$next_link.'</ul></td></tr>
                </table>
                ';
        }
        }

        echo $output;
    }

    //view goods image//
    function goods_imgView($sp_id,$gd_idd){
        $goods = new goodsModel();
        $goods->sp_id = $sp_id;
        $gd_iddd = base64_decode($gd_idd);
        $goods->id = $gd_iddd;
        return $goods->goods_imgView();
    }

     //get variation//
    function goods_getVariation(){
        $goods = new goodsModel();
        $gd_variation = $_POST['variation'];
        header("location: ViewProduct.php?gd_variation=$gd_variation");
    }

    //view variation//
    function goods_viewVariation(){
        $goods = new goodsModel();
        $goods->gd_variation = $_POST['variation'];
        $goods->limit = 50;
        $page = 1;

        if($_POST['page'] > 1){
            $goods->start = (($_POST['page'] - 1) * $goods->limit);
            $page = $_POST['page'];
        }
        else{
            $goods->start = 0;   
        }

        $endrow = $goods->start + $goods->limit;

        if($_POST['search'] == ""){
            if($_POST['sortPrice'] == "none"){
                $data = $goods->viewNormal();
                $datano = $goods->countNone();
            }
            else if($_POST['sortPrice'] == "asc"){
                $data = $goods->viewLow();
                $datano = $goods->countNone();
            }
            else if($_POST['sortPrice'] == "desc"){
                $data = $goods->viewHigh();
                $datano = $goods->countNone();
            }
        }
        else if($_POST['search'] != ""){
            $goods->search = $_POST['search'];
            if($_POST['sortPrice'] == "none"){
                $data = $goods->viewSearchNormal();
                $datano = $goods->countSearch();
            }
            else if($_POST['sortPrice'] == "asc"){
                $data = $goods->viewSearchLow();
                $datano = $goods->countSearch();
            }
            else if($_POST['sortPrice'] == "desc"){
                $data = $goods->viewSearchHigh();
                $datano = $goods->countSearch();
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
            $i = ($goods->start+1);
            foreach($data as $row){
                $image = $row['gd_coverpath'];
                $image_src = "../../images/GoodsImages/".$image;

                $show_gd_id =  base64_encode($row['gd_id']);

                $location = '"../../ApplicationLayer/ManageGoodsDelivery/Product.php?gd_id='.$show_gd_id.'"';

                $output .= '
                    <form action="" method="POST">
                    <td style="padding: 5px;"><button type="button" id="seeProduct_btn" style="width: 180px;height: 230px;border:transparent;" onclick=\'location.href='.$location.'\'><img src='.$image_src.' style="width:160px;height:140px;padding-left:5px;padding-right:7px;"> <br><br> '.$row['gd_name'].' <br><br> RM '.$row['gd_price'].'</button></td>';

                if($i % 5 == 0){
                    $output .='</tr><tr>';
                }
                $i++; 
                
            }

        $total_links = ceil($datano/$goods->limit);

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
    function goods_viewProduct($gd_idd){
        $goods = new goodsModel();
        $id = base64_decode($gd_idd);
        $goods->gd_id = $id;
        return $goods->viewProduct();
    }

    //customer view goods image//
    function goods_viewImgProduct($gd_idd){
        $goods = new goodsModel();
        $id = base64_decode($gd_idd);
        $goods->id = $id;
        return $goods->goods_viewImgProduct();
    }
}
?>
