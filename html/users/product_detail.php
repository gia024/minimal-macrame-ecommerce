<?php
    require('../includes/dbcon.php');

    session_start();
    $user = $_SESSION['user'];

    $id = $_GET['id'];

    $query = "select * from product where id = $id";
    $result = mysqli_query($con, $query);

    $row = mysqli_fetch_assoc($result);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details Page</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/user/product_detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
		.header-icons{
			position: relative;
            color: black;
		}
		.header-icons:hover .dropdown-content{
			display: block;
		}
		.dropdown-content{
			padding: 5px 0;
			position: absolute;
			display: none;
			text-align: left;
			background: white ;
			width: 100%;
		}
		.dropdown-content > a{
			color: black;
			font-weight: 500;
			padding: 10px;
			display: block;
		}	
		.dropdown-content > a:hover{
			color: var(--main-color);
		}
        .big-img {
    width: 400px; /* Adjust width as needed */
    height: 400px; /* Adjust height as needed */
    border-radius: 10px; /* Adjust border radius as needed */
    overflow: hidden; /* Ensure image does not overflow */
}

.big-img img {
    width: 100%; /* Ensure image fills the container */
    height: 100%; /* Ensure image fills the container */
    object-fit: cover; /* Cover the container with the image */
}
.cart-btn,
.buy-btn {
    background-color: black;
    color: white; /* Set text color to contrast with the black background */
    border: none; /* Remove border */
    padding: 10px 20px; /* Adjust padding as needed */
    border-radius: 5px; /* Add border radius for rounded corners */
    cursor: pointer;
}

.cart-btn:hover,
.buy-btn:hover {
    /* Optional: Hover effect */
    background-color: darkgray; /* Change the background color on hover */
}


		
	</style>
</head>
<body>
    <!----header--->
	<header>
    <!-- Logo (with black color) -->
    <a href="../../user_index.php" class="logo" style="color: black;">CRAFTIFY</a>

    <!-- Navigation Links -->
    <ul class="navlist">
    <li><a href="#home" style="color: black;">Home</a></li>
    <li><span class="nav-bar">|</span></li>
    <li><a href="#featured" style="color: black;">Featured</a></li>
    <li><span class="nav-bar">|</span></li>
    <li><a href="#new" style="color: black;">New</a></li>
    <li><span class="nav-bar">|</span></li>
    <li><a href="#contact" style="color: black;">Contact</a></li>
</ul>


    <!-- Search Bar -->
    <div class="search">
        <!-- Search Icon (with adjusted style) -->
        <i class='bx bx-search' id="searchIcon" style="color: black; font-size: 20px;"></i>
        <!-- Search Input (Initially Hidden) -->
        <form id="searchForm" action="html/includes/searchProduct.php" method="GET">
            <input type="text" id="searchInput" name="search" placeholder="Search a product" style="display: none;" />
        </form>
    </div>

    <!-- Cart Icon -->
    <div class="header-icons">
        <a href="dashboard.php"><i class='bx bx-shopping-bag' style='color:black;'></i></a>
    </div>

		<div class="header-icons">
			<a href="#"><i class='bx bx-user' style="color: black;"></i></a>
			<a class="navbar-action-btn"><b><?php echo $user['username'] ?></b></a>
			<div class="dropdown-content">
				<a href="dashboard.php" class="navbar-action-btn">Dashboard</a>
				<a href="../includes/logout.php" class="navbar-action-btn">Logout</a>
			</div>
		</div>
	</header>


    <div class="flex-box">
        <div class="left">
            <div class="big-img">
                <img src="../../images/product/<?php echo $row['avatar'] ?>">
            </div>
        </div>
        <form action="../includes/addtocart.php" method="POST">
            <input type="hidden" name="product_id" value="<?= $_GET['id']?>">
            <input type="hidden" name="user_id" value="<?= $user['id']?>">
            <input type="hidden" name="amount" value="<?= $row['price']?>">
            <div class="right">
                <div class="pname"><?php echo $row['name'] ?></div>
                <div class="description"><?php echo $row['description'] ?></div>
                
                <div class="price">Nrs. <span id="price"><?php echo $row['price'] ?></span></div>
                
                <div class="quantity">
                    <p>Quantity :</p>
                    <input type="number" name="quantity" min="1" max="5" value="1" onchange="priceUpdate(this)">
                </div>
                <div class="btn-box">
                    <button class="cart-btn">Add to Cart</button>
                    <button class="buy-btn">Buy Now</button>
                </div>
            </div>
        </form>
    </div>


    <script>
        let bigImg = document.querySelector('.big-img img');
        function showImg(pic){
            bigImg.src = pic;
        }
        function priceUpdate(elem){
            let price = <?php echo $row['price'] ?>;
            console.log(elem.value);
            console.log(price);
            amount = price * elem.value;
            document.querySelector("#price").textContent = amount; 
            document.querySelector("input[name=amount]").value = amount; 
        }
    </script>
</body>
</html>