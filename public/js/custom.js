/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var URL = window.location.href.split('?')[0],
    $BODY = $('body'),
    $MENU_TOGGLE = $('#menu_toggle'),
    $SIDEBAR_MENU = $('#sidebar-menu'),
    $SIDEBAR_FOOTER = $('.sidebar-footer'),
    $LEFT_COL = $('.left_col'),
    $RIGHT_COL = $('.right_col'),
    $NAV_MENU = $('.nav_menu'),
    $FOOTER = $('footer');

// Sidebar



$(document).ready(function() {
    localStorage.removeItem('bg_color');
    /*
    if(localStorage.getItem('bg_color') != ''){
        $('body').removeClass('body_blue body_red body_dark_blue body_green body_indigo');
        $('body').addClass(localStorage.getItem('bg_color'));        
     }else{
        $('body').addClass(localStorage.getItem('bg_color')); 
     }
  
      $('.default_temp').on('click',function(){
        var bg = $(this).attr('bg');
        $('body').removeClass('body_blue body_red body_dark_blue body_green body_indigo');
        $('body').addClass(bg);
        localStorage.setItem('bg_color', bg);
      });*///end

      
    //Favicon
    // TODO: This is some kind of easy fix, maybe we can improve this
    var setContentHeight = function() {
        // reset height
        $RIGHT_COL.css('min-height', $(window).height());

        var bodyHeight = $BODY.height(),
            leftColHeight = $LEFT_COL.eq(1).height() + $SIDEBAR_FOOTER.height(),
            contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;

        // normalize content
        contentHeight -= $NAV_MENU.height() + $FOOTER.height();

        $RIGHT_COL.css('min-height', contentHeight);
    };

    $SIDEBAR_MENU.find('a').on('click', function(ev) {
        var $li = $(this).parent();

        if ($li.is('.active')) {
            $li.removeClass('active');
            $('ul:first', $li).slideUp(function() {
                setContentHeight();
            });
        } else {
            // prevent closing menu if we are on child menu
            if (!$li.parent().is('.child_menu')) {
                $SIDEBAR_MENU.find('li').removeClass('active');
                $SIDEBAR_MENU.find('li ul').slideUp();
            }

            $li.addClass('active');

            $('ul:first', $li).slideDown(function() {
                setContentHeight();
            });
        }
    });

    // toggle small or large menu
    $MENU_TOGGLE.on('click', function() {
        if ($BODY.hasClass('nav-md')) {
            $BODY.removeClass('nav-md').addClass('nav-sm');
            $LEFT_COL.removeClass('scroll-view').removeAttr('style');

            if ($SIDEBAR_MENU.find('li').hasClass('active')) {
                $SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
            }
        } else {
            $BODY.removeClass('nav-sm').addClass('nav-md');

            if ($SIDEBAR_MENU.find('li').hasClass('active-sm')) {
                $SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
            }
        }

        setContentHeight();
    });

    // check active menu
    $SIDEBAR_MENU.find('a[href="' + URL + '"]').parent('li').addClass('current-page');

    $SIDEBAR_MENU.find('a').filter(function() {
        return this.href == URL;
    }).parent('li').addClass('current-page').parents('ul').slideDown(function() {
        setContentHeight();
    }).parent().addClass('active');
    //if (URL.indexOf("view_company") >= 0)
    //$li.addClass('active');

    // recompute content when resizing
    $(window).smartresize(function() {
        setContentHeight();
    });
});
// /Sidebar

// Panel toolbox
$(document).ready(function() {
    $('.collapse-link').on('click', function() {
        var $BOX_PANEL = $(this).closest('.x_panel'),
            $ICON = $(this).find('i'),
            $BOX_CONTENT = $BOX_PANEL.find('.x_content');

        // fix for some div with hardcoded fix class
        if ($BOX_PANEL.attr('style')) {
            $BOX_CONTENT.slideToggle(200, function() {
                $BOX_PANEL.removeAttr('style');
            });
        } else {
            $BOX_CONTENT.slideToggle(200);
            $BOX_PANEL.css('height', 'auto');
        }

        $ICON.toggleClass('fa-chevron-up fa-chevron-down');
    });

    $('.close-link').click(function() {
        var $BOX_PANEL = $(this).closest('.x_panel');

        $BOX_PANEL.remove();
    });
});
// /Panel toolbox

// Tooltip
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });
});
// /Tooltip

// Progressbar
// if ($(".progress .progress-bar")[0]) {
//     $('.progress .progress-bar').progressbar(); // bootstrap 3
// }
// /Progressbar

// Switchery
$(document).ready(function() {
    if ($(".js-switch")[0]) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, {
                color: '#26B99A'
            });
        });
    }
});
// /Switchery

