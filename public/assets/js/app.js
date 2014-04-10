$(function(){
	/* full screen */ 
	$('#supported').text('Supported/allowed: ' + !!screenfull.enabled);
	
	if (!screenfull.enabled) {
		return false;
	}

	$(document).on('click', '[data-toggle=fullscreen]', function (e) {
        if (screenfull.enabled) {
            screenfull.request();
        }
    });

	$(document).on('click', '[data-toggle=exitfullscreen]', function (e) {
        if (screenfull.enabled) {
            screenfull.exit();
        }
    });

    $(document).on('click', '[data-toggle=loadContent]', function (e) {
        e && e.preventDefault();
        var $this = $(e.target), $target, $title;
        $target = $this.data('target') || $this.attr('href');
    	$title  = $this.data('title')  || $this.attr('data-title');
    	if($('#tabContent').tabs('exists', $title)){
	        $('#tabContent').tabs('select', $title);
	    } else {
	        $('#tabContent').tabs('add',{
	            title:$title,
	            closable:true,
	            href: $target
	        });
	    } 	
    });

});


/* page ajax load */
function loadContent(title, url){
    
    if ($('#tabContent').tabs('exists', title)){

        $('#tabContent').tabs('select', title);
    
    } else {

        $('#tabContent').tabs('add',{
            title:title,
            closable:true,
            href: url
        });
    }       
}