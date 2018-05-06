window.reload_hooks = [];

function addReloadHook(h) {
    window.reload_hooks.push(h);
}

function runReloadHooks() {
    for(i=0;i<window.reload_hooks.length;i++) {
        var f = window.reload_hooks[i];
        //alert(window.reload_hooks.length);
        eval(f)();
    }
}

function need_login() {
    $("#needLoginModal").modal("show");
    return false;
}
function pre_process_result(r) {

    if (r != undefined & r == 'login-is-needed') {
        $("#loginModal").modal('show');
        return  false;
    }

    if (isloggedin  == 0) {
        //show login modal
        $("#loginModal").modal('show');
        return true;
    }
    return false;

}


function my_confirm(f, m) {
    m = (m == undefined) ? window.lang.are_you_sure : m;
    swal({
      title: m,
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: window.lang.yes,
      cancelButtonText: window.lang.cancel,
      confirmButtonClass: 'btn btn-confirm-ok',
      cancelButtonClass: 'btn btn-confirm-cancel',
      buttonsStyling: true
    }).then(f)
}

function showLoader() {
    $(".load-bar").fadeIn();
}

function hideLoader() {
    $(".load-bar").fadeOut();
}

function change_lighting(t) {
    v = $(t);
    if(v.prop('checked')) {
        $('body').addClass('night_mode');
        $.ajax({
            url:baseUrl + 'turn/light?t=off'
        })
    } else {
        $('body').removeClass('night_mode');
        $.ajax({
            url:baseUrl + 'turn/light?t=on'
        })
    }
}





function notify(m, type) {
    noty({
        text:m,
        type:type,
        progressBar : true,
        timeout:4000
    });
}



function switch_exchange_currency(t) {
    var v = $(t).val();
    load_page(baseUrl+'exchanges?coin=' + v);
}

