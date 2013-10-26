<?php
    
    include_once dirname(dirname(__FILE__)).'/includes/bootstrap.inc';
    include_once dirname(dirname(__FILE__)).'/includes/password.inc';
    
    include("database.php");
    include("security.php");
    //$result = security($_POST);
    $result = 1;
  
    
   
    if($result=='1'){
        if($_POST['userId']){
            $sel=mysql_query("select pass from users where uid='$_POST[userId]'");
            if(mysql_num_rows($sel) == 0){
                header("HTTP/1.0 404 User not found");
                exit;
            }
        }else{
            header("HTTP/1.0 400 Bad request");
            exit;
        }
		if($_POST['itemName'] && $_POST['quantity'] && $_POST['currencyType']){
            
            $name=$_POST['itemName'];
            $currency=$_POST['currencyType'];
            $qty1=$_POST['quantity'];
           
            $res1="select p.pid,p.isConsumable from product p where p.pname='$name'";
            // Check valid product name          
            
            $row1=mysql_query($res1);
            $fet2=mysql_fetch_array($row1);
            if(mysql_num_rows($row1) == 0){
                header("HTTP/1.0 407 Invalid product name");
                exit;
            }
         
            
            
            $sel="select * from users_info where uid='$_POST[userId]'";
            $exe=mysql_query($sel);
            $fet=mysql_fetch_array($exe);
          //  echo ("select * from user_inventory ui, product prop where ui.uid=".$_POST[userId]." and ui.pid=prop.pid and prod.pname=".$_POST['itemName']);
          //  die();
            $res= mysql_query("select ui.level level from user_inventory ui, product prod where ui.uid='$_POST[userId]' and ui.pid=prod.pid and prod.pname='$_POST[itemName]'");
           // echo "count=".mysql_num_rows($res);

                     
            
            $user_inventory_sql=mysql_query("SELECT prod.pname pname, prod.pid pid,  prod.isConsumable consumable, pl.buxPrice buxPrice, pl.maxbuxPrice maxbuxPrice , ui.uid uid, ui.quantity curentQuantity, ui.level currentLevel, pl.level FROM user_inventory ui, product_level pl, product prod where ui.uid='$_POST[userId]' and prod.pname='$name' and prod.pid=ui.pid and pl.pid=prod.pid  and (ui.level+1=pl.level or pl.level='All Level')");
            $rowcount = mysql_num_rows($user_inventory_sql);    
            
           // $user_inventory_sql1=mysql_query("SELECT prod.pname pname, prod.pid pid,  prod.isConsumable consumable, pl.buxPrice buxPrice, pl.maxbuxPrice maxbuxPrice , ui.uid uid, ui.quantity curentQuantity, ui.level currentLevel, pl.level FROM user_inventory ui, product_level pl, product prod where ui.uid='$_POST[userId]' and prod.pname='$name' and prod.pid=ui.pid and pl.pid=prod.pid  and ui.level='5' and pl.level='5'");
           // $rowcount2 = mysql_num_rows($user_inventory_sql1);    
          //  echo $res;
            $userinventory=mysql_fetch_array($res);
            if($qty1 >=99)
            {
                header("HTTP/1.0 403 Inventory more than 99 are not allowed");
                exit; 
            }

          //  echo "level=".$userinventory['level'];
           if($rowcount ==0)
           {
              
               if($userinventory['level'] >= 5)
               {
                    header("HTTP/1.0 403 Item can not be upgrade to level more than 5");
                   exit;
               }
           }
                           
            if($rowcount > 0){
               //$user_inventory_result=mysql_fetch_array($res);
                $user_inventory_result = mysql_fetch_array($user_inventory_sql);
                
              //  $sel1="select * from product_level where pid='$fet2[pid]'";
        	//	$exe1=mysql_query($sel1);
        	//	$fet1=mysql_fetch_array($exe1);
                
               
                    
					// update query
                    
					if($user_inventory_result['consumable']=='0'){
                       //  echo 'mmmm';
                       // echo $user_inventory_result['currentLevel'];
                      
                        
                        //Erorr: Item can not update to level more than 5
                       if($user_inventory_result['currentLevel']==5)
                       {
                           header("HTTP/1.0 408 Item can not be upgrade to level more than 5");
                           exit; 
                       }

			   if($user_inventory_result['buxPrice']=='0' && $currency=='Bux'){
			   header("HTTP/1.0 403 Item can not be puchase with this currency");
			   exit;
			   }
			   
			   if($user_inventory_result['maxbuxPrice']=='0' && $currency=='MaxBux'){
			   header("HTTP/1.0 403 Item can not be puchase with this currency");
			   exit;
			   }
                        
                        if(($currency=='Bux' && $fet['bux']<($user_inventory_result['buxPrice'])) || ($currency=='MaxBux' && $fet['maxbux']<($user_inventory_result['maxbuxPrice']))){
                            
                            header("HTTP/1.0 405 Insufficient balance");
                            exit;
                        }
                        //Error for sufficient balance
                        
                        
                        if($user_inventory_result['curentQuantity']=='0'){
                            $res = "update user_inventory set quantity='1', level=level+1 where uid='$_POST[userId]' and pid='$user_inventory_result[pid]'";
                            mysql_query($res);
                        }else{
                            $res = "update user_inventory set level=level+1 where uid='$_POST[userId]' and pid='$user_inventory_result[pid]'";
                            mysql_query($res);
                        }
                        if($currency=='Bux'){
                            $sql1="update users_info set bux=bux-$qty1*$user_inventory_result[buxPrice] where uid='$_POST[userId]'";
                            mysql_query($sql1);
                            
                        }elseif($currency=='MaxBux'){
                            $sql1="update users_info set maxbux=maxbux-$qty1*$user_inventory_result[maxbuxPrice] where uid='$_POST[userId]'";
                            mysql_query($sql1);
                        }
                        else
                        {
                            header("HTTP/1.0 406 Invalid Currency");
                            exit;
                        }
                        
                    } else{
                        
                        if(($user_inventory_result['curentQuantity']+$qty1) >=99)
                        {
                            header("HTTP/1.0 403 You can not have more than 99 items in your inventory");
                            exit; 
                        }

			   if($user_inventory_result['buxPrice']=='0' && $currency=='Bux'){
			   header("HTTP/1.0 403 Item can not be puchase with this currency");
			   exit;
			   }
			   
			   if($user_inventory_result['maxbuxPrice']=='0' && $currency=='MaxBux'){
			   header("HTTP/1.0 403 Item can not be puchase with this currency");
			   exit;
			   }
                        
                       
                        if(($currency=='Bux' && $fet['bux']<($qty1*$user_inventory_result['buxPrice'])) || ($currency=='MaxBux' && $fet['maxbux']<($qty1*$user_inventory_result['maxbuxPrice']))){
                            
                            header("HTTP/1.0 405 Insufficient balance");
                            exit;
                        }
                        $res = "update user_inventory set quantity=quantity+$qty1 where uid='$_POST[userId]' and pid='$user_inventory_result[pid]'";
                        mysql_query($res);
                        
                        
                        if($currency=='Bux'){
                            $sql1="update users_info set bux=bux-$qty1*$user_inventory_result[buxPrice] where uid='$_POST[userId]'";
                            mysql_query($sql1);
                        }else{
                            $sql1="update users_info set maxbux=maxbux-$qty1*$user_inventory_result[maxbuxPrice] where uid='$_POST[userId]'";
                            mysql_query($sql1);
						}
					}
            }else{
                
                $sel1="select * from product_level where pid='$fet2[pid]' and (level='1' or level='All Level')";
                $exe1=mysql_query($sel1);
                $fet1=mysql_fetch_array($exe1);		
                
			 if($fet1['buxPrice']=='0' && $currency=='Bux'){
			   header("HTTP/1.0 403 Item can not be puchase with this currency");
			   exit;
			   }
			   
			   if($fet1['maxbuxPrice']=='0' && $currency=='MaxBux'){
			   header("HTTP/1.0 403 Item can not be puchase with this currency");
			   exit;
			   }

			
                if(($currency=='Bux' && $fet['bux']<($qty1*$fet1['buxPrice'])) || ($currency=='MaxBux' && $fet['maxbux']<($qty1*$fet1['maxbuxPrice']))){
                    
                    header("HTTP/1.0 405 Insufficient balance");
                    exit;
                    
                }else{
					
					if($fet2['isConsumable']=='1'){ 
						$level='All Level';
                    }else{
						$level='1';
                    }
                    $sql="insert into user_inventory(uid,pid,quantity,level)values('$_POST[userId]','$fet2[pid]','$qty1','$level')";
                    mysql_query($sql);
                    if($currency=='Bux'){
                        $sql1="update users_info set bux=bux-$qty1*$fet1[buxPrice] where uid='$_POST[userId]'";
                        mysql_query($sql1);
					}else{
                        $sql1="update users_info set maxbux=maxbux-$qty1*$fet1[maxbuxPrice] where uid='$_POST[userId]'";
                        mysql_query($sql1);
					}
				}
                
            }
        }
        
        //Items...............
        $res=mysql_query("select p.pname as Name,p.isConsumable as consum, ui.quantity as qty,ui.level as level ,p.pid from user_inventory ui,product p where ui.pid=p.pid and ui.uid='$_POST[userId]'");
        $i=0;
        while($row2=mysql_fetch_assoc($res)){
            
            $cost=mysql_query("select buxPrice,maxbuxPrice from product_level where pid='$row2[pid]'");
        	$buxarray=array();
        	$maxbuxarray=array();
        	while($crow=mysql_fetch_assoc($cost)){
                $buxarray[]=(int)$crow['buxPrice'];
                $maxbuxarray[]=(int)$crow['maxbuxPrice'];
        	}
            if($row2['consum']=='1'){
                $row2['LevelOrUses']=(int)$row2['qty'];
            }else{
                $row2['LevelOrUses']=(int)$row2['level'];
            }
            
        	$row2['BuxCost']=$buxarray;
        	$row2['MaxBuxCost']=$maxbuxarray;
            
        	unset($row2['consum']);
            unset($row2['qty']);
            unset($row2['level']);
            unset($row2['pid']);
            $inventory[$i]=$row2;
            $i++;
        }
        echo stripslashes(json_encode($inventory));
        
    }else{
        header("HTTP/1.0 402 Invalid Keys or signature");
    }	
    ?>
