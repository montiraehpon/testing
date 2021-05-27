<?php

class medModel{
    public $sp_id,$name,$imgpath,$imgid,$coverpath,$detail,$price,$quantity,$type,$variation,$searchname,$id,$med_variation;
    
    // create a new PDO connection
    public function connect(){
    $servername = "localhost";
    $username = "root";
    $password = "";

    $pdo = new PDO("mysql:host=$servername;dbname=project", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
    }

    public function run($sql, $args = NULL){
        if (!$args){
            $conn = $this->connect();
            return $conn->query($sql);
        }

        $connn = $this->connect();
        $stmt = $connn->prepare($sql);

        try{
            $stmt->execute($args);
            return $stmt;
        }
        catch (PDOException $e){
            echo $e->getMessage();
            die();
        }   
    }
    
    //insert product//
    function med_addProduct(){
    	$sql = "insert into medicine(med_name,med_detail,med_price,med_imgid,med_coverpath,med_quantity,med_variation,sp_id) values(:med_name,:med_detail,:med_price,:med_imgid,:med_coverpath,:med_quantity,:med_variation,:sp_id)";
        $args = [':med_name'=>$this->name, ':med_detail'=>$this->detail, ':med_price'=>$this->price, ':med_imgid'=>$this->imgid, ':med_coverpath'=>$this->coverpath,':med_quantity'=>$this->quantity,':med_variation'=>$this->variation,':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //get id//
    function getImg(){
        $sql = "select * from medicine where med_imgid=:med_imgid and sp_id=:sp_id";
        $args = [':med_imgid'=>$this->imgid, ':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $imgdb = $row['med_id'];
        return $imgdb;
    }

    //insert image//
    function med_addImg(){
        $sql = "insert into med_image(imgpath,get_imgid,sp_id) values(:imgpath,:get_imgid,:sp_id)";
        $args = [':imgpath'=>$this->imgpath, ':get_imgid'=>$this->imgdb, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view specific product//
    function med_imgView(){
        $sql = "select * from med_image where get_imgid=:get_imgid and sp_id=:sp_id order by med_imgid ASC";
        $args = [':get_imgid'=>$this->id , ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function med_view(){
        $sql = "select * from medicine where med_id=:med_id and sp_id=:sp_id";
        $args = [':med_id'=>$this->id , ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //delete product//
    function med_deleteProduct(){
        $sql = "delete from medicine where med_id=:med_id and sp_id=:sp_id ";
        $args = [':med_id'=>$this->id,':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    function med_deleteImg(){
        $sql = "delete from med_image where get_imgid=:get_imgid and sp_id=:sp_id";
        $args = [':get_imgid'=>$this->id, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //edit product//
    function med_editProduct(){
        if($this->coverpath != ""){
            $sql = "update medicine set med_name=:med_name,med_detail=:med_detail,med_variation=:med_variation,med_coverpath=:med_coverpath,med_price=:med_price,med_quantity=:med_quantity where med_id=:med_id and sp_id=:sp_id";
            $args = [':med_name'=>$this->name, ':med_detail'=>$this->detail, ':med_variation'=>$this->variation, ':med_coverpath'=>$this->coverpath,':med_price'=>$this->price,':med_quantity'=>$this->quantity,':med_id'=>$this->id, ':sp_id'=>$this->sp_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count;
        }
        else{
            $sql = "update medicine set med_name=:med_name,med_detail=:med_detail,med_variation=:med_variation,med_price=:med_price,med_quantity=:med_quantity where med_id=:med_id and sp_id=:sp_id";
            $args = [':med_name'=>$this->name, ':med_detail'=>$this->detail, ':med_variation'=>$this->variation, ':med_price'=>$this->price,':med_quantity'=>$this->quantity,':med_id'=>$this->id, ':sp_id'=>$this->sp_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count; 
        }
    }

    function med_editImg(){
        $sql = "insert into med_image(imgpath,get_imgid,sp_id) values(:imgpath,:get_imgid,:sp_id)";
        $args = [':imgpath'=>$this->imgpath, ':get_imgid'=>$this->id, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view all product//
    function viewSpecList(){
        $sql = "select * from medicine where med_variation=:med_variation and sp_id=:sp_id order by med_id ASC limit $this->start, $this->limit";
        $args = [':med_variation'=>$this->med_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecListPrice_asc(){
        $sql = "select * from medicine where med_variation=:med_variation and sp_id=:sp_id order by med_price ASC limit $this->start, $this->limit";
        $args = [':med_variation'=>$this->med_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecListPrice_desc(){
        $sql = "select * from medicine where med_variation=:med_variation and sp_id=:sp_id order by med_price DESC limit $this->start, $this->limit";
        $args = [':med_variation'=>$this->med_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecListQuan_asc(){
        $sql = "select * from medicine where med_variation=:med_variation and sp_id=:sp_id order by med_quantity ASC limit $this->start, $this->limit";
        $args = [':med_variation'=>$this->med_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecListQuan_desc(){
        $sql = "select * from medicine where med_variation=:med_variation and sp_id=:sp_id order by med_quantity DESC limit $this->start, $this->limit";
        $args = [':med_variation'=>$this->med_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function allSpecList(){
        $sql = "select * from medicine where med_variation=:med_variation and sp_id=:sp_id";
        $args = [':med_variation'=>$this->med_variation, ':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    function viewList(){
        $sql = "select * from medicine where sp_id=:sp_id order by med_id ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewListPrice_asc(){
        $sql = "select * from medicine where sp_id=:sp_id order by med_price ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewListPrice_desc(){
        $sql = "select * from medicine where sp_id=:sp_id order by med_price DESC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewListQuan_asc(){
        $sql = "select * from medicine where sp_id=:sp_id order by med_quantity ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewListQuan_desc(){
        $sql = "select * from medicine where sp_id=:sp_id order by med_quantity DESC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function allList(){
        $sql = "select * from medicine where sp_id=:sp_id";
        $args = [':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    function viewSpec(){
        $sql = "select * from medicine where (med_variation=:med_variation and sp_id=:sp_id) and med_name like '%$this->search%' order by med_id ASC limit $this->start, $this->limit";
        $args = [':med_variation'=>$this->med_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecPrice_asc(){
        $sql = "select * from medicine where (med_variation=:med_variation and sp_id=:sp_id) and med_name like '%$this->search%' order by med_price ASC limit $this->start, $this->limit";
        $args = [':med_variation'=>$this->med_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecPrice_desc(){
        $sql = "select * from medicine where (med_variation=:med_variation and sp_id=:sp_id) and med_name like '%$this->search%' order by med_price DESC limit $this->start, $this->limit";
        $args = [':med_variation'=>$this->med_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecQuan_asc(){
        $sql = "select * from medicine where (med_variation=:med_variation and sp_id=:sp_id) and med_name like '%$this->search%' order by med_quantity ASC limit $this->start, $this->limit";
        $args = [':med_variation'=>$this->med_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecQuan_desc(){
        $sql = "select * from medicine where (med_variation=:med_variation and sp_id=:sp_id) and med_name like '%$this->search%' order by med_quantity DESC limit $this->start, $this->limit";
        $args = [':med_variation'=>$this->med_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function allSpec(){
        $sql = "select * from medicine where (med_variation=:med_variation and sp_id=:sp_id) and med_name like '%$this->search%'";
        $args = [':med_variation'=>$this->med_variation, ':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    function viewSpecSearch(){
        $sql = "select * from medicine where sp_id=:sp_id and med_name like '%$this->search%' order by med_id ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecSearchPrice_asc(){
        $sql = "select * from medicine where sp_id=:sp_id and med_name like '%$this->search%' order by med_price ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecSearchPrice_desc(){
        $sql = "select * from medicine where sp_id=:sp_id and med_name like '%$this->search%' order by med_price DESC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecSearchQuan_asc(){
        $sql = "select * from medicine where sp_id=:sp_id and med_name like '%$this->search%' order by med_quantity ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecSearchQuan_desc(){
        $sql = "select * from medicine where sp_id=:sp_id and med_name like '%$this->search%' order by med_quantity DESC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function allSpecSearch(){
        $sql = "select * from medicine where sp_id=:sp_id and med_name like '%$this->search%'";
        $args = [':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //Customer view variation product//
    function viewNormal(){
        $sql = "select * from medicine where med_variation=:med_variation order by med_id ASC limit $this->start, $this->limit";
        $args = [':med_variation'=>$this->med_variation];
        return $this->run($sql, $args);
    }

    function viewLow(){
        $sql = "select * from medicine where med_variation=:med_variation order by med_price ASC limit $this->start, $this->limit";
        $args = [':med_variation'=>$this->med_variation];
        return $this->run($sql, $args);
    }

    function viewHigh(){
        $sql = "select * from medicine where med_variation=:med_variation order by med_price DESC limit $this->start, $this->limit";
        $args = [':med_variation'=>$this->med_variation];
        return $this->run($sql, $args);
    }

    function countNone(){
        $sql = "select * from medicine where med_variation=:med_variation";
        $args = [':med_variation'=>$this->med_variation];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    function viewSearchNormal(){
        $sql = "select * from medicine where med_variation=:med_variation and med_name like '%$this->search%' order by med_id ASC limit $this->start, $this->limit";
        $args = [':med_variation'=>$this->med_variation];
        return $this->run($sql, $args);
    }

    function viewSearchLow(){
        $sql = "select * from medicine where med_variation=:med_variation and med_name like '%$this->search%' order by med_price ASC limit $this->start, $this->limit";
        $args = [':med_variation'=>$this->med_variation];
        return $this->run($sql, $args);
    }

    function viewSearchHigh(){
        $sql = "select * from medicine where med_variation=:med_variation and med_name like '%$this->search%' order by med_price DESC limit $this->start, $this->limit";
        $args = [':med_variation'=>$this->med_variation];
        return $this->run($sql, $args);
    }

    function countSearch(){
        $sql = "select * from medicine where med_variation=:med_variation and med_name like '%$this->search%'";
        $args = [':med_variation'=>$this->med_variation];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //customer view product//
    function viewProduct(){
        $sql = "select * from medicine where med_id=:med_id";
        $args = [':med_id'=>$this->med_id];
        return $this->run($sql, $args);
    }

    //customer view product images//
    function med_viewImgProduct(){
        $sql = "select * from med_image where get_imgid=:get_imgid order by med_imgid ASC";
        $args = [':get_imgid'=>$this->id];
        return $this->run($sql, $args);
    }
}
?>