function subscribe_for_updates() {

    var socket = io.connect('https://streamer.cryptocompare.com/');
    var subscription = get_coin_on_page();
    socket.emit('SubAdd', { subs: subscription });
    if ($("#exchangeDataTableList").length > 0 || $("#tradeDataTableList").length > 0) {
        var fsym = $("#exchangeDataTableList").data('coin');
        if (fsym == undefined) fsym = $("#tradeDataTableList").data('coin');
        var tsym = base_currency;
        var dataUrl = "https://min-api.cryptocompare.com/data/subs?fsym=" + fsym + "&tsyms=" + tsym;
        showLoader();
        $.getJSON(dataUrl, function(data) {
            if ($("#exchangeDataTableList").length > 0) {
                currentSubs = data[base_currency]['CURRENT'];
                var  aa = currentSubs;

                for(i=0;i<aa.length;i++) {
                    var subsA = aa[i];

                    var spl = subsA.split('~');
                    $("#"+spl[1]+'-detail-container').show();
                    console.log("#"+spl[1]+'-detail-container');
                }
                        var count = 0;
                        $('.coin-exchange-container').each(function() {
                            if($(this).css('display') != 'none') count = count + 1;
                        });
                        $(".exchange-count-list").html(count)
                socket.emit('SubAdd', {subs: currentSubs});
            }

            if ($("#tradeDataTableList").length > 0) {
                currentSubs = data[base_currency]['TRADES'];
                socket.emit('SubAdd', {subs: currentSubs});
            }
            hideLoader();
        });
    }


    socket.on("m", function(message) {
		var messageType = message.substring(0, message.indexOf("~"));
		var res = {};
		///console.log(messageType);

		if (messageType == CCC.STATIC.TYPE.CURRENTAGG) {
			data = CCC.CURRENT.unpack(message);
            var from = data['FROMSYMBOL'];
            var to = data['TOSYMBOL'];
            var fsym = CCC.STATIC.CURRENCY.getSymbol(from);
            var tsym = CCC.STATIC.CURRENCY.getSymbol(to);
            var pair = from + to;
            var c = $("."+from + '-detail-container');
            c.each(function() {
                var c = $(this);
               if (c.length > 0) {
                    var price = data['PRICE'];
                    var flashType = '';
                    if (price) {
                        var currentPrice = c.data('price');
                        portfolio_regulate_price(from,c,price);
                        c.data('price', price)
                        if (price > currentPrice) {
                            flashType = 'increment';
                        } else if(price < currentPrice) {
                            flashType = 'decrement';
                        }
                        if(isFiatCurrencyCoin) {
							
							
							if(price >= 1000){
		
		c.find('.price').html(accounting.formatNumber(price, 2));
		
	} else if (price >= 1)  {
		
		c.find('.price').html(accounting.formatNumber(price, 2));
		
	}  else if (price == 0)  {
		
		c.find('.price').html(accounting.formatNumber(price, 2));
		
	} else {
		
		c.find('.price').html(accounting.formatNumber(price, 6));
		
	}
							
							
							
							
                            
                        } else {
							
							if(price*base_currency_rate >= 1000){
		
		c.find('.price').html(accounting.formatNumber(price*base_currency_rate, 2));
		
	} else if (price*base_currency_rate >= 1)  {
		
		c.find('.price').html(accounting.formatNumber(price*base_currency_rate, 2));
		
	}  else if (price*base_currency_rate == 0)  {
		
		c.find('.price').html(accounting.formatNumber(price*base_currency_rate, 2));
		
	} else {
		
		c.find('.price').html(accounting.formatNumber(price*base_currency_rate, 6));
		
	}
							
						
                        }

                        var changePTC = ((data['PRICE'] - data['OPEN24HOUR']) / data['OPEN24HOUR'] * 100).toFixed(2);
                        if (changePTC != 'NaN') {
                            var changeC = c.find('.change');
                            changeC.removeClass('change-up');
                            changeC.removeClass('change-down');
                            changeC.find('i').removeClass('icon-arrow-up');
                            changeC.find('i').removeClass('icon-arrow-down');

                            if (changePTC > 0) {
                                changePTC = "<i class='icons icon-arrow-up-circle'></i> "+ changePTC;
                                changeC.addClass('change-up');
                                changeC.find('i').addClass('icon-arrow-up');
                            } else {
                                changePTC = "<i class='icons icon-arrow-down-circle'></i> "+ changePTC;
                                changeC.addClass('change-down');
                                changeC.find('i').addClass('icon-arrow-down');
                            }
                            changeC.html(changePTC+'%');
                        }


                        if (c.data('no-flash') == undefined) {
                            c.removeClass('flash-increment');
                            c.removeClass('flash-decrement');
                            c.addClass('flash-'+flashType);
                            setTimeout(function() {
                                c.removeClass('flash-'+flashType);
                            }, 300);
                        } else {
                            c.find('.price').parent().removeClass('color-increment');
                            c.find('.price').parent().removeClass('color-decrement');
                            c.find('.price').parent().addClass('color-'+flashType);
                            setTimeout(function() {
                                 c.find('.price').parent().removeClass('color-'+flashType);
                             }, 800);
                        }

                    }


                }
            });

	    } else if(messageType == CCC.STATIC.TYPE.TRADE){
            var incomingTrade = CCC.TRADE.unpack(message);
            var maxTableSize = 30;
            console.log(incomingTrade);
            var newTrade = {
                Market: incomingTrade['M'],
                Type: incomingTrade['T'],
                ID: incomingTrade['ID'],
                Price: CCC.convertValueToDisplay(base_currency_symbol, incomingTrade['P'] * base_currency_rate),
                Quantity: CCC.convertValueToDisplay('', incomingTrade['Q']),
                Total: CCC.convertValueToDisplay(base_currency_symbol, incomingTrade['TOTAL'])
            };

            if (incomingTrade['F'] & 1) {
                newTrade['Type'] = "<button class='btn btn-sm btn-success'  style='text-transform:uppercase'>"+window.lang.buy+"</button>";
            }
            else if (incomingTrade['F'] & 2) {
                newTrade['Type'] = "<button class='btn btn-sm btn-danger'  style='text-transform:uppercase'>"+window.lang.sell+"</button>";;
            }
            else {
                newTrade['Type'] = "<button class='btn btn-sm btn-secondary' style='text-transform:uppercase'>"+window.lang.unknown+"</button>";;
            }

            //display it
            var length = $('#tradeDataTableList tr').length;
            $('#tradeDataTableList #trades').after(
                "<tr class=" +  newTrade.Type + "><td><strong>" +  newTrade.Market + "</strong></td><td>" +  newTrade.Type + "</td><td>" +  newTrade.Price + "</td><td>" +  newTrade.Quantity + "</td><td>" +  newTrade.Total + "</td></tr>"
            );

            if (length >= maxTableSize) {
                $('#tradeDataTableList tr:last').remove();
            }
		} else if(messageType == CCC.STATIC.TYPE.CURRENT) {
            data = CCC.CURRENT.unpack(message);
            var market = data['MARKET'];
            var to = data['TOSYMBOL'];
            var c = $("#"+market + '-detail-container');
                   var price = data['PRICE'];
                    var flashType = '';
                    if (data['VOLUME24HOURTO'] && price) {
                        c.show();
                        var currentPrice = c.data('price');
                        c.data('price', price)
                        if (price > currentPrice) {
                            flashType = 'increment';
                        } else if(price < currentPrice) {
                            flashType = 'decrement';
                        }
                        if(!isFiatCurrencyCoin) {
    //c.find('.price-order').html(price*base_currency_rate);
                            c.find('.exchange-price').html(accounting.formatNumber(price*base_currency_rate, decimalPoint,thousandSep,decimalSep));
                            //c.find('.open').html(data['OPEN24HOUR']);
                            //c.find('.open').html(accounting.formatNumber(data['OPEN24HOUR']*base_currency_rate, decimalPoint));
                            if (data['OPEN24HOUR']) c.find('.exchange-open').html(accounting.formatNumber(data['OPEN24HOUR']*base_currency_rate, decimalPoint,thousandSep,decimalSep));
                            if (data['LOW24HOUR']) c.find('.exchange-low').html(accounting.formatNumber(data['LOW24HOUR']*base_currency_rate, decimalPoint,thousandSep,decimalSep));
                            if (data['HIGH24HOUR']) c.find('.exchange-high').html(accounting.formatNumber(data['HIGH24HOUR']*base_currency_rate, decimalPoint,thousandSep,decimalSep));
                            c.find('.exchange-volume').html(accounting.formatNumber(data['VOLUME24HOURTO']*base_currency_rate, decimalPoint,thousandSep,decimalSep));
                        } else {
    //c.find('.price-order').html(price*base_currency_rate);
                            c.find('.exchange-price').html(accounting.formatNumber(price, decimalPoint,thousandSep,decimalSep));
                            //c.find('.open').html(data['OPEN24HOUR']);
                            //c.find('.open').html(accounting.formatNumber(data['OPEN24HOUR']*base_currency_rate, decimalPoint));
                            if (data['OPEN24HOUR']) c.find('.exchange-open').html(accounting.formatNumber(data['OPEN24HOUR'], decimalPoint,thousandSep,decimalSep));
                            if (data['LOW24HOUR']) c.find('.exchange-low').html(accounting.formatNumber(data['LOW24HOUR'], decimalPoint,thousandSep,decimalSep));
                            if (data['HIGH24HOUR']) c.find('.exchange-high').html(accounting.formatNumber(data['HIGH24HOUR'], decimalPoint,thousandSep,decimalSep));
                            c.find('.exchange-volume').html(accounting.formatNumber(data['VOLUME24HOURTO'], decimalPoint,thousandSep,decimalSep));
                        }
                        var changePTC = ((data['PRICE'] - data['OPEN24HOUR']) / data['OPEN24HOUR'] * 100).toFixed(2);
                        if (changePTC != 'NaN') {
                            var changeC = c.find('.exchange-change');
                            changeC.removeClass('change-up');
                            changeC.removeClass('change-down');
                            changeC.find('i').removeClass('icon-arrow-up');
                            changeC.find('i').removeClass('icon-arrow-down');

                            if (changePTC > 0) {
                                changePTC = "<i class='icons icon-arrow-up-circle'></i> "+ changePTC;
                                changeC.addClass('change-up');
                                changeC.find('i').addClass('icon-arrow-up');
                            } else {
                                changePTC = "<i class='icons icon-arrow-down-circle'></i> "+ changePTC;
                                changeC.addClass('change-down');
                                changeC.find('i').addClass('icon-arrow-down');
                            }
                            changeC.html(changePTC+'%');
                        }

                        if (c.data('no-flash') == undefined) {
                            c.removeClass('flash-increment');
                            c.removeClass('flash-decrement');
                            c.addClass('flash-'+flashType);
                            setTimeout(function() {
                                c.removeClass('flash-'+flashType);
                            }, 500);
                        }

                    } else {
                        c.hide();

                    }

            console.log(data);
		}
	});
}
function get_coin_on_page() {
    var result = [];
    $('.coin-detail-container').each(function() {
        result.push('5~CCCAGG~'+$(this).data('symbol')+'~'+base_currency+'')
    });
    return result;
}

