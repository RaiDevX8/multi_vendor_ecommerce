<style>
    .prod-img{
        width:calc(100%);
        height:auto;
        max-height: 10em;
        object-fit:scale-down;
        object-position:center center
    }
</style>
<style>
            .width{
                width: 600px;
            }
            @media(max-width: 600px)
            {
                .width{
                width: 350px;
            }
            }
            .error{
                color: red;
                font-size: large;
            
            }
            .success{
                color: green;
                font-size: large;
          
            }
            .error1{
                color: red;
                font-size: large;
            
            }
            .success1{
                color: green;
                font-size: large;
          
            }
            #message1{
                color: red;
            }
            #message2{
                color: red;
            }
            #message3{
                color: red;
            }
            #message4{
                color: red;
            }
            #message5{
                color: red;
            }
            #message6{
                color: red;
            }
            #message7{
                color: red;
            }
            #message8{
                color: red;
            }
            img{
                margin: auto;
                border-radius: 3px;
                border: 1px solid grey;
                height: 190px;
                width: 180px;
            }
           
        </style>
<div class="content py-3">
    <div class="card card-outline card-primary rounded-0 shadow-0">
        <div class="card-header">
            <h5 class="card-title">Cart List</h5>
        </div>
        <div class="card-body">
            <div id="cart-list">
                <div class="row">
                <?php 
                $gtotal = 0;
                $vendors = $conn->query("SELECT * FROM `vendor_list` where id in (SELECT vendor_id from product_list where id in (SELECT product_id FROM `cart_list` where client_id ='{$_settings->userdata('id')}')) order by `shop_name` asc");
                while($vrow=$vendors->fetch_assoc()):                
                ?>
                    <div class="col-12 border">
                        <span>Vendor: <b><?= $vrow['code']. " - " . $vrow['shop_name'] ?></b></span>
                    </div>
                    <div class="col-12 border p-0">
                        <?php 
                        $vtotal = 0;
                        $products = $conn->query("SELECT c.*, p.name as `name`, p.price,p.image_path FROM `cart_list` c inner join product_list p on c.product_id = p.id where c.client_id = '{$_settings->userdata('id')}' and p.vendor_id = '{$vrow['id']}' order by p.name asc");
                        while($prow = $products->fetch_assoc()):
                            $total = $prow['price'] * $prow['quantity'];
                            $gtotal += $total;
                            $vtotal += $total;
                        ?>
                        <div class="d-flex align-items-center border p-2">
                            <div class="col-2 text-center">
                                <a href="./?page=products/view_product&id=<?= $prow['product_id'] ?>"><img src="<?= validate_image($prow['image_path']) ?>" alt="" class="img-center prod-img border bg-gradient-gray"></a>
                            </div>
                            <div class="col-auto flex-shrink-1 flex-grow-1">
                                <h4><b><?= $prow['name'] ?></b></h4>
                                <div class="d-flex">
                                    <div class="col-auto px-0"><small class="text-muted">Price: </small></div>
                                    <div class="col-auto px-0 flex-shrink-1 flex-grow-1"><p class="m-0 pl-3"><small class="text-primary"><?= format_num($prow['price']) ?></small></p></div>
                                </div>
                               
                            </div>
                            <div class="col-3 text-right"><?= format_num($total) ?></div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="col-12 border">
                        <div class="d-flex">
                            <div class="col-9 text-right font-weight-bold text-muted">Total</div>
                            <div class="col-3 text-right font-weight-bold"><?= format_num($vtotal) ?></div>
                        </div>
                    </div>
                <?php endwhile; ?>
                    <div class="col-12 border">
                        <div class="d-flex">
                            <div class="col-9 h4 font-weight-bold text-right text-muted">Grand Total</div>
                            <div class="col-3 h4 font-weight-bold text-right"><?= format_num($gtotal) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    
<div class="content py-3">
    <div class="card card-outline card-primary shadow rounded-0">
        <div class="card-header">
            <div class="h5 card-title">Checkout</div>
        </div>
        <div class="card-body">
        <div class="row" id="summary">
               
                <div class="shadow p-2">
                
					<h4 class="text-center p-2">Payment Details</h4>
					<form method="post" action="placeorder.php">
    <table class="table table-borderless table-sm">
        <tr>
            <th><label for="card_no" class="control-label">Card Number</label><span id="message4">*</span></th>
            <th><input type="number" name="card_no" id="card_no" required minlength="16" pattern="[0-9]{16,16}" maxlength="16" class="form-control form-control-sm" required></th>
        </tr>
        <tr>
            <th> <label for="name_card" class="control-label">Name on Card</label><span id="message7">*</span></th>
            <th><input type="text" name="name_card" id="name_card" class="form-control form-control-sm" onblur="validateNCard()" required></th>
        </tr>
        <tr>
            <th>Expiry Date</th>
            <th><input type="month" id="expiry_date" required class="form-control form-control-sm"></th>
        </tr>
        <tr>
            <th><label for="cvv" class="control-label">Cvv Number</label><span id="message8">*</span></th>
            <th><input type="number" name="cvv" id="cvv"  maxlength="3" class="form-control form-control-sm" required></th>
        </tr>
    </table>
