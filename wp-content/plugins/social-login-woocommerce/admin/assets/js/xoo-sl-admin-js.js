jQuery(document).ready(function($){

	$('select[name="xoo-sl-gl-options[gl-btn-type]"]').on('change', function(){
		var $googid 	= $('select[name="xoo-sl-goo-options[btn-type]"]'),
			$appleid 	= $('select[name="xoo-sl-apl-options[btn-mode]"]'),
			$layout   	= $('select[name="xoo-sl-gl-options[gl-btn-layout]"]'),
			$iconSize 	= $('select[name="xoo-sl-gl-options[gl-iconsize]"]'),
			$iconSizeSt = $iconSize.closest('.xoo-as-setting'),
			val 		= $(this).val();

		if( val === 'icon' ){
			$googid.val('icon');
			$appleid.val('logo-only');
			$layout.val('one_line');
			$iconSizeSt.show();

		}
		else{
			$googid.val('standard');
			$appleid.val('center-align');
			$iconSizeSt.hide();
		}
		$googid.add($appleid).add($layout).add($iconSize).trigger('change');
	})


	$('select[name="xoo-sl-gl-options[gl-iconsize]"]').on('change', function(){
		var $googid 	= $('select[name="xoo-sl-goo-options[btn-size]"]'),
			val 		= $(this).val();

		$googid.val(val).trigger('change');
	})


})