function portfolio_regulate_price(from,c,price) {

    value = c.find('.coin-quantity').data('quantity') * price * base_currency_rate;
	
	if(value >= 1000){
		
		c.find('.value').html(accounting.formatNumber(value, 0));
		
	} else if (value >= 1)  {
		
		c.find('.value').html(accounting.formatNumber(value, 2));
		
	}  else if (value == 0)  {
		
		c.find('.value').html(accounting.formatNumber(value, 2));
		
	} else {
		
		c.find('.value').html(accounting.formatNumber(value, 6));
		
	}
	
    c.find('.value').data('value', value);
    invest = c.find('.invest').data('value');
    profit = value - invest;
	
	if(value >= 1000){
		
		c.find('.profit').html(accounting.formatNumber(profit, 0));
		
	} else {
		
		c.find('.profit').html(accounting.formatNumber(profit, 2));
		
	}
	
	
    c.find('.profit').data('value', profit);
    re = (profit / invest) * 100;
    c.find('return').html(re);

    //do overall calculation
    var overallValue = 0;
    var overallProfit = 0;
    $('.coin-detail-container').each(function() {
        overallValue = overallValue + $(this).find('.value').data('value');
        overallProfit = overallProfit + $(this).find('.profit').data('value');
    });
	
	if(overallValue >= 1){
		
		$('.net-worth').html(accounting.formatNumber(overallValue, 2));
		
	
		 $('.net-worth').attr('data-value', overallValue);
		
	} else if(overallValue > 0 && overallValue < 1){
		
		$('.net-worth').html(accounting.formatNumber(overallValue, 6));
		$('.net-worth').attr('data-value', overallValue);
		
	}  else {
		
		$('.net-worth').html(accounting.formatNumber(overallValue, 2));
		$('.net-worth').attr('data-value', overallValue);
		
	}
	
	
	if(overallProfit >= 1){
		
		 $('.total-profit').html(accounting.formatNumber(overallProfit, 2));
		
	} else if(overallProfit > 0 && overallProfit < 1){
		
		$('.total-profit').html(accounting.formatNumber(overallProfit, 6));
		
	}  else {
		
		$('.total-profit').html(accounting.formatNumber(overallProfit, 2));
		
	}

    var totalInvest = $(".total-invest").data('value');
	var overallValuemain2 = $('.net-worth').attr('data-value');
	
    var re = ((overallValuemain2-totalInvest)/totalInvest)*100;  
	
	if(re >= 1){
		
		$('.total-return').html(accounting.formatNumber(re, 0));
		
	}  else {
		
		$('.total-return').html(accounting.formatNumber(re, 2));
		
	}
	
    
}



