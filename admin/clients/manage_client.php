<?php 
if(isset($_GET['id'])){
	$client = $conn->query("SELECT * FROM client_list where id ='".$_GET['id']."'");
	if($client->num_rows > 0){
		$res = $client->fetch_array();
		foreach($res as $k =>$v){
			$$k = $v;
		}
	}else{
		echo '<script> alert("Unknown Client"); location.replace("./?page=clients")</script>';
	}

}else{
	echo '<script> alert("Unknown Client"); location.replace("./?page=clients")</script>';
}
?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
	#cimg{
          width:200px;
          height:200px;
          object-fit:scale-down;
          object-position:center center
      }
</style>
<div class="content py-3"></div>
	<div class="card card-outline rounded-0 card-primary shadow">
		<div class="card-body">
			<div class="container-fluid">
				<div id="msg"></div>
				<form action="" id="manage-user">	
					<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
					<div class="row">
                       
                       
                    </div>
                    <div class="row">
			 
                        <div class="form-group col-md-6">
                            <label for="email" class="control-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-sm form-control-border" value="<?= isset($email) ? $email : "" ?>" required readonly>
                        </div>
                    </div>
                    
                  
					<div class="row">
						<div class="form-group col-md-4">
                            <label for="status" class="control-label">Status</label>
                            <select type="text" id="status" name="status" class="form-control form-control-sm form-control-border select2" required>
                                <option value="1" <?= isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
					</div>
				</form>
			</div>
		</div>
		<div class="card-footer text-center">
				<button class="btn btn-sm btn-primary" form="manage-user">Update</button>
		</div>
	</div>
</div>
<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
			$('#cimg').attr('src', "<?= validate_image(isset($avatar) ? $avatar : "") ?>");
		}
	}
	
	$(function(){
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
		$('#manage-user').submit(function(e){
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
				_this.prepend(el)
				el.show('slow')
				$('html,body').scrollTop(0)
				return false;
			}
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Users.php?f=save_client",
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
						location.href="./?page=clients";
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