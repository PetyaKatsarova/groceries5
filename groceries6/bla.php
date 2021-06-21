<?php
$db = new mysqli("localhost", "root", "koekjes", "test");
if($db->connect_error){
    die("Connection failed: " . $db->connect_error);
}

//check if ingredient is not already in the ingredients table

$stmt = $db->query("SELECT ingredient_name, ingredient_id FROM ingredients");
$ingrs = [];
if($stmt->num_rows > 0){
    while($row=$stmt->fetch_assoc()){
        $ingrs[$row['ingredient_id']]=$row['ingredient_name'];
    }
}
asort($ingrs);

// select all ingredients from the ingrs table 

$new_ingredient = isset($_POST['new_ingredient']) ? $_POST['new_ingredient'] : false;
$stmt2 = false;
if(!empty($new_ingredient)){
    if (!in_array($new_ingredient, $ingrs)) {
        $stmt2 = $db->prepare("INSERT INTO ingredients (ingredient_name)
                       VALUES (?)");
       $stmt2->bind_param('s', $new_ingredient);
       $stmt2->execute(); 
       echo "New ingredient added to the database";                  
    }else{
        echo "The ingredient exist in the databes, select it from the list below.";
    }
}

// logic
if(isset($_POST['submit_add_recipe'])){
    $recipe_id = ....;
    $ingredients_arr = [];
    $quantity_arr = [];
    $measurement_arr = [];

    if(!isset($_POST['ingredients']) || !isset($_POST['quantity']) || !isset($_POST['measurement'])){
        echo "Please select ingredient/s, quantity and measurement";
    }else{
        for($i=0; $i<count($_POST['measurement']); $i++){
            if($_POST['ingredients'][$i] !== NULL && $_POST['quantity'][$i] !== NULL && $_POST['measurement'][$i] !== ''){
                array_push($ingredients_arr, $_POST['ingredients'][$i]);
                array_push($quantity_arr, $_POST['quantity'][$i]);
                array_push($measurement_arr, $_POST['measurement'][$i]);
            }
       }

       // insert recipe name and instructions in recipes


       //get last id and assign to recipe_id



       // insert all in link
            for($i=0; $i<count($measurement_arr); $i++){
                $stmt2 = $db->prepare("INSERT INTO link (recipe_id, ingredient_id, quantity, measurement)
                VALUES (?, ?, ?, ?)");
                
                $stmt2->bind_param('iiis', $recipe_id, $ingredients_arr[$i], $quantity_arr[$i], $measurementsarr[$i]);
                $stmt2->execute(); 

            }
    //    var_dump($ingredients_arr);
    //    echo "</br>above are ingredients: </br>";
    //    var_dump($quantity_arr);
    //    echo "</br>above is quantity</br>";
    //    var_dump($measurement_arr);
    //    echo "<br/>above are measurenets: ";
    }
}


//         echo 'data was stored';
//     }
// }




// $new_ingredient = isset($_POST['new_ingredient']) ? $_POST['new_ingredient'] : false;
// $stmt2 = false;
// if(!empty($new_ingredient)){
//     if (!in_array($new_ingredient, $ingrs)) {
//         $stmt2 = $db->prepare("INSERT INTO ingredients (ingredient_name)
//                        VALUES (?)");
//        $stmt2->bind_param('s', $new_ingredient);
//        $stmt2->execute(); 
//        echo "New ingredient added to the database";
        // $stmt2 = $db->query("INSERT INTO ingredients (ingredient_name)
        //                VALUES ('". $new_ingredient ."')");                    
//     }else{
//         echo "The ingredient exist in the databes, select it from the list below.";
//     }
// }


    // $name = strtolower($_POST['add_recipe']);
    // $instructions= $_POST['instructions'];
    // $last_id = -1;
    // $cook_time = $_POST['cook_time'];
    // $ingredient = intval($_POST['ingredients']);
    // $quantity = intval($_POST['quantity']);
    // $measurement = $_POST['measurement'];
    
    // $sql = "INSERT INTO recipes (recipe_name, instructions) 
    //         VALUES('". $name ."', '". $instructions ."')";
    // if($db->query($sql) === TRUE){
    //     $last_id = $db->insert_id;
    //    // echo "New record created successfully. last inserted ID is: " . $last_id;
    // }else{
    //     echo "Error: " . $sql . "<br>" . $db->error;
    // }
    
    // $qu = "INSERT INTO link (recipe_id, ingredient_id, quantity)
    // VALUES('". $last_id ."', '". $ingredient ."', '". $quantity ."')";
    // if ($db->query($qu) === TRUE) {
    //     echo "New recipe ingredients and quantity were created successfully";
    // } else {
    //     echo "Error: " . $db->error;
    //     echo $qu;
    // }
     
//}
?>

<head>
</head>
<h3>Add/Remove Recipe and Ingredients</h3>

<!-- first form: add recipe to recipes and links -->
<form method="post" id="add_form">
    <label for="add_recipe">Recipe Name</label>
    <input type="text" name="add_recipe" id="add_recipe" /></br>
    <label for="instructions">Instructions</label>
    <textarea name="instructions" name="instructions"></textarea></br>
    <label for="cook_time">Cooking Time In Min</label>
    <input type="number" name="cook_time" /></br>

   <label for="ingredients_for_link"> Select Ingredients, Quantity, Measure: </label>
   <ul>
   <?php
   foreach($ingrs as $id=>$name){
   ?>
        <li><span><?php echo ucfirst($name) ?></span>
            <input class="small" type="checkbox" value="<?php echo $id ?>" name="ingredients[]" />
            <input class="small" type="text" name="quantity[]" />
          <input class="small" type="text" name="measurement[]" />
        </li>
    <?php
    }
    ?>
    </ul>
    <input type="submit" value="Submit" name="submit_add_recipe" />
</form>





