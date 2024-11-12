

<?php include('header.php'); ?>
<form method="post">
    <br>
    
    <div class="container" style="width: 500px; background-color: whitesmoke; padding: 20px; border-radius:20px;">
        <div class="text-center">
            <h1>Login</h1> <br><hr>
        </div>
        <div class="mb-3">
            <label for="txtEmail" class="form-label">Email address</label>
            <input type="text" class="form-control" id="txtEmail" name="txtEmail">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1"><br>
        </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Submit</button>
        </div>
    </div>
</form>
<?php include('footer.php'); ?>