<footer>
    
    <div id="footer-container">

        <section id="footer-projects">

            <h4>Projects</h4>

            <ul>

                <?php
                
                foreach( getProjects( $db ) as $project ) : ?>
                
                    <li>
                        <a href="projects.php#<?php echo $project[ 'id' ]; ?>"><?php echo $project[ 'title' ]; ?></a>
                    </li>

                <?php endforeach; ?>

            </ul>

        </section>

        <section id="footer-navigation">

            <h4>JA.</h4>

            <ul>

                <li><a href="index.php">Home</a></li>
                <li><a href="projects.php">Projects</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>

            </ul>

        </section>

        <section id="footer-social">

            <h4>Presence</h4>

            <ul>

                <li><a href="http://github.com/jordanalamilla" target="_blank">Github</a></li>
                <li><a href="http://behance.net/alamilla" target="_blank">Behance</a></li>
                <li><a href="http://linkedin.com/in/jordanalamilla/" target="_blank">LinkedIn</a></li>
                <li><a href="http://instagram.com/jordanalamilla" target="_blank">Instagram</a></li>

            </ul>

        </section>
        
        <p id="copyright">&copy; Jordan Alamilla | 2018</p>
        
        <?php if ( checkLogin() ) : ?>
            <a href="logout.php">Logout</a>
        
        <?php else : ?>
            <a href="login.php">Admin Login</a>
        
        <?php endif; ?>
        
    </div>
    
    <?php
    
//    echo '<pre>';
//    print_r( $_SESSION );
//    echo '<pre>';
//    
//    echo '<pre>';
//    print_r( $_POST );
//    echo '<pre>';
//    
//    echo '<pre>';
//    print_r( $_FILES );
//    echo '<pre>';
    
    ?>
    
</footer>

</body>
</html>