<h1 class="">Welcome to <?php echo $_settings->info('name') ?> - Admin Side</h1>
<style>
  #cover-image{
    width:calc(100%);
    height:50vh;
    object-fit:cover;
    object-position:center center;
  }
</style>
<hr>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/jquery.fancybox.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">
	<link rel="stylesheet" href="css/on-off-switch.css"/>
	<link rel="stylesheet" href="css/summernote.css">
	<link rel="stylesheet" href="style.css">


<section class="content">
<div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  
                  <span class="iinfo-box-number text-left h4">
           <h3><?php 
            $total = $conn->query("SELECT count(id) as total FROM category_list where delete_flag = 0 ")->fetch_assoc()['total'];
            echo format_num($total);
          ?> <div class="icon">
                  <i class="ionicons ion-android-cart"></i>
                </div>
         </h3>
        </span>
                  <p>Products</p>
                </div>
                <div class="icon">
                  <i class="ionicons ion-android-cart"></i>
                </div>
                
              </div>
            </div>
            <!-- ./col -->
            
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php 
            $total = $conn->query("SELECT count(id) as total FROM category_list where delete_flag = 0 ")->fetch_assoc()['total'];
            echo format_num($total);
          ?></h3>

                  <p>Total Categories</p>
                </div>
                <div class="icon">
                  <i class="ionicons ion-android-checkbox-outline"></i>
                </div>
               
              </div>
            </div>
          
			
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-orange">
				  <div class="inner">
					<h3><?php 
            $total = $conn->query("SELECT count(id) as total FROM shop_type_list where delete_flag = 0 ")->fetch_assoc()['total'];
            echo format_num($total);
          ?></h3>
  
					<p>Total Shop Type</p>
				  </div>
				  <div class="icon">
					<i class="ionicons ion-load-a"></i>
				  </div>
				  
				</div>
			  </div>

			  <div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-red">
				  <div class="inner">
					<h3><?php 
            $total = $conn->query("SELECT count(id) as total FROM client_list where delete_flag = 0 ")->fetch_assoc()['total'];
            echo format_num($total);
          ?></h3>
  
					<p>Total Customers</p>
				  </div>
				  <div class="icon">
					<i class="ionicons ion-person-stalker"></i>
				  </div>
				  
				</div>
			  </div>

			  <div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-yellow">
				  <div class="inner">
					<h3><?php 
            $total = $conn->query("SELECT count(id) as total FROM vendor_list where delete_flag = 0 ")->fetch_assoc()['total'];
            echo format_num($total);
          ?></h3>
  
					<p>Total Vendors</p>
				  </div>
				  <div class="icon">
					<i class="ionicons ion-person-add"></i>
				  </div>
				  
				</div>
			  </div>
        <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-maroon">
                <div class="inner">
                  <h3><?php 
            $total = $conn->query("SELECT count(id) as total FROM payment_list where `status` = 0 ")->fetch_assoc()['total'];
            echo format_num($total);
          ?></h3>

                  <p>Pending Orders</p>
                </div>
                <div class="icon">
                  <i class="ionicons ion-clipboard"></i>
                </div>
                
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-blue">
				  <div class="inner">
					<h3><?php 
            $total = $conn->query("SELECT count(id) as total FROM payment_list where `status` = 2 ")->fetch_assoc()['total'];
            echo format_num($total);
          ?></h3>
  
					<p>Confirmed Shipping</p>
				  </div>
				  <div class="icon">
					<i class="ionicons ion-android-menu"></i>
				  </div>
				  
				</div>
			  </div>
			  <div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-teal">
				  <div class="inner">
					<h3><?php 
            $total = $conn->query("SELECT count(id) as total FROM payment_list where `status` = 4 ")->fetch_assoc()['total'];
            echo format_num($total);
          ?></h3>
  
					<p>Delivered</p>
				  </div>
				  <div class="icon">
					<i class="ionicons ion-location"></i>
				  </div>
				  
				</div>
			  </div>
        <div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-olive">
				  <div class="inner">
					<h3><?php 
            $total = $conn->query("SELECT count(id) as total FROM payment_list where `status` = 3 ")->fetch_assoc()['total'];
            echo format_num($total);
          ?></h3>
  
					<p>Out for Delivery</p>
				  </div>
				  <div class="icon">
					<i class="ionicons ion-location"></i>
				  </div>
				  
				</div>
			  </div>

			  <div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-pink">
				  <div class="inner">
					<h3><?php 
            $total = $conn->query("SELECT count(id) as total FROM payment_list where `status` = 5 ")->fetch_assoc()['total'];
            echo format_num($total);
          ?></h3>
  
					<p>Cancelled Products</p>
				  </div>
				  <div class="icon">
					<i class="ionicons ion-arrow-up-b"></i>
				  </div>
				  
				</div>
			  </div>

			  

			  
		  
</section>


