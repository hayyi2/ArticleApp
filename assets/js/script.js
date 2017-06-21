function numbering() {
	$('[numbering]').each(function(i) {
		var el = $(this);
		$(this).find(el.attr('numbering')).text(++i + ". ");
	});
}
function addtinymce() {
	tinymce.init({
		selector: '.tinymce',
		height: 100,
		theme: 'modern',
		menubar:false,
		skin : 'light',
		plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime media table nonbreaking save table contextmenu directionality',
			'paste textcolor colorpicker textpattern charmap',
		],
		toolbar1: 'insertfile undo | | redo bold underline italic | | alignleft aligncenter alignright alignjustify | | bullist numlist | | outdent indent | | table charmap | | fullscreen',
		elementpath: false,
		// content_css : "/public/altra/plugins/tinymce/mycontent.css",
		content_style: "p, ul, ol{ font-family: 'Arial', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.42857143; color: #333333;}"
	});

	tinymce.init({
		selector: '.tinymce-lg',
		height: 250,
		theme: 'modern',
		menubar:false,
		skin : 'light',
		plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime media table nonbreaking save table contextmenu directionality',
			'paste textcolor colorpicker textpattern',
		],
		toolbar1: 'insertfile undo | | redo bold underline italic | | alignleft aligncenter alignright alignjustify | | bullist numlist | | outdent indent | | table | | fullscreen',
		elementpath: false,
		// content_css : "/public/altra/plugins/tinymce/mycontent.css",
		content_style: "p, ul, ol{ font-family: 'Arial', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.42857143; color: #333333;}"
	});
}
$(document).ready(function(){ 
	numbering();
	addtinymce();

	$('[data-toggle="tooltip"]').tooltip();

	/******************************************
	 :: Toggle
	 ******************************************/
	 
	$('[data-toggle-checkbox=display]').change(function(event) {
		var el = $(this);
		if($(el).attr('type') == 'checkbox' ){
			if( el.is(':checked') ) {
				$( el.attr('target-display') ).show();
			} else {
				$( el.attr('target-display') ).hide();
			}
		}
	}).change();

	$('[data-toggle-change_class]').click(function(event) {
		var el = $(this);
		var target = $(el.attr('data-toggle-change_class'));

		target.addClass(target.attr('change-to'));
		target.removeClass(target.attr('change-from'));
		var class_form = target.attr('change-from');
		target.attr('change-from', target.attr('change-to'));
		target.attr('change-to', class_form);

		return false;
	});

	$('[data-toggle-display]').click(function(event) {
		var el = $(this);
		var target = $( el.attr('data-toggle-display') );
		if( target.attr('display') == "none" ) {
			target.show();
			target.attr('display', "display");
		} else {
			target.hide();
			target.attr('display', "none");
		}

		return false;
	});

	$('[confirm]').click(function(event) {
		return confirm($(this).attr('confirm'));
	});
});
function add_attr(i) {
	$('[body-add-attr] [add-attr-key]').each(function(event) {
		var el = $(this);
		el.attr($(this).attr('add-attr-key'), "");
		el.removeAttr("add-attr-key");
	});

	$('[body-add-attr] [add-attr-name]').each(function(event) {
		var el = $(this);
		el.attr("name", "quation["+i+"]["+$(this).attr('add-attr-name')+"]");
		el.removeAttr("add-attr-name");
	});

	$('[body-add-attr] [add-attr-name-file]').each(function(event) {
		var el = $(this);
		el.attr("name", $(this).attr('add-attr-name-file')+$i);
		el.removeAttr("add-attr-name-file");
	});
}

$(document).on('click', '[alfa-add]', function(event) {
	var el = $(this);
	var master = $( el.attr('alfa-add') + ' #alfa-master' );

	$(master.html()).appendTo(el.attr('alfa-add'));
	add_attr(parseInt(master.attr('no-list')) + 1);
	master.attr('no-list', parseInt(master.attr('no-list'))+1);
	numbering();
});

$(document).on('click', '[alfa-remove]', function(event) {
	var el = $(this);

	el.parents(el.attr('alfa-remove')).remove();
	numbering();
});

$(document).on('click', '[remove-disabled-show]', function(event) {
	var el = $(this);

	$(el.attr('remove-disabled-show')).show();
	$(el.attr('remove-disabled-show')).removeAttr('disabled');
});

$(document).on('click', '[remove-disabled]', function(event) {
	var el = $(this);

	$(el.attr('remove-disabled')).removeAttr('disabled');
});

$(document).on('click', '[remove]', function(event) {
	var el = $(this);

	el.parents(el.attr('remove')).remove();
	return false; 
});

// Examination

