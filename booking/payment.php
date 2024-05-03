<?php

if (!isset($_SESSION['dragonhouse_cart'])) {
  # code...
  redirect(WEB_ROOT.'index.php');
}

function createRandomPassword() {

    $chars = "abcdefghijkmnopqrstuvwxyz023456789";

    srand((double)microtime()*1000000);

    $i = 0;

    $pass = '' ;
    while ($i <= 7) {

        $num = rand() % 33;

        $tmp = substr($chars, $num, 1);

        $pass = $pass . $tmp;

        $i++;

    }

    return $pass;

}

 $confirmation = createRandomPassword();
$_SESSION['confirmation'] = $confirmation;
 
 $count_cart = count($_SESSION['dragonhouse_cart']);

if(isset($_POST['btnsubmitbooking'])){
  // $message = $_POST['message'];
 

if(!isset($_SESSION['GUESTID'])){

$sql = "SELECT * FROM `tblauto` WHERE `autoid`=1";
$mydb->setQuery($sql);
$res = $mydb->loadSingleResult();


$guest = New Guest();
$guest->GUESTID          = $res->start;
$guest->G_FNAME          = $_SESSION['name'];    
$guest->G_LNAME          = $_SESSION['last'];  
$guest->G_CITY           = $_SESSION['City'];
$guest->G_ADDRESS        = $_SESSION['address'] ;        
$guest->DBIRTH           = date_format(date_create($_SESSION['dbirth']), 'Y-m-d');   
$guest->G_PHONE          = $_SESSION['phone'];    
$guest->G_NATIONALITY    = $_SESSION['nationality'];          
$guest->G_COMPANY        = $_SESSION['company'];      
$guest->G_CADDRESS       = $_SESSION['caddress'];        
$guest->G_TERMS          = 1;    
$guest->G_EMAIL          = $_SESSION['cemail'];  
$guest->G_UNAME          = $_SESSION['username'];    
$guest->G_PASS           = sha1($_SESSION['pass']);    
$guest->ZIP              = $_SESSION['zip'];
$guest->create(); 


  $lastguest= $res->start;
   
$_SESSION['GUESTID'] =   $lastguest;

}
 
    $count_cart = count($_SESSION['dragonhouse_cart']);
  

    for ($i=0; $i < $count_cart  ; $i++) { 

 

            $reservation = new Reservation();
            $reservation->CONFIRMATIONCODE  = $_SESSION['confirmation'];
            $reservation->TRANSDATE         = date('Y-m-d h:i:s'); 
            $reservation->ROOMID            = $_SESSION['dragonhouse_cart'][$i]['dragonhouseroomid'];
            $reservation->ARRIVAL           = date_format(date_create( $_SESSION['dragonhouse_cart'][$i]['dragonhousecheckin']), 'Y-m-d');  
            $reservation->DEPARTURE         = date_format(date_create( $_SESSION['dragonhouse_cart'][$i]['dragonhousecheckout']), 'Y-m-d'); 
            $reservation->RPRICE            = $_SESSION['dragonhouse_cart'][$i]['dragonhouseroomprice'];  
            $reservation->GUESTID           = $_SESSION['GUESTID']; 
            $reservation->PRORPOSE          = 'Travel';
            $reservation->STATUS            = 'Pending';
            $reservation->create(); 

            
            @$tot += $_SESSION['dragonhouse_cart'][$i]['dragonhouseroomprice'];
            }

           $item = count($_SESSION['dragonhouse_cart']);

            $sql = "INSERT INTO `tblpayment` (`TRANSDATE`,`CONFIRMATIONCODE`,`PQTY`, `GUESTID`, `SPRICE`,`CARD_NUMBER`,`HOLDER`,`VALID_THROUGH`,`CVV`,`MSGVIEW`,`STATUS`)
       VALUES ('" .date('Y-m-d h:i:s')."','" . $_SESSION['confirmation'] ."',".$item."," . $_SESSION['GUESTID'] . ",".$tot.",'".$_POST['card_number']."','".$_POST['card_holder']."','".$_POST['valid-thru-text']."','".$_POST['cvv-text']."',0,'Pending')" ;


       
      //echo $sql; die;
      $mydb->setQuery($sql);
      $mydb->executeQuery(); 


      $sql = "UPDATE `tblauto` SET `start` = `start` + 1 WHERE `autoid`=1";
      $mydb->setQuery($sql);
      $mydb->executeQuery(); 



  

            unset($_SESSION['dragonhouse_cart']);
            // unset($_SESSION['confirmation']);
            unset($_SESSION['pay']);
            unset($_SESSION['from']);
            unset($_SESSION['to']);
            $_SESSION['activity'] = 1;

            ?> 

<script type="text/javascript"> alert("Booking is successfully submitted!");</script>

            <?php
            
    redirect( WEB_ROOT."index.php");


}
?>

 
 
 <div id="accom-title"  > 
    <div  class="pagetitle">   
            <h1 >Billing Details 
                 
            </h1> 
        </div> 
  </div>
 
<div id="bread">
   <ol class="breadcrumb">
      <li><a href="<?php echo WEB_ROOT ;?>index.php">Home</a> </li> 
      <li><a href="<?php echo WEB_ROOT ;?>booking/">Booking Cart</a></li>  
       <li class="active"> <br/>Booking Details</li>
   </ol> 
