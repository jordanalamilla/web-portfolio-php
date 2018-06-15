<?php include( 'functions.php' );
$pageTitle = 'Login';

$response = null;

if( $_POST[ 'submitted' ] ) {

    $response = login( $db, $_POST[ 'email' ], $_POST[ 'password' ] );
}

include( 'top.php' );

?>

<main>

    <div class="form-container"
         id="login-container">
        
        <h2><?php echo $pageTitle; ?></h2>

        <?php if( count( $response ) > 0 ) : ?>

            <ul id="response">

                <?php foreach( $response as $message ) { echo $message; } ?>

            </ul>

        <?php endif; ?>

        <form id="login-form"
              action="<?php echo $_SERVER[ 'PHP_SELF' ]; ?>"
              method="post">

            <input type="hidden"
                   name="submitted"
                   value="1"/>

            <input type="email"
                   name="email"
                   placeholder="Email"
                   value="<?php echo $_POST[ 'email' ]; ?>"/>

            <input type="password"
                   name="password"
                   placeholder="Password" />

            <input type="submit"
                   value="Login" />

        </form>
        
    </div>
    
</main>

<?php include( 'bottom.php' ); ?>