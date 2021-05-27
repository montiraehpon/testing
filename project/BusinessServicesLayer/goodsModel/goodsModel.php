<?php

class goodsModel{
    public $sp_id,$name,$imgpath,$imgid,$coverpath,$detail,$price,$quantity,$type,$variation,$searchname,$id,$gd_variation;
    
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
    function goods_addProduct(){
    	$sql = "insert into goods(gd_name,gd_detail,gd_price,gd_imgid,gd_coverpath,gd_quantity,gd_variation,sp_id) values(:gd_name,:gd_detail,:gd_price,:gd_imgid,:gd_coverpath,:gd_quantity,:gd_variation,:sp_id)";
        $args = [':gd_name'=>$this->name, ':gd_detail'=>$this->detail, ':gd_price'=>$this->price, ':gd_imgid'=>$this->imgid, ':gd_coverpath'=>$this->coverpath,':gd_quantity'=>$this->quantity,':gd_variation'=>$this->variation,':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //get id//
    function getImg(){
        $sql = "select * from goods where gd_imgid=:gd_imgid and sp_id=:sp_id";
        $args = [':gd_imgid'=>$this->imgid, ':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $imgdb = $row['gd_id'];
        return $imgdb;
    }

    //insert image//
    function goods_addImg(){
        $sql = "insert into gd_image(imgpath,get_imgid,sp_id) values(:imgpath,:get_imgid,:sp_id)";
        $args = [':imgpath'=>$this->imgpath, ':get_imgid'=>$this->imgdb, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view specific product//
    function goods_imgView(){
        $sql = "select * from gd_image where get_imgid=:get_imgid and sp_id=:sp_id order by gd_imgid ASC";
        $args = [':get_imgid'=>$this->id , ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function goods_view(){
        $sql = "select * from goods where gd_id=:gd_id and sp_id=:sp_id";
        $args = [':gd_id'=>$this->id , ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //delete product//
    function goods_deleteProduct(){
        $sql = "delete from goods where gd_id=:gd_id and sp_id=:sp_id ";
        $args = [':gd_id'=>$this->id,':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    function goods_deleteImg(){
        $sql = "delete from gd_image where get_imgid=:get_imgid and sp_id=:sp_id";
        $args = [':get_imgid'=>$this->id, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //edit product//
    function goods_editProduct(){
        if($this->coverpath != ""){
            $sql = "update goods set gd_name=:gd_name,gd_detail=:gd_detail,gd_variation=:gd_variation,gd_coverpath=:gd_coverpath,gd_price=:gd_price,gd_quantity=:gd_quantity where gd_id=:gd_id and sp_id=:sp_id";
            $args = [':gd_name'=>$this->name, ':gd_detail'=>$this->detail, ':gd_variation'=>$this->variation, ':gd_coverpath'=>$this->coverpath,':gd_price'=>$this->price,':gd_quantity'=>$this->quantity,':gd_id'=>$this->id, ':sp_id'=>$this->sp_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count;
        }
        else{
            $sql = "update goods set gd_name=:gd_name,gd_detail=:gd_detail,gd_variation=:gd_variation,gd_price=:gd_price,gd_quantity=:gd_quantity where gd_id=:gd_id and sp_id=:sp_id";
            $args = [':gd_name'=>$this->name, ':gd_detail'=>$this->detail, ':gd_variation'=>$this->variation, ':gd_price'=>$this->price,':gd_quantity'=>$this->quantity,':gd_id'=>$this->id, ':sp_id'=>$this->sp_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count; 
        }
    }

    function goods_editImg(){
        $sql = "insert into gd_image(imgpath,get_imgid,sp_id) values(:imgpath,:get_imgid,:sp_id)";
        $args = [':imgpath'=>$this->imgpath, ':get_imgid'=>$this->id, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //view all product//
    function viewSpecList(){
        $sql = "select * from goods where gd_variation=:gd_variation and sp_id=:sp_id order by gd_id ASC limit $this->start, $this->limit";
        $args = [':gd_variation'=>$this->gd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecListPrice_asc(){
        $sql = "select * from goods where gd_variation=:gd_variation and sp_id=:sp_id order by gd_price ASC limit $this->start, $this->limit";
        $args = [':gd_variation'=>$this->gd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecListPrice_desc(){
        $sql = "select * from goods where gd_variation=:gd_variation and sp_id=:sp_id order by gd_price DESC limit $this->start, $this->limit";
        $args = [':gd_variation'=>$this->gd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecListQuan_asc(){
        $sql = "select * from goods where gd_variation=:gd_variation and sp_id=:sp_id order by gd_quantity ASC limit $this->start, $this->limit";
        $args = [':gd_variation'=>$this->gd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecListQuan_desc(){
        $sql = "select * from goods where gd_variation=:gd_variation and sp_id=:sp_id order by gd_quantity DESC limit $this->start, $this->limit";
        $args = [':gd_variation'=>$this->gd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function allSpecList(){
        $sql = "select * from goods where gd_variation=:gd_variation and sp_id=:sp_id";
        $args = [':gd_variation'=>$this->gd_variation, ':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    function viewList(){
        $sql = "select * from goods where sp_id=:sp_id order by gd_id ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewListPrice_asc(){
        $sql = "select * from goods where sp_id=:sp_id order by gd_price ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewListPrice_desc(){
        $sql = "select * from goods where sp_id=:sp_id order by gd_price DESC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewListQuan_asc(){
        $sql = "select * from goods where sp_id=:sp_id order by gd_quantity ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewListQuan_desc(){
        $sql = "select * from goods where sp_id=:sp_id order by gd_quantity DESC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function allList(){
        $sql = "select * from goods where sp_id=:sp_id";
        $args = [':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    function viewSpec(){
        $sql = "select * from goods where (gd_variation=:gd_variation and sp_id=:sp_id) and gd_name like '%$this->search%' order by gd_id ASC limit $this->start, $this->limit";
        $args = [':gd_variation'=>$this->gd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecPrice_asc(){
        $sql = "select * from goods where (gd_variation=:gd_variation and sp_id=:sp_id) and gd_name like '%$this->search%' order by gd_price ASC limit $this->start, $this->limit";
        $args = [':gd_variation'=>$this->gd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecPrice_desc(){
        $sql = "select * from goods where (gd_variation=:gd_variation and sp_id=:sp_id) and gd_name like '%$this->search%' order by gd_price DESC limit $this->start, $this->limit";
        $args = [':gd_variation'=>$this->gd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecQuan_asc(){
        $sql = "select * from goods where (gd_variation=:gd_variation and sp_id=:sp_id) and gd_name like '%$this->search%' order by gd_quantity ASC limit $this->start, $this->limit";
        $args = [':gd_variation'=>$this->gd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecQuan_desc(){
        $sql = "select * from goods where (gd_variation=:gd_variation and sp_id=:sp_id) and gd_name like '%$this->search%' order by gd_quantity DESC limit $this->start, $this->limit";
        $args = [':gd_variation'=>$this->gd_variation, ':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function allSpec(){
        $sql = "select * from goods where (gd_variation=:gd_variation and sp_id=:sp_id) and gd_name like '%$this->search%'";
        $args = [':gd_variation'=>$this->gd_variation, ':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    function viewSpecSearch(){
        $sql = "select * from goods where sp_id=:sp_id and gd_name like '%$this->search%' order by gd_id ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecSearchPrice_asc(){
        $sql = "select * from goods where sp_id=:sp_id and gd_name like '%$this->search%' order by gd_price ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecSearchPrice_desc(){
        $sql = "select * from goods where sp_id=:sp_id and gd_name like '%$this->search%' order by gd_price DESC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecSearchQuan_asc(){
        $sql = "select * from goods where sp_id=:sp_id and gd_name like '%$this->search%' order by gd_quantity ASC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function viewSpecSearchQuan_desc(){
        $sql = "select * from goods where sp_id=:sp_id and gd_name like '%$this->search%' order by gd_quantity DESC limit $this->start, $this->limit";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function allSpecSearch(){
        $sql = "select * from goods where sp_id=:sp_id and gd_name like '%$this->search%'";
        $args = [':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //Customer view variation product//
    function viewNormal(){
        $sql = "select * from goods where gd_variation=:gd_variation order by gd_id ASC limit $this->start, $this->limit";
        $args = [':gd_variation'=>$this->gd_variation];
        return $this->run($sql, $args);
    }

    function viewLow(){
        $sql = "select * from goods where gd_variation=:gd_variation order by gd_price ASC limit $this->start, $this->limit";
        $args = [':gd_variation'=>$this->gd_variation];
        return $this->run($sql, $args);
    }

    function viewHigh(){
        $sql = "select * from goods where gd_variation=:gd_variation order by gd_price DESC limit $this->start, $this->limit";
        $args = [':gd_variation'=>$this->gd_variation];
        return $this->run($sql, $args);
    }

    function countNone(){
        $sql = "select * from goods where gd_variation=:gd_variation";
        $args = [':gd_variation'=>$this->gd_variation];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    function viewSearchNormal(){
        $sql = "select * from goods where gd_variation=:gd_variation and gd_name like '%$this->search%' order by gd_id ASC limit $this->start, $this->limit";
        $args = [':gd_variation'=>$this->gd_variation];
        return $this->run($sql, $args);
    }

    function viewSearchLow(){
        $sql = "select * from goods where gd_variation=:gd_variation and gd_name like '%$this->search%' order by gd_price ASC limit $this->start, $this->limit";
        $args = [':gd_variation'=>$this->gd_variation];
        return $this->run($sql, $args);
    }

    function viewSearchHigh(){
        $sql = "select * from goods where gd_variation=:gd_variation and gd_name like '%$this->search%' order by gd_price DESC limit $this->start, $this->limit";
        $args = [':gd_variation'=>$this->gd_variation];
        return $this->run($sql, $args);
    }

    function countSearch(){
        $sql = "select * from goods where gd_variation=:gd_variation and gd_name like '%$this->search%'";
        $args = [':gd_variation'=>$this->gd_variation];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //customer view product//
    function viewProduct(){
        $sql = "select * from goods where gd_id=:gd_id";
        $args = [':gd_id'=>$this->gd_id];
        return $this->run($sql, $args);
    }

    //customer view product images//
    function goods_viewImgProduct(){
        $sql = "select * from gd_image where get_imgid=:get_imgid order by gd_imgid ASC";
        $args = [':get_imgid'=>$this->id];
        return $this->run($sql, $args);
    }
}   
?>
