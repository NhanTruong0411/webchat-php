<?php 
    $user = $_SESSION['user'];
?>
<div class="container">
    <br />
    <h3 class="text-center">PHP Chat Application</h3>
    <br />
    <div class="row">
        <div class="col-lg-8"></div>
        <div class="col-lg-4">
            <div class="mt-3 mb-3 text-center">
                <img src="<?php echo $user['avatar'] ?>" alt="" width="150"
                class="img-fluid rounded-circle img-thumbnail" />
                <h3><?php echo $user['username'] ?></h3>
                <div>
                    <a class="btn btn-info mt-2 mb-2 text-white">Edit</a>
                    <a href="index.php?ctrl=UserController&action=logout" class="btn btn-danger mt-2 mb-2 text-white">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>