</form>

<script>
    // Set minimum value for month input to current month
    var today = new Date();
    var month = (today.getMonth() + 1).toString().padStart(2, '0');
    var year = today.getFullYear();
    document.getElementById('expiry_date').min = year + '-' + month;

    // Disable previous months in month input
    document.getElementById('expiry_date').addEventListener('input', function () {
        var selectedMonth = this.value.substr(5, 2);
        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
        var currentMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0');

        if (parseInt(this.value.substr(0, 4)) === currentYear && parseInt(selectedMonth) < parseInt(currentMonth)) {
            this.value = currentYear + '-' + currentMonth;
        }
    });
</script>

                <div class="col-12 border">
                 
                    </div>
                    <?php 
                    $gtotal = 0;
                    $vendors = $conn->query("SELECT * FROM `vendor_list` where id in (SELECT vendor_id from product_list where id in (SELECT product_id FROM `cart_list` where client_id ='{$_settings->userdata('id')}')) order by `shop_name` asc");
                    while($vrow=$vendors->fetch_assoc()):    
                    $vtotal = $conn->query("SELECT sum(c.quantity * p.price) FROM `cart_list` c inner join product_list p on c.product_id = p.id where c.client_id = '{$_settings->userdata('id')}' and p.vendor_id = '{$vrow['id']}'")->fetch_array()[0];   
                    $vtotal = $vtotal > 0 ? $vtotal : 0;
                    $gtotal += $vtotal;

                    ?>
                    <div class="col-12 border item">
                       
                        <div class="text-right"><b></b></div>
                    </div>
                    <?php endwhile; ?>
                    <div class="col-12 border">
                      
                        <div class="text-right h3" id="total"></div>
                    </div>
					</div>
                    <div class="col-md-8">
                    <form action="" id="checkout-form">
                        <div class="form-group">
                            <label for="delivery_address" class="control-label">Delivery Address</label>
                            <textarea name="delivery_address" id="delivery_address" rows="4" class="form-control rounded-0" required><?= $_settings->userdata('address') ?></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-flat btn-default btn-sm bg-navy" id="submit" >Place Order</button>
                        </div>
                    </form>
                </div>
                <!-- <div class="col-md-4">
                    <div class="row" id="summary">
                    <div class="col-12 border">
                        <h2 class="text-center"><b>Summary</b></h2>
                    </div>
                    <?php 
                    $gtotal = 0;
                    $vendors = $conn->query("SELECT * FROM `vendor_list` where id in (SELECT vendor_id from product_list where id in (SELECT product_id FROM `cart_list` where client_id ='{$_settings->userdata('id')}')) order by `shop_name` asc");
                    while($vrow=$vendors->fetch_assoc()):    
                    $vtotal = $conn->query("SELECT sum(c.quantity * p.price) FROM `cart_list` c inner join product_list p on c.product_id = p.id where c.client_id = '{$_settings->userdata('id')}' and p.vendor_id = '{$vrow['id']}'")->fetch_array()[0];   
                    $vtotal = $vtotal > 0 ? $vtotal : 0;
                    $gtotal += $vtotal;

                    ?>
                    <div class="col-12 border item">
                        <b class="text-muted"><small><?= $vrow['code']." - ".$vrow['shop_name'] ?></small></b>
                        <div class="text-right"><b><?= format_num($vtotal) ?></b></div>
                    </div>
                    <?php endwhile; ?>
                    <div class="col-12 border">
                        <b class="text-muted">Grand Total</b>
                        <div class="text-right h3" id="total"><b><?= format_num($gtotal) ?></b></div>
                    </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
<script>
    $('#checkout-form').submit(function(e){
        e.preventDefault()
        var _this = $(this)
        if(_this[0].checkValidity() == false){
            _this[0].reportValidity()
            return false;
        }
        if($('#summary .item').length <= 0){
            alert_toast("There is no order listed in the cart yet.",'error')
            return false;
        }
        $('.pop_msg').remove();
        var el = $('<div>')
            el.addClass("alert alert-danger pop_msg")
            el.hide()
        start_loader()
        $.ajax({
            url:_base_url_+'classes/Master.php?f=place_order',
            method:'POST',
            data:_this.serialize(),
            dataType:'json',
            error:err=>{
                console.error(err)
                alert_toast("An error occurred.",'error')
                end_loader()
            },
            success:function(resp){
                if(resp.status == 'success'){
                    location.replace('./?page=products')
                }else if(!!resp.msg){
                    el.text(resp.msg)
                    _this.prepend(el)
                    el.show('slow')
                    $('html,body').scrollTop(0)
                }else{
                    el.text("An error occurred.")
                    _this.prepend(el)
                    el.show('slow')
                    $('html,body').scrollTop(0)
                }
                end_loader()
            }
        })
    })
