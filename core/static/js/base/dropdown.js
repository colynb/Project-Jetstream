/* ============================================================
 * bootstrap-dropdown.js v1.4.0
 * http://twitter.github.com/bootstrap/javascript.html#dropdown
 * ============================================================
 * Copyright 2011 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */


!function( $ ){

    "use strict"

    /* DROPDOWN PLUGIN DEFINITION
   * ========================== */

    $.fn.dropdown = function ( selector ) {
	return this.each(function () {
	    $(this).delegate(selector || d, 'click', function (e) {
		e.preventDefault();
		var li = $(this).parent('li')
		, isActive = li.hasClass('open');


		clearMenus();
		!isActive && li.toggleClass('open');

		if (!isActive) {
		    $(window).trigger('dropdown.opened');
		}


		return false;
	    })
	})
    }

    /* APPLY TO STANDARD DROPDOWN ELEMENTS
   * =================================== */

    var d = 'a.menu, .dropdown-toggle'

    function clearMenus() {
	$(d).parent('li').removeClass('open');
    }

    $(function () {


	$('html').bind('click', clearMenus);
	// Added custom event for clearing the menu
	$(d).parent('li').bind('mouseover', function(e){
	    $('html').unbind('click');
	});

	$(d).parent('li').bind('mouseleave', function(e){
	    $('html').bind('click', clearMenus);
	});

	$('body').dropdown( '[data-dropdown] a.menu, [data-dropdown] .dropdown-toggle' )
    })

}( window.jQuery || window.ender );


