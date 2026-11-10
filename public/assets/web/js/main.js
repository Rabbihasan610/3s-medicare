

// image upload
function proPicURL(input) {
	if (input.files && input.files[0]) {
		console.log(input);
		var reader = new FileReader();
		reader.onload = function (e) {
			var preview = $(input).closest('.image-upload-wrapper').find('.image-upload-preview');
			$(preview).css('background-image', 'url(' + e.target.result + ')');
			$(preview).addClass('has-image');
			$(preview).hide();
			$(preview).fadeIn(650);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

$(".image-upload-input").on('change', function () {
	proPicURL(this);
});


$("form").on("change", ".file-upload-field", function () {
	$(this).parent(".file-upload-wrapper").attr("data-text", $(this).val().replace(/.*(\/|\\)/, ''));
});


$('.d-submenu.mm-active > .mm-active').find('.fa-regular').removeClass('fa-circle').addClass('fa-circle-dot');


// image upload end


function highlightWordAtIndex() {
    var h5 = $(".highlight-text");
    var text = h5.text();
    var words = text.split(' ');

    if (words.length > 2) {
        var firstPart = words.slice(0, 3).join(' ');
        var middlePart = words[2];
        var lastPart = words.slice(3, words.length).join(' ');

        console.log(middlePart);

        h5.html(firstPart + ' <span class="highlight">' + middlePart + '</span> ' + lastPart);
    }
}

highlightWordAtIndex();