function do_calculator() {
    var calc = $('.currency-converter');
    var type  = $("#calculator-switch").data('type');
    var inp = calc.find('.converter-from-'+type);
    var from = calc.find('.from');
    var to = calc.find('.to');

    var answerFrom = calc.find('.answer-right');
    var answerTo = calc.find('.answer-left');
    if (inp.val() == '') return false;
    if (type == 'left') {
        //answerFrom.html(inp.val() + ' '+from.val());
    } else {
        //answerTo.html(inp.val() + ' '+to.val());
    }
    $.ajax({
        url :baseUrl + 'convert',
        data :{input:inp.val(),from:from.val(),to:to.val(),type:type},
        success : function(c) {
            if (type == 'left') {
                answerTo.html(c);
            } else{
                answerFrom.html(c);
            }
        }
    })
}
function change_calculator(t) {
    var type = $(t).data('type');
    $('.converter-from-right').hide();
    $('.converter-from-left').hide();
    $('.answer-right').hide();
    $('.answer-left').hide();
    type = (type == 'left') ? 'right' : 'left';
    $('.converter-from-' + type).fadeIn();
    $('.answer-' + type).fadeIn();

    if (type == 'left') {
        $(t).find('i').removeClass('icon-arrow-up-circle');
        $(t).find('i').addClass('icon-arrow-down-circle');
        $(t).data('type', 'left');
        $('.converter-from-left').focus();
    } else {
        $(t).find('i').addClass('icon-arrow-up-circle');
        $(t).find('i').removeClass('icon-arrow-down-circle');
        $('.converter-from-right').focus();
        $(t).data('type', 'right');
    }
    return false;
}

