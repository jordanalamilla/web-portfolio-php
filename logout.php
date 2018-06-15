<?php

include( 'functions.php' );

$_SESSION[ 'isLoggedIn' ] = null;
unset( $_SESSION[ 'isLoggedIn' ] );

redirect();