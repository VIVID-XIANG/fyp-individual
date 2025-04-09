
<div class="userprofile-navigation-bar-div">


<div class="user_info_bar">
    <a href="user_profile.php">My Profile</a>
    <a href="userprofile_address.html">Addresses</a>
   <a href="my_orders.php">My Orders</a>
    <a href="view_history.php">View History</a>
    <a href="reset_password.php">Reset Password</a>

     <a class="" href="">
        <img class="" src=""> My coupons
    </a>
    <a class="" href="">
        <img class="" src=""> Need Help?
    </a>
</div>
<div>
    <a class="log-out-a" onclick="confirmLogout()">
        <img class="log_out_image" src="log_out.png" > Log out
    </a>

</div>
   

</div>
<script>

function confirmLogout() {
   

    if (confirm("Are you sure you want to log out?")) {
        //remove session data
        window.location.href = "logout.php";
    }
}


</script>
<style>
    .userprofile-navigation-bar-div{
    background-color: #333;
    display: flex;
    flex-direction: column;
    
    height: 100vh; 
    
    justify-content: space-between;
}
.user_info_bar{
    display: flex;
    flex-direction: column;
    padding: 5px;
}
a{
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    margin: 5px;
}
a:hover{
    background-color: #555;
}
a:active{
    background-color: white;
    color: #333;
}
.log-out-a{
    display: flex; 
    align-items: center; 
    justify-content: center; 
    border-style: solid;
    border-width: 1px;
    border-radius: 5px;
    margin: 5px;
    text-align: center;
    width: 200px;

}
.log_out_image{
    width: 20px;
    height: auto;
   margin-right: 5px;
}
</style>