function do_widget_change() {
    var coin = $("#widget-coin").val();
    var currency = $("#widget-currency").val();
    var symbol = ($("#widget-symbol").prop('checked')) ? 1 : 0;
    var market = ($("#widget-market").prop('checked')) ? 1 : 0;
    var rank = ($("#widget-rank").prop('checked')) ? 1 : 0;
    var volume = ($("#widget-volume").prop('checked')) ? 1 : 0;
    var link = baseUrl + 'widget?coin='+coin+'&currency='+currency+'&symbol='+symbol+'&rank='+rank+'&market='+market+'&volume='+volume;

    var content = "<iframe src='"+link+"' style='width:100%;height:240px;border:none;'></iframe>";
    $('.widget-embed-text textarea').val(content);
    $('.widget-preview').html(content);
    return true;
}
function reload_init(d) {
    $('.tool-tip').tooltip();

    $('.sparkline-charts').each(function() {
        //var values = $(this).data('value').split(',')
        $(this).sparkline('html', {width:$(this).data('width'),height:'20px', lineWidth: 1,spotColor:'#3A7ABA',maxSpotColor:'#3A7ABA',lineColor:'#0275D8',fillColor:'#D0DDF7'})
    });

    if($(".news-container").length > 0) {
        $.ajax({
            url: baseUrl+'news',
            success:function(d) {
                $(".news-container").html(d);
            }
        })
    }

    if ($("#coin-profile").length > 0) {
        $('.side-coin-item').removeClass('side-coin-active');
        var coin = $("#coin-profile").data('symbol').toUpperCase();
        $(".side-coin-"+coin).addClass('side-coin-active');
    }

    if($('#site-overview-chart').length  > 0) {
        var ctx = document.getElementById('site-overview-doughnut').getContext("2d");;
        var config = get_site_chart_config();
        new Chart(ctx, config);
    }

   if($('#portfolio-overview-chart').length  > 0) {
        var ctx = document.getElementById('portfolio-overview-doughnut').getContext("2d");;
        var config = get_portfolio_chart_config();
        new Chart(ctx, config);
    }

   if($('#portfolio-worth-chart').length  > 0) {
        var ctx = document.getElementById('portfolio-worth-doughnut').getContext("2d");;
        var config = get_portfolio_worth_chart_config();
        new Chart(ctx, config);
    }



   if($('#portfolio-profit-chart').length  > 0) {
        var ctx = document.getElementById('portfolio-profit-doughnut').getContext("2d");;
        var config = get_portfolio_profit_chart_config();
        new Chart(ctx, config);
    }


    subscribe_for_updates();
    if($("#home-coin-chart").length > 0) {
        var first = $('.each-top-coin');
        init_coin_chart(first.data('symbol'),first.data('currency'),first.data('logo'));
    }


     if ($("#editor").length > 0) {
        CKEDITOR.replace( 'editor' );
     }

     $(".rich-editor").each(function() {
        CKEDITOR.replace( $(this).attr('id') );
     });



    $('#dataTable').DataTable();
    $('#exchangeDataTable').DataTable({
         paging: false,
         searching: false,
         ordering : true,
         order : [[1, 'asc']]
    });
    if(d == undefined && $("#coin-chart").length > 0) {
       init_coin_chart();
    }


    if($("#widget-customizer").length > 0) {
        do_widget_change();
    }

     $('.toggle-one').bootstrapToggle();

    $('.datepicker').each(function() {
        var timepicker = false;

        var format = dateFormat;
        if ($(this).data('time') != undefined) {
            timepicker = true;
            format += ' H:i';
        }

        $(this).datetimepicker({
                timepicker :timepicker,
                format:format
            });
    });

    $('.color-picker').each(function() {
                var c = $(this);
                var input = c.find('input');
                var holder = c.find('.holder')
                input.ColorPicker({
                    onSubmit: function(hsb, hex, rgb, el) {
                    		$(el).val('#'+hex);
                    		$(el).ColorPickerHide();
                    		holder.css('background-color', '#'+hex);
                    	},
                    onBeforeShow: function () {
                    	$(this).ColorPickerSetColor(this.value);
                    },
                    onChange: function (hsb, hex, rgb) {
                    		$(el).val('#'+hex);
                    		holder.css('background-color', '#'+hex);
                    }
                }).bind('keyup', function(){
                  	$(this).ColorPickerSetColor(this.value);
                  });
        })

        $(".select2").select2();
        $(".select2-container").each(function() {
                var n = $(this).next();
                if (n.hasClass('select2-container')) n.remove();
            });


    runReloadHooks();
}

