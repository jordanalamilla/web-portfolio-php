<?php

$pageTitle = 'Contact';
include( 'functions.php' );

$response = null;

if( $_POST[ 'submitted' ] ) {

    $response = sendMessage( $db,
                             $_POST[ 'name' ],
                             $_POST[ 'email' ],
                             $_POST[ 'message' ],
                             $_POST[ 'g-recaptcha-response' ] );
}

include( 'top.php' ); ?>

<main>
        
    <div class="form-container"
         id="add-container">

        <h2><?php echo $pageTitle; ?></h2>

        <?php if( count( $response ) > 0 ) : ?>

            <ul id="response">

                <?php foreach( $response as $message ) { echo $message; } ?>

            </ul>

        <?php endif; ?>

        <form id="add-form"
              action="<?php echo $_SERVER[ 'PHP_SELF' ]; ?>"
              method="post">

            <input type="hidden"
                   name="submitted"
                   value="1" />

            <input type="text"
                   name="name"
                   placeholder="Your Name"
                   value="<?php echo $_POST[ 'name' ] ?>"/>

            <input type="email"
                   name="email"
                   placeholder="Email Address"
                   value="<?php echo $_POST[ 'email' ] ?>" />

            <textarea name="message"
                      rows="10"
                      cols="80"
                      placeholder="Message"><?php echo $_POST[ 'message' ] ?></textarea>
            
            <div class="g-recaptcha" data-sitekey="<?php echo CAPTCHA_PUBLIC ?>"></div>

            <input type="submit"
                   value="Send" />

        </form>
        
    </div>
    
</main>

<?php include( 'bottom.php' ); ?>