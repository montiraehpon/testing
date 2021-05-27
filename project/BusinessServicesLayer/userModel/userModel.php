<?php

class userModel{
    public $username,$email,$phone_num,$password,$user_type,$sp_imgpath,$sp_name,$sp_address,$sp_shop_name,$sp_shop_type,$new_pw,$new_pw2,$accname,$accnum,$bankname,$token,$set_pw,$new_token,$user_id,$sp_ic,$sp_icpath,$rn_icpath,$rn_name,$rn_ic,$rn_licensepath,$rn_gender,$rn_address,$status;

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

    //get password to check//
    function getPw(){
        $sql = "select password from user where email=:email and user_type=:user_type";
        $args = [':email'=>$this->email, ':user_type'=>$this->user_type];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $pwdb = $row['password'];
        return $pwdb;
    }

    //sign up//
    function signup(){
        $sql = "insert into user(email,password,user_type) values(:email,:password,:user_type)";
        $args = [':email'=>$this->email, ':password'=>$this->password, ':user_type'=>$this->user_type];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //check user exist//
    function check(){
        $sql = "select * from user where email=:email and user_type=:user_type";
        $args = [':email'=>$this->email,':user_type'=>$this->user_type];
        $stmt = $this->run($sql,$args);
        $count = $stmt->rowCount();
        return $count;
    }

    //get id//
    function getId(){
        $sql = "select user_id from user where email=:email and user_type=:user_type";
        $args = [':email'=>$this->email, ':user_type'=>$this->user_type];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $getId = $row['user_id'];
        return $getId;
    }

    //update token//
    function addId(){
        $sql = "update user set token=:token where user_id=:user_id";
        $args = [':token'=>$this->token, ':user_id'=>$this->user_id];
        $stmt = $this->run($sql,$args);
        $count = $stmt->rowCount();
        return $count;
    }

    //update password//
    function set_newPw(){
        $sql = "update user set password=:password, token=:token where user_id=:user_id";
        $args = [':password'=>$this->set_pw, ':token'=>$this->new_token, ':user_id'=>$this->user_id];
        $stmt = $this->run($sql,$args);
        $count = $stmt->rowCount();
        return $count;
    }

    //check token and id//
    function checkId(){
        $sql = "select * from user where token=:token and user_id=:user_id";
        $args = [':token'=>$this->token, ':user_id'=>$this->user_id];
        $stmt = $this->run($sql,$args);
        $count = $stmt->rowCount();
        return $count;
    }

    //view profile//
    function view(){
        $sql = "select * from user where user_id=:user_id and token=:token";
        $args = [':user_id'=>$this->user_id, ':token'=>$this->token];
        return $this->run($sql,$args);
    }

    //check password//
    function pwCheck(){
        $sql = "select password from user where user_id=:user_id";
        $args = [':user_id'=>$this->user_id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $pwdb = $row["password"];
        return $pwdb;
    }

    //change password inside profile//
    function changePw(){
        $sql = "update user set password=:new_pw where user_id=:user_id";
        $args = [':new_pw'=>$this->new_cfm_pw, ':user_id'=>$this->user_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    // admin//
    //view sp//
    function ad_viewSp(){
        $sql = "select * from sp where sp_id=:sp_id";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    function ad_spList(){
        $sql = "select * from sp order by sp_id ASC limit $this->start, $this->limit";
        return $this->run($sql);
    }

    function ad_allSPList(){
        $sql = "select * from sp";
        $stmt = $this->run($sql);
        $count = $stmt->rowCount();
        return $count;
    }

    //view specific sp//
    function ad_spSpec(){
        $sql = "select * from sp where sp_name like '%$this->search%' order by sp_id ASC limit $this->start, $this->limit";
        return $this->run($sql);
    }

    function ad_allSPSpec(){
        $sql = "select * from sp where sp_name like '%$this->search%'";
        $stmt = $this->run($sql);
        $count = $stmt->rowCount();
        return $count;
    }

    //update sp status//
    function ad_spStatus(){
        $sql = "update sp set status=:status where sp_id=:sp_id";
        $args = [':status'=>$this->status, ':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //view runner//
    function ad_viewRn(){
        $sql = "select * from runner where rn_id=:rn_id";
        $args = [':rn_id'=>$this->rn_id];
        return $this->run($sql, $args);
    }

    function ad_rnList(){
        $sql = "select * from runner order by rn_id ASC limit $this->start, $this->limit";
        return $this->run($sql);
    }

    function ad_allRNList(){
        $sql = "select * from runner";
        $stmt = $this->run($sql);
        $count = $stmt->rowCount();
        return $count;
    }

    //view specific runner//
    function ad_rnSpec(){
        $sql = "select * from runner where rn_name like '%$this->search%' order by rn_id ASC limit $this->start, $this->limit";
        return $this->run($sql);
    }

    function ad_allRNSpec(){
        $sql = "select * from runner where rn_name like '%$this->search%'";
        $stmt = $this->run($sql);
        $count = $stmt->rowCount();
        return $count;
    }

    //update runner status//
    function ad_rnStatus(){
        $sql = "update runner set status=:status where rn_id=:rn_id";
        $args = [':status'=>$this->status, ':rn_id'=>$this->rn_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //get runner image//
    function ad_getIc(){
        $sql = "select rn_icpath from runner where rn_id=:id";
        $args = [':id'=>$this->id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $icpath = $row['rn_icpath'];
        return $icpath;
    }

    function ad_getLicense(){
        $sql = "select rn_licensepath from runner where rn_id=:id";
        $args = [':id'=>$this->id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $licensepath = $row['rn_licensepath'];
        return $licensepath;
    }

    function ad_getSPIc(){
        $sql = "select sp_icpath from sp where sp_id=:id";
        $args = [':id'=>$this->id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $icpath = $row['sp_icpath'];
        return $icpath;
    }
    // Service provider //
    //get id//
    function sp_getId(){
        $sql = "select sp_id from sp where user_id=:user_id";
        $args = [':user_id'=>$this->user_id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $iddb = $row['sp_id'];
        return $iddb;
    }

    //get name//
    function sp_getName(){
        $sql = "select sp_name from sp where user_id=:user_id";
        $args = [':user_id'=>$this->user_id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $namedb = $row['sp_name'];
        return $namedb;
    }

    //check status to login//
    function sp_checkStatus(){
        $sql = "select status from sp where user_id=:user_id";
        $args = [':user_id'=>$this->user_id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $status = $row['status'];
        return $status;
    }

    //view profile//
    function sp_view(){
        $sql = "select * from sp where sp_id=:sp_id";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql,$args);
    }

    //insert profile//
    function sp_save(){
       $sql = "insert into sp(sp_name,sp_ic,sp_icpath,phone_num,sp_address,sp_shop_name,email,user_id)values(:sp_name,:sp_ic,:sp_icpath,:phone_num,:sp_address,:sp_shop_name,:email,:user_id)";
        $args = [':sp_name'=>$this->sp_name, ':sp_ic'=>$this->sp_ic, ':sp_icpath'=>$this->sp_icpath,':phone_num'=>$this->phone_num, ':sp_address'=>$this->sp_address, ':sp_shop_name'=>$this->sp_shop_name, ':email'=>$this->email, ':user_id'=>$this->user_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //update profile//
    function sp_update(){
        if($this->sp_imgpath != ""){
            $sql = "update sp set sp_imgpath=:sp_imgpath,sp_name=:sp_name,phone_num=:phone_num,sp_address=:sp_address,sp_shop_name=:sp_shop_name,email=:email where sp_id=:sp_id";
            $args = [':sp_imgpath'=>$this->sp_imgpath,':sp_name'=>$this->sp_name, ':phone_num'=>$this->phone_num, ':sp_address'=>$this->sp_address, ':sp_shop_name'=>$this->sp_shop_name, ':email'=>$this->email, ':sp_id'=>$this->sp_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count;
        }
        else{
            $sql = "update sp set sp_name=:sp_name,phone_num=:phone_num,sp_address=:sp_address,sp_shop_name=:sp_shop_name,email=:email where sp_id=:sp_id";
            $args = [':sp_name'=>$this->sp_name, ':phone_num'=>$this->phone_num, ':sp_address'=>$this->sp_address, ':sp_shop_name'=>$this->sp_shop_name, ':email'=>$this->email, ':sp_id'=>$this->sp_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count;
        }
    }

    //add bank//
    function sp_bankAdd(){
        $sql = "insert into sp_bank(accnum,accname,bankname,sp_id)values(:accnum,:accname,:bankname,:sp_id)";
        $args = [':accnum'=>$this->accnum, ':accname'=>$this->accname, ':bankname'=>$this->bankname, ':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //delete bank//
    function sp_bankDelete(){
        $sql = "delete from sp_bank where acc_id=:acc_id and sp_id=:sp_id ";
        $args = [':acc_id'=>$this->acc_id, ':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //view bank//
    function sp_bankView(){
        $sql = "select * from sp_bank where sp_id=:sp_id order by acc_id ASC";
        $args = [':sp_id'=>$this->sp_id];
        return $this->run($sql, $args);
    }

    //check bank amount//
    function sp_bankCheck(){
        $sql = "select * from sp_bank where sp_id=:sp_id";
        $args = [':sp_id'=>$this->sp_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    // runner // 
    //get id//
    function rn_getId(){
        $sql = "select rn_id from runner where user_id=:user_id";
        $args = [':user_id'=>$this->user_id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $iddb = $row['rn_id'];
        return $iddb;
    }

    //get name//
    function rn_getName(){
        $sql = "select rn_name from runner where user_id=:user_id";
        $args = [':user_id'=>$this->user_id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $namedb = $row['rn_name'];
        return $namedb;
    }

    //check status to login//
    function rn_checkStatus(){
        $sql = "select status from runner where user_id=:user_id";
        $args = [':user_id'=>$this->user_id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $status = $row['status'];
        return $status;
    }

    //view profile//
    function rn_view(){
        $sql = "select * from runner where rn_id=:rn_id";
        $args = [':rn_id'=>$this->rn_id];
        return $this->run($sql, $args);
    }

    //insert profile//
    function rn_save(){
       $sql = "insert into runner(rn_name,rn_ic,rn_icpath,rn_licensepath,phone_num,rn_gender,rn_address,email,user_id)values(:rn_name,:rn_ic,:rn_icpath,:rn_licensepath,:phone_num,:rn_gender,:rn_address,:email,:user_id)";
        $args = [':rn_name'=>$this->rn_name, ':rn_ic'=>$this->rn_ic, ':rn_icpath'=>$this->rn_icpath, ':rn_licensepath'=>$this->rn_licensepath,':phone_num'=>$this->phone_num, ':rn_gender'=>$this->rn_gender, ':rn_address'=>$this->rn_address, ':email'=>$this->email, ':user_id'=>$this->user_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //update profile//
    function rn_update(){
        if($this->rn_imgpath != ""){
            $sql = "update runner set rn_imgpath=:rn_imgpath,rn_name=:rn_name,phone_num=:phone_num,rn_address=:rn_address,rn_gender=:rn_gender,email=:email where rn_id=:rn_id";
            $args = [':rn_imgpath'=>$this->rn_imgpath,':rn_name'=>$this->rn_name, ':phone_num'=>$this->phone_num, ':rn_address'=>$this->rn_address, ':rn_gender'=>$this->rn_gender, ':email'=>$this->email, ':rn_id'=>$this->rn_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count;
        }
        else{
            $sql = "update runner set rn_name=:rn_name,phone_num=:phone_num,rn_address=:rn_address,rn_gender=:rn_gender,email=:email where rn_id=:rn_id";
            $args = [':rn_name'=>$this->rn_name, ':phone_num'=>$this->phone_num, ':rn_address'=>$this->rn_address, ':rn_gender'=>$this->rn_gender, ':email'=>$this->email, ':rn_id'=>$this->rn_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count;
        }
    }

    //view bank//
    function rn_bankView(){
        $sql = "select * from rn_bank where rn_id=:rn_id order by acc_id ASC ";
        $args = [':rn_id'=>$this->rn_id];
        return $this->run($sql, $args);
    }

    //check bank amount//
    function rn_bankCheck(){
        $sql = "select * from rn_bank where rn_id=:rn_id";
        $args = [':rn_id'=>$this->rn_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //delete bank//
    function rn_bankDelete(){
        $sql = "delete from rn_bank where acc_id=:acc_id and rn_id=:rn_id ";
        $args = [':acc_id'=>$this->acc_id, ':rn_id'=>$this->rn_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //add bank//
    function rn_bankAdd(){
        $sql = "insert into rn_bank(accnum,accname,bankname,rn_id)values(:accnum,:accname,:bankname,:rn_id)";
        $args = [':accnum'=>$this->accnum, ':accname'=>$this->accname, ':bankname'=>$this->bankname, ':rn_id'=>$this->rn_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    // customer //
    //check profile exist//
    function cus_firstCheck(){
        $sql = "select * from customer where user_id=:user_id";
        $args = [':user_id'=>$this->user_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //view profile//
    function cus_firstView(){
        $sql = "select * from user where user_id=:user_id";
        $args = [':user_id'=>$this->user_id];
        return $this->run($sql, $args);
    }

    function cus_view(){
        $sql = "select * from customer where cus_id=:cus_id";
        $args = [':cus_id'=>$this->cus_id];
        return $this->run($sql, $args);
    }

    //get id//
    function cus_getId(){
        $sql = "select cus_id from customer where user_id=:user_id";
        $args = [':user_id'=>$this->user_id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $iddb = $row['cus_id'];
        return $iddb;
    }

    //get name//
    function cus_getName(){
        $sql = "select username from customer where user_id=:user_id";
        $args = [':user_id'=>$this->user_id];
        $stmt = $this->run($sql, $args);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $namedb = $row['username'];
        return $namedb;
    }

    //insert profile//
    function cus_save(){
        if($this->cus_imgpath == ""){
        $sql = "insert into customer(username,cus_name,phone_num,cus_gender,cus_address,cus_dob,email,user_id)values(:username,:cus_name,:phone_num,:cus_gender,:cus_address,:cus_dob,:email,:user_id)";
        $args = [':username'=>$this->username, ':cus_name'=>$this->cus_name,':phone_num'=>$this->phone_num, ':cus_gender'=>$this->cus_gender, ':cus_address'=>$this->cus_address, ':cus_dob'=>$this->cus_dob,':email'=>$this->email, ':user_id'=>$this->user_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
        }
        else if($this->cus_imgpath != "")
        $sql = "insert into customer(username,cus_name,cus_imgpath,phone_num,cus_gender,cus_address,cus_dob,email,user_id)values(:username,:cus_name,:cus_imgpath,:phone_num,:cus_gender,:cus_address,:cus_dob,:email,:user_id)";
        $args = [':username'=>$this->username, ':cus_name'=>$this->cus_name, ':cus_imgpath'=>$this->cus_imgpath,':phone_num'=>$this->phone_num, ':cus_gender'=>$this->cus_gender, ':cus_address'=>$this->cus_address, ':cus_dob'=>$this->cus_dob,':email'=>$this->email, ':user_id'=>$this->user_id];
        $stmt = $this->run($sql, $args);
        $count = $stmt->rowCount();
        return $count;
    }

    //update profile//
    function cus_update(){
        if($this->cus_imgpath != ""){
            $sql = "update customer set cus_imgpath=:cus_imgpath,username=:username,cus_name=:cus_name,phone_num=:phone_num,cus_address=:cus_address,cus_gender=:cus_gender,cus_dob=:cus_dob,email=:email where cus_id=:cus_id";
            $args = [':cus_imgpath'=>$this->cus_imgpath, ':username'=>$this->username, ':cus_name'=>$this->cus_name, ':phone_num'=>$this->phone_num, ':cus_address'=>$this->cus_address, ':cus_gender'=>$this->cus_gender, ':cus_dob'=>$this->cus_dob, ':email'=>$this->email, ':cus_id'=>$this->cus_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count;
        }
        else{
            $sql = "update customer set username=:username,cus_name=:cus_name,phone_num=:phone_num,cus_address=:cus_address,cus_gender=:cus_gender,cus_dob=:cus_dob,email=:email where cus_id=:cus_id";
            $args = [':username'=>$this->username, ':cus_name'=>$this->cus_name, ':phone_num'=>$this->phone_num, ':cus_address'=>$this->cus_address, ':cus_gender'=>$this->cus_gender, ':cus_dob'=>$this->cus_dob, ':email'=>$this->email, ':cus_id'=>$this->cus_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count;
        }
    }

    //add bank//
    function cus_bankAdd(){
            $sql = "insert into cus_bank(accnum,accname,bankname,cus_id)values(:accnum,:accname,:bankname,:cus_id)";
            $args = [':accnum'=>$this->accnum, ':accname'=>$this->accname, ':bankname'=>$this->bankname, ':cus_id'=>$this->cus_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count;
    }

    //delete bank//
    function cus_bankDelete(){
            $sql = "delete from cus_bank where acc_id=:acc_id and cus_id=:cus_id ";
            $args = [':acc_id'=>$this->acc_id, ':cus_id'=>$this->cus_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count;
    }

    //view bank//
    function cus_bankView(){
            $sql = "select * from cus_bank where cus_id=:cus_id order by acc_id ASC";
            $args = [':cus_id'=>$this->cus_id];
            return $this->run($sql, $args);
    }

    //check bank amount//
    function cus_bankCheck(){
            $sql = "select * from cus_bank where cus_id=:cus_id";
            $args = [':cus_id'=>$this->cus_id];
            $stmt = $this->run($sql, $args);
            $count = $stmt->rowCount();
            return $count;
    }
}
?>
