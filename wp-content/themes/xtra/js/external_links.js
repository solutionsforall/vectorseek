jQuery(document).ready(function($) {
    // Check if links are external, if yes, add class=external and add proper attributes
    $('a').filter(function() {
        return this.hostname && this.hostname !== location.hostname;
    }).addClass("external").attr("rel","external noopener noreferrer").attr("target","_blank");
});