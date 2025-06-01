(function ($) {
    "use strict";
    
    // Dropdown on mouse hover
    // $(document).ready(function () {
    //     function toggleNavbarMethod() {
    //         if ($(window).width() > 992) {
    //             $('.navbar .dropdown').on('mouseover', function () {
    //                 $('.dropdown-toggle', this).trigger('click');
    //             }).on('mouseout', function () {
    //                 $('.dropdown-toggle', this).trigger('click').blur();
    //             });
    //         } else {
    //             $('.navbar .dropdown').off('mouseover').off('mouseout');
    //         }
    //     }
    //     toggleNavbarMethod();
    //     $(window).resize(toggleNavbarMethod);
    // });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Vendor carousel
    $('.vendor-carousel').owlCarousel({
        loop: true,
        margin: 29,
        nav: false,
        autoplay: true,
        smartSpeed: 1000,
        responsive: {
            0:{
                items:2
            },
            576:{
                items:3
            },
            768:{
                items:4
            },
            992:{
                items:5
            },
            1200:{
                items:6
            }
        }
    });


    // Related carousel
    $('.related-carousel').owlCarousel({
        loop: true,
        margin: 29,
        nav: false,
        autoplay: true,
        smartSpeed: 1000,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:2
            },
            768:{
                items:3
            },
            992:{
                items:4
            }
        }
    });


    // Product Quantity
    $('.quantity button').on('click', function () {
        var button = $(this);
        var oldValue = button.parent().parent().find('input').val();
        if (button.hasClass('btn-plus')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        button.parent().parent().find('input').val(newVal);
    });

    $('.datatable').DataTable()

    $(document).on('click','#btn-toggle-sidebar',function(e){
        e.preventDefault();
        $('body').toggleClass('panel-sidebar-collapse')
    })
    
})(jQuery);


function randId(length) {
    var result = "";
    var characters =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(
            Math.floor(Math.random() * charactersLength)
        );
    }
    return result;
}

function passwordInputRender() {
    let passwordInput = $(".input-password");

    if (passwordInput.length) {
        passwordInput.each(function (i, el) {
            let _this = $(el);
            let _html = _this.html();
            let _label = $(_this.find("label")).get(0).outerHTML;
            let _input = $(_this.find("input")).get(0).outerHTML;
            let btnIds = randId(9);

            _this.removeClass("input-password");

            let replaceInput = `<div class="input-password">
                                ${_input}
                                <span class="input-password-eye-icon" __${btnIds}></span>
                            </div>`;

            _this.find("input").replaceWith(replaceInput);

            $(document).on("click", "[__" + btnIds + "]", function (e) {
                e.preventDefault();
                let inputPwd = $(this).parents(".input-password").find("input");

                if (inputPwd.attr("type") == "password") {
                    inputPwd.attr("type", "text");
                    $(this).addClass("show");
                } else {
                    inputPwd.attr("type", "password");
                    $(this).removeClass("show");
                }
            });
        });
    }
}

passwordInputRender();

$(document).ready(function(){

    function showImageUploader(file,target){
        
        if(file && file[0])
        {
            if (file[0].type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    $(target).attr('src',event.target.result)
                };
                reader.readAsDataURL(file[0]);
            }
        }

    }
    
    let uploadViewer = $('input.upload-viewer')

    uploadViewer.each(function(i,el){
        let _this = $(el)

        _this.attr('accept','.jpg,.png,.jpeg')

        $(document).on('change',_this, function(e){
            showImageUploader(e.target.files,_this.attr('data-target'))
        })

    })
    
})