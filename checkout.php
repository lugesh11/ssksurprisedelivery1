<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['fosuid']==0)) {
  header('location:logout.php');
  } else{ 

//placing order

if(isset($_POST['placeorder'])){

//getting address
$fnaobno=$_POST['flatbldgnumber'];
$street=$_POST['streename'];
$area=$_POST['area'];
$lndmark=$_POST['landmark'];
$city=$_POST['city'];
$cod=$_POST['cod'];
$userid=$_SESSION['fosuid'];
$giftmessage=$_POST['giftmessage'];
$addmessage=$_POST['addmessage'];
      
$itempic=$_FILES["receiptimages"]["name"];
$extension = substr($itempic,strlen($itempic)-4,strlen($itempic));
// allowed extensions
$allowed_extensions = array(".jpg",".jpeg",".png",".gif");
// Validation for allowed extensions .in_array() function searches an array for a specific value.
$itempic=md5($itempic).$extension;
move_uploaded_file($_FILES["receiptimages"]["tmp_name"],"admin/receiptimages/".$itempic);
//genrating order number
$orderno= mt_rand(100000000, 999999999);
$query="update tblorders set OrderNumber='$orderno',IsOrderPlaced='1',CashonDelivery='$cod' where UserId='$userid' and IsOrderPlaced is null;";
$query.="insert into tblorderaddresses(UserId,Ordernumber,Flatnobuldngno,StreetName,Area,Landmark,City,image,giftmessage,addmessage) values('$userid','$orderno','$fnaobno','$street','$area','$lndmark','$city','$itempic','$giftmessage','$addmessage');";

$result = mysqli_multi_query($con, $query);
if ($result) {

echo '<script>alert("Your order placed successfully. Order number is "+"'.$orderno.'")</script>';
echo "<script>window.location.href='my-order.php'</script>";

}
}    

    ?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>SSK Surprise Delivery || Checkout Page</title>

        <!-- Icon css link -->
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="vendors/linearicons/style.css" rel="stylesheet">
        <link href="vendors/flat-icon/flaticon.css" rel="stylesheet">
        <link href="vendors/stroke-icon/style.css" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Rev slider css -->
        <link href="vendors/revolution/css/settings.css" rel="stylesheet">
        <link href="vendors/revolution/css/layers.css" rel="stylesheet">
        <link href="vendors/revolution/css/navigation.css" rel="stylesheet">
        <link href="vendors/animate-css/animate.css" rel="stylesheet">
        
        <!-- Extra plugin css -->
        <link href="vendors/owl-carousel/owl.carousel.min.css" rel="stylesheet">
        <link href="vendors/magnifc-popup/magnific-popup.css" rel="stylesheet">
        <link href="vendors/jquery-ui/jquery-ui.min.css" rel="stylesheet">
        <link href="vendors/nice-select/css/nice-select.css" rel="stylesheet">
        
        <link href="css/style.css" rel="stylesheet">
        <link href="css/responsive.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <script type="text/javascript">
    window.onload = function () {
        var tblFruits = document.getElementById("headingOne");
        var chks = tblFruits.getElementsByTagName("INPUT");
        for (var i = 0; i < chks.length; i++) {
            chks[i].onclick = function () {
                for (var i = 0; i < chks.length; i++) {
                    if (chks[i] != this && this.checked) {
                        chks[i].checked = false;
                    }
                }
            };
        }
    };
</script>
    
    <script type="text/javascript">
    function validateFileType(){
        var fileName = document.getElementById("fileName").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            //TO DO
        }else{
            alert("Only jpg/jpeg and png files are allowed!");
            
        }   
    }
</script>
<style>
    .h11 {
  color: #3e606b;
  font-family: "Playfair Display", serif;
  font-weight: bold;
  font-size: 38px;
  position: relative;
  display: inline-block;
  margin-bottom: 15px;
    margin-left: 15px;
}
    
