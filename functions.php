<?php

require( 'config.php' );
require( 'res/class.upload.php' );

function sanitize( $db, $string ) {
    
    $string = mysqli_real_escape_string( $db, strip_tags( trim( $string ) ) );
    
    return $string;
}

function redirect( $location = '' ) {
    
    header( 'Location: ' . SITE_ROOT . $location );
    die();
}

function getProject( $db, $id ) {
    
    $query = "SELECT * FROM projects WHERE id = $id LIMIT 1";
        
    $result = mysqli_query( $db, $query ) or die( mysqli_error( $db ) . '<br>' . $query );
    
    $row = mysqli_fetch_assoc( $result );
    
    return $row;
    
}

function getProjects( $db ) {
    
    $data = array();
    
    $query = "SELECT * FROM projects";
        
    $result = mysqli_query( $db, $query ) or die( mysqli_error( $db ) . '<br>' . $query );
    
    while ( $row = mysqli_fetch_assoc( $result ) ) { array_push( $data, $row ); }
    
    return $data;
    
}

function checkLogin() {
    
    $isLoggedIn = false;
    
    if( $_SESSION[ 'isLoggedIn' ] == LOGIN_TOKEN ) {
        
        $isLoggedIn = true;
    }
    
    return $isLoggedIn;
}

function login( $db, $email, $password ) {
    
    //RESPONSE ARRAY
    $response   = array();
    
    //SANITIZE INPUT
    $email      = sanitize( $db, $email );
    $password   = sanitize( $db, $password );
    
    if( !strlen( $email ) )     { array_push( $response, '<li class="error">Please enter an email address.</li>' ); }
    if( !strlen( $password ) )  { array_push( $response, '<li class="error">Please enter your password.</li>' ); }
    
    //FIND USER IN DATABASE
    $query      = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
    $result     = mysqli_query( $db, $query ) or die( mysqli_error( $db ) . '<br>' . $query );
    
    //IF USER IS FOUND, CHECK PASSWORD
    if( mysqli_num_rows( $result ) == 1 ) {
        
        $row = mysqli_fetch_assoc( $result );
        
        if( password_verify( $password, $row[ 'password' ] ) ) {
        
            $_SESSION[ 'isLoggedIn' ] = LOGIN_TOKEN;
            redirect();
            
        } else {
            
            array_push( $response, '<li class="error">Your password is incorrect.</li>' );
        }
        
    } else {
        
        array_push( $response, '<li class="error">User does not exist.</li>' );
    }
    
    return $response;
}

function upload_image( $image_to_upload, $name = null ) {
    
    //NEW INSTANCE OF UPLOAD
    $image = new upload( $image_to_upload );
    
    if( $image->uploaded ) {
        
        if( $name ) { $image->file_new_name_body = $name; }

        $image->image_resize            = true;        //DECLARE IMAGE WILL BE RESIZED
        $image->image_x                 = 1000;       //RESIZE WIDTH IN PIXELS
        $image->image_ratio_y           = true;      //MAINTAIN ASPECT RATIO FOR HEIGHT
        $image->process( 'images/projects/' );     //START PROCESSING IMAGE, UPLOAD TO DESTINATION

        if( $image->processed ) {
            
            echo 'image resized.';
            $image->clean();
            
        } else {
            echo 'error:' . $image->error;
        }
    }
    
    return $image->file_dst_name;
    
}

function addProject( $db, $title, $content, $technology, $link, $image ) {
    
    //ARRAY TO STORE ERRORS AND SUCCESS MESSAGES
    $response = array();

    //CHECK EACH VARIABLE FOR EMPTIES
    if( !strlen( $title ) )         { array_push( $response, '<li class="error">Please enter a title.</li>' ); }
    if( !strlen( $content ) )       { array_push( $response, '<li class="error">Please talk about the project.</li>' ); }
    if( !strlen( $technology ) )    { array_push( $response, '<li class="error">Please list the technology used to make this project.</li>' ); }
    if( !strlen( $link ) )          { array_push( $response, '<li class="error">Please enter a link to the live project.</li>' ); }


    //IF NO ERRORS..
    if( count( $response ) == 0 ) {

        //..SANTIZE ALL INPUTS
        $title          = sanitize( $db, $title );
        $content        = sanitize( $db, $content );
        $technology     = sanitize( $db, $technology );
        $link           = sanitize( $db, $link );

        //IF IMAGE UPLOADED SUCCESSFULLY..
        $image_file_name = upload_image( $image );

        //INSERT ALL OTHER TEXT DATA, ALONG WITH IMAGE FILENAME, INTO PROJECT TABLE
        $insert = "INSERT INTO
                   projects(title, content, link, technology, image)
                   VALUES('$title','$content','$link','$technology','$image_file_name')";

        //EXECUTE INSERT
        $result = mysqli_query( $db, $insert )
            or die( mysqli_error( $db ) . '<br>' . $insert );
        
        if( $result ) { array_push( $response, '<li class="success">Project Added. <a href="projects.php">View Projects.</a></li>' ); }
    }
    
    return $response;
}

