@extends('ecommerce.shared.app')
@section('Main')
    <div class="Breadcrumb">
        <div class="PageWidth">
            <h3 class="BreadCrumbTitle">
                @if( !empty(request()->productype_code) )
                    {{ $productypes[request()->productype_code] }}
                @else
                    Danh sách sản phẩm
                @endif
            </h3>
        </div>
    </div>

    <div class="PageWidth">
        <div class="ProductGrid">
            @foreach( $products as $key => $product )
                <div class="ProductItem">
                    <div class="ProductGroup">
                        <a class="ProductThumnail" href="{{ displayThumnail($product->thumbnail)}}">
                            <img class="ProductImg" src="{{ displayThumnail($product->thumbnail)}}">
                        </a>
                        <h3 class="ProductTitle">{{$product->name}}</h3>
                        <div class="ProductPrice">
                            <span class="ProductPriceSale">{{$product->price_output_formatted}}</span>
                        </div>
                        <a class="ProductBtnView" href="{{route('product.detail', ['slug' => $product->slug])}}">
                            xem chi tiết
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div> <!-- End PageWidth -->
@endsection