</script>
<script>
     $("#submit").prop('disabled',true);
        var validateNCard = function(elementValue) {
          var cardPattern = /^[a-zA-Z ]+$/;
          return cardPattern.test(elementValue);
      }
      $('#name_card').keyup(function() {
      
      var value = $(this).val();
      var valid = validateNCard(value);

 
    if (!valid) {
      
      
      $('#message7').html(' *').css('color', 'red');
      $("#submit").prop('disabled',true);

  } else {


      $('#message7').html(' *').css('color', 'green');
      $("#submit").prop('disabled',false);

  }
});

      
     

        $('#card_no').on('keyup',function() {
            if($('#card_no').val().length == 16 )
            {
                $('#message4').html(' *').css('color','green');
               
            }
            else
                $('#message4').html('*').css('color','red');
              

        }
        );


        $('#cvv').on('keyup',function() {
            if($('#cvv').val().length == 3)
            {
                $('#message8').html(' *').css('color','green');
               
            }
            else
                $('#message8').html('*').css('color','red');
              

        }
        );


//Last Name
var validateLName = function(elementValue) {
          var lnamePattern = /^[a-zA-Z ]+$/;
          return lnamePattern.test(elementValue);
      }
      $('#lastname').keyup(function() {
      
      var value = $(this).val();
      var valid = validateLName(value);

 
    if (!valid) {
      
      
      $('#message2').html('     Last Name should be in proper format').css('color', 'red');
      $("#submit").prop('disabled',true);

  } else {


      $('#message2').html(' *').css('color', 'green');
      $("#submit").prop('disabled',false);

  }
});



//Email

var validateEmail = function(elementValue) {
          var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
          return emailPattern.test(elementValue);
      }
      $('#email').keyup(function() {
      
          var value = $(this).val();
          var valid = validateEmail(value);
      
          if (!valid) {
      
      
              $('#message3').html(' Enter the proper email format').css('color', 'red');
              $("#submit").prop('disabled',true);
      
          } else {
      
      
              $('#message3').html(' *').css('color', 'green');
              $("#submit").prop('disabled',false);
      
          }
      });
        
   
        $('#contact').on('keyup',function() {
            if($('#contact').val().length == 10 )
            {
                $('#message4').html(' *').css('color','green');
             
            }
            else
                $('#message4').html(' Enter 10 digits').css('color','red');
              
        }
        );
               
        $('#password, #cpassword').on('keyup', function () {
      if($('#password').val() == $('#cpassword').val() && $('#password').val().length != 0) 
      {
                    $('#message5').html('Matched').css('color', 'green');
                     $("#submit").prop('disabled',false);
      } 
       else 
       {
                    $('#message5').html('Password Missmatch').css('color', 'red');
                    $("#submit").prop('disabled',true);
       }
      }
      );


  $password = $_POST['password1']; // Assuming the password is submitted via a form field

// // Define the regular expression pattern
// $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/';

// // Perform the validation
// if (preg_match($pattern, $password)) {
//     echo "Password is valid.";
// } else {
//     echo "Password is invalid.";
// }

function validatePassword(password) {
  // Regular expressions to check for the presence of letters, digits, and special characters
  var letterRegex = /[a-zA-Z]/;
  var digitRegex = /\d/;
  var specialCharRegex = /[\W_]/; // Matches any non-word character or underscore

  // Check if the password meets the required criteria
  if (
    letterRegex.test(password) &&
    digitRegex.test(password) &&
    specialCharRegex.test(password)
  ) {
    return true; // Password is valid
  }

  return false; // Password is invalid
}

// Example usage
var password = "MyPassword123!"; // Replace with the password you want to validate
if (validatePassword(password)) {
  console.log("Password is valid.");
} else {
  console.log("Password is invalid.");
}





//       var validatePassword = function(elementValue3) {
//           var passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
//           return passwordPattern.test(elementValue3);
//       }
//       $('#password1').keyup(function() {
      
//       var value = $(this).val();
//       var valid = validatePassword(value);

 
//     if (!valid) {
      
//       $('#message6').html('Password should be proper').css('color', 'red');
//       $("#submit").prop('disabled',true);

//   } else {

//       $('#message6').html(' *').css('color', 'green');
//       $("#submit").prop('disabled',false);

//   }
// });

 

        
  
</script>