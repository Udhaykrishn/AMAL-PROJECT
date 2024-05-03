<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$code=$_GET['code'];


 
		$query="SELECT  `G_FNAME` ,  `G_LNAME` ,  `G_ADDRESS` ,  `TRANSDATE` ,  `CONFIRMATIONCODE` ,  `PQTY` ,  `SPRICE` ,`STATUS`,`CARD_NUMBER`,`HOLDER`,`VALID_THROUGH`,`CVV`
				FROM  `tblpayment` p,  `tblguest` g
				WHERE p.`GUESTID` = g.`GUESTID` AND `CONFIRMATIONCODE`='".$code."'";
		$mydb->setQuery($query);
		$res = $mydb->loadSingleResult();

		if($res->STATUS=='Confirmed'){
			$stats = '<li class="next"><a href="'.WEB_ROOT .'admin/mod_reservation/controller.php?action=checkin&code='.$res->CONFIRMATIONCODE.
		'">Confirmed &rarr;</a></li>';
		}elseif($res->STATUS=='Checkedin'){
		$stats = '<li class="next"><a href="'.WEB_ROOT .'admin/mod_reservation/controller.php?action=checkout&code='.$res->CONFIRMATIONCODE.
		'">Checkin &rarr;</a></li>';
		}elseif($res->STATUS=='Checkedout'){
		$stats= "";
		}else{
			$stats = '<li class="next"><a href="'.WEB_ROOT .'admin/mod_reservation/controller.php?action=confirm&code='.$res->CONFIRMATIONCODE.
		'">Confirm &rarr;</a></li>';
		}

 

?>

<?php 
$CARD_NUMBER= $res->CARD_NUMBER; 
$HOLDER=$res->HOLDER;
$VALID_THROUGH=$res->VALID_THROUGH; 
$CVV=$res->CVV; ?>


<div class="container">


 <div class="col-lg-3">  
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title ">Guest Information</h3><hr/>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li class="active"><a><i class="fa fa-inbox"></i> FIRSTNAME :
                  <?php echo $res->G_FNAME; ?></span></a></li>
                <li class="active"><a><i class="fa fa-envelope-o"></i> LASTNAME :
                <?php echo $res->G_LNAME; ?></span></a></li>
                <li class="active"><a><i class="fa fa-file-text-o"></i> ADDRESS : 
                <?php echo $res->G_ADDRESS; ?> </a></li>
               
              </ul>
            </div>
            <!-- /.box-body -->
          </div>

 </div> 

 <div class="col-lg-9">     

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Reservation
                    <small>View Rooms</small>
                </h1> 
            </div>
     

        </div>
        <!-- /.row --> 
<?php

$query="SELECT * 
				FROM  `tblreservation` r,  `tblguest` g,  `tblroom` rm, tblaccomodation a
				WHERE r.`ROOMID` = rm.`ROOMID` 
				AND a.`ACCOMID` = rm.`ACCOMID` 
				AND g.`GUESTID` = r.`GUESTID`  AND r.`STATUS`<>'Cancelled'
				AND  `CONFIRMATIONCODE` = '".$code."'";
$mydb->setQuery($query);
$res = $mydb->loadResultList();

foreach ($res as $cur) {
$image = WEB_ROOT . 'admin/mod_room/'.$cur->ROOMIMAGE;	
$day=dateDiff(date($cur->ARRIVAL),date($cur->DEPARTURE));

?>

        <!-- Blog Post Row -->
        <div class="row">
            <!-- <div class="col-md-1 text-center">
                <p><i class="fa fa-camera fa-4x"></i>
                </p>
                <p>June 17, 2014</p>
            </div> -->
            <div class="col-md-3"> 
                    <img class="img-responsive img-hover" src="<?php echo $image ; ?>" alt=""> 
            </div>
            <div class="col-md-6">
            <div class="box box-solid">
            <ul class="nav nav-pills nav-stacked">
            	<li><h3>
                    <?php echo $cur->ROOM; ?> [ <small><?php echo $cur->ACCOMODATION; ?></small> ]
                </h3>
                </li>
                <li></li>
            </ul>
                 
                <p><strong>ARRIVAL: </strong><?php echo date_format(date_create($cur->ARRIVAL),'m/d/Y');?></p>
                <p><strong>DEPARTURE: </strong><?php echo date_format(date_create($cur->DEPARTURE),'m/d/Y'); ?></p>
                <p><strong>Day(s): </strong><?php echo ($day==0) ? '1' : $day; ?></p>
                <p><strong>PRICE: </strong>&#x20B9;<?php echo $cur->RPRICE; ?></p>
                <p><strong>CARD NUMBER: </strong> <?php echo $CARD_NUMBER; ?></p>
                <p><strong>HOLDER: </strong> <?php echo $HOLDER; ?></p>
                <p><strong>VALID THROUGH: </strong> <?php echo $VALID_THROUGH; ?></p>
                <p><strong>CVV: </strong> <?php echo $CVV; ?></p>
                <!-- <a class="btn btn-danger" href="<?php echo WEB_ROOT .'admin/mod_reservation/controller.php?id='.$cur->RESERVEID.'&action=cancelroom'; ?>">Cancel<i class="fa fa-angle-right"></i></a> -->
            </div>
        </div>
        </div>
        <!-- /.row -->

        <hr>
        
       <?php }  

       ?>
      </div>
        <!-- Pager -->
        <div class="row">
            <ul class="pager">
                <li class="previous"><a href="<?php echo WEB_ROOT .'admin/mod_reservation/index.php'; ?>">&larr; Back</a>
                </li>
               <?php echo $stats; ?>
            </ul>
        </div>
        <!-- /.row -->

        <hr>