@extends('frontend.master_dashboard')

@section('title','sepet')

@section('main')

    <div class="container">
        <div class="row">
            <div class="col-sm-3 pt-4">
                <h5>Hesabım</h5>
                <div class="list-group">
                    <a href="/" class="list-group-item list-group-item-action">Sepetim</a>
                </div>
            </div>
            <div class="col-sm-9 pt-4">
                <h5>Sepetim</h5>
                @if(count($cart->details) > 0)
                    <table class="table">
                        <thead>
                        <th>Fotoğraf</th>
                        <th>Ürün</th>
                        <th>Adet</th>
                        <th>Fiyat</th>
                        <th>İşlemler</th>
                        </thead>
                        <tbody>
                        @foreach($cart->details as $detail)
                            {{--                            @dd($detail->product)--}}
                            <tr>
                                <td>
                                    <img src="{{  asset('storage/' . $detail->product->image) }}" alt="{{ $detail->product->name }}"
                                         style="height: 60px; ">
                                </td>
                                <td>{{ $detail->product->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ $detail->product->price }}</td>
                                {{--                                <td>--}}
                                {{--                                    <a href="/basket/delete/{cartDetail}{{$detail->cart_detail_id}}">Sepetten Sil</a>--}}
                                {{--                                </td>--}}
                                <td>
                                    <a href="{{ route('basket.delete', ['cartDetail' => $detail->cart_detail_id]) }}">Sepetten Sil</a>
                                </td>
                                {{--                                @dd($detail->cart_detail_id)--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <a href="/payment" class="btn btn-success float-end">payment</a>
                @else
                    <p class="text-danger text-center">Sepetinizde ürün bulunamadı.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
