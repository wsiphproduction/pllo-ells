@extends('theme.main')

@section('pagecss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@php
    $contents = $page->contents;

// LATEST NEWS
    $featuredArticles = Article::where('is_featured', 1)->where('status', 'Published')->skip(0)->take(3)->get();
    if($featuredArticles->count()) {

        $featuredArticlesHTML = '';

        $prefooter = asset('theme/images/pre-footer.jpg');

        foreach ($featuredArticles as $index => $article) {
            $imageUrl = (empty($article->thumbnail_url)) ? asset('theme/images/misc/no-image.jpg') : $article->thumbnail_url;

            
            $featuredArticlesHTML .= '

                <div class="slide" data-thumb="'. $imageUrl .'">
                    <a href="'. $article->get_url() .'" class="d-block position-relative">
                        <div class="row">
                            <div class="col-md-6 half-one position-default">
                                <div class="floating-panel">
                                    <h2 class="h2 fw-semibold lh-base" style="margin-bottom: 0px;">'. $article->name .'</h2>
                                    <small style="color: #878787;">Date posted: '. $article->date_posted() .'</small>
                                    <p class="text-muted mt-4">'. $article->teaser .'</p>
                                    <a href="'. $article->get_url() .'" class="button button-3d button-mini button-rounded button-blue">Learn More &nbsp; ></a>
                                </div>
                            </div>
                            <div class="col-md-6 p-5">
                                <img class="rounded-corners" src="'. $imageUrl .'" alt="modair">
                            </div>
                        </div>
                    </a>
                </div>

                ';

            if (Article::has_featured_limit() && $index >= env('FEATURED_NEWS_LIMIT')) {
                break;
            }
        }

    } else {
        $featuredArticlesHTML = '';
    } 
    
    $keywords   = ['{Featured Articles}'];
    $variables  = [$featuredArticlesHTML];
    $contents = str_replace($keywords,$variables,$contents);

@endphp

@section('content')
    {!! $contents !!}
@endsection


@section('pagejs')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script>

    function buynow(){
        var qty = $('#quantity').val();
        $('#buy_now_qty').val(qty);

        $('#buy-now-form').submit();
    }

    
    function add_to_cart(product, price, remaining_stock, name, image){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var qty   = 1;
        // var price = parseFloat($('#product_price').val());
        // var remaining_stock = parseFloat($('#remaining_stock').val());

        if(qty <= remaining_stock){

            $.ajax({
                data: {
                    "product_id": product, 
                    "qty": qty,
                    "price": price,
                    "_token": "{{ csrf_token() }}",
                },
                type: "post",
                url: "{{route('product.add-to-cart')}}",
                success: function(returnData) {
                    $("#loading-overlay").hide();
                    if (returnData['success']) {

                        $('.top-cart-number').html(returnData['totalItems']);


                        var cartotal = parseFloat($('#input-top-cart-total').val());
                        var productotal = price*qty;
                        var newtotal = cartotal+productotal;


                        $('#top-cart-total').html('₱'+newtotal.toFixed(2));
				        $('#input-top-cart-total').val(newtotal);

                        // $('#top-cart-items').append(
                        //     '<div class="top-cart-item">'+
                        //         '<div class="top-cart-item-image border-0">'+
                        //             '<a href="#"><img src="{{-- asset('storage/products/'.$product->photoPrimary) --}}" alt="Cart Image 1" /></a>'+
                        //         '</div>'+
                        //         '<div class="top-cart-item-desc">'+
                        //             '<div class="top-cart-item-desc-title">'+
                        //                 '<a href="#" class="fw-medium">{{--$product->name--}}</a>'+
                        //                 '<span class="top-cart-item-price d-block">'+price.toFixed(2)+'</span>'+
                        //                 '<div class="d-flex mt-2">'+
                        //                     '<a href="#" class="fw-normal text-black-50 text-smaller"><u>Edit</u></a>'+
                        //                     '<a href="#" class="fw-normal text-black-50 text-smaller ms-3" onclick="top_remove_product('+returnData['cartId']+');"><u>Remove</u></a>'+
                        //                 '</div>'+
                        //             '</div>'+
                        //             '<div class="top-cart-item-quantity">x '+qty+'</div>'+
                        //         '</div>'+
                        //    '</div>'
                        // );
                        var cartItem = $('#top-cart-items').find('[data-product-id="' + product + '"]');
                        if (cartItem.length) {
                            // If the item already exists in the cart, update its quantity and price
                            var oldQty = parseFloat(cartItem.find('.top-cart-item-quantity').text().trim().replace('x ', ''));
                            var newQty = oldQty + qty;
                            var oldPrice = parseFloat(cartItem.find('.top-cart-item-price').text().trim().replace('₱', ''));
                            var productTotal = price * qty;
                            var newTotal = oldPrice + productTotal;

                            cartItem.find('.top-cart-item-quantity').text('x ' + newQty);
                            // cartItem.find('.top-cart-item-price').text('₱' + newTotal.toFixed(2));
                        } else {

                            $('#top-cart-items').append(
                                '<div class="top-cart-item" data-product-id="' + product + '">' +
                                '<div class="top-cart-item-image border-0">' +
                                '<a href="#"><img src="{{ asset('storage/products/') }}/' + image + '" alt="Cart Image 1" /></a>' +
                                '</div>' +
                                '<div class="top-cart-item-desc">' +
                                '<div class="top-cart-item-desc-title">' +
                                '<a href="#" class="fw-medium">' + name + '</a>' +
                                '<span class="top-cart-item-price d-block">₱' + price + '</span>' +
                                '<div class="d-flex mt-2">' +
                                '<a href="javascript:void()" onclick="location.reload();" class="fw-normal text-black-50 text-smaller"><u>Reload to Edit</u></a>' +
                                '<a href="#" class="fw-normal text-black-50 text-smaller ms-3" onclick="top_remove_product(' + returnData['cartId'] + ');"><u>Remove</u></a>' +
                                '</div>' +
                                '</div>' +
                                '<div class="top-cart-item-quantity">x ' + qty + '</div>' +
                                '</div>' +
                                '</div>'
                            );

                            // $('#top-cart-items').append(
                            //     '<div class="top-cart-item" data-product-id="' + product + '">' +
                            //     '<div class="top-cart-item-image border-0">' +
                            //     '<a href="#"><img src="{{-- asset('storage/products/'.$product->photoPrimary) --}}" alt="Cart Image 1" /></a>' +
                            //     '</div>' +
                            //     '<div class="top-cart-item-desc">' +
                            //     '<div class="top-cart-item-desc-title">' +
                            //     '<a href="#" class="fw-medium">{{--$product->name--}}</a>' +
                            //     '<span class="top-cart-item-price d-block">₱' + price + '</span>' +
                            //     // '<span class="top-cart-item-price d-block">₱' + (price * qty).toFixed(2) + '</span>' +
                            //     '<div class="d-flex mt-2">' +
                            //     '<a href="javascript:void()" onclick="location.reload();" class="fw-normal text-black-50 text-smaller"><u>Reload to Edit</u></a>' +
                            //     '<a href="#" class="fw-normal text-black-50 text-smaller ms-3" onclick="top_remove_product(' + returnData['cartId'] + ');"><u>Remove</u></a>' +
                            //     '</div>' +
                            //     '</div>' +
                            //     '<div class="top-cart-item-quantity">x ' + qty + '</div>' +
                            //     '</div>' +
                            //     '</div>'
                            // );
                        }

                        $.notify("Product Added to your cart",{ 
                            position:"bottom right", 
                            className: "success" 
                        });

                    } else {
                        swal({
                            toast: true,
                            position: 'center',
                            title: "Warning!",
                            text: "We have insufficient inventory for this item.",
                            type: "warning",
                            showCancelButton: true,
                            timerProgressBar: true, 
                            closeOnCancel: false

                        });
                    }
                }
            });

            $('#quantity').val(1);
            $('#remaining_stock').val(remaining_stock - qty);
        }
        else{
            swal({
                toast: true,
                position: 'center',
                title: "Warning!",
                text: "We have insufficient inventory for this item.",
                type: "warning",
                showCancelButton: true,
                timerProgressBar: true, 
                closeOnCancel: false

            });
        }
    }

    // function add_to_cart(product, price){

    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });

    //     var qty   = 1
    //     // var qty   = parseFloat($('#quantity').val());
    //     // var price = parseFloat($('#product_price').val());

    //     $.ajax({
    //         data: {
    //             "product_id": product, 
    //             "qty": qty,
    //             "_token": "{{ csrf_token() }}",
    //         },
    //         type: "post",
    //         url: "{{route('product.add-to-cart')}}",
    //         success: function(returnData) {
    //             $("#loading-overlay").hide();
    //             if (returnData['success']) {

    //                 $('.top-cart-number').html(returnData['totalItems']);


    //                 var cartotal = parseFloat($('#input-top-cart-total').val());
    //                 var productotal = price*qty;
    //                 var newtotal = cartotal+productotal;

    //                 $('#top-cart-total').html('₱'+newtotal.toFixed(2));
    //                 var cartItem = $('#top-cart-items').find('[data-product-id="' + product + '"]');
    //                 // if (cartItem.length) {
    //                 //     // If the item already exists in the cart, update its quantity and price
    //                 //     var oldQty = parseFloat(cartItem.find('.top-cart-item-quantity').text().trim().replace('x ', ''));
    //                 //     var newQty = oldQty + qty;
    //                 //     var oldPrice = parseFloat(cartItem.find('.top-cart-item-price').text().trim().replace('₱', ''));
    //                 //     var productTotal = price * qty;
    //                 //     var newTotal = oldPrice + productTotal;

    //                 //     cartItem.find('.top-cart-item-quantity').text('x ' + newQty);
    //                 //     // cartItem.find('.top-cart-item-price').text('₱' + newTotal.toFixed(2));
    //                 // } else {

    //                 //     $('#top-cart-items').append(
    //                 //         '<div class="top-cart-item" data-product-id="' + product + '">' +
    //                 //         '<div class="top-cart-item-image border-0">' +
    //                 //         '<a href="#"><img src="{{-- asset('storage/products/'.$product->photoPrimary) --}}" alt="Cart Image 1" /></a>' +
    //                 //         '</div>' +
    //                 //         '<div class="top-cart-item-desc">' +
    //                 //         '<div class="top-cart-item-desc-title">' +
    //                 //         '<a href="#" class="fw-medium">{{--$product->name--}}</a>' +
    //                 //         '<span class="top-cart-item-price d-block">₱' + price + '</span>' +
    //                 //         // '<span class="top-cart-item-price d-block">₱' + (price * qty).toFixed(2) + '</span>' +
    //                 //         '<div class="d-flex mt-2">' +
    //                 //         '<a href="javascript:void()" onclick="location.reload();" class="fw-normal text-black-50 text-smaller"><u>Reload to Edit</u></a>' +
    //                 //         '<a href="#" class="fw-normal text-black-50 text-smaller ms-3" onclick="top_remove_product(' + returnData['cartId'] + ');"><u>Remove</u></a>' +
    //                 //         '</div>' +
    //                 //         '</div>' +
    //                 //         '<div class="top-cart-item-quantity">x ' + qty + '</div>' +
    //                 //         '</div>' +
    //                 //         '</div>'
    //                 //     );

    //                 // }
                    
    //                 $('#top-cart-items').append(
    //                     '<div class="top-cart-item" data-product-id="' + product + '">' +
    //                         '<a href="javascript:void()" onclick="location.reload();" class="fw-normal text-black-50 text-smaller"><u>New item added. Reload to Edit</u></a>' +
    //                     '</div>'
    //                 );

    //                 $.notify("Product Added to your cart",{ 
    //                     position:"bottom right", 
    //                     className: "success" 
    //                 });

    //             } else {
    //                 swal({
    //                     toast: true,
    //                     position: 'center',
    //                     title: "Warning!",
    //                     text: "We have insufficient inventory for this item.",
    //                     type: "warning",
    //                     showCancelButton: true,
    //                     timerProgressBar: true, 
    //                     closeOnCancel: false

    //                 });
    //             }
    //         }
    //     });

    //     $('#quantity').val(1);
    // }
    
