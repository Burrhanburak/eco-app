@extends('frontend.master_dashboard')

@section('title','Home easy online shop')

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-sm-3 pt-4">
                <h5>Category</h5>
                <div class="list-group">
                    <a href="/"
                       class="list-group-item list-group-item-action">Hepsi</a>
                    @if(count($categories) > 0)
                        @foreach($categories as $category)
                            <a href="/category/{{$category->slug}}"
                               class="list-group-item list-group-item-action">{{$category->name}}</a>
                            <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top" alt="{{ $category->image[0] }}"
                                 style="width: 50px; ">
                        @endforeach
                    @endif

                </div>
            </div>
            <div class="col-sm-9 pt-4">
                <h5>Ürünler</h5>
                @if(count($products) > 0)
                    <div class="card-group">
                        @foreach($products as $product)
                            <div class="card" style="width: 18rem;">
                                <img src="{{asset( 'storage/'.$product->image)}}"
                                     class="card-img-top" alt="{{$product->image[0]}}">
                                <div class="card-body">
                                    <h5 class="card-title">{{$product->name}}</h5>
                                    <h6 class="card-title">Fiyat: {{$product->price}}TL</h6>
                                    <p class="card-text">{{$product->description}}</p>
                                    <a href="/basket/add/{{$product->id}}" class="btn btn-primary">Sepete Ekle</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>


@endsection
