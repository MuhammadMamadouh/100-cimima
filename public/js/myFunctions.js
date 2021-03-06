$(document).ready(function () {
    $('.input').on('focus', function () {
        $(this).attr('data-place', $(this).attr('placeholder'));
        $(this).attr('placeholder', '')
    });
    $('.input').on('blur', function () {
        $(this).attr('placeholder', $(this).attr('data-place'))
    });

    function checkAll() {
        $('input[class="item_checkbox"]:checkbox').each(function () {
            if ($('input[class="check_all"]:checkbox:checked').length == 0) {
                $(this).prop('checked', !1)
            } else {
                $(this).prop('checked', !0)
            }
        })
    }

    function delete_all() {
        $(document).on('click', '.delAll', function () {
            $('#form_data').submit()
        });
        $(document).on('click', '.delBtn', function () {
            $(document).on('click', '.del_all', function () {
                $('#form_data').submit()
            });
            var itemChecked = $('input[class="item_checkbox"]:checkbox').filter(":checked").length;
            if (itemChecked > 0) {
                $('.record_count').text(itemChecked);
                $('.not_empty_record').removeClass('hidden');
                $('.empty_record').addClass('hidden')
            } else {
                $('.record_count').text('');
                $('.not_empty_record').addClass('hidden');
                $('.empty_record').removeClass('hidden')
            }
            $('#mutlipleDelete').modal('show')
        });
        $('.carousel').carousel()
    }

    $('textarea').on('keyup', function () {
        var el = this;
        setTimeout(function () {
            el.style.cssText = 'height:auto; padding:0';
            el.style.cssText = '-moz-box-sizing:content-box';
            el.style.cssText = 'height:' + el.scrollHeight + 'px'
        }, 0)
    });
    var readURL = function (input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.result-pic').attr('src', e.target.result)
            };
            reader.readAsDataURL(input.files[0])
        }
    };
    $(".file-upload").on('change', function () {
        readURL(this)
    });
    $(".upload-button").on('click', function () {
        $(".file-upload").click()
    });
    $('.js-description_readmore').moreLines({
        linecount: 1,
        baseclass: 'b-description',
        basejsclass: 'js-description',
        classspecific: '_readmore',
        buttontxtmore: "read more",
        buttontxtless: "read less",
        animationspeed: 250
    });
    $('#search_bar').on('keyup', function () {
        var input = $(this).val();
        if (input !== '') {
            var query = input.replace(' ', '+');
            $('#searchMenu').load('http://localhost/imdb/search?query=' + query)
        }
    })
});