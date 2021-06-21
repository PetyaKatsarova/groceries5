<?php
include_once 'dbconnection.php';
include_once 'add_recipe_logic.php';
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
?>

<head>
    <link href="styles.css" type="text/css" rel="stylesheet" />
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
            <input class="small" type="checkbox" value="<?php echo $id ?>" name="ingredients" />
            <input class="small" type="text" name="quantity" />
          <input class="small" type="text" name="measurement" />
        </li>
    <?php
    }
    ?>
    </ul>
    <input type="submit" value="Submit" name="submit_add_recipe" />
</form>

<!-- second form: add ingredients to the ingredients table -->

<form method="post" action="">
    <label for="new_ingredient">Add Ingredient To The List</label>
    <input type="text" name="new_ingredient" />
    <input type="submit" value="Submit" />
</form>

<!-- third form: delete recipe from recipe and links tables simultaneously -->

<form method="post">
   <label for="delete_ingredient_from_recipe">Delete Ingredient From Recipe:</label>
   <select name="recipe_delete_from">
   <?php include_once 'display_recipe_names.php' ?>
   </select>
    <select name="del_ingr" id="delete_ingredient_from_recipe">
        <?php
        foreach($ingrs as $key=>$val){
        ?>
            <option value="<?php echo $key ?>" ><?php echo $val ?></option>;
        <?php
        }
        ?>
    </select> 
    <input type="submit" value="Delete" name="delete_ingr_from_link" />
</form>

<a href="index.php">Return to main menu</a>