</style>
    

   
    <body>
        
        <!--================Main Header Area =================-->
		<?php include_once('includes/header.php');?>
        <!--================End Main Header Area =================-->
        
        <!--================End Main Header Area =================-->
        <section class="banner_area">
        	<div class="container">
        		<div class="banner_text">
        			<h3>Chekout</h3>
        			<ul>
        				<li><a href="index.php">Home</a></li>
        				<li><a href="checkout.php">Chekout</a></li>
        			</ul>
        		</div>
        	</div>
        </section>
        <!--================End Main Header Area =================-->
        
        <!--================Billing Details Area =================-->    
        <section class="billing_details_area p_100">
            <div class="container">

                <div class="row">
                	<div class="col-lg-7">
               	    	<div class="main_title">
               	    		<h2>Shipping Details</h2>
               	    	</div>
                		<div class="billing_form_area">
                			<form class="billing_form row" action="" method="post" id="contactForm" enctype="multipart/form-data">
                			<input type="hidden" name="size" value="1000000">
								<div class="form-group col-md-6">
								    <label for="first">House & Block Number*</label>
									<input type="text" name="flatbldgnumber"  placeholder="Flat or Building Number" class="form-control" required="true">
								</div>
								<div class="form-group col-md-6">
								    <label for="last">Street Name*</label>
									<input type="text" name="streename" placeholder="Street Name" class="form-control" required="true">
								</div>
								<div class="form-group col-md-12">
								    <label for="company">Residential area*</label>
									<input type="text" name="area"  placeholder="Area" class="form-control" required="true">
								</div>
								<div class="form-group col-md-12">
								    <label for="address">Postcode*</label>
									<input type="text" name="landmark" placeholder="Postcode" class="form-control" required="true">
									
								</div>
								<div class="form-group col-md-12">
								    <label for="city">Town / City *</label>
									<input type="text" name="city" placeholder="City" class="form-control" required="true">
								</div>
                               
                                <div class="main_title">
               	    		    <h2>Additional Information</h2>
               	    	        </div>
                               
                                <div class="form-group col-md-12">
                                <label for="giftmessage">Special instruction for gift customization*</label>
								<textarea class="form-control" name="giftmessage" id="giftmessage" rows="1" placeholder="Special instructions or information such as receiver's name & age, theme, needed modification & etc." required="true"></textarea>
							    </div>
                                <div class="form-group col-md-12">
                                <label for="addmessage">Additional instructions for delivery (Optional)</label>
								<textarea class="form-control" name="addmessage" id="addmessage" rows="1" placeholder="Additional Information on how the gift should be delivered."></textarea>
							    </div>
                       
                       
                       
                       
                       
                		</div>
                	</div>
                	
                	<div class="col-lg-5">
                		<div class="order_box_price">
                			<div class="main_title">
                				<h2>Your Order</h2>
                			</div>
							<div class="payment_list">
								<div class="price_single_cost">
									
									<h5>Product <span>Total</span></h5>
									<?php 
$userid= $_SESSION['fosuid'];
$query=mysqli_query($con,"select tblfood.Image,tblfood.ItemName,tblfood.ItemDes,tblfood.Weight,tblfood.ItemPrice,tblfood.ItemQty,tblorders.FoodId from tblorders join tblfood on tblfood.ID=tblorders.FoodId where tblorders.UserId='$userid' and tblorders.IsOrderPlaced is null");
$num=mysqli_num_rows($query);
if($num>0){
while ($row=mysqli_fetch_array($query)) {
 

?>
									<h5><?php echo $row['ItemName']?> <span>RM<?php echo $total=$row['ItemPrice']?>
									<?php 
$grandtotal+=$total;
$cnt=$cnt+1; 
                           
 ?></span></h5><?php $cnt++; } }?>
									<h4>Subtotal <span>RM<?php echo $grandtotal;?></span></h4>
									<h5>Shipping And Handling<span class="text_f">Free Shipping</span></h5>
									<h3>Total <span>RM<?php echo $grandtotal;?></span></h3>
								</div>
								<p5>Receipt Drop:<br></p5>
								<div id="accordion" class="accordion_area">
									<div class="card">
										<div class="card-header" id="headingOne" required="true" >
											<h11 class="mb-0" >
												<input type="checkbox" name="cod" id="cod" value="Full Payment" >
												Full Payment
											</h11><br>
											<h11 class="mb-0" >
											<input type="checkbox" name="cod" id="cod" value="Half Payment">
												Cash On Delivery (Half Payment)
								            </h11>
										</div>
									</div>
								</div><br>
								<div class="form-group row">
                                    <div class="col-sm-10">
                                    <input type="file"  name="receiptimages" required="true" id="fileName" accept=".jpg,.jpeg,.png" onchange="validateFileType()"/>
                                    <label for="file">
                                        Upload Your Receipt
                                    </label>
                                    
                                    </div>
                                </div>
                                            
								<button type="submit" value="submit" name="placeorder" class="btn pest_btn">Place Order</button></form>
							</div>
						</div>
                	</div>
                </div>
            </div>
        </section>
        <!--================End Billing Details Area =================-->   
        
       <?php include_once('includes/footer.php');?>
        
        
        
        
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- Rev slider js -->
        <script src="vendors/revolution/js/jquery.themepunch.tools.min.js"></script>
        <script src="vendors/revolution/js/jquery.themepunch.revolution.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.actions.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.video.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
        <!-- Extra plugin js -->
        <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
        <script src="vendors/magnifc-popup/jquery.magnific-popup.min.js"></script>
        <script src="vendors/isotope/imagesloaded.pkgd.min.js"></script>
        <script src="vendors/isotope/isotope.pkgd.min.js"></script>
        <script src="vendors/datetime-picker/js/moment.min.js"></script>
        <script src="vendors/datetime-picker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
        <script src="vendors/jquery-ui/jquery-ui.min.js"></script>
        <script src="vendors/lightbox/simpleLightbox.min.js"></script>
        
        
        
        <script src="js/theme.js"></script>
    </body>

</html><?php }?>