</script>

<script>
    
    // for edit quantity
	function FormatAmount(number, numberOfDigits) {
		var amount = parseFloat(number).toFixed(numberOfDigits);
		var num_parts = amount.toString().split(".");
		num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

		return num_parts.join(".");
	}

	function addCommas(nStr){
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}

    function plus_qty(id){
		var qty = parseFloat($('#quantity'+id).val())+1;

		if(parseInt($('#maxorder'+id).val()) < 1){
			swal({
				title: '',
				text: 'Sorry. Currently, there is no sufficient stocks for the item you wish to order.',
				icon: 'warning'
			});

			$('#quantity'+id).val($('#prevqty'+id).val()-1);
			return false;
		}

		order_qty(id,qty);
	}

	function minus_qty(id){
		var qty = parseFloat($('#quantity'+id).val())-1;
		order_qty(id,qty);
	}

	function order_qty(id,qty){

		if(qty == 0){
			$('#quantity'+id).val(1).val();
			return false;
		}
		
		var price = $('#cartItemPrice'+id).val();
		total_price  = parseFloat(price)*parseFloat(qty);

		$('#order'+id+'_total_price').html('₱'+FormatAmount(total_price,2));
		$('#input_order'+id+'_product_total_price').val(total_price);

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			data: { 
				"quantity": qty, 
				"orderID": id, 
				"_token": "{{ csrf_token() }}",
			},
			type: "post",
			url: "{{route('cart.update')}}",
			
			success: function(returnData) {

				$('#maxorder'+id).val(returnData.maxOrder);
				$('.top-cart-number').html(returnData['totalItems']);
				$('#prevqty'+id).val(qty);
				// var promo_discount = parseFloat(returnData.total_promo_discount);

				// let subtotal = 0;
				// $(".input_product_total_price").each(function() {
				//     if(!isNaN(this.value) && this.value.length!=0) {
				//         subtotal += parseFloat(this.value);
				//     }
				// });

				// $('#subtotal').val(subtotal);


				// for the sidebar cart total
				// var cartotal = parseFloat($('#input-top-cart-total').val());
				// var productotal = price*qty;
				// var newtotal = cartotal+total_price;
				
				// alert(cartotal);

				// $('#input-top-cart-total').val(newtotal);
				// $('#top-cart-total').html('₱'+newtotal.toFixed(2));
				// 
				
				// resetCoupons();
				cart_total();
			}
		});
	}

	function cart_total(){
		var couponTotalDiscount = parseFloat($('#coupon_total_discount').val());
		var promoTotalDiscount = 0;
		var subtotal = 0;

		$(".input_product_total_price").each(function() {
			if(!isNaN(this.value) && this.value.length!=0) {
				subtotal += parseFloat(this.value);
			}
		});

		if(couponTotalDiscount == 0){
			$('#couponDiscountDiv').css('display','none');
		}

		// var totalDeduction = promoTotalDiscount + couponTotalDiscount;
		// var grandtotal = subtotal - totalDeduction;
		
		// $('#subtotal').html('₱'+FormatAmount(subtotal,2));

		$('#top-cart-total').val(subtotal);
		$('#top-cart-total').html('₱'+subtotal.toFixed(2));
	}

    $("#op_hov1").on("mouseover", function () {

        $('#img_op1').removeClass('invi');
        for(var i = 2; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov2").on("mouseover", function () {

        $('#img_op2').removeClass('invi');
        $('#img_op1').addClass('invi');
        for(var i = 3; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov3").on("mouseover", function () {

        $('#img_op3').removeClass('invi');
        for(var u = 1; u <= 2; u++) {
            img_looper(u);
        }
        for(var i = 4; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov4").on("mouseover", function () {

        $('#img_op4').removeClass('invi');
        for(var u = 1; u <= 3; u++) {
            img_looper(u);
        }
        for(var i = 5; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov5").on("mouseover", function () {

        $('#img_op5').removeClass('invi');
        for(var u = 1; u <= 4; u++) {
            img_looper(u);
        }
        for(var i = 6; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov6").on("mouseover", function () {

        $('#img_op6').removeClass('invi');
        for(var u = 1; u <= 5; u++) {
            img_looper(u);
        }
        for(var i = 7; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov7").on("mouseover", function () {

        $('#img_op7').removeClass('invi');
        for(var u = 1; u <= 6; u++) {
            img_looper(u);
        }
        for(var i = 8; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov8").on("mouseover", function () {

        $('#img_op8').removeClass('invi');
        for(var u = 1; u <= 7; u++) {
            img_looper(u);
        }
        for(var i = 9; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov9").on("mouseover", function () {

        $('#img_op9').removeClass('invi');
        for(var u = 1; u <= 8; u++) {
            img_looper(u);
        }
        for(var i = 10; i <= 11; i++) {
            img_looper(i);
        }
    });

    $("#op_hov10").on("mouseover", function () {

        $('#img_op10').removeClass('invi');
        $('#img_op11').addClass('invi');

        for(var u = 1; u <= 9; u++) {
            img_looper(u);
        }
        
    });

    $("#op_hov11").on("mouseover", function () {

        $('#img_op11').removeClass('invi');
        
        for(var u = 1; u <= 10; u++) {
            img_looper(u);
        }
        
    });
    function img_looper(cnt){
        let img_op = '#img_op' + cnt;
        $(img_op).addClass('invi');
    }

    // services js animation
    $('#img_serv_trigger1').on("mouseover", function () {
        $('#img_serv1').addClass('scaleUp');
    });
    $('#img_serv_trigger1').on("mouseout", function () {
        $('#img_serv1').removeClass('scaleUp');
    });

    $('#img_serv_trigger2').on("mouseover", function () {
        $('#img_serv2').addClass('scaleUp');
    });
    $('#img_serv_trigger2').on("mouseout", function () {
        $('#img_serv2').removeClass('scaleUp');
    });

    $('#img_serv_trigger3').on("mouseover", function () {
        $('#img_serv3').addClass('scaleUp');
    });
    $('#img_serv_trigger3').on("mouseout", function () {
        $('#img_serv3').removeClass('scaleUp');
    });

    $('#img_serv_trigger4').on("mouseover", function () {
        $('#img_serv4').addClass('scaleUp');
    });
    $('#img_serv_trigger4').on("mouseout", function () {
        $('#img_serv4').removeClass('scaleUp');
    });

</script>
@endsection

