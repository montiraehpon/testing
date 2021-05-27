<?php

class petModel{
    public $sp_id,$name,$imgpath,$imgid,$coverpath,$detail,$price,$quantity,$type,$variation,$searchname,$id,$pet_variation;
    
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
    function pet_addProduct(){
    	$sql = "insert into pet(pet_name,pet_detail,pet_price,pet_imgid,pet_coverpath,pet_quantity,pet_variation,sp_id) values(:pet_name,:pet_detail,:pet_price,:pet_imgid,:pet_coverpath,:pet_quantity,:pet_variation,:sp_id)";
        $args = [':pet_name'=>$this->name, ':pet_detail'=>$this->detail, ':pet_price'=>$this->price, ':pet_imgid'=>$this->imgid, ':pet_coverpath'=>$this->coverpath,':pet_quantity'=>$this->quantity,':pet_variation'=>$this->variation,':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //get id//
    function getImg(){
        $sql = "select * from pet where pet_imgid=:pet_imgid and sp_id=:sp_id";
        $args = [':pet_imgid'=>$this->imgid, ':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $imgdb = $row['pet_id'];
        return $imgdb;
    }

    //insert image//
    function pet_addImg(){
        $sql = "insert into pet_image(imgpath,get_imgid,sp_id) values(:imgpath,:get_imgid,:sp_id)";
        $args = [':imgpath'=>$this->imgpath, ':get_imgid'=>$this->imgdb, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view specific product//
    function pet_imgView(){
        $sql = "select * from pet_image where get_imgid=:get_imgid and sp_id=:sp_id order by pet_imgid ASC";
        $args = [':get_imgid'=>$this->id , ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function pet_view(){
        $sql = "select * from pet where pet_id=:pet_id and sp_id=:sp_id";
        $args = [':pet_id'=>$this->id , ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //delete product//
    function pet_deleteProduct(){
        $sql = "delete from pet where pet_id=:pet_id and sp_id=:sp_id ";
        $args = [':pet_id'=>$this->id,':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    function pet_deleteImg(){
        $sql = "delete from pet_image where get_imgid=:get_imgid and sp_id=:sp_id";
        $args = [':get_imgid'=>$this->id, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //edit product//
    function pet_editProduct(){
        if($this->coverpath != ""){
            $sql = "update pet set pet_name=:pet_name,pet_detail=:pet_detail,pet_variation=:pet_variation,pet_coverpath=:pet_coverpath,pet_price=:pet_price,pet_quantity=:pet_quantity where pet_id=:pet_id and sp_id=:sp_id";
            $args = [':pet_name'=>$this->name, ':pet_detail'=>$this->detail, ':pet_variation'=>$this->variation, ':pet_coverpath'=>$this->coverpath,':pet_price'=>$this->price,':pet_quantity'=>$this->quantity,':pet_id'=>$this->id, ':sp_id'=>$this->sp_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count;
        }
        else{
            $sql = "update pet set pet_name=:pet_name,pet_detail=:pet_detail,pet_variation=:pet_variation,pet_price=:pet_price,pet_quantity=:pet_quantity where pet_id=:pet_id and sp_id=:sp_id";
            $args = [':pet_name'=>$this->name, ':pet_detail'=>$this->detail, ':pet_variation'=>$this->variation, ':pet_price'=>$this->price,':pet_quantity'=>$this->quantity,':pet_id'=>$this->id, ':sp_id'=>$this->sp_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count; 
        }
    }

    function pet_editImg(){
        $sql = "insert into pet_image(imgpath,get_imgid,sp_id) values(:imgpath,:get_imgid,:sp_id)";
        $args = [':imgpath'=>$this->imgpath, ':get_imgid'=>$this->id, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view all product//
    function viewSpecList(){
        $sql = "select * from pet where pet_variation=:pet_variation and sp_id=:sp_id order by pet_id ASC limit $this->start, $this->limit";
        $args = [':pet_variation'=>$this->pet_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecListPrice_asc(){
        $sql = "select * from pet where pet_variation=:pet_variation and sp_id=:sp_id order by pet_price ASC limit $this->start, $this->limit";
        $args = [':pet_variation'=>$this->pet_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecListPrice_desc(){
        $sql = "select * from pet where pet_variation=:pet_variation and sp_id=:sp_id order by pet_price DESC limit $this->start, $this->limit";
        $args = [':pet_variation'=>$this->pet_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecListQuan_asc(){
        $sql = "select * from pet where pet_variation=:pet_variation and sp_id=:sp_id order by pet_quantity ASC limit $this->start, $this->limit";
        $args = [':pet_variation'=>$this->pet_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecListQuan_desc(){
        $sql = "select * from pet where pet_variation=:pet_variation and sp_id=:sp_id order by pet_quantity DESC limit $this->start, $this->limit";
        $args = [':pet_variation'=>$this->pet_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function allSpecList(){
        $sql = "select * from pet where pet_variation=:pet_variation and sp_id=:sp_id";
        $args = [':pet_variation'=>$this->pet_variation, ':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    function viewList(){
        $sql = "select * from pet where sp_id=:sp_id order by pet_id ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewListPrice_asc(){
        $sql = "select * from pet where sp_id=:sp_id order by pet_price ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewListPrice_desc(){
        $sql = "select * from pet where sp_id=:sp_id order by pet_price DESC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewListQuan_asc(){
        $sql = "select * from pet where sp_id=:sp_id order by pet_quantity ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewListQuan_desc(){
        $sql = "select * from pet where sp_id=:sp_id order by pet_quantity DESC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function allList(){
        $sql = "select * from pet where sp_id=:sp_id";
        $args = [':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    function viewSpec(){
        $sql = "select * from pet where (pet_variation=:pet_variation and sp_id=:sp_id) and pet_name like '%$this->search%' order by pet_id ASC limit $this->start, $this->limit";
        $args = [':pet_variation'=>$this->pet_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecPrice_asc(){
        $sql = "select * from pet where (pet_variation=:pet_variation and sp_id=:sp_id) and pet_name like '%$this->search%' order by pet_price ASC limit $this->start, $this->limit";
        $args = [':pet_variation'=>$this->pet_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecPrice_desc(){
        $sql = "select * from pet where (pet_variation=:pet_variation and sp_id=:sp_id) and pet_name like '%$this->search%' order by pet_price DESC limit $this->start, $this->limit";
        $args = [':pet_variation'=>$this->pet_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecQuan_asc(){
        $sql = "select * from pet where (pet_variation=:pet_variation and sp_id=:sp_id) and pet_name like '%$this->search%' order by pet_quantity ASC limit $this->start, $this->limit";
        $args = [':pet_variation'=>$this->pet_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecQuan_desc(){
        $sql = "select * from pet where (pet_variation=:pet_variation and sp_id=:sp_id) and pet_name like '%$this->search%' order by pet_quantity DESC limit $this->start, $this->limit";
        $args = [':pet_variation'=>$this->pet_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function allSpec(){
        $sql = "select * from pet where (pet_variation=:pet_variation and sp_id=:sp_id) and pet_name like '%$this->search%'";
        $args = [':pet_variation'=>$this->pet_variation, ':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    function viewSpecSearch(){
        $sql = "select * from pet where sp_id=:sp_id and pet_name like '%$this->search%' order by pet_id ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecSearchPrice_asc(){
        $sql = "select * from pet where sp_id=:sp_id and pet_name like '%$this->search%' order by pet_price ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecSearchPrice_desc(){
        $sql = "select * from pet where sp_id=:sp_id and pet_name like '%$this->search%' order by pet_price DESC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecSearchQuan_asc(){
        $sql = "select * from pet where sp_id=:sp_id and pet_name like '%$this->search%' order by pet_quantity ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecSearchQuan_desc(){
        $sql = "select * from pet where sp_id=:sp_id and pet_name like '%$this->search%' order by pet_quantity DESC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function allSpecSearch(){
        $sql = "select * from pet where sp_id=:sp_id and pet_name like '%$this->search%'";
        $args = [':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //Customer view variation product//
    function viewNormal(){
        $sql = "select * from pet where pet_variation=:pet_variation order by pet_id ASC limit $this->start, $this->limit";
        $args = [':pet_variation'=>$this->pet_variation];
        return $this->run($sql, $args);
    }

    function viewLow(){
        $sql = "select * from pet where pet_variation=:pet_variation order by pet_price ASC limit $this->start, $this->limit";
        $args = [':pet_variation'=>$this->pet_variation];
        return $this->run($sql, $args);
    }

    function viewHigh(){
        $sql = "select * from pet where pet_variation=:pet_variation order by pet_price DESC limit $this->start, $this->limit";
        $args = [':pet_variation'=>$this->pet_variation];
        return $this->run($sql, $args);
    }

    function countNone(){
        $sql = "select * from pet where pet_variation=:pet_variation";
        $args = [':pet_variation'=>$this->pet_variation];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    function viewSearchNormal(){
        $sql = "select * from pet where pet_variation=:pet_variation and pet_name like '%$this->search%' order by pet_id ASC limit $this->start, $this->limit";
        $args = [':pet_variation'=>$this->pet_variation];
        return $this->run($sql, $args);
    }

    function viewSearchLow(){
        $sql = "select * from pet where pet_variation=:pet_variation and pet_name like '%$this->search%' order by pet_price ASC limit $this->start, $this->limit";
        $args = [':pet_variation'=>$this->pet_variation];
        return $this->run($sql, $args);
    }

    function viewSearchHigh(){
        $sql = "select * from pet where pet_variation=:pet_variation and pet_name like '%$this->search%' order by pet_price DESC limit $this->start, $this->limit";
        $args = [':pet_variation'=>$this->pet_variation];
        return $this->run($sql, $args);
    }

    function countSearch(){
        $sql = "select * from pet where pet_variation=:pet_variation and pet_name like '%$this->search%'";
        $args = [':pet_variation'=>$this->pet_variation];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //customer view product//
    function viewProduct(){
        $sql = "select * from pet where pet_id=:pet_id";
        $args = [':pet_id'=>$this->pet_id];
        return $this->run($sql, $args);
    }

    //customer view product images//
    function pet_viewImgProduct(){
        $sql = "select * from pet_image where get_imgid=:get_imgid order by pet_imgid ASC";
        $args = [':get_imgid'=>$this->id];
        return $this->run($sql, $args);
    }
    function pet_quantity(){
        $sql = "select * from pet where pet_id=:pet_id";
        $args = [':pet_id'=>$this->pet_id];
        $stmt = petModel::connect()->prepare($sql);
        $stmt->execute($args);
        return $stmt;
        //$sql = "select * from pet where pet_name like '%$this->pet_name%'";
        //$args = [':pet_name'=>$this->pet_name];
        //return DB::run($sql,$args);
    }
}
?>