function change_access_form(t) {
    $('.access-form').hide();
    $("." + t + '-form-container').fadeIn();
    return false;
}

function do_search(t) {
    var i = $(t);

    if (i.val().length > 0) {
    showLoader();
        $.ajax({
            url :baseUrl + 'search',
            data : {term:i.val()},
            success : function(r) {
                hideLoader();
                $("#search-dropdown").html(r);
                $("#search-dropdown").fadeIn();
                $('body').click(function() {
                    $("#search-dropdown").fadeOut();
                })
            }
        })
    }
}

function toggle_left_pane() {
    if ($("body").hasClass('mobile-open-left-nav')) {
        $("body").removeClass('mobile-open-left-nav');
    } else {
        $("body").addClass('mobile-open-left-nav')
    }
    return false;
}


function load_page(link) {
    showLoader();
    $('body').click();

    window.onpopstate = function(e) {
            load_page(window.location, true);
        }
        $.ajax({
            url : link,
            success : function(data) {
            hideLoader();
                var data = jQuery.parseJSON(data);
                document.title = data.title;
                $("#page-content").html(data.content);
                window.history.pushState({},'New URL:' + link, link);
                $(window).scrollTop(0);
                $("#header-nav li").removeClass('active');
                if (data.active_menu != '' ) {
                    $("#"+data.active_menu + "-nav").addClass('active');
                }

            },
            complete : function() {
                reload_init();
               // hide_search();
                $("#search-dropdown").fadeOut();
                if($(".trick-hide-nav").css('display') != 'none') {
                    $("#header-nav").hide();
                }
                           }
        });
}

function open_pay(plan,price) {

    $("#payModal").find('#pay-amount-input').val(price);
    $("#payModal").find('#pay-plan-input').val(plan);
    $("#payModal").find('.pay-price').html(price);
    $("#payModal").modal("show");
   // alert(price)
    $("#payModal").find('.pay-type').val(1);
    return false;
}

function validate_pay_amount(t) {
    v = $(t).val();
    if (v == 1) {
        a = $("#payModal").find('#pay-amount-input').val();
        $("#payModal").find('.pay-price').html(a);
    } else {
        a = $("#payModal").find('#pay-amount-input').val();
         n = Math.round(a - ((20 * a) / 100)) ;
         $("#payModal").find('.pay-price').html(n*12);

    }
}

function init_stripe() {
    $("#pay-methods").hide();
    $(".stripe-form-content").fadeIn();
    window.stripe = Stripe(publishableKey);

    // Create an instance of Elements.
    var elements = window.stripe.elements();
    window.card = elements.create('card');

    // Add an instance of the card Element into the `card-element` <div>.
    window.card.mount('#card-element');
    return false;
}

function init_paypal() {
    var price = $("#payModal").find('.pay-price').html();
    var payType = $("#payModal").find('.pay-type').val()
    var payPlan = $("#payModal").find('#pay-plan-input').val();

    var url = baseUrl + 'pay/paypal?price=' + price + '&type='+payType+'&plan='+payPlan;

    window.location.href = url;
    return false;
}

function submit_stripe(t) {
    window.stripe.createToken(window.card).then(function(result) {
        var price = $("#payModal").find('.pay-price').html();
        var payType = $("#payModal").find('.pay-type').val()
        var payPlan = $("#payModal").find('#pay-plan-input').val();
        //alert(result.token.id);
        $(".loader-container").fadeIn();
            if (Object.prototype.hasOwnProperty.call(result, "error")) {
                    notify(result.error.message,'error')
                } else {
                  $.ajax({
                    url : baseUrl + 'pay/stripe',
                    data :{token:result.token.id,price:price,type:payType,plan:payPlan},
                    success : function(r) {
                        var r = jQuery.parseJSON(r);
                        $(".loader-container").hide();
                        if (r.status == 1) {
                            notify(r.message, 'success');
                            $("#payModal").modal("hide");
                            load_page(baseUrl+'settings');
                        } else{
                            notify(r.message, 'error');
                        }
                    }
                  })
                }
     });

    return false;
}

