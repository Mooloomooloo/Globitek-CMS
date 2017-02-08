<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.

  // if this is a POST request, process the form
  // Hint: private/functions.php can help

    // Confirm that POST values are present before accessing them.

    // Perform Validations
    // Hint: Write these in private/validation_functions.php

    // if there were no errors, submit data to database

      // Write SQL INSERT statement
      // $sql = "";

      // For INSERT statments, $result is just true/false
      // $result = db_query($db, $sql);
      // if($result) {
      //   db_close($db);

      //   TODO redirect user to success page

      // } else {
      //   // The SQL INSERT statement failed.
      //   // Just show the error, not the form
      //   echo db_error($db);
      //   db_close($db);
      //   exit;
      // }

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    // TODO: display any form errors here
    // Hint: private/functions.php can help
    
    // Sets default values
    $first_name = '';
    $last_name = '';
    $email = '';
    $username = '';
    $errors = [];
    
    if( is_post_request() ) {
      
      // first name input outcomes
      if( is_blank( $_POST['firstname'] ) ) {
        $errors[] = "First name cannot be blank.";
      }
      else if( !has_length($_POST['firstname'], ['min' => 2, 'max' => 225]) ) {
        $errors[] = "First name must be between 2 and 255 characters.";
      }
      else {
        $first_name = $_POST['firstname'];
      }
    
      // last name input outcomes
      if( is_blank( $_POST['lastname'] ) ) {
        $errors[] = "Last name cannot be blank.";
      }
      else if( !has_length($_POST['lastname'], ['min' => 2, 'max' => 225]) ) {
        $errors[] = "Last name must be between 2 and 255 characters.";
      }
      else {
        $last_name = $_POST['lastname'];
      }
      
      // email input outcomes
      if( is_blank( $_POST['email'] ) ) {
        $errors[] = "Email cannot be blank.";
      }
      else if( !has_length($_POST['email'], ['min' => 2, 'max' => 225]) ) {
        $errors[] = "Email must be between 2 and 255 characters.";
      }
      else if( !has_valid_email_format( $_POST['email'] ) ) {
        $errors[] = "Email must contain '@' symbol";
      }
      else {
        $email = $_POST['email'];
      }
      
      // username input outcomes
      if( is_blank( $_POST['username'] ) ) {
        $errors[] = "Username cannot be blank.";
      }
      else if( !has_length($_POST['username'], ['min' => 8, 'max' => 225]) ) {
        $errors[] = "Username must be between 8 and 255 characters.";
      }
      else {
        $username = $_POST['username'];
      }

      if( !empty($errors) ) {
        echo display_errors( $errors );
      }
      else {
        
        $date = date('Y-m-d H:i:s');
        
        // sanitizing inputs
        $first_name = h( $first_name );
        $last_name = h( $last_name );
        $email = h( $email );
        $username = h( $username );
        
        $query = "INSERT INTO users ( first_name, last_name, email, username, created_at )
        VALUES ( '".$first_name."', '".$last_name."', '".$email."', '".$username."', '".$date."' )";
        
        $result = db_query( $db, $query );
        
        if( $result ) {
          db_close( $db );
          redirect_to( "./registration_success" );
        }
        else {
          echo db_error($db);
          db_close($db);
          exit;
        }
        
      }

    }
  ?>


  <form action="./register.php" method="post">
    First name:
    <br/>
    <input type="text" name="firstname" value="<?php echo $first_name; ?>" />
    <br/>
    
    Last name:
    <br/>
    <input type="text" name="lastname" value="<?php echo $last_name; ?>" />
    <br/>
    
    Email:
    <br/>
    <input type="text" name="email" value="<?php echo $email; ?>" />
    <br/>
    
    Username:
    <br/>
    <input type="text" name="username" value="<?php echo $username; ?>" />
    <br/>
    <br/>
    
    <input type="submit" value="Submit">
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
