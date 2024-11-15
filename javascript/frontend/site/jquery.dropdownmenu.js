/*
 * DC Mega Menu - jQuery mega menu
 * Copyright (c) 2011 Design Chemical
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 *
 */
(function($){

	//define the defaults for the plugin and how to call it	
	$.fn.dcDropDownMenu = function(options){
		//set default options  
		var defaults = {
			classParent: 'dc-dropdown',
			rowItems: 3,
			speed: 'fast',
			effect: 'slide'
		};

		//call in the default otions
		var options = $.extend(defaults, options);
		var $dcdropdownMenuObj = this;

		//act upon the element that is passed into the design    
		return $dcdropdownMenuObj.each(function(options){

			dropdownSetup();
			
			function dropdownOver(){
				var subNav = $('.sub',this);
				$(this).addClass('dropdown-hover');
				if(defaults.effect == 'fade'){
					$(subNav).fadeIn(defaults.speed);
				}
				if(defaults.effect == 'slide'){
					$(subNav).slideDown(defaults.speed);
				}
			}
			
			function dropdownOut(){
				var subNav = $('.sub',this);
				$(this).removeClass('dropdown-hover');
				$(subNav).hide();
			}

			function dropdownSetup(){
				$arrow = '<span class="dc-dropdown-icon"></span>';
				var classParentLi = defaults.classParent+'-li';
				var menuWidth = $($dcdropdownMenuObj).outerWidth(true);
				$('> li',$dcdropdownMenuObj).each(function(){
					//Set Width of sub
					var mainSub = $('> ul',this);
					var primaryLink = $('> a',this);
					if($(mainSub).length > 0){
						$(primaryLink).addClass(defaults.classParent).append($arrow);
						$(mainSub).addClass('sub').wrap('<div class="sub-container" />');
						
						// Get Position of Parent Item
							var position = $(this).position();
							parentLeft = position.left;
							
						if($('ul',mainSub).length > 0){
							$(this).addClass(classParentLi);
							$('.sub-container',this).addClass('dropdown');
							$('> li',mainSub).addClass('dropdown-hdr');
							$('.dropdown-hdr > a').addClass('dropdown-hdr-a');
							// Create Rows
							var hdrs = $('.dropdown-hdr',this);
							rowSize = parseInt(defaults.rowItems);
							for(var i = 0; i < hdrs.length; i+=rowSize){
								hdrs.slice(i, i+rowSize).wrapAll('<div class="row" />');
							}

							// Get Sub Dimensions & Set Row Height
							$(mainSub).show();

							// Calc Left Position of Sub Menu
							// // Get Width of Parent
							var parentWidth = $(this).width();
							
							// // Calc Width of Sub Menu
							var subWidth = $(mainSub).outerWidth(true);
							var totalWidth = $(mainSub).parent('.sub-container').outerWidth(true);
							var containerPad = totalWidth - subWidth;
							var itemWidth = $('.dropdown-hdr',mainSub).outerWidth(true);
							var rowItems = $('.row:eq(0) .dropdown-hdr',mainSub).length;
							var innerItemWidth = itemWidth * rowItems;
							var totalItemWidth = innerItemWidth + containerPad;
							
							// Set dropdown header height
							$('.row',this).each(function(){
								$('.dropdown-hdr:last',this).addClass('last');
								var maxValue = undefined;
								$('.dropdown-hdr-a',this).each(function(){
									var val = parseInt($(this).height());
									if (maxValue === undefined || maxValue < val){
										maxValue = val;
									}
								});
								$('.dropdown-hdr-a',this).css('height',maxValue+'px');
								$(this).css('width',innerItemWidth+'px');
							});
							
							// // Calc Required Left Margin
							var marginLeft = (totalItemWidth - parentWidth)/2;
							var subLeft = parentLeft - marginLeft;

							// If Left Position Is Negative Set To Left Margin
							if(subLeft < 0){
								$('.sub-container',this).css('left','0');
							} else {
								$('.sub-container',this).css('left',parentLeft+'px').css('margin-left',-marginLeft+'px');
							}
							
							// Calculate Row Height
							$('.row',mainSub).each(function(){
								var rowHeight = $(this).height();
								$('.dropdown-hdr',this).css('height',rowHeight+'px');
								$(this).parent('.row').css('height',rowHeight+'px');
							});
							$(mainSub).hide();
					
						} else {
							$('.sub-container',this).addClass('non-dropdown').css('left',parentLeft+'px');
						}
					}
				});
				// Set position of dropdown dropdown to bottom of main menu
				var menuHeight = $('> li > a',$dcdropdownMenuObj).outerHeight(true);
				$('.sub-container',$dcdropdownMenuObj).css({top: menuHeight+'px'}).css('z-index','1000');
				// HoverIntent Configuration
				var config = {
					sensitivity: 2, // number = sensitivity threshold (must be 1 or higher)
					interval: 100, // number = milliseconds for onMouseOver polling interval
					over: dropdownOver, // function = onMouseOver callback (REQUIRED)
					timeout: 400, // number = milliseconds delay before onMouseOut
					out: dropdownOut // function = onMouseOut callback (REQUIRED)
				};
				$('li',$dcdropdownMenuObj).hoverIntent(config);
			}
		});
	};
})(jQuery);