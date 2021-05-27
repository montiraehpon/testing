<?php

class trackModel{
    public $sp_id;

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

    //check delivery list//
    function checkList(){
        $sql = "select sp_id from ordered where not status=:status group by sp_id";
        $args = [':status'=>$this->status];
        return $this->run($sql,$args);
    }

    //check delivery list//
    function checkDate(){
        $sql = "select sp_id from ordered where status=:status group by sp_id";
        $args = [':status'=>$this->status];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //check delivery detail//
    function viewDeliveryDetail(){
        $sql = "select ordered.product_name, ordered.product_quantity, customer.cus_address, customer.phone_num from ordered, customer where ordered.cus_id=customer.cus_id and ordered.sp_id=:sp_id and not status=:status";
        $args = [':sp_id'=>$this->sp_id, ':status'=>$this->status];
        return $this->run($sql,$args);
    }

    //view service provider detail//
    function viewSPDetail(){
        $sql = "select * from sp where sp_id=:sp_id";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql,$args);
    }

    //accept delivery//
    function acceptDelivery(){
        $sql = "update ordered set order_droptime=:order_droptime, rn_id=:rn_id, status=:status where sp_id=:sp_id and not status=:doneStatus";
        $args = [':order_droptime'=>$this->date, ':rn_id'=>$this->rn_id, ':status'=>$this->status , ':sp_id'=>$this->sp_id, ':doneStatus'=>$this->doneStatus];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //view status//
    function viewStatus(){
        $sql = "select ordered.product_name, ordered.product_quantity, customer.cus_address, customer.phone_num from ordered, customer where ordered.cus_id=customer.cus_id and ordered.rn_id=:rn_id and not status=:status";
        $args = [':rn_id'=>$this->rn_id, ':status'=>$this->status];
        return $this->run($sql,$args);
    }

    //get service provider data//
    function getSP(){
        $sql = "select sp_id from ordered where rn_id=:rn_id and not status=:status";
        $args = [':rn_id'=>$this->rn_id,':status'=>$this->status];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $spdb = $row['sp_id'];
        return $spdb;
    }

    //get runner data//
    function getRunner(){
        $sql = "select * from ordered where rn_id=:rn_id and not status=:status";
        $args = [':rn_id'=>$this->rn_id, ':status'=>$this->status];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }  

    //get runner data//
    function getComplete(){
        $sql = "select * from ordered where rn_id=:rn_id and status=:status or status=:status2";
        $args = [':rn_id'=>$this->rn_id, ':status'=>$this->status, ':status2'=>$this->status2];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }   

    //update delivery//
    function updateDelivery(){
        $sql = "update ordered set status=:status, order_droptime=:order_droptime where rn_id=:rn_id and sp_id=:sp_id and not status=:doneStatus";
        $args = [':status'=>$this->status, ':order_droptime'=>$this->date, ':rn_id'=>$this->rn_id, ':sp_id'=>$this->sp_id, ':doneStatus'=>$this->doneStatus];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //check order//
    function checkOrder(){
        $sql = "select * from ordered where cus_id=:cus_id";
        $args = [':cus_id'=>$this->cus_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //view order//
    function viewOrder(){
        $sql = "select * from ordered where cus_id=:cus_id order by order_id ASC ";
        $args = [':cus_id'=>$this->cus_id];
        return $this->run($sql, $args);
    }

    //check history//
    function checkHistory(){
        $sql = "select * from ordered where cus_id=:cus_id and status=:status";
        $args = [':cus_id'=>$this->cus_id, ':status'=>$this->status];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //view history//
    function viewHistory(){
        $sql = "select * from ordered where cus_id=:cus_id and status=:status order by order_id ASC ";
        $args = [':cus_id'=>$this->cus_id, ':status'=>$this->status];
        return $this->run($sql, $args);
    }

    //service provider check order//
    function checkSPOrder(){
        $sql = "select * from ordered where sp_id=:sp_id";
        $args = [':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //service provider view order//
    function viewSPOrder(){
        $sql = "select * from ordered where sp_id=:sp_id order by order_id ASC ";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //check service provider history//
    function checkSPHistory(){
        $sql = "select * from ordered where sp_id=:sp_id and status=:status";
        $args = [':sp_id'=>$this->sp_id, ':status'=>$this->status];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //view history//
    function viewSPHistory(){
        $sql = "select * from ordered where sp_id=:sp_id and status=:status order by order_id ASC ";
        $args = [':sp_id'=>$this->sp_id, ':status'=>$this->status];
        return $this->run($sql, $args);
    }

    //report of food products//
    function food_rpt(){
        $sql = "select count(product_id) as sum, product_name, product_price, product_quantity from ordered where sp_id=:sp_id and product_type=:product_type group by product_name";
        $args = [':sp_id'=>$this->sp_id, ':product_type'=>$this->type];
        return $this->run($sql, $args);
    }

    function food_rpt_check(){
        $sql = "select * from ordered where sp_id=:sp_id and product_type=:product_type";
        $args = [':sp_id'=>$this->sp_id, ':product_type'=>$this->type];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //report of goods products//
    function goods_rpt(){
        $sql = "select count(product_id) as sum, product_name, product_price, product_quantity from ordered where sp_id=:sp_id and product_type=:product_type group by product_name";
        $args = [':sp_id'=>$this->sp_id, ':product_type'=>$this->type];
        return $this->run($sql, $args);
    }

    function goods_rpt_check(){
        $sql = "select * from ordered where sp_id=:sp_id and product_type=:product_type";
        $args = [':sp_id'=>$this->sp_id, ':product_type'=>$this->type];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //report of medical products//
    function med_rpt(){
        $sql = "select count(product_id) as sum, product_name, product_price, product_quantity from ordered where sp_id=:sp_id and product_type=:product_type group by product_name";
        $args = [':sp_id'=>$this->sp_id, ':product_type'=>$this->type];
        return $this->run($sql, $args);
    }

    function med_rpt_check(){
        $sql = "select * from ordered where sp_id=:sp_id and product_type=:product_type";
        $args = [':sp_id'=>$this->sp_id, ':product_type'=>$this->type];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //report of pet products//
    function pet_rpt(){
        $sql = "select count(product_id) as sum, product_name, product_price, product_quantity from ordered where sp_id=:sp_id and product_type=:product_type group by product_name";
        $args = [':sp_id'=>$this->sp_id, ':product_type'=>$this->type];
        return $this->run($sql, $args);
    }

    function pet_rpt_check(){
        $sql = "select * from ordered where sp_id=:sp_id and product_type=:product_type";
        $args = [':sp_id'=>$this->sp_id, ':product_type'=>$this->type];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //Runner Report//
    function rn_rpt(){
        $sql = "select * from ordered where rn_id=:rn_id and status=:status order by order_id ASC";
        $args = [':rn_id'=>$this->rn_id, ':status'=>$this->status];
        return $this->run($sql, $args);
    }

    function rn_rpt_check(){
        $sql = "select * from ordered where rn_id=:rn_id and status=:status";
        $args = [':rn_id'=>$this->rn_id, ':status'=>$this->status];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }
}
?>