let logged_in = false;
let user = null;

$(function(){
    $('#submit-login').on('click', function(event){
        event.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();
        $.ajax({
            method: "post",
            url: "func.php",
            data:{
                email:email,
                password:password,
                type:"login"
            },
            success:function(data){
                console.log(parseInt(data));
                if(parseInt(data)){
                    logged_in = true;
                    user = email;
                    location.replace("home.html");
                }
                else{
                    $('#error').html('<p style="color:red">Error: Please check your details and log in again</p>')
                }
            }
        })
    }),
    $('#submit-reg').on('click', function(event){
        event.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();
        var cpassword = $('#cpassword').val();
        console.log(email != "" && password != "" && cpassword != "")
        if(email != "" && password != "" && cpassword != ""){
            if(password == cpassword ){
                $.ajax({
                    method: "post",
                    url: "func.php",
                    data:{
                        email:email,
                        password:password,
                        type:"register" 
                    },
                    success:function(data){
                        console.log(parseInt(data));
                        if(data){
                            logged_in = true;
                            user = email;
                            location.replace("home.html")
                        }
                        else{
                            $('#error').html('<p style="color:red">Error: Please check your details and log in again</p>')
                        }
                    }
                })
            }
            else{
                $('#error').html('<p style="color:red">Error: Passwords dont match</p>')
            }
        } else{
            $('#error').html('<p style="color:red">Error: please enter valid details</p>')
        }
        
    }),
    $('#logout').on('click', function(event){
        event.preventDefault();
        logged_in = false;
        user = null;
        location.replace('login.html');
    }),
    $('#add-product').on('click', function(event){
        event.preventDefault();
        $("#add-prod-form").show()
    }),
    $('#upload-product').on('click', function(event){
        event.preventDefault();
        var name = $("#name").val();
        var price = $("#price").val();
        var feature1 = $("#feature-1").val();
        var feature2 = $("#feature-2").val();
        var discription = $("#discription").val();
        var img = $("#img").val();
        $.ajax({
            method: "post",
            url: "func.php",
            data:{
                user:user,
                name:name,
                price:price,
                feature1:feature1,
                feature2:feature2,
                discription:discription,
                img:img,
                type:"upload-product"
            },
            success:function(data){
                // console.log(data);
                $("#name").val("");
                $("#price").val("");
                $("#feature-1").val("");
                $("#feature-2").val("");
                $("#discription").val("");
                $("#img").val("");
                if(data){
                    $("#add-prod-form").hide()
                    $('#result').html("<span style='color:white'>Upload successful!!<span>")
                    $.ajax({
                        method: "post",
                        url: "func.php",
                        data:{
                            type:"update-my-prods"
                        },
                        success:function(data){
                            // console.log(data);
                            $('#my-prods').html(data)
                        }
                    })
                }
                else{
                    $('#result').html("<span style='color:red'>Upload failed!! try again.<span>")
                }
            }
        })
    }),
    $('#submit-feedback').on('click', function(event){
        event.preventDefault();
        var email = $('#email2').val();
        var name = $('#name2').val();
        var message = $('#message2').val();
            $.ajax({
                method: "post",
                url: "func.php",
                data:{
                    email:email,
                    message:message,
                    name:name,
                    type:"feedback-entry"
                },
                success:function(data){
                    console.log(data);
                    if(data){
                        alert("feedback submitted successfully!");
                        location.replace("home.html");
                    }
                }
            })
    })
})

function loadmyProducts(){
    $.ajax({
        method: "post",
        url: "func.php",
        data:{
            type:"update-my-prods"
        },
        success:function(data){
            // console.log(data);
            $('#my-prods').html(data)
        }
    })
}

function loadallProducts(){
    $.ajax({
        method: "post",
        url: "func.php",
        data:{
            type:"update-all-prods"
        },
        success:function(data){
            // console.log(data);
            $('#allProducts').html(data)
        }
    })
}

function deleteProduct(id){
    $.ajax({
        method: "post",
        url: "func.php",
        data:{
            id:id,
            type:"delete-product"
        },
        success:function(data){
            console.log(data);
            if(data){
                loadmyProducts();
            }
        }
    })
}

function gotoProduct(id){
    $.ajax({
        method: "post",
        url: "func.php",
        data:{
            id:id,
            type:"load-prod-page"
        },
        success:function(data){
            // console.log(data);
            if(data){
                location.replace("product.html");
            }
        }
    })
       
}

function loadCurrentProd(){
    $.ajax({
        method: "post",
        url: "func.php",
        data:{
            type:"update-prod-page"
        },
        success:function(data){
            // console.log(data);
            $('#Product-details').html(data)
        }
    })
}

function AddtoCart(id){
    $.ajax({
        method: "post",
        url: "func.php",
        data:{
            id:id,
            type:"add-to-cart"
        },
        success:function(data){
            // console.log(data);
            if(data){
                alert('product added to cart');
            }
        }
    })
}

function loadCart(){
    $.ajax({
        method: "post",
        url: "func.php",
        data:{
            type:"load-cart"
        },
        success:function(data){
            // console.log(data);
            $('#cart-prods').html(data)
        }
    })
}

function getCartVals(){
    $.ajax({
        method: "post",
        url: "func.php",
        data:{
            type:"cart-vals"
        },
        success:function(data){
            console.log(data)
            if (data == ""){
                data = 0;
            }
            total = parseInt(data) + 90;
            $('#price-sum').html(data);
            $('#total').html(total);
        }
    })
}

function deleteFromCart(id){
    $.ajax({
        method: "post",
        url: "func.php",
        data:{
            id:id,
            type:"delete-from-cart"
        },
        success:function(data){
            if(data){
                loadCart();
                getCartVals();
            }
        }
    })
}

function calcBids(){
    $.ajax({
        method: "post",
        url: "func.php",
        data:{
            type:"calc-bids"
        },
        success:function(data){
            console.log(data)
        }
    })
}

function placeBid(){
    $('#bidinputform').show();
}

function submitBid(){
    var bid = $('#bid-input').val();
        $.ajax({
            method: "post",
            url: "func.php",
            data:{
                bid:bid,
                type:"place-bid"
            },
            success:function(data){
                if(data){
                    calcBids();
                }
            }
        })
}




