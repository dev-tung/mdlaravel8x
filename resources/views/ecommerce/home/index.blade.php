        
@extends('ecommerce.shared.app')
@section('Main')
    <div class="PageWidth">
        <section class="SectionSlide">
            <div class="SlideMain swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide SlideMainItem">
                        <img class="SlideMainImg" src="{{ asset('img/ecommerce/slide/1.png')}}">
                    </div>
                    <div class="swiper-slide SlideMainItem">
                        <img class="SlideMainImg" src="{{ asset('img/ecommerce/slide/2.png')}}">
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>

        </section> <!-- End slider -->

        @if( !empty($products) )
            @foreach( $products as $product_code => $product )
                @if( !empty( $product_code ) )
                    <section class="SectionProduct">
                        <div class="ProductLatest swiper">
                            <div class="ProductHeader">
                                <h3 class="ProductHeaderTitle">
                                    {{ $productypes[$product_code] }}
                                </h3>  
                                <div class="ProductHeaderNav">
                                    <img src="{{ asset('img/ecommerce/icon/previous.png') }}" class="ProductHeaderNavBtn ProductHeaderNavBtn_Next">
                                    <img src="{{ asset('img/ecommerce/icon/next.png') }}" class="ProductHeaderNavBtn ProductHeaderNavBtn_Prev">
                                </div>
                            </div>
                        
                            <div class="swiper-wrapper ProductGrid">
                                @foreach( $products[$product_code] as $key => $product )
                                    <div class="swiper-slide ProductItem">
                                        <div class="ProductGroup">
                                            <a class="ProductThumnail" href="{{ asset($product->product_thumbnail)}}">
                                                <img class="ProductImg" src="{{ asset($product->product_thumbnail)}}">
                                            </a>
                                            <h3 class="ProductTitle">{{$product->product_name}}</h3>
                                            <div class="ProductPrice">
                                                <span class="ProductPriceSale">{{commonNumberToVND($product->product_price_output)}}</span>
                                            </div>
                                            <a class="ProductBtnView" href="{{route('web.product.detail', ['product_id' => $product->product_id])}}">
                                                xem chi tiết
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        
                        </div>
                    </section> <!-- End product -->
                @endif
            @endforeach
        @endif

    </div> <!-- End PageWidth -->
@endsection