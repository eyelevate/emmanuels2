$(document).ready(function(){
	layouts.events();
});

layouts = {
	events: function() {
		$('[data-toggle="offcanvas"]').click(function () {
			$('.row-offcanvas').toggleClass('active').toggleClass('side-toggle');
		});
		$(window).resize(function () {
			if ($(window).width() < 768) {
				$('.row-offcanvas').removeClass('animate');
			} else {
				$('.row-offcanvas').addClass('animate');
			}
		});
	}

};



(function($) {
    $.fn.clickToggle = function(func1, func2) {
        var funcs = [func1, func2];
        this.data('toggleclicked', 0);
        this.click(function() {
            var data = $(this).data();
            var tc = data.toggleclicked;
            $.proxy(funcs[tc], this)();
            data.toggleclicked = (tc + 1) % 2;
        });
        return this;
    };
}(jQuery));