function editProject( $db, $project, $title, $content, $technology, $link, $image = null ) {
    
    //ARRAY TO STORE ERRORS AND SUCCESS MESSAGES
    $response = array();

    //CHECK EACH VARIABLE FOR EMPTIES
    if( !strlen( $title ) )         { array_push( $response, 'Please enter a title.' ); }
    if( !strlen( $content ) )       { array_push( $response, 'Please talk about the project.' ); }
    if( !strlen( $technology ) )    { array_push( $response, 'Please list the technology used to make this project.' ); }
    if( !strlen( $link ) )          { array_push( $response, 'Please enter a link to the live project.' ); }


    //IF NO ERRORS..
    if( count( $response ) == 0 ) {

        //..SANTIZE ALL INPUTS
        $title          = sanitize( $db, $title );
        $content        = sanitize( $db, $content );
        $technology     = sanitize( $db, $technology );
        $link           = sanitize( $db, $link );
        
        //ARRAYS TO STORE ROWS AND DATA TO BE USED IN UPDATE
        $rows = array();
        $data = array();
        
        //IF DATA ENTER DIFFERS FROM EXISTING DATA, ADD TO ARRAYS TO BE UPDATED
        if( $title      != $project[ 'title' ] )        { array_push( $rows, 'title' );         array_push( $data, $title ); }
        if( $content    != $project[ 'content' ] )      { array_push( $rows, 'content' );       array_push( $data, $content ); }
        if( $technology != $project[ 'technology' ] )   { array_push( $rows, 'technology' );    array_push( $data, $technology ); }
        if( $link       != $project[ 'link' ] )         { array_push( $rows, 'link' );          array_push( $data, $link ); }
        
        if( $image ) {
            array_push( $rows, 'image' );
            array_push( $data, $image[ 'name' ] );
        }
        
        $rows_to_update = '';
        
        for( $i = 0; $i < count( $rows ); $i++ ) {
            
            if( ( $i + 1 ) == count( $rows ) ) {
                $rows_to_update .= "{$rows[ $i ]} = '{$data[ $i ]}' ";
                
            } else {
                $rows_to_update .= "{$rows[ $i ]} = '{$data[ $i ]}', ";
            }
        }
        
        $_SESSION[ 'rows to update' ] = $rows_to_update;
        $_SESSION[ 'rows' ] = $rows;

        //IF IMAGE UPLOADED SUCCESSFULLY..
        
        $image_file_name = upload_image( $image );

        //INSERT ALL OTHER TEXT DATA, ALONG WITH IMAGE FILENAME, INTO PROJECT TABLE
        $update = "UPDATE projects
                   SET $rows_to_update
                   WHERE id = {$project[ 'id' ]}";

        //EXECUTE INSERT
        $result = mysqli_query( $db, $update )
            or die( mysqli_error( $db ) . '<br>' . $update );
        
        if( $result ) { array_push( $response, 'Project updated.' ); }
    }
    
    return $response;
}

function deleteProject( $db, $id ) {

    //DELETE QUERY
    $delete = "DELETE FROM projects
               WHERE id = $id";

    //EXECUTE INSERT
    $result = mysqli_query( $db, $delete )
        or die( mysqli_error( $db ) . '<br>' . $delete );
}

function sendMessage( $db, $name, $email, $message, $captcha ) {
    
    //ARRAY TO STORE ERRORS AND SUCCESS MESSAGES
    $response = array();
    
    //SANITIZE INPUTS
    $name       = sanitize( $db, $name );
    $email      = sanitize( $db, $email );
    $message    = sanitize( $db, $message );

    //CHECK EACH VARIABLE FOR EMPTINESS
    if( !strlen( $name ) )         { array_push( $response, '<li class="error">Please enter your name.</li>' ); }
    if( !strlen( $email ) )        { array_push( $response, '<li class="error">Please enter your email address.</li>' ); }
    if( !strlen( $message ) )      { array_push( $response, '<li class="error">Please write a message.</li>' ); }
    
    //VERIFY CAPTCHA RESPONSE
    $captcha_response = post_captcha( $captcha );

    if ( !$captcha_response[ 'success' ] ) {
        array_push( $response, '<li class="error">Please click the reCAPTCHA checkbox.</li>' );

    } else {

        //REQUIRE PHPMAILER FILES
        require( 'res/PHPMailer-master/src/PHPMailer.php' );
        require( 'res/PHPMailer-master/src/Exception.php' );

        //IF NO ERRORS..
        if( count( $response ) == 0 ) {

            //..CREATE NEW PHPMAILER OBJECT
            $mail = new \PHPMailer\PHPMailer\PHPMailer( true );

            //ATTEMPT TO SEND MESSAGE
            try {

                //SET TO AND FROM
                $mail->setFrom( $email );
                $mail->addAddress( 'jordan.alamilla@gmail.com' );

                //SET SUBJECT AND BODY TEXT
                $mail->Subject  = 'Business Inquiry From ' . ucfirst( $name ) . '! - jordanalamilla.com';
                $mail->Body     = $message;

                //SEND MESSAGE
                $mail->send();

                //SUCCESS MESSAGE
                array_push( $response, '<li class="success">Message sent.</li>' );

            } catch( Exception $e ) {

                //IF THERE WAS A PROBLEM SENDING MESSAGE, SEND ERROR
                array_push( $response, '<li class="error">There was an error sending your message: ' . $mail->ErrorInfo . '.</li>' );

            }
        }
    }
    
    return $response;
    
}

function post_captcha( $user_response ) {
//FROM MAKINGSPIDERSENSE.COM
    
        $fields_string = '';
    
        $fields = array(
            'secret'    => CAPTCHA_SECRET,
            'response'  => $user_response
        );
    
        foreach( $fields as $key=>$value )
        $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim( $fields_string, '&' );

        $ch = curl_init();
    
        curl_setopt( $ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify' );
        curl_setopt( $ch, CURLOPT_POST, count( $fields ) );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields_string) ;
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, True );

        $result = curl_exec($ch);
    
        curl_close($ch);

        return json_decode( $result, true );
    }