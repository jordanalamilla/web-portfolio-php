<?php

$pageTitle = 'Home';
include( 'functions.php' );
include( 'top.php' ); ?>

<main>
    
    <div id="home-intro">

        <img id="home-image"
             src="images/home/computer.gif"
             alt="An animated gif of a computer writing code." />

        <h2>Jordan Alamilla</h2>

        <p>Hi there, I'm a web developer. My skills include both front and back end technologies, making me a versatile addition to any team. I'm passionate about creating optimized code and simple, yet functional design.</p>

        <ul id="home-buttons">
            <li>
                <a class="low button"
                   id="view-my-work-button"
                   href="projects.php">View My Work</a>
            </li>
            <li>
                <a class="high button"
                   id="contact-me-button"
                   href="contact.php">Contact Me</a>
            </li>
        </ul>
    </div>
    
</main>

<?php include( 'bottom.php' ); ?>