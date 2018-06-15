<?php

$pageTitle = 'Add Project';
include( 'functions.php' );

$response = null;

if( $_POST[ 'submitted' ] ) {

    $response = addProject( $db,
                            $_POST[ 'title' ],
                            $_POST[ 'content' ],
                            $_POST[ 'technology' ],
                            $_POST[ 'link' ],
                            $_FILES[ 'image' ] );
}

include( 'top.php' );

?>

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
              method="post"
              enctype="multipart/form-data">

            <input type="hidden"
                   name="submitted"
                   value="1" />

            <input type="text"
                   name="title"
                   placeholder="Title" />

            <textarea name="content"
                      rows="10"
                      cols="80"
                      placeholder="Content"></textarea>

            <input type="text"
                   name="technology"
                   placeholder="Technology Used" />

            <input type="text"
                   name="link"
                   placeholder="Website Link" />

            <input type="file" name="image"> 

            <input type="submit"
                   value="Post" />

        </form>
        
    </div>
    
</main>

<?php include( 'bottom.php' ); ?>