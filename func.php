<?php
$conn = mysqli_connect('localhost', 'root', '', 'sneakerresale');
session_start();
// $_SESSION['loggedin'] = true;
// $_SESSION['user'] = 'null';
// print_r($_SESSION['user']);

function checkUser($email, $password, $conn)
{
    // print_r($_SESSION['user']);
    $query = "SELECT * from user WHERE email = '" . $email . "' and password = '" . $password . "';";
    $res = mysqli_query($conn, $query);
    $num_rows = mysqli_num_rows($res);
    if ($num_rows == 1) {
        echo true;
    } else {
        echo $num_rows;
    }
}

function addUser($email, $password, $conn)
{
    $query = "INSERT INTO user (email,password) VALUES('" . $email . "', '" . $password . "');";
    $res = mysqli_query($conn, $query);
    if ($res) {
        echo true;
    } else {
        echo 0;
    }
}

if ($_POST['type'] == 'login') {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $_SESSION['loggedin'] = true;
    $_SESSION['user'] = $email;
    checkUser($email, $password, $conn);
}

if ($_POST['type'] == 'register') {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $_SESSION['loggedin'] = true;
    $_SESSION['user'] = $email;
    addUser($email, $password, $conn);
}

if ($_POST['type'] == 'upload-product') {
    print_r($_SESSION['user']);
    $name = $_POST['name'];
    $price = $_POST['price'];
    $feature1 = $_POST['feature1'];
    $feature2 = $_POST['feature2'];
    $discription = $_POST['discription'];
    $img = $_POST['img'];
    $sql = "INSERT INTO `products` (`name`, `discription`, `feature1`, `feature2`, `price`, `img`, `user`) VALUES ('" . $name . "', '" . $discription . "', '" . $feature1 . "', '" . $feature2 . "', '" . $price . "', '" . $img . "', '" . $_SESSION['user'] . "');";
    $res = mysqli_query($conn, $sql);
}

if ($_POST['type'] == 'update-my-prods') {
    // print_r($_SESSION['user']);
    $sql = "SELECT * FROM products where user = '" . $_SESSION['user'] . "'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        while ($row = mysqli_fetch_array($res)) {
            echo '<tr>';
            echo '<th scope="row" class="border-0">';
            echo '<div class="p-2">';
            echo '<img src="' . $row['img'] . '" alt="" width="70" class="img-fluid rounded shadow-sm"/>';
            echo '<div class="ml-3 d-inline-block align-middle"><h5 class="mb-0"><a onclick=" gotoProduct('.$row['id'].')" class="text-dark d-inline-block align-middle">' . $row['name'] . '</a></h5></div>';
            echo '</div>';
            echo '</th>';
            echo '<td class="border-0 align-middle"><strong>' . $row['price'] . '</strong></td>';
            echo '<td class="border-0 align-middle"><strong>' . $row['bids'] . '</strong></td>';
            echo '<td class="border-0 align-middle"><a href="#" class="text-dark"><i class="fa fa-trash" onclick="deleteProduct(' . $row['id'] . ')"></i></a></td>';
            echo '</tr>';
        }
    } else {
        echo "<h2>nothing to display...</h2>";
    }
}

if ($_POST['type'] == 'update-all-prods') {
    // print_r($_SESSION['user']);
    $sql = "SELECT * FROM products";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        while ($row = mysqli_fetch_array($res)) {
            echo '<li class="list-group-item"><a class="media align-items-lg-center flex-column flex-lg-row p-3 tdn" onclick="gotoProduct(' . $row['id'] . ')"><div class="media-body order-2 order-lg-1"><h5 class="mt-0 font-weight-bold mb-2">' . $row['name'] . '</h5><p class="font-italic text-muted mb-0 small">' . $row['discription'] . '</p><div class="d-flex align-items-center justify-content-between mt-1"><h6 class="font-weight-bold my-2">Asking price:₹' . $row['price'] . '&nbsp;<br><br>Highest Bid:₹' . $row['bids'] . '</h6></div></div><img src="' . $row['img'] . '" alt="Generic placeholder image" width="200" class="ml-lg-5 order-1 order-lg-2" /></a></li>';
        }
    } else {
        echo "<h2>nothing to display...</h2>";
    }
}

if ($_POST['type'] == 'load-prod-page') {
    $_SESSION['id'] = $_POST['id'];
    if(isset($_SESSION['id'])){
        echo 'true';
    }
    else{
        echo 'false';
    }
}

