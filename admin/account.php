<?php
require_once('../assets/constants/config.php');
require_once('constants/check-login.php');
require_once('constants/fetch-my-info.php');
include('header.php');
?>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row mb-1">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Profile</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active"><a href="#">Profile</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">

            <!-- Form control repeater section start -->
            <section id="form-control-repeater">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="tel-repeater">User Profile</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">

                                    <form action="app/update-profile.php" method="POST" autocomplete="OFF" enctype="multipart/form-data" >
                                        <div class="form-group col-12 mb-2">
                                            <input type="text" class="form-control" placeholder="E-mail" name="email" value="<?php echo $myemail; ?>">
                                        </div>
                                        <div class="form-group col-12 mb-2">
                                        	<?php
			                                    if ($myvataor == null) { ?>
			                                    <img src="../assets/admin/images/portrait/small/avatar-s-19.png" alt="avatar">

			                                    <?php }else{

			                                    print ' <img  id="blah" class="card-img-left myavatar"  src="../assets/uploads/avatar/'.$myvataor.'" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'; }
			                                    ?>
                                            <input type="file"  onchange="readURL(this);" name="image" accept="image/*">
                                            <input type="hidden" name="current" value="<?php echo $myvataor; ?>">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="tel-repeater">Update Password</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">

                                    <form name="frm1" action="app/new-pw.php" method="POST" autocomplete="OFF">
                                        <div class="form-group col-12 mb-2">
                                            <input type="password" class="form-control" name="password" placeholder="Enter new password">
                                        </div>
                                        <div class="form-group col-12 mb-2">
                                            <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm new password">
                                        </div>
                                        <button onclick="return val_a();" type="submit" class="btn btn-primary btn-block">Save Changes</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- // Form control repeater section end -->
        </div>
    </div>
</div>
    <!-- END: Content-->
<?php include 'footer.php'; ?>
<script>
function readURL(input) {
if (input.files && input.files[0]) {
var reader = new FileReader();

reader.onload = function (e) {
$('#blah')
.attr('src', e.target.result);
};

reader.readAsDataURL(input.files[0]);
}
}
</script>
<script>
        function val_a(){
if(frm1.password.value == "")
{
    alert("Enter the Password.");
    frm1.password.focus(); 
    return false;
}
if((frm1.password.value).length < 8)
{
    alert("Password should be minimum 8 characters.");
    frm1.password.focus();
    return false;
}

if((frm1.password.value).length > 20)
{
    alert("Password should be maximum 20 characters.");
    frm1.password.focus();
    return false;
}

if(frm1.confirmpassword.value == "")
{
    alert("Enter the Confirmation Password.");
    return false;
}
if(frm1.confirmpassword.value != frm1.password.value)
{
    alert("Password confirmation does not match.");
    return false;
}

return true;
}
</script>