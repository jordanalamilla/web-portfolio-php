<?php include( 'functions.php' );
$pageTitle = 'Edit Project';

$response = null;

$project = getProject( $db, $_GET[ 'id' ] );

if( $_POST[ 'submitted' ] ) {

    $response = editProject( $db,
                             $project,
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

            <ul>

                <?php foreach( $response as $message ) : ?>

                    <li><?php echo $message; ?></li>

                <?php endforeach; ?>

            </ul>

        <?php endif; ?>

        <form id="add-form"
              action="<?php echo $_SERVER[ 'PHP_SELF' ] . '?id=' . $_GET[ 'id' ]; ?>"
              method="post"
              enctype="multipart/form-data">

            <input type="hidden"
                   name="submitted"
                   value="1" />

            <input type="text"
                   name="title"
                   placeholder="Title"
                   value="<?php echo $project[ 'title' ]; ?>" />

            <textarea name="content"
                      rows="10"
                      cols="80"
                      placeholder="Content"><?php echo $project[ 'content' ]; ?></textarea>

            <input type="text"
                   name="technology"
                   placeholder="Technology Used"
                   value="<?php echo $project[ 'technology' ]; ?>" />

            <input type="text"
                   name="link"
                   placeholder="Website Link"
                   value="<?php echo $project[ 'link' ]; ?>" />

            <input type="file" name="image"> 

            <input type="submit"
                   value="Post" />

        </form>
        
    </div>
    
</main>

<?php include( 'bottom.php' ); ?>