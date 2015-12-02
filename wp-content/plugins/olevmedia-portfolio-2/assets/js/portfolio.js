jQuery(function($){
	"use strict";
	
	if(jQuery().isotopeOm) {
		
		//helpers
    function reset_height(items) {
			for(var i=0; i<items.length; i++){
				$(items[i].element).find('.ompf-desc-wrapper').css('height','auto');
			}
    }
    
    function fit_height(items) {
			var groups=[];
			var max_heights=[];
			var last_top=-1;
			var group_id=-1;
			for(var i=0; i<items.length; i++){
				var pos=items[i].position;
				pos=pos.y;
					
				if(pos != last_top) {
					group_id++;
					groups[group_id]=[];
					max_heights[group_id]=0;
					last_top=pos;
				}
				groups[group_id].push(i);
				var h=$(items[i].element).find('.ompf-desc').outerHeight();
				if(h > max_heights[group_id])
					max_heights[group_id]=h;
			}
			
			var i,j;
			for (i=0; i<groups.length; i++) {
				for(j=0; j<groups[i].length; j++) {
					var $el=$(items[groups[i][j]].element).find('.ompf-desc-wrapper');
				 	$el.css('height',max_heights[i]+'px');
				}
			}
    }
    
    function run_callbacks($container, elems) {
			var appenedElemsCallbacks=$container.data('appenedElemsCallbacks');
			if(appenedElemsCallbacks && appenedElemsCallbacks.length) {
				for(var i=0;i<appenedElemsCallbacks.length;i++) {
					if(typeof(appenedElemsCallbacks[i]) == 'function') {
						appenedElemsCallbacks[i].call(null, elems);
					}
				}
			}
    }
    
    /*-------------------*/
		
		$('.ompf-portfolio').not('.ompf-layout-random').not('.ompf-widget-mode').each(function(){
			var $container=$(this);

	    var args={ 
		    itemSelector: '.ompf-portfolio-thumb',
		    transitionDuration: '0.5s'
		  };
		  
	    if($container.hasClass('ompf-layout-fixed')) {
	    	$.extend(args, {
	    		layoutMode: 'fitRows'
			  });
	    } else if($container.hasClass('ompf-layout-masonry')) {
	    	$.extend(args, {
	    		layoutMode: 'masonry'
				});
	    }
		  
			$container.isotopeOm(args);
			
			if($container.hasClass('ompf-layout-fixed') && $container.data('fit-height') && $container.hasClass('ompf-preview-layout-full')) {

				$container.isotopeOm( 'on', 'beforeLayout', function(obj) {
					reset_height(obj.items);
				});
								
				$container.isotopeOm( 'on', 'beforeAnimation', function(obj) {
					fit_height(obj.items);
				});
			}
			
			$(window).bind('load',function(){
				// when webfonts loaded the container sizes could change
				$container.isotopeOm('layout');
			});

			/*** Navigation ***/
			
			var ajaxHandler=false;
			

			if($container.hasClass('ompf-pagination-no')) {
				/**
				 * No pagination mode
				 */
				var $categories=$('.ompf-portfolio-categories a');
	      $categories.click(function(){
	      	if($(this).hasClass('ompf-active'))
	      		return false;
	        $categories.removeClass('ompf-active');
	        $(this).addClass('ompf-active');
	
	        var selector = $(this).data('filter');
	        if(typeof selector == 'undefined')
	        	selector='';
	        if(selector != '')
						args.filter='.ompf-'+selector;
					else
						args.filter=false;
	        
	        $container.isotopeOm(args);
	        
	        if(selector == '')
	        	selector='all';
	        document.location.hash=selector;
	        
	        return false;
	      });
	
				if(document.location.hash) {
					$categories.filter('[data-filter='+document.location.hash.replace('#','')+']').click();
				}
				
			} else if($container.hasClass('ompf-pagination-pages')) {
				/**
				 * Pagination mode
				 */
				 
				var $categories=$('.ompf-portfolio-categories a');
				var $pagination=$('#ompf-pagination-holder');
				var $loading=$('<div class="ompf-ajaxloading" />').appendTo('body');

				// helpers
				function pages_set_hash(data) {
					var hash='';
					if(data.category_id)
						hash=data.category_id;
					else
						hash='all';
					if(data.paged && data.paged != 1)
						hash+='&'+data.paged;

					document.location.hash=hash;
				}

		    function pagination_init($context) {
		    	$('a',$context).click(function(){
		
						var data={
							paged: $(this).data('page-number')
						}
		  		
						var category_id=$container.data('current-category-id');
						if(category_id)
							data.category_id=category_id;
						
						pages_load_items(data);
		
		    		return false;
		    	});
		    	
		    }
		    
				function pages_load_items(data) {

					data.action = 'ompf_portfolio_ajax';
					data.portfolio_id = $container.data('portfolio-post-id');
					if((!('category_id' in data) || !data.category_id) && $container.data('portfolio-category-id'))
						data.category_id = $container.data('portfolio-category-id');
					data.pagination = 'pages';

					if(ajaxHandler)
						ajaxHandler.abort();

					$container.stop(true).fadeTo(300,0.5);
					$loading.stop(true).fadeTo(300,1);								
					
					ajaxHandler=$.ajax({
						type: 'POST',
						url: ajaxurl,
						data: data,
						dataType: 'json'
					}).success(function(resp){
						if(resp.error == 0) {
							pages_set_hash(data);
							if(data.category_id)
								$container.data('current-category-id', data.category_id);
							else
								$container.data('current-category-id', false);

							var $elems=$(resp.html).filter('.ompf-portfolio-thumb');
							$container.isotopeOm('remove',$container.find('.ompf-portfolio-thumb'));
							$container.isotopeOm('insert',$elems);
							
							run_callbacks($container, $elems);
							
							$pagination.html(resp.html_pagination);
							pagination_init($pagination);
						}
					}).always(function(){
						$container.stop(true).fadeTo(300,1);
						$loading.stop(true).fadeOut(300);
					});
					
					var offset=$container.offset();
					var st=$(window).scrollTop();
					if(offset.top < st) {
						st=offset.top - 70;
						if(st < 0)
							st=0;
						$('html, body').animate({scrollTop:st}, '500', 'swing');
					}

				}
		    
				// initial state
				if(document.location.hash) {
					var hash=document.location.hash.replace('#','').split('&');
					if(hash[0] || hash[1]) {
						var data={};
						if(hash[0] && hash[0] != 'all') {
							data.category_id=hash[0];
							var $cat=$categories.filter('[data-category-id='+hash[0]+']');
							if($cat.length) {
				        $categories.removeClass('ompf-active');
				        $cat.addClass('ompf-active');
				      }
						}
						if(hash[1])
							data.paged=hash[1];
						pages_load_items(data);
					}
				}				

				// categories
				$categories.click(function(){
	      	if($(this).hasClass('ompf-active'))
	      		return false;
	        $categories.removeClass('ompf-active');
	        $(this).addClass('ompf-active');
	        
	        var category_id=$(this).data('category-id');

					var data={
						category_id: category_id
					}
					
					pages_load_items(data);
					
					return false;
				});
				
				//pagination
				pagination_init($pagination);
				
			} else if($container.hasClass('ompf-pagination-scroll')) {
				/**
				 * Scroll mode
				 */
				 
				var $categories=$('.ompf-portfolio-categories a');
				var $loadmore=$('#ompf-loadmore-holder');
				var $loadingmore=$('<div class="ompf-loadmoreloading" />').insertBefore($loadmore);
				var $loading=$('<div class="ompf-ajaxloading" />').appendTo('body');

				// helpers
				function scroll_set_hash(data) {
					var hash='';
					if(data.category_id)
						hash=data.category_id;

					if(hash != '') {
						document.location.hash=hash;
					} else {
						if(document.location.hash.replace('#','') != '') {
							document.location.hash='all';
						}
					}
				}

		    function loadmore_init($context) {
		    	$('a',$context).click(function(){

						var paged=$container.data('current-paged');
						if(typeof paged == 'undefined')
							paged=1;
						paged++;
						var data={
							paged: paged
						}
		  		
						var category_id=$container.data('current-category-id');
						if(category_id)
							data.category_id=category_id;
						
						scroll_load_items(data);
		
		    		return false;
		    	});
		    	
		    	if(jQuery.waypoints) {
		    		setTimeout(function(){
							$('#ompf-loadmore-link', $context).waypoint(function() {
							  $(this).click();
							}, {
								offset: '130%',
								triggerOnce: true
							});
		    		}, 500);
		    	}
		    	
		    }
		    
				function scroll_load_items(data) {

					data.action = 'ompf_portfolio_ajax';
					data.portfolio_id = $container.data('portfolio-post-id');
					if((!('category_id' in data) || !data.category_id) && $container.data('portfolio-category-id'))
						data.category_id = $container.data('portfolio-category-id');
					data.pagination = 'scroll';

					if(ajaxHandler)
						ajaxHandler.abort();

					$loadmore.hide();
					if(data.is_new_category) {
						$container.stop(true).fadeTo(300,0.5);
						$loading.stop(true).fadeTo(300,1);		
					} else {
						$loadingmore.stop(true, true).css({visibility: 'visible'}).show();
					}


					ajaxHandler=$.ajax({
						type: 'POST',
						url: ajaxurl,
						data: data,
						dataType: 'json'
					}).success(function(resp){
						if(resp.error == 0) {
							scroll_set_hash(data);
							$container.data('current-paged', data.paged);
							if(data.category_id)
								$container.data('current-category-id', data.category_id);
							else
								$container.data('current-category-id', false);

							var $elems=$(resp.html).filter('.ompf-portfolio-thumb');
							if(data.is_new_category) {
								$container.isotopeOm('remove',$container.find('.ompf-portfolio-thumb'));
								$container.isotopeOm('insert',$elems);
							} else {
								$container.append($elems).isotopeOm('appended',$elems);
							}

							run_callbacks($container, $elems);
							
							$loadmore.html(resp.html_pagination);
							loadmore_init($loadmore);
						}
					}).always(function(){
						if(data.is_new_category) {
							$container.stop(true).fadeTo(300,1);
							$loading.stop(true).fadeOut(300);
						} else {
							$loadingmore.css('visibility','hidden').slideUp(300);
						}
						$loadmore.show();
					});

				}
		    
		    
				// categories
				$categories.click(function(){
	      	if($(this).hasClass('ompf-active'))
	      		return false;
	        $categories.removeClass('ompf-active');
	        $(this).addClass('ompf-active');
	        
	        var category_id=$(this).data('category-id');

					var data={
						category_id: category_id,
						paged: 1,
						is_new_category: true
					}
					
					scroll_load_items(data);
					
					return false;
				});
				

				// initial state
				var loadinghashstate=false;
				if(document.location.hash) {
					var hash=document.location.hash.replace('#','').split('&');
					if(hash[0]) {
						var $cat=$categories.filter('[data-category-id='+hash[0]+']');
						if($cat.length) {
							var data={};
							data.category_id=hash[0];
			        $categories.removeClass('ompf-active');
			        $cat.addClass('ompf-active');
			        data.is_new_category=true;
							scroll_load_items(data);
							loadinghashstate=true;
						}
					}
				}				
				
				//pagination
				if(!loadinghashstate)
					loadmore_init($loadmore);
				
			}
    });
	}
	
	/**
	 * Responsive embed
	 */
 
	$('.ompf-responsive-embed').each(function(){
		var $obj=$(this).children(':first');
		if($obj.length) {
			var w=parseInt($obj.attr('width'));
			var h=parseInt($obj.attr('height'));
			if(!isNaN(w) && !isNaN(h) && w > 0 && h > 0) {
				var r=h/w;
				$(this).css('padding-bottom',(r*100)+'%');
			}
		}
	});

});
