$(document).ready(function() {
	
	var dHeight = parseInt($(document).height());
	
	var pageContentHeight = dHeight - 50;
	$("#page-content").css('height', pageContentHeight + 'px');


	var contentContainerHeight = dHeight - 150;
	$("#content-container").css('height', contentContainerHeight + 'px');
	$("#content-container").css('overflow-y', 'auto');

 	
	var leftMenuContainerHeight = dHeight - 60;
	$("#left-menu-container").css('height', leftMenuContainerHeight + 'px');
	$("#left-menu-container").css('overflow-y', 'auto');
	
});