$(document).ready(function(){
	var el = $('[countdown-timer]');

	var time = parseInt(el.attr('countdown-timer'));
	var hours = Math.floor(time/60);
	var minut = Math.floor(time%60);
	var secont = 0;
	
	function show_time() {
		$('#hours').text(hours + " Jam ");
		$('#minut').text(minut + " Menit ");
		$('#secont').text(secont + " Detik ");
	}

	show_time();
	countdown();

	function countdown() {
		if (secont == 0) {
			if (minut == 0) {
				if (hours == 0) {
					$('[give-confirm]').removeAttr('give-confirm').click();
				}else{
					minut = 59;
					secont = 59;
					--hours;
				}
			}else{
				secont = 59;
				--minut;
			}
		}else{
			--secont;
		}

		show_time();

		if (hours == 0 && minut < 9  && secont != 0 ) {
			$('#message #content-message').html("Waktu pengerjaan kurang dari 10 Menit.");
			$('#message').show();
			$('#message').addClass("text-warning");
		}

		if (hours == 0 && minut == 0 && secont == 0) {
			$('#message #content-message').html("Waktu pengerjaan sudah habis. Akan Tersubmit secara otomatis.");
			$('#message').removeClass("text-warning");
			$('#message').addClass("text-danger");
		}

		setTimeout(countdown, 1000);
	}
	
}); 

$(document).ready(function(){
	var el = $('[timing]');

	var hours2 = 0;
	var minut2 = 0;
	var secont2 = 0;
	
	function set_time() {
		el.attr("value", hours2 + ":" + minut2 + ":" + secont2);
	}

	set_time();
	count();

	function count() {
		if (secont2 == 59) {
			if (minut2 == 59) {
				minut2 = 0;
				secont2 = 0;
				++hours2;
			}else{
				secont2 = 0;
				++minut2;
			}
		}else{
			++secont2;
		}

		set_time();
		setTimeout(count, 1000);
	}
	
}); 

function jumlah_checked() {
	var check = 0;
	$('input[type=radio]').each(function(event) {
		var el = $(this);
		if (el.is(':checked')) {
			check++;
		}
	});
	return check;
}

$(document).on('click', '[answer]', function(event) {
	var el = $(this);

	var element = '<span class="label label-primary">'+$(this).attr('answer')+'</span>';
	
	$(el.attr('target') + ' sup').html(element);

	if ($('[start]').attr('start') < $('[arrow-max]').attr('arrow-max') && !$('[give-confirm]').hasClass("btn-primary")) {
		$('[arrow-next]').addClass("btn-primary");
	}else {
		$('[give-confirm]').addClass("btn-primary");
	}
});

$(document).on('click', '[eraser-amswer]', function(event) {
	var el = $(this);
	var target = $(el.attr('eraser-amswer') + ' input[type=radio]');

	target.prop("checked", false);
	$(target.attr('target') + ' sup').html("");

	return false;
});

$(document).on('click', '[arrow-next]', function(event) {
	var el = $(this);
	if ($('[start]').attr('start') < $('[arrow-max]').attr('arrow-max')) {
		var position = $('[start]');

		$('#quation' + (parseInt(position.attr('start')))).hide();
		position.attr('start', (parseInt(position.attr('start'))+1));
		$('#quation' + (parseInt(position.attr('start')))).show();


		el.removeClass("btn-primary");
	}
});

$(document).on('click', '[arrow-previous]', function(event) {
	var el = $(this);
	if ($('[start]').attr('start') > $('[arrow-min]').attr('arrow-min')) {
		var position = $('[start]');

		$('#quation' + (parseInt(position.attr('start')))).hide();
		position.attr('start', (parseInt(position.attr('start'))-1));
		$('#quation' + (parseInt(position.attr('start')))).show();


		el.removeClass("btn-primary");
	}
});

$(document).on('click', '[to-number]', function(event) {
	var el = $(this);
	$("ol#list-quation").attr('start', el.attr('to-number'));
	$("ol#list-quation li[id]").hide();
	$('#quation' + el.attr('to-number')).show();
});

$(document).on('click', '[give-confirm]', function(event) {
	return confirm("Apakah anda ingin menyelesaikan ujian dengan menjawab " + jumlah_checked() + " Soal dari "+ $('[arrow-max]').attr('arrow-max') + " Soal? Jika iya tekan Oke.");
});

$(document).on('click', '[isset-empty-tab] button[type=submit]', function(event) {
	var el = $('[isset-empty-tab]');
	var tab = el.attr('isset-empty-tab');
	$(tab + ' input[required]').each(function(i) {
		var el2 = $(this);
		if (el2.val() == "") {
			$('a[tab='+tab.substr(1)+']').tab('show');
			el2.focus();
		}
	});
});
