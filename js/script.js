$( function() {
    
    $( '#mobile-nav-button' ).on( 'click', function() {
     
        $( '#mobile-nav-links' ).toggle();
    });
    
    $( '.delete-button' ).on( 'click', function() {
        
        var confimation = confirm( 'Are you sure?' );
       
        if( confimation ) {
            
            $.ajax({

                type    : 'GET',
                url     : $( this ).data( 'url' )

            }).done( function( response ) {

                console.log( $( this ).data( 'url' ) );
                window.location.replace( 'projects.php' );
            });    
            
        } else {
            return false;
        }
        
    });
    
    $( '.read-more' ).on( 'click', function() {
        
        var id = $( this ).data( 'id' );
        
        console.log( $( '#' + id + ' .item-content' ).text() );
     
        $( '#' + id + ' .item-content' ).text( $( this ).data( 'full' ) );
    });
});