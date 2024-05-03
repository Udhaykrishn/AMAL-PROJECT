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

      $sql = "INSERT INTO `tblpayment` (`TRANSDATE`,`CONFIRMATIONCODE`,`PQTY`, `GUESTID`, `SPRICE`,`MSGVIEW`,`STATUS`)
       VALUES ('" .date('Y-m-d h:i:s')."','" . $_SESSION['confirmation'] ."',".$item."," . $_SESSION['GUESTID'] . ",".$tot.",0,'Pending')" ;
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
<form action="index.php?view=credit" method="post"  name="personal" >
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Card Form</title>
    <link rel="stylesheet" href="credit-payment.css">
</head>

<body>
    <main class="container">
        <section class="ui">
            <div class="container-left">
                <form id="credit-card">
                    <div class="number-container">
                        <label>Card Number</label>
                        <input type="text" name="card-number" id="card-number" maxlength="19" placeholder="1234 5678 9101 1121" required onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>
                    <div class="name-container">
                        <label>Holder</label>
                        <input type="text" name="name-text" id="name-text" maxlength="30" placeholder="NOAH JACOB" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.key == ' '">
                    </div>
                    <div class="infos-container">
                        <div class="expiration-container">
                            <label>Valid-thru</label>
                            <input type="text" name="valid-thru-text" id="valid-thru-text" maxlength="5" placeholder="02/40" required onkeypress="return event.charCode >=48 && event.charCode <= 57">
                        </div>
                        <div class="cvv-container">
                            <label>CVV</label>
                            <input type="text" name="cvv-text" id="cvv-text" maxlength="4" placeholder="1234" required onkeypress="return event.charCode >=48 && event.charCode <= 57">
                        </div>
                    </div>
                    <button type="submit" class="button" name="btnsubmitbooking">Submit Booking</button>
                    <!-- <input type="submit" value="ADD" id="add" name="btnsubmitbooking"> -->
                </form>
            </div>
            <div class="container-right">
                <div class="card">
                    <div class="intern">
                        <img class="approximation" src="img/aprox.png" alt="aproximation">
                        <div class="card-number">
                            <div class="number-vl">1234 5678 9101 1121</div>
                        </div>
                        <div class="card-holder">
                            <label>Holder</label>
                            <div class="name-vl">NOAH JACOB</div>
                        </div>
                        <div class="card-infos">
                            <div class="exp">
                                <label>valid-thru</label>
                                <div class="expiration-vl">02/40</div>
                            </div>
                            <div class="cvv">
                                <label>CVV</label>
                                <div class="cvv-vl">123</div>
                            </div>
                        </div>
                        <img class="chip" src="img/chip.png" alt="chip">
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="credit-payment.js"></script>
    <script>
//         form.addEventListener("submit", (e) => {
//     e.preventDefault();

//     alert("Booking Confirm");

//     // Redirect to the home page
//     window.location.href = "http://localhost/marimar/index.php"; // Replace with your home page URL
// });
</script>

</body>

</html>
</form>