</div> 


<form action="index.php?view=payment" method="post"  name="personal" >

 
<div class="col-md-12">

  <div class="row">
    <div class="col-md-8 col-sm-4">
       <div class="col-md-12">
          <label>Name:</label>
          <?php echo $_SESSION['name'] . ' '. $_SESSION['last']; 
   echo $count_cart;
           ?>
        </div>
        <div class="col-md-12">
          <label>Address:</label>
          <?php echo isset($_SESSION['city']) ? $_SESSION['city']: ' '. ' ' . isset($_SESSION['address'])  ? $_SESSION['address'] : ' '; ?> 
        </div>
        <div class="col-md-12"> 
        <label>Phone :</label>
         <?php echo $_SESSION['phone'] ; ?>
        </div>
    </div> 
    <div class="col-md-4 col-sm-2">
      <div class="col-md-12">
        <label>Transaction Date:</label>
       <?php echo date("m/d/Y") ; ?>
      </div>
       <div class="col-md-12">
        <label>Transaction Id:</label>
       <?php echo $_SESSION['confirmation']; ?>
      </div>
      
    </div>
  </div> 
  <br/>




<div class="row">
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <td>Room</td>
          <td>Arrival</td>
          <td>Departure</td>
          <td>Price</td>
          <td>Day(s)</td>
          <td>Subtotal</td>
        </tr>
      </thead> 
      <tbody>
<?php
$payable = 0;
if (isset( $_SESSION['dragonhouse_cart'])){ 
$count_cart = count($_SESSION['dragonhouse_cart']);


for ($i=0; $i < $count_cart  ; $i++) {  

  $query = "SELECT * FROM `tblroom` r ,`tblaccomodation` a WHERE r.`ACCOMID`=a.`ACCOMID` AND ROOMID=" . $_SESSION['dragonhouse_cart'][$i]['dragonhouseroomid'];
   $mydb->setQuery($query);
   $cur = $mydb->loadResultList(); 
    foreach ($cur as $result) { 


?>

      
        <tr>
          <td><?php echo  $result->ROOM.' '. $result->ROOMDESC; ?></td>
          <td><?php echo  date_format(date_create( $_SESSION['dragonhouse_cart'][$i]['dragonhousecheckin']),"m/d/Y"); ?></td>
          <td><?php echo  date_format(date_create( $_SESSION['dragonhouse_cart'][$i]['dragonhousecheckout']),"m/d/Y"); ?></td>
          <td><?php echo  ' &#x20B9;'. $result->PRICE; ?></td>
          <td><?php echo   $_SESSION['dragonhouse_cart'][$i]['dragonhouseday']; ?></td>
          <td><?php echo ' &#x20B9;'.   $_SESSION['dragonhouse_cart'][$i]['dragonhouseroomprice']; ?></td>
        </tr>
<?php
       $payable += $_SESSION['dragonhouse_cart'][$i]['dragonhouseroomprice'] ;
      }

    } 
     $_SESSION['pay'] = $payable;
 } 
 ?> 
      </tbody>
    </table>
       
          
          
  </div> 
</div>
							
<div class="right"> 
      <h3 style="text-align: right;">Total: &#x20B9; <?php echo   $_SESSION['pay'] ;?></h3>
    </div>
    
    <br>
    <div class="">
        <div class="col-md-12">

  <div class="row">
<div class="form-group">
								<div class="col-md-6">
									<label class="control-label" for="U_USERNAME">CARD NUMBER:</label>
									<input type="text" name="card_number" id="card-number" maxlength="19" placeholder="1234 5678 9101 1121" required="" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" class="form-control input">
								</div>

								<div class="col-md-6">
									<label class="control-label" for="U_PASS">HOLDER:</label>
									<input type="text" name="card_holder" id="name-text" maxlength="30" placeholder="NOAH JACOB" required="" onkeypress="return (event.charCode > 64 &amp;&amp; event.charCode < 91) || (event.charCode > 96 &amp;&amp; event.charCode < 123) || event.key == ' '" class="form-control input">

								</div>
								<div class="col-md-6"><br>
									<label class="control-label" for="U_USERNAME">VALID THROUGH:</label>
									<input type="text" name="valid-thru-text" id="valid-thru-text" maxlength="5" placeholder="02/40" required=""  class="form-control input">
								</div>
								<div class="col-md-6"><br>
									<label class="control-label" for="U_USERNAME">CVV:</label>
									<input type="text" name="cvv-text" id="cvv-text1" maxlength="4" placeholder="1234" required="" onkeypress="return event.charCode >=48 &amp;&amp; event.charCode <= 57" class="form-control input">
								</div>
							</div>
</div></div>
    <button type="submit" class="button"  name="btnsubmitbooking">Submit Booking</button>
    </div>
      </button>
      <!-- <button type="submit" class="button"  name="btnsubmitbooking">Submit Booking</button> -->
    </div>
    <br>
    <br>
  </div>   

  
</form>



       <!-- <button type="submit" class="button"  name="btnsubmitbooking">Submit Booking</button> -->

 



