<?php

class orderModel{
	public $product_name,$product_price,$product_id,$cus_id,$sp_id,$product_imgpath,$product_quantity,$order_droplocation,$order_picklocation,$order_time,$total_price,$status;

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

	//add into cart//
    function addCart(){
    	$sql = "insert into cart(product_id,product_name,product_price,product_imgpath,product_quantity,type,sp_id,cus_id) values(:product_id,:product_name,:product_price,:product_imgpath,:product_quantity,:type,:sp_id,:cus_id)";
        $args = [':product_id'=>$this->product_id, ':product_name'=>$this->product_name, ':product_price'=>$this->product_price, ':product_imgpath'=>$this->product_imgpath, ':product_quantity'=>$this->product_quantity, ':type'=>$this->type, ':sp_id'=>$this->sp_id, ':cus_id'=>$this->cus_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //check cart//
    function checkCart(){
    	$sql = "select * from cart where product_id=:product_id and cus_id=:cus_id";
    	$args = [':product_id'=>$this->product_id,':cus_id'=>$this->cus_id];
    	$stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //get quantity//
    function getQuantity(){
        $sql = "select * from cart where product_id=:product_id and cus_id=:cus_id";
        $args = [':product_id'=>$this->product_id,':cus_id'=>$this->cus_id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $quandb = $row['product_quantity'];
        return $quandb;
    }

    //update quantity//
    function updateQuantity(){
        $sql = "update cart set product_quantity=:product_quantity where product_id=:product_id and cus_id=:cus_id";
        $args = [':product_quantity'=>$this->product_quantity,':product_id'=>$this->product_id,':cus_id'=>$this->cus_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //check cart//
    function checkTotalCart(){
    	$sql = "select * from cart where cus_id=:cus_id";
        $args = [':cus_id'=>$this->cus_id];
       	$stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //view cart//
    function viewCart(){
    	$sql = "select * from cart where cus_id=:cus_id";
        $args = [':cus_id'=>$this->cus_id];
       	return $this->run($sql, $args);
    }

    //delete product//
    function deleteProduct(){
    	$sql = "delete from cart where product_id=:product_id";
        $args = [':product_id'=>$this->product_id];
       	return $this->run($sql, $args);
    }

    //view customer detail//
    function viewCusDetail(){
    	$sql = "select * from customer where cus_id=:cus_id";
        $args = [':cus_id'=>$this->cus_id];
       	return $this->run($sql, $args);
    }

    //delete cart//
	function deleteCart(){
    	$sql = "delete from cart where cus_id=:cus_id";
        $args = [':cus_id'=>$this->cus_id];
       	return $this->run($sql, $args);
    }

    //get SP detail//
    function viewSPDetail(){
		$sql = "select * from sp where sp_id=:sp_id";
        $args = [':sp_id'=>$this->sp_id];
       	return $this->run($sql, $args);
    }

    //update cart//
    function updateCart(){
    	$sql = "update cart set order_time=:order_time, total_price=:total_price ,status=:status where cus_id=:cus_id";
       	$args = [':order_time'=>$this->date, ':total_price'=>$this->total_price,':status'=>$this->status, ':cus_id'=>$this->cus_id];
       	return $this->run($sql, $args);
    }

    //add into order//
    function addOrder(){
    	$sql = "insert into ordered(product_id, product_name, product_price, product_quantity, product_type, order_time, status, total_price, sp_id, cus_id) select product_id, product_name, product_price, product_quantity, type, order_time, status, total_price, sp_id, cus_id from cart where cus_id=:cus_id";
        $args = [':cus_id'=>$this->cus_id];
        return $this->run($sql, $args);
    }


    //show cart item//
    function showCart(){
        $sql = "select * from cart where cus_id=:cus_id";
        $args = [':cus_id'=>$this->cus_id];
        return $this->run($sql, $args);
    }

    //add payment//
    function addPayment(){
        $sql = "insert into payment(total_price,date,payment_status,cus_id) values(:total_price,:date,:payment_status,:cus_id)";
        $args = [':total_price'=>$this->total_price,':date'=>$this->date,':payment_status'=>$this->payment_status,':cus_id'=>$this->cus_id];
        return $this->run($sql, $args);
    }  

}
?>