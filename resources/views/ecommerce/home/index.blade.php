        
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

        @if( !empty($taxonomies) )
            @foreach( $taxonomies as $key => $taxonomy )
                @if( !empty( $taxonomy->products ) )
                    <section class="SectionProduct">
                        <div class="ProductLatest">
                            <div class="ProductHeader">
                                <h3 class="ProductHeaderTitle">
                                    {{ $taxonomy->name }}
                                </h3>  
                            </div>
                            <div class="ProductGrid">
                                @foreach( $taxonomy->products as $key => $product )
                                    <div class="ProductItem">
                                        <div class="ProductGroup">
                                            <a class="ProductThumnail" href="{{ asset($product->thumbnail)}}">
                                                <img class="ProductImg" src="{{ asset($product->thumbnail)}}">
                                            </a>
                                            <h3 class="ProductTitle">{{$product->name}}</h3>
                                            <div class="ProductPrice">
                                                <span class="ProductPriceSale">{{$product->price_output}}</span>
                                            </div>
                                            <a class="ProductBtnView" href="{{ route('product.detail', ['slug' => $product->slug]) }}">
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