<?php
include_once 'dbconnection.php';

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
        // $stmt2 = $db->query("INSERT INTO ingredients (ingredient_name)
        //                VALUES ('". $new_ingredient ."')");                    
    }else{
        echo "The ingredient exist in the databes, select it from the list below.";
    }
}

// logic
if(isset($_POST['submit_add_recipe'])){
    $name = strtolower($_POST['add_recipe']);
    $instructions= $_POST['instructions'];
    $last_id = -1;
    $cook_time = $_POST['cook_time'];
    $ingredient = intval($_POST['ingredients']);
    $quantity = intval($_POST['quantity']);
    $measurement = $_POST['measurement'];
    
    $sql = "INSERT INTO recipes (recipe_name, instructions) 
            VALUES('". $name ."', '". $instructions ."')";
    if($db->query($sql) === TRUE){
        $last_id = $db->insert_id;
       // echo "New record created successfully. last inserted ID is: " . $last_id;
    }else{
        echo "Error: " . $sql . "<br>" . $db->error;
    }
    
    $qu = "INSERT INTO link (recipe_id, ingredient_id, quantity)
    VALUES('". $last_id ."', '". $ingredient ."', '". $quantity ."')";
    if ($db->query($qu) === TRUE) {
        echo "New recipe ingredients and quantity were created successfully";
    } else {
        echo "Error: " . $db->error;
        echo $qu;
    }
     
}