function add_watchlist(coin, page, o) {
    if (page) {
        var coin = $("#watchlist-icon").val();
        $(".loader-container").fadeIn();
        $.ajax({
            url : baseUrl + 'watchlist/add',
            data : {coin:coin},
            success : function(r) {
                $("#watchlistModal").modal("hide");
                $(".loader-container").hide();
                var r = jQuery.parseJSON(r);
                notify(r.message, 'success');
                load_page(baseUrl+'watchlist');
            }
        })
    } else {
        //from star icon
        var a = $(o);
        if (a.hasClass('starred')) {
            a.removeClass('starred');
        } else {
            a.addClass('starred');
        }
        $.ajax({
            url : baseUrl + 'watchlist/add',
            data : {coin:coin},
            success : function(r) {
                var r = jQuery.parseJSON(r);
                notify(r.message, 'success');
            }
        })
    }
    return false;
}

function remove_watchlist(coin) {
        $(".loader-container").fadeIn();
        $.ajax({
            url : baseUrl + 'watchlist/add',
            data : {coin:coin},
            success : function(r) {
                var r = jQuery.parseJSON(r);
                $(".loader-container").hide();
                notify(r.message, 'success');
                $("#watchlist-"+coin).remove();
            }
        })
    return false;
}

function hide_mobile_menu() {
    $("#header-nav").fadeOut();
    return false;
}
$(function() {
    reload_init();

    $(document).on("click", ".ajax-link", function() {
            var link = $(this).attr('href');
            load_page(link);
            return false;
        });
    $(document).on("submit", "#signup-form", function() {
        $(".loader-container").fadeIn();
        $(this).ajaxSubmit({
            url : baseUrl + 'signup',
            success : function(result) {
                var json = jQuery.parseJSON(result);
                if (json.status == 1) {
                    //we can redirect to the next destination
                    window.location.href = json.url;
                    notify(json.message, 'success');
                } else {
                    notify(json.message, 'error');
                    $(".loader-container").fadeOut();
                }
            }
        })
        return false;
    });

     $(document).on("submit", "#login-form", function() {
            $(".loader-container").fadeIn();
            $(this).ajaxSubmit({
                url : baseUrl + 'login',
                success : function(result) {
                    var json = jQuery.parseJSON(result);
                    if (json.status == 1) {
                        //we can redirect to the next destination
                        window.location.href = json.url;
                        notify(json.message, 'success');
                    } else {
                        notify(json.message, 'error');
                        $(".loader-container").fadeOut();
                    }
                }
            })
            return false;
        });

$(document).on('submit', '#portfolio-coin-form', function() {
       $(".loader-container").fadeIn();
        showLoader();
        $(this).ajaxSubmit({
            url : baseUrl + 'portfolio/coin/save',
            success : function(r) {
                hideLoader();
                $("#addCoinModal").modal('toggle');
                $(".loader-container").fadeOut();
                load_page(r);
            }
        })

        return false;
    });
	
	
	$(document).on('submit', '#portfolio-coin-form-remove', function() {
       $(".loader-container").fadeIn();
        showLoader();
        $(this).ajaxSubmit({
            url : baseUrl + 'portfolio/coin/remove',
            success : function(r) {
                hideLoader();
                $(".loader-container").fadeOut();
                load_page(r);
            }
        })

        return false;
    });
	
	

    $(document).on('submit', '#alert-form', function() {
           $(".loader-container").fadeIn();

            $(this).ajaxSubmit({
                url : baseUrl + 'alerts',
                success : function(r) {
                    hideLoader();
                    $(".loader-container").fadeOut();
                    load_page(baseUrl+'alerts');
                }
            })

            return false;
        });

    $(document).on('click', '.confirm-link', function() {
        var link = $(this).attr('href');
        my_confirm(function() {
            window.location.href = link;
        })
        return false;
    });

     $(document).on('click', '.each-top-coin', function() {
            var first = $(this);
            init_coin_chart(first.data('symbol'),first.data('currency'),first.data('logo'));
            return false;
        });

        $(document).on('click', '.mobile-menu-toggle', function() {
            $("#header-nav").fadeIn();
            return false;
        });
})