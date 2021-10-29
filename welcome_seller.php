<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - Spare Store</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/css/pikaday.min.css">
</head>

<script> 
    function onlyNumberKey(evt) { 

        // Only ASCII charactar in that range allowed 
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode 
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) 
            return false; 
        return true; 
    } 
</script>
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once "connect.php";

$name = $mark = $item_condition = $description = $number = $image = $price =  "";

$name_err = $mark_err = $item_condition_err = $description_err = $number_err = $image_err = $price_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter an item name.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM items WHERE name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);
            
            // Set parameters
            $param_name = trim($_POST["name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $name_err = "This item_name is already taken.";
                } else{
                    $name = trim($_POST["name"]);
                }

                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate email
    if(empty(trim($_POST["mark"]))){
        $mark_err = "Please enter a car mark.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM items WHERE mark = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_mark);
            
            // Set parameters
            $param_mark = trim($_POST["mark"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                $mark = trim($_POST["mark"]);
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    if(empty(trim($_POST["item_condition"]))){
        $item_condition_err = "Please enter a condition.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM items WHERE item_condition = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_item_condition);
            
            // Set parameters
            $param_item_condition = trim($_POST["item_condition"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                $item_condition = trim($_POST["item_condition"]);
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if(empty(trim($_POST["description"]))){
        $description_err = "Please enter a description.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM items WHERE description = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_description);
            
            // Set parameters
            $param_description = trim($_POST["description"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                $description = trim($_POST["description"]);
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if(empty(trim($_POST["number"]))){
        $number_err = "Please enter a number.";
    } else if(strlen(trim($_POST["number"]))>11){
        $number_err = "Please enter a valid number between 10-11 digits.";
    } else if(!is_numeric(trim($_POST["number"]))){
        $number_err = "Please enter numbers only.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM items WHERE number = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_number);
            
            // Set parameters
            $param_number = trim($_POST["number"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                $number = trim($_POST["number"]);
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    if(empty(trim($_POST["price"]))){
        $price_err = "Please enter price.";
    } else if(!is_numeric(trim($_POST["price"]))){
        $price_err = "Please enter numbers only.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM items WHERE price = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_price);
            
            // Set parameters
            $param_price = trim($_POST["price"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                $price = trim($_POST["price"]);
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    $image_2 = $_FILES['image']['tmp_name'];
    $imageFileType = strtolower(pathinfo($image_2,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"){
        $image_err = "Please upload images only." + $imageFileType;
    }


    
    
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($mark_err) && empty($item_condition_err) && empty($description_err) && empty($number_err) && empty($price_err) && empty($image_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO items (name, mark, item_condition, description, number, price,  image) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_name, $param_mark, $param_item_condition, $param_description, $param_number, $param_price, $param_image);
            
            // Set parameters
            $param_name = $name;
            $param_mark = $mark;
            $param_item_condition = $item_condition;
            $param_description = $description;
            $param_number = $number;
            $param_price = $price;
            $image_1 = $_FILES['image']['tmp_name'];
            $param_image = file_get_contents($image_1);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: welcome_seller.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
        
    // Close connection
    mysqli_close($link);
}



?>
<body>
    <nav class="navbar navbar-dark navbar-expand-lg fixed-top bg-white portfolio-navbar gradient">
        <div class="container"><a class="navbar-brand logo" href="welcome_seller.php">Spare Store</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navbarNav"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse"
                id="navbarNav">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="welcome_seller.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Log out</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page lanidng-page">
        <h2 class="text-center">Welcome, <b><?php echo htmlspecialchars($_SESSION["username_w"]); ?></b> &nbsp;</h2>
        <section class="portfolio-block contact" style="padding-top: 50px;padding-bottom: 50px;">
            <div class="container">
                <div class="heading">
                    <h2>Upload an item</h2>
                </div>
                
                <form style="padding-top: 40px;padding-left: 40px;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                        <label >Item name</label>
                        <input autocomplete="off" class="form-control" type="text" name="name" value="<?php echo $name; ?>">
                        <span class="help-block"><?php echo $name_err; ?></span>
                    </div>

                    <div class="form-group <?php echo (!empty($mark_err)) ? 'has-error' : ''; ?>">
                        <label >Car mark</label>
                        <select class="form-control" name="mark" value="<?php echo $mark; ?>">
                            <optgroup label="Select car mark">
                            <option value="Toyota" selected="">Toyota</option>
                            <option value="Lada">Lada</option>
                            <option value="Mercedes">Mercedes</option>
                        </optgroup>
                    </select>
                    <span class="help-block"><?php echo $mark_err; ?></span>
                    </div>

                    <div class="form-group <?php echo (!empty($item_condition_err)) ? 'has-error' : ''; ?>" type="button" style="width: 550px;">
                        <label >Condition</label>
                        <select class="form-control" name="item_condition" value="<?php echo $item_condition; ?>">
                            <optgroup label="Select condition">
                                <option value="New" selected="">New</option>
                                <option value="Used">Used</option>
                                <option value="broken">Broken/Not working</option>
                            </optgroup>
                        </select>
                        <span class="help-block"><?php echo $mark_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                        <label >Description</label>
                        <textarea class="form-control" name="description" value="<?php echo $description; ?>"></textarea>
                        <span class="help-block"><?php echo $description_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($number_err)) ? 'has-error' : ''; ?>">
                        <label >Contact Number</label>
                        <input autocomplete="off" onkeypress="return onlyNumberKey(event)" maxlength="11" class="form-control" type="text" name="number" value="<?php echo $number; ?>">
                        <span class="help-block"><?php echo $number_err; ?></span>
                    </div>

                    <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                        <label >Price in tenge</label>
                        <input autocomplete="off" onkeypress="return onlyNumberKey(event)" maxlength="9" class="form-control" type="text" name="price"  value="<?php echo $price; ?>">
                        <span class="help-block"><?php echo $price_err; ?></span>
                    </div>


                    <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                        <label for="email">Upload an image</label>
                        <input autocomplete="off" type="file" style="padding-left: 100px;" name="image" value="<?php echo $image; ?>">
                        <span class="help-block"><?php echo $image_err; ?></span>
                    </div>
                    <div class="form-group"><button class="btn btn-primary btn-block btn-lg" type="submit" value = "Place">Place Item</button></div>
                </form>


                </div>

        </section>

    </main>
    <footer class="page-footer">
        <div class="container">
            <div class="links"><a href="welcome_seller.php">Home</a></div>
            <div class="social-icons"><a href="https://github.com/TaumergenovN" target="_blank"><i class="icon ion-social-github"></i></a></div>
        </div>
    </footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>