if ($_POST['type'] == 'update-prod-page') {
    $prodid = $_SESSION['id'];
    $sql = "SELECT * FROM products where id = ".$prodid.";";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $row = mysqli_fetch_array($res);
        echo '<div class="container py-4 my-4 mx-auto d-flex flex-column">';
        echo '<div class="header"><div class="row r1"><div class="col-md-9 abc"><h1>'.$row['name'].'</h1></div></div></div>';
        echo '<div class="container-body mt-4">';
        echo '<div class="row r3">';
        echo '<div class="col-md-5 p-0 klo"><ul><li>Asking Price: ₹<span id="price">'.$row['price'].'</span></li><li>Highest bids: ₹<span id="price">'.$row['bids'].'</span></li><li><p id="discription">'.$row['discription'].'</p></li><li><p id="feature1">'.$row['feature1'].'</p></li><li><p id="feature2">'.$row['feature2'].'</p></li></ul></div>';
        echo '<div class="col-md-7"><img src="'.$row['img'].'" width="75%" height="auto" /></div>';
        echo '</div>';
        echo '<div>';
        echo '<ul class="list-inline">';
        echo '<li class="list-inline-item"><div class="tdn myt"><a class="tdn" href="home.html"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back </a></div></li>';
        echo '<li class="list-inline-item"><div class="tdn myt"><button type="button" class="btn btn-outline-dark"><a class="tdn" onclick="AddtoCart('.$row['id'].')" id="ATC">Add to Cart</a></button></div></li>';
        echo '<li class="list-inline-item"><div class="tdn myt"><button type="button" class="btn btn-outline-dark"><a class="tdn" onclick="placeBid()" id="BN">BID NOW</a></button></div></li>';
        echo '<li class="list-inline-item" id="bidinputform" style="display:none;"><input type="text" placeholder="bid amount" id="bid-input" >&nbsp;<button onclick="submitBid();"><i class="fa fa-check" aria-hidden="true" ></button></i></li>';
        echo '</ul>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    } else {
        echo "<h2>nothing to display...</h2>";
    }
}

if ($_POST['type'] == 'add-to-cart') {
    $prodid = $_POST['id'];
    $usr = $_SESSION['user'];
    $sql = "INSERT INTO cart (user,product) VALUES('".$usr."','".$prodid."');";
    $res = mysqli_query($conn, $sql);
    if($res){
        echo 'true';
    }
    else{
        echo 'false';
    }
}

if ($_POST['type'] == 'load-cart') {
    $email = $_SESSION['user'];
    $sql = "SELECT * FROM products where id in(SELECT product FROM cart where user = '".$email."');";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        while ($row = mysqli_fetch_array($res)) {
            echo '<tr>';
            echo '<th scope="row" class="border-0">';
            echo '<div class="p-2">';
            echo '<img src="' . $row['img'] . '" alt="" width="70" class="img-fluid rounded shadow-sm"/>';
            echo '<div class="ml-3 d-inline-block align-middle"><h5 class="mb-0"><a onclick=" gotoProduct('.$row['id'].')" class="text-dark d-inline-block align-middle">' . $row['name'] . '</a></h5></div>';
            echo '</div>';
            echo '</th>';
            echo '<td class="border-0 align-middle"><strong>' . $row['price'] . '</strong></td>';
            echo '<td class="border-0 align-middle"><strong>' . $row['bids'] . '</strong></td>';
            echo '<td class="border-0 align-middle"><a href="#" class="text-dark"><i class="fa fa-trash" onclick = "deleteFromCart(' . $row['id'] . ')" ></i></a></td>';
            echo '</tr>';
        }
    } else {
        echo "<h2>nothing to display...</h2>";
    }
}

if ($_POST['type'] == 'delete-from-cart') {
    $prodid = $_POST['id'];
    $usr = $_SESSION['user'];
    $sql = "DELETE FROM cart WHERE user = '".$usr."' AND product = '".$prodid."';";
    $res = mysqli_query($conn, $sql);
    if($res){
        echo 'true';
    }
    else{
        echo 'false';
    }
}

if ($_POST['type'] == 'delete-product') {
    $prodid = $_POST['id'];
    // $usr = $_SESSION['user'];
    $sql = "DELETE FROM products WHERE id = '".$prodid."';";
    $res = mysqli_query($conn, $sql);
    if($res){
        echo 'true';
    }
    else{
        echo 'false';
        echo $prodid;
    }
}

if ($_POST['type'] == 'cart-vals') {
    // $prodid = $_POST['id'];
    $usr = $_SESSION['user'];
    $sql = "SELECT sum(price) FROM products where id in(SELECT product FROM cart where user = '".$usr."');";
    $res = mysqli_query($conn, $sql);
    if($res){
        $row = mysqli_fetch_array($res);
        echo $row[0];
    }
    else{
        echo 'false';
    }
}

if ($_POST['type'] == 'feedback-entry') {
    $usr = $_SESSION['user'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $msg = $_POST['message'];
    $sql = "INSERT INTO feedback (user,name,email,message) VALUES('".$usr."','".$name."','".$email."','".$msg."');";
    $res = mysqli_query($conn, $sql);
    if($res){
        echo 'true';
    }
    else{
        echo 'false';
    }
}

if ($_POST['type'] == 'calc-bids') {
    $query = "SELECT id from products;";
    $res = mysqli_query($conn,$query);
    if ($res) {
        while ($row = mysqli_fetch_array($res)) {
            $sql = "SELECT max(bid) from bids where product ='".$row['id']."';";
            $res1 = mysqli_query($conn, $sql);
            if ($res1) {
                $row1 = mysqli_fetch_array($res1);
                $update = "UPDATE products SET bids =".$row1[0]." WHERE id=".$row['id'].";"; 
                $res2 = mysqli_query($conn, $update);
                if ($res2){
                    echo 'true';
                }
                else{
                    echo 'false';
                }
            }
        }
    }
}
if ($_POST['type'] == 'place-bid') {
    $id = $_SESSION['id'];
    $usr = $_SESSION['user'];
    $bid = $_POST['bid'];
    $sql = "INSERT INTO bids (user,product,bid) VALUES('".$usr."', '".$id."', '".$bid."')";
    $res = mysqli_query($conn,$sql);
    if ($res){
        echo 'true';
    }
    else{
        echo 'false';
    }
}

mysqli_close($conn);

?>

