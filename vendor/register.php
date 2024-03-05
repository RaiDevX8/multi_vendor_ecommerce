<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
<body class="hold-transition">
  <script>
    start_loader()
  </script>
  <style>
      html,body{
          height: calc(100%);
          width: calc(100%);
      }
      body{
          width:calc(100%);
          height:calc(100%);
          background-image:url(../Images/eg2.jpg);
          background-repeat: no-repeat;
          background-size:cover;
      }
      #logo-img{
          width:15em;
          height:15em;
          object-fit:scale-down;
          object-position:center center;
      }
      #system_name{
        color:#fff;
        text-shadow: 3px 3px 3px #000;
      }
      #cimg{
          width:200px;
          height:200px;
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
            img{
                margin: auto;
                border-radius: 3px;
                border: 1px solid grey;
                height: 190px;
                width: 180px;
            }
           
        </style>
  <script>
  </script>
  <div class="d-flex justify-content-center align-items-center flex-row h-100">
        <div class="col-5">
            
            <h1 class="text-center" id="system_name"><?= $_settings->info('name') ?></h1>
        </div>
        <div class="col-7 h-100 bg-gradient-light px-4">
            <div class="d-flex justify-content-center align-items-center w-100 h-100">
                <div class="card card-outline card-primary col-12 rounded-0 shadow">
                    <div class="card-header text-center">
                    <a href="./register.php" class="h1"><b>Create an Account</b></a>
                    </div>
                    <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <form id="vregister-frm" action="" method="post">
                        <input type="hidden" name="id">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="shop_name" class="control-label">Shop Name</label>
                                <input type="text" id="shop_name" autofocus name="shop_name" class="form-control form-control-sm form-control-border" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="shop_owner" class="control-label">Shop Owner Fullname</label><span id="message1">*</span>
                                <input type="text" id="shop_owner" name="shop_owner" class="form-control form-control-sm form-control-border" onblur="validateName()" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="contact" class="control-label">Contact #</label><span id="message4"> *</span>
                                <input type="text" id="contact" name="contact" class="form-control form-control-sm form-control-border" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="shop_type_id" class="control-label">Shop Type</label>
                                <select type="text" id="shop_type_id" name="shop_type_id" class="form-control form-control-sm form-control-border select2" required>
                                    <option value="" disabled selected></option>
                                    <?php 
                                    $types = $conn->query("SELECT * FROM `shop_type_list` where delete_flag = 0 and `status` = 1 order by `name` asc ");
                                    while($row = $types->fetch_assoc()):
                                    ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email" class="control-label">Email</label><span id="message3">*</span>
                                <input type="text" id="email" name="email" class="form-control form-control-sm form-control-border" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="password" class="control-label">Password</label><span id="message6">*</span>
                                <div class="input-group input-group-sm">
                                    <input type="password" id="password" name="password" class="form-control form-control-sm form-control-border" required>
                                    <div class="input-group-append bg-transparent border-top-0 border-left-0 border-right-0 rounded-0">
                                        <span class="input-group-text bg-transparent border-top-0 border-left-0 border-right-0 rounded-0">
                                            <a href="javascript:void(0)" class="text-reset text-decoration-none pass_view"> <i class="fa fa-eye-slash"></i></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cpassword" class="control-label">Confirm Password</label><span id="message5">*</span>
                                <div class="input-group input-group-sm">
                                    <input type="password" id="cpassword" class="form-control form-control-sm form-control-border" required>
                                    <div class="input-group-append bg-transparent border-top-0 border-left-0 border-right-0 rounded-0">
                                        <span class="input-group-text bg-transparent border-top-0 border-left-0 border-right-0 rounded-0">
                                            <a href="javascript:void(0)" class="text-reset text-decoration-none pass_view"> <i class="fa fa-eye-slash"></i></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row align-item-end">
                            <div class="col-8">
                                <a href="<?= base_url ?>">Back to Site</a>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Create Account</button>
                            </div>
                            <div class="col-12 text-center">
                            <a href="<?= base_url.'/login.php' ?>">Already have an Account</a>
                            </div>
                        <!-- /.col -->
                        </div>
                    </form>
                    <!-- /.social-auth-links -->

                    <!-- <p class="mb-1">
                        <a href="forgot-password.html">I forgot my password</a>
                    </p> -->
                    
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            
        </div>
  </div>


<!-- jQuery -->
<script src="<?php echo base_url ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<!-- <script src="<?php echo base_url ?>dist/js/adminlte.min.js"></script> -->
<!-- Select2 -->
<script src="<?php echo base_url ?>plugins/select2/js/select2.full.min.js"></script>

<script>
    function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
	        	$('#cimg').attr('src', '<?= validate_image('') ?>');
        }
	}
  $(function(){
    end_loader();
    $('body').height($(window).height())
    $('.select2').select2({
        placeholder:"Please Select Here",
        width:'100%'
    })
    $('.select2-selection').addClass("form-border")
    $('.pass_view').click(function(){
        var _el = $(this).closest('.input-group')
        var type = _el.find('input').attr('type')
        if(type == 'password'){
            _el.find('input').attr('type','text').focus()
            $(this).find('i.fa').removeClass('fa-eye-slash').addClass('fa-eye')
        }else{
            _el.find('input').attr('type','password').focus()
            $(this).find('i.fa').addClass('fa-eye-slash').removeClass('fa-eye')

        }
    })

    $('#vregister-frm').submit(function(e){
        e.preventDefault();
        var _this = $(this)
            $('.err-msg').remove();
        var el = $('<div>')
            el.addClass("alert err-msg")
            el.hide()
        if(_this[0].checkValidity() == false){
            _this[0].reportValidity();
            return false;
            }
        if($('#password').val() != $('#cpassword').val()){
            el.addClass('alert-danger').text('Password does not match.')
            _this.append(el)
            el.show('slow')
            $('html,body').scrollTop(0)
            return false;
        }
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Users.php?f=save_vendor",
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            dataType: 'json',
            error:err=>{
                console.error(err)
                el.addClass('alert-danger').text("An error occured");
                _this.prepend(el)
                el.show('.modal')
                end_loader();
            },
            success:function(resp){
                if(typeof resp =='object' && resp.status == 'success'){
                    location.href= './login.php';
                }else if(resp.status == 'failed' && !!resp.msg){
                    el.addClass('alert-danger').text(resp.msg);
                    _this.prepend(el)
                    el.show('.modal')
                }else{
                    el.text("An error occured");
                    console.error(resp)
                }
                $("html, body").scrollTop(0);
                end_loader()

            }
        })
    })
  })
</script>
<script>
        

        //First Name


        var validateName = function(elementValue) {
          var namePattern = /^[a-zA-Z ]+$/;
          return namePattern.test(elementValue);
      }
      $('#shop_owner').keyup(function() {
      
      var value = $(this).val();
      var valid = validateName(value);

 
    if (!valid) {
      
      
      $('#message1').html(' First Name should be in proper format').css('color', 'red');
      $("#submit").prop('disabled',true);

  } else {


      $('#message1').html(' *').css('color', 'green');
      $("#submit").prop('disabled',false);

  }
});


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
       var validateEmail = function(elementValue) {
          var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
          return emailPattern.test(elementValue);
      }

//Email

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
</body>
</html>