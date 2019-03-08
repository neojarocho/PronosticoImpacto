$(function() {
	$('#navbar').affix({
		offset: {
			top: 0
		}
	});

	$("pre.html").snippet("html", {style:'matlab'});
	$("pre.css").snippet("css", {style:'matlab'});
	$("pre.javascript").snippet("javascript", {style:'matlab'});

	$('#easyPaginate').easyPaginate({
		paginateElement: 'div.contentMuni',
		elementsPerPage: 5,
		effect: 'climb'
	});
});