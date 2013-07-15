App.Content = {

	init: function() {
		this.initDashboard();
		this.initSelectboxes();
		this.initInviteConfirmation();
	},

	initDashboard: function() {
		$(".panel .toggle").click(function() {
			var $el     = $(this);
			var $panel  = $el.closest("li");
			var $people = $panel.find(".people");

			$people.slideToggle(100);

			return false;
		});
	},

	initSelectboxes: function() {
		if ( ! this.isMobile()) {
			$(".select2").select2({
				width: "100%",
				placeholder: "Biraj...",
				allowClear: true
			});

			$(".multiselect").multiselect({
				buttonClass: 'btn',
				buttonWidth: '100%'
			});
		}
	},

	initInviteConfirmation: function() {
		var $ok     = $(".invitations-confirm .form-actions .button-yes");
		var $no     = $(".invitations-confirm .form-actions .button-no");
		var $form   = $(".invitations-confirm form");
		var $method = $(".invitations-confirm input[name=_method]");

		$ok.click(function() {
			$method.val('PUT');
			$form.submit();
			return false;
		});

		$no.click(function() {
			$method.val('DELETE');
			$form.submit();
			return false;
		});

	},

	isMobile: function() {
		if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) return true;

		return false;
	}

};