// iCheck
$(document).ready(function() {
    if ($("input.flat")[0]) {
        $(document).ready(function() {
            $('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
        });
    }
});
// /iCheck

// Table
$('table input').on('ifChecked', function() {
    checkState = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('table input').on('ifUnchecked', function() {
    checkState = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});

var checkState = '';

$('.bulk_action input').on('ifChecked', function() {
    checkState = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('.bulk_action input').on('ifUnchecked', function() {
    checkState = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});
$('.bulk_action input#check-all').on('ifChecked', function() {
    checkState = 'all';
    countChecked();
});
$('.bulk_action input#check-all').on('ifUnchecked', function() {
    checkState = 'none';
    countChecked();
});

function countChecked() {
    if (checkState === 'all') {
        $(".bulk_action input[name='table_records']").iCheck('check');
    }
    if (checkState === 'none') {
        $(".bulk_action input[name='table_records']").iCheck('uncheck');
    }

    var checkCount = $(".bulk_action input[name='table_records']:checked").length;

    if (checkCount) {
        $('.column-title').hide();
        $('.bulk-actions').show();
        $('.action-cnt').html(checkCount + ' Records Selected');
    } else {
        $('.column-title').show();
        $('.bulk-actions').hide();
    }
}

// Accordion
$(document).ready(function() {
    $(".expand").on("click", function() {
        $(this).next().slideToggle(200);
        $expand = $(this).find(">:first-child");

        if ($expand.text() == "+") {
            $expand.text("-");
        } else {
            $expand.text("+");
        }
    });
});

// NProgress
if (typeof NProgress != 'undefined') {
    $(document).ready(function() {
        NProgress.start();
    });

    $(window).load(function() {
        NProgress.done();
    });
}

/**
 * Resize function without multiple trigger
 * 
 * Usage:
 * $(window).smartresize(function(){  
 *     // code here
 * });
 */
   
(function($, sr) {
    // debouncing function from John Hann
    // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
    var debounce = function(func, threshold, execAsap) {
        var timeout;

        return function debounced() {
            var obj = this,
                args = arguments;

            function delayed() {
                if (!execAsap)
                    func.apply(obj, args);
                timeout = null;
            }

            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);

            timeout = setTimeout(delayed, threshold || 100);
        };
    };

    // smartresize 
    jQuery.fn[sr] = function(fn) { return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery, 'smartresize');








/****************** Check and  Uncheck all checkbox **********************/
$(document).ready(
    function() {
        //clicking the parent checkbox should check or uncheck all child checkboxes

        $(document).on('click', ".parentCheckBox", function() {
            $(this).closest('table').find('.childCheckBox').prop('checked', this.checked);
            //$(this).parents('tabel').find('.childCheckBox').attr('checked', this.checked);

            $(this).closest('table').find('.childCheckBox').each(function() {
                if (this.checked == false) {
                    flag = false;
                }
                if ($(this).prop('checked')) {
                    console.log('checked');
                    var share_id = $(this).closest('tr').attr('share_id');
                    $(this).closest('tr').addClass('scno_active');
                    $(this).closest('table').find('.sid_' + share_id).addClass('scno_active');
                } else {
                    console.log('Unchecked');
                    var share_id = $(this).closest('tr').attr('share_id');
                    $(this).closest('tr').removeClass('scno_active');
                    $(this).closest('table').find('.sid_' + share_id).removeClass('scno_active');
                }
            });
        });
        //clicking the last unchecked or checked checkbox should check or uncheck the parent checkbox

        $(document).on('click', ".childCheckBox", function() {
            var flag = true;
            $(this).closest('table').find('.childCheckBox').each(
                function() {
                    if (this.checked == false)
                        flag = false;
                }
            );
            $(this).closest('table').find('.parentCheckBox').prop('checked', flag);

            //Specific for share Crt no //
            if ($(this).prop('checked')) {
                console.log('checked');
                var share_id = $(this).closest('tr').attr('share_id');
                $(this).closest('tr').addClass('scno_active');
                $(this).closest('table').find('.sid_' + share_id).addClass('scno_active');
            } else {
                console.log('Unchecked');
                var share_id = $(this).closest('tr').attr('share_id');
                $(this).closest('tr').removeClass('scno_active');
                $(this).closest('table').find('.sid_' + share_id).removeClass('scno_active');
            }
            // END //
        });
    }
);
/**************************** End ***************************************/
$(document).ready(function() {

}); //end fun

function check_function_new(date_of_fye) {
    //console.log("test1"+date_of_fye);
    var tmp = null;
    if(date_of_fye!='' && date_of_fye!=undefined){
        $.ajax({
            'async': false,
            type: 'POST',
            dataType: 'json',
            url: script_file_base_url + '/mainadmin/check_validateDate_new',
            data: {
                [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val(),
                date_of_fye: date_of_fye
            },
            success: function(obj) {
                tmp = obj.is_date;
                $('.txt_csrfname').val(obj.token);
            }
        });
    }
    return tmp;
}

function dateToHowManyAgo(stringDate){
    var currDate = new Date();
    var diffMs=currDate.getTime() - new Date(stringDate).getTime();
    var sec=diffMs/1000;
    if(sec<60)
        return parseInt(sec)+' second'+(parseInt(sec)>1?'s':'')+' ago';
    var min=sec/60;
    if(min<60)
        return parseInt(min)+' minute'+(parseInt(min)>1?'s':'')+' ago';
    var h=min/60;
    if(h<24)
        return parseInt(h)+' hour'+(parseInt(h)>1?'s':'')+' ago';
    var d=h/24;
    if(d<30)
        return parseInt(d)+' day'+(parseInt(d)>1?'s':'')+' ago';
    var m=d/30;
    if(m<12)
        return parseInt(m)+' month'+(parseInt(m)>1?'s':'')+' ago';
    var y=m/12;
    return parseInt(y)+' year'+(parseInt(y)>1?'s':'')+' ago';
}

///////////////////////////////////////////New Script for date Mask//////////////////////////////////////////
function initializeDateMask(selector) {
    const elements = document.querySelectorAll(selector);

    elements.forEach(element => {
        element.addEventListener('input', function(event) {
            let value = event.target.value;
            value = value.replace(/[^\d/]/g, ''); 

            if (value.length > 0) {
                const day = parseInt(value.charAt(0));
                if (isNaN(day) || day > 3) {
                    value = '0' + day;
                }
            }
            if (value.length > 1) {
                const day = parseInt(value.charAt(0));
                const nextDigit = parseInt(value.charAt(1));
                if (day === 3 && nextDigit > 1) {
                    value = '31';
                }
            }

            if (value.length > 3) {
                const month = parseInt(value.charAt(3));
                if (isNaN(month) || month > 1) {
                    value = value.substring(0, 3) + '0' + month;
                }
            }
            if (value.length > 4) {
                const month = parseInt(value.charAt(3));
                const nextDigit = parseInt(value.charAt(4));
                if (month === 1 && nextDigit > 2) {
                    value = value.substring(0, 4) + '12';
                }
            }

            if (value.length > 2 && value.charAt(2) !== '/') {
                value = value.slice(0, 2) + '/' + value.slice(2); 
            }
            if (value.length > 5 && value.charAt(5) !== '/') {
                value = value.slice(0, 5) + '/' + value.slice(5); 
            }

            if (value.length > 10) {
                value = value.substring(0, 10); 
            }

            event.target.value = value;
        });
    });
}



function addDateValidator(selector) {
    const elements = document.querySelectorAll(selector);

    elements.forEach(element => {
        let errorElement = null;
        let isUserInput = false;

        element.addEventListener('blur', function(event) {
            const value = event.target.value.trim();
            const isValidDate = /^\d{2}\/\d{2}\/\d{4}$/.test(value);

            if (isUserInput && value !== '' && !isValidDate) {
                showError();
            }
        });

        element.addEventListener('input', function() {
            isUserInput = true;
        });

        element.addEventListener('change', function(event) {
            const value = event.target.value.trim();
            const isValidDate = /^\d{2}\/\d{2}\/\d{4}$/.test(value);

            if (value === '') {
                hideError(); // Clear error message if the field is empty
            } else if (!isValidDate) {
                showError();
            } else {
                hideError();
            }
        });

        function showError() {
            if (!errorElement) {
                errorElement = document.createElement('div');
                errorElement.className = 'error-message';
                errorElement.style.color = 'red';
                element.parentNode.insertBefore(errorElement, element.nextSibling);
            }
            errorElement.innerText = `Please enter a valid date in the format DD/MM/YYYY`;
        }

        function hideError() {
            if (errorElement) {
                errorElement.remove(); // Remove error message
                errorElement = null;
            }
        }
    });
}


  // how to call these functions
  // initializeDateMask('.date_validator');
  // addDateValidator('.date_validator');
  
///////////////////////////////////////////End New Script for date Mask//////////////////////////////////////////


if (typeof crm_initializeYearPicker !== 'function') {
    function crm_initializeYearPicker(inputSelector) {
        $(inputSelector).on('click', function () {
            // Check if a year picker already exists
            if ($('.crm-year-picker').length) {
                // If it exists, just focus on the existing picker and return
                $('.crm-year-picker').show();
                return;
            }

            // Create the year picker
            const yearPickerHtml = $('<div class="crm-year-picker"></div>');

            const startYear = moment().year();
            for (let year = startYear - 15; year <= startYear + 15; year++) {
                yearPickerHtml.append(`<div class="crm-year" data-year="${year}">${year}</div>`);
            }

            // Show year picker
            $(this).after(yearPickerHtml);

            // Handle year selection
            yearPickerHtml.on('click', '.crm-year', function (e) {
                e.stopPropagation(); // Prevent closing the picker when clicking on a year

                $(this).toggleClass('selected'); // Toggle the selected state

                const selectedYears = yearPickerHtml.find('.crm-year.selected').map(function() {
                    return $(this).data('year');
                }).get();

                // If two years are selected, format it as "YYYY/YYYY"
                if (selectedYears.length === 2) {
                    $(inputSelector).val(`${selectedYears[0]}/${selectedYears[1]}`);
                    yearPickerHtml.remove(); // Hide picker
                } else if (selectedYears.length > 2) {
                    alert("Please select only two years.");
                }
            });

            // Hide the year picker when clicking outside
            $(document).on('click', function (e) {
                if (!$(e.target).closest(inputSelector).length && !$(e.target).closest('.crm-year-picker').length) {
                    yearPickerHtml.remove();
                }
            });
        });
    }
}
