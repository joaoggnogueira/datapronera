function _CarregarPagina(page,p,elem) {
	$.ajax({
	  url: 'paginas/'+page+'.html',
	  // type: 'POST',
	  dataType: 'html',
	  data: {},
	  complete: function(xhr, textStatus) {
	    //called when complete
		console.log('ajax complete');
	  },
	  success: function(data, textStatus, xhr) {
	    //called when successful
	    $(elem).html(data);
		console.log('ajax success');
	  },
	  error: function(xhr, textStatus, errorThrown) {
	    //called when there is an error
		console.log('ajax error');
	  }
	});
}
