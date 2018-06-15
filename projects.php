<?php

$pageTitle = 'Projects';
include( 'functions.php' );

if( $_GET[ 'type' ] == 'delete' ) { deleteProject( $db, $_GET[ 'id' ] ); }

include( 'top.php' ); ?>

<main>
    
    <!--TITLE-->
    <h2><?php echo $pageTitle; ?></h2>
        
    <!--ADMIN LOGGED IN: SHOW ADD PROJECT-->
    <?php if( checkLogin() ) : ?>

    <a class="low button item-extra"
       id="add-button"
       href="add.php">Add New Project</a>

    <?php endif; ?>
    
    <!--SHOW ALL PROJECTS AS ARTICLES-->
	<?php foreach( getProjects( $db ) as $project ) : ?>

    <article id="<?php echo $project[ 'id' ]; ?>">
        
        <!--IMAGE-->
        <a href="<?php echo $project[ 'link' ]; ?>"
           target="_blank">
            
            <img class="article-image"
                 src="images/projects/<?php echo $project[ 'image' ]; ?>"
                 alt="image" />
        </a>

        <!--PROJECT TITLE-->
        <h3><?php echo $project[ 'title' ]; ?></h3>
        
        <!--DESCRIPTION-->
        <p class="item-content"><?php echo $project[ 'content' ]; ?></p>
        
        <!--TECHNOLOGIES USED-->
        <p class="item-extra">Technologies used:<br><?php echo $project[ 'technology' ]; ?></p>
        
        <ul class="item-extra project-buttons">
            <!--LINK TO LIVE PROJECT-->
            <li><a class="high button"
               href="<?php echo $project[ 'link' ]; ?>"
               target="_blank">Visit Live Project</a></li>
            
            <!--ADMIN LOGGED IN: SHOW EDIT AND DELETE BUTTONS-->
            <?php if( checkLogin() ) : ?>
            
            <li><a class="low button"
                   href="edit.php?id=<?php echo $project[ 'id' ]; ?>">Edit</a></li>
            
            <li><button class="delete-button low button"
                        data-url="<?php echo SITE_ROOT . 'projects.php?type=delete&id=' . $project[ 'id' ]; ?>">Delete</button></li>
        </ul>
        
        <?php endif; ?>

    </article>

	<?php endforeach; ?>
    
</main>

<?php include( 'bottom.php' ); ?>