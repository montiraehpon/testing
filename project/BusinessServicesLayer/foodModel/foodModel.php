<?php

class foodModel{
    public $sp_id,$name,$imgpath,$imgid,$coverpath,$detail,$price,$quantity,$type,$variation,$searchname,$id,$fd_variation;
    
    // create a new PDO connection//
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
    function food_addProduct(){
    	$sql = "insert into food(fd_name,fd_detail,fd_price,fd_imgid,fd_coverpath,fd_quantity,fd_variation,sp_id) values(:fd_name,:fd_detail,:fd_price,:fd_imgid,:fd_coverpath,:fd_quantity,:fd_variation,:sp_id)";
        $args = [':fd_name'=>$this->name, ':fd_detail'=>$this->detail, ':fd_price'=>$this->price, ':fd_imgid'=>$this->imgid, ':fd_coverpath'=>$this->coverpath,':fd_quantity'=>$this->quantity,':fd_variation'=>$this->variation,':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //get id//
    function getImg(){
        $sql = "select * from food where fd_imgid=:fd_imgid and sp_id=:sp_id";
        $args = [':fd_imgid'=>$this->imgid, ':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $imgdb = $row['fd_id'];
        return $imgdb;
    }

    //insert image//
    function food_addImg(){
        $sql = "insert into fd_image(imgpath,get_imgid,sp_id) values(:imgpath,:get_imgid,:sp_id)";
        $args = [':imgpath'=>$this->imgpath, ':get_imgid'=>$this->imgdb, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view specific product image//
    function food_imgView(){
        $sql = "select * from fd_image where get_imgid=:get_imgid and sp_id=:sp_id order by fd_imgid ASC";
        $args = [':get_imgid'=>$this->id , ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view specific product//
    function food_view(){
        $sql = "select * from food where fd_id=:fd_id and sp_id=:sp_id";
        $args = [':fd_id'=>$this->id , ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //delete product//
    function food_deleteProduct(){
        $sql = "delete from food where fd_id=:fd_id and sp_id=:sp_id ";
        $args = [':fd_id'=>$this->id,':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //delete product image//
    function food_deleteImg(){
        $sql = "delete from fd_image where get_imgid=:get_imgid and sp_id=:sp_id";
        $args = [':get_imgid'=>$this->id, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //edit product//
    function food_editProduct(){
        if($this->coverpath != ""){
            $sql = "update food set fd_name=:fd_name,fd_detail=:fd_detail,fd_variation=:fd_variation,fd_coverpath=:fd_coverpath,fd_price=:fd_price,fd_quantity=:fd_quantity where fd_id=:fd_id and sp_id=:sp_id";
            $args = [':fd_name'=>$this->name, ':fd_detail'=>$this->detail, ':fd_variation'=>$this->variation, ':fd_coverpath'=>$this->coverpath,':fd_price'=>$this->price,':fd_quantity'=>$this->quantity,':fd_id'=>$this->id, ':sp_id'=>$this->sp_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count;
        }
        else{
            $sql = "update food set fd_name=:fd_name,fd_detail=:fd_detail,fd_variation=:fd_variation,fd_price=:fd_price,fd_quantity=:fd_quantity where fd_id=:fd_id and sp_id=:sp_id";
            $args = [':fd_name'=>$this->name, ':fd_detail'=>$this->detail, ':fd_variation'=>$this->variation, ':fd_price'=>$this->price,':fd_quantity'=>$this->quantity,':fd_id'=>$this->id, ':sp_id'=>$this->sp_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count; 
        }
    }

    //edit product image//
    function food_editImg(){
        $sql = "insert into fd_image(imgpath,get_imgid,sp_id) values(:imgpath,:get_imgid,:sp_id)";
        $args = [':imgpath'=>$this->imgpath, ':get_imgid'=>$this->id, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //SP view all product//
    function viewSpecList(){
        $sql = "select * from food where fd_variation=:fd_variation and sp_id=:sp_id order by fd_id ASC limit $this->start, $this->limit";
        $args = [':fd_variation'=>$this->fd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view variation from price asc///
    function viewSpecListPrice_asc(){
        $sql = "select * from food where fd_variation=:fd_variation and sp_id=:sp_id order by fd_price ASC limit $this->start, $this->limit";
        $args = [':fd_variation'=>$this->fd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view variation from price desc//
    function viewSpecListPrice_desc(){
        $sql = "select * from food where fd_variation=:fd_variation and sp_id=:sp_id order by fd_price DESC limit $this->start, $this->limit";
        $args = [':fd_variation'=>$this->fd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view variation from quantity asc//
    function viewSpecListQuan_asc(){
        $sql = "select * from food where fd_variation=:fd_variation and sp_id=:sp_id order by fd_quantity ASC limit $this->start, $this->limit";
        $args = [':fd_variation'=>$this->fd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view variation from quantity desc//
    function viewSpecListQuan_desc(){
        $sql = "select * from food where fd_variation=:fd_variation and sp_id=:sp_id order by fd_quantity DESC limit $this->start, $this->limit";
        $args = [':fd_variation'=>$this->fd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }


    //count list//
    function allSpecList(){
        $sql = "select * from food where fd_variation=:fd_variation and sp_id=:sp_id";
        $args = [':fd_variation'=>$this->fd_variation, ':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //view all list//
    function viewList(){
        $sql = "select * from food where sp_id=:sp_id order by fd_id ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view all list from price asc//
    function viewListPrice_asc(){
        $sql = "select * from food where sp_id=:sp_id order by fd_price ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view all list from price desc//
    function viewListPrice_desc(){
        $sql = "select * from food where sp_id=:sp_id order by fd_price DESC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view all list from quantity asc//
    function viewListQuan_asc(){
        $sql = "select * from food where sp_id=:sp_id order by fd_quantity ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view all list quantity desc//
    function viewListQuan_desc(){
        $sql = "select * from food where sp_id=:sp_id order by fd_quantity DESC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //count all list//
    function allList(){
        $sql = "select * from food where sp_id=:sp_id";
        $args = [':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //view variation search//
    function viewSpec(){
        $sql = "select * from food where (fd_variation=:fd_variation and sp_id=:sp_id) and fd_name like '%$this->search%' order by fd_id ASC limit $this->start, $this->limit";
        $args = [':fd_variation'=>$this->fd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view variation search from price asc//
    function viewSpecPrice_asc(){
        $sql = "select * from food where (fd_variation=:fd_variation and sp_id=:sp_id) and fd_name like '%$this->search%' order by fd_price ASC limit $this->start, $this->limit";
        $args = [':fd_variation'=>$this->fd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view variation search from price desc//
    function viewSpecPrice_desc(){
        $sql = "select * from food where (fd_variation=:fd_variation and sp_id=:sp_id) and fd_name like '%$this->search%' order by fd_price DESC limit $this->start, $this->limit";
        $args = [':fd_variation'=>$this->fd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view variation search from quantity asc//
    function viewSpecQuan_asc(){
        $sql = "select * from food where (fd_variation=:fd_variation and sp_id=:sp_id) and fd_name like '%$this->search%' order by fd_quantity ASC limit $this->start, $this->limit";
        $args = [':fd_variation'=>$this->fd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view variation search from quantity desc//
    function viewSpecQuan_desc(){
        $sql = "select * from food where (fd_variation=:fd_variation and sp_id=:sp_id) and fd_name like '%$this->search%' order by fd_quantity DESC limit $this->start, $this->limit";
        $args = [':fd_variation'=>$this->fd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //count variation search//
    function allSpec(){
        $sql = "select * from food where (fd_variation=:fd_variation and sp_id=:sp_id) and fd_name like '%$this->search%'";
        $args = [':fd_variation'=>$this->fd_variation, ':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //view all search//
    function viewSpecSearch(){
        $sql = "select * from food where sp_id=:sp_id and fd_name like '%$this->search%' order by fd_id ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view all search price asc//
    function viewSpecSearchPrice_asc(){
        $sql = "select * from food where sp_id=:sp_id and fd_name like '%$this->search%' order by fd_price ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view all search price desc//
    function viewSpecSearchPrice_desc(){
        $sql = "select * from food where sp_id=:sp_id and fd_name like '%$this->search%' order by fd_price DESC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view all search quantity asc//
    function viewSpecSearchQuan_asc(){
        $sql = "select * from food where sp_id=:sp_id and fd_name like '%$this->search%' order by fd_quantity ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view all search quantity desc//
    function viewSpecSearchQuan_desc(){
        $sql = "select * from food where sp_id=:sp_id and fd_name like '%$this->search%' order by fd_quantity DESC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function allSpecSearch(){
        $sql = "select * from food where sp_id=:sp_id and fd_name like '%$this->search%'";
        $args = [':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //Customer view variation product//
    function viewNormal(){
        $sql = "select * from food where fd_variation=:fd_variation order by fd_id ASC limit $this->start, $this->limit";
        $args = [':fd_variation'=>$this->fd_variation];
        return $this->run($sql, $args);
    }

    //view price asc//
    function viewLow(){
        $sql = "select * from food where fd_variation=:fd_variation order by fd_price ASC limit $this->start, $this->limit";
        $args = [':fd_variation'=>$this->fd_variation];
        return $this->run($sql, $args);
    }

    //view price desc//
    function viewHigh(){
        $sql = "select * from food where fd_variation=:fd_variation order by fd_price DESC limit $this->start, $this->limit";
        $args = [':fd_variation'=>$this->fd_variation];
        return $this->run($sql, $args);
    }

    //count//
    function countNone(){
        $sql = "select * from food where fd_variation=:fd_variation";
        $args = [':fd_variation'=>$this->fd_variation];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //view search normal//
    function viewSearchNormal(){
        $sql = "select * from food where fd_variation=:fd_variation and fd_name like '%$this->search%' order by fd_id ASC limit $this->start, $this->limit";
        $args = [':fd_variation'=>$this->fd_variation];
        return $this->run($sql, $args);
    }

    //view search low//
    function viewSearchLow(){
        $sql = "select * from food where fd_variation=:fd_variation and fd_name like '%$this->search%' order by fd_price ASC limit $this->start, $this->limit";
        $args = [':fd_variation'=>$this->fd_variation];
        return $this->run($sql, $args);
    }

    //view search high price//
    function viewSearchHigh(){
        $sql = "select * from food where fd_variation=:fd_variation and fd_name like '%$this->search%' order by fd_price DESC limit $this->start, $this->limit";
        $args = [':fd_variation'=>$this->fd_variation];
        return $this->run($sql, $args);
    }

    //count search//
    function countSearch(){
        $sql = "select * from food where fd_variation=:fd_variation and fd_name like '%$this->search%'";
        $args = [':fd_variation'=>$this->fd_variation];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }
    
    //customer view product//
    function viewProduct(){
        $sql = "select * from food where fd_id=:fd_id";
        $args = [':fd_id'=>$this->fd_id];
        return $this->run($sql, $args);
    }

    //customer view product images//
    function food_viewImgProduct(){
        $sql = "select * from fd_image where get_imgid=:get_imgid order by fd_imgid ASC";
        $args = [':get_imgid'=>$this->id];
        return $this->run($sql, $args);
    }
}
?>
