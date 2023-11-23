@extends('frontend.master_dashboard')

@section('title','Home easy online shop')

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-4 offset-4">
                <main class="mt-5">
                    <form method="POST" action="{{url("/payment")}}">
                        @csrf
                        <h1 class="h3 mb-3 fw-normal">Kredi Kartı Bilgileri</h1>
                        <div class="form-group mt-2">
                            <label for="name">Ad Soyad</label>
                            <input required type="text" id="name" name="name" placeholder="Kart üzerindeki ad soyad" class="form-control" />
                        </div>

                        <div class="form-group mt-2">
                            <label for="card_no">Kart No</label>
                            <input required type="text"  id="card_no" name="card_no" label="Kart No" placeholder="16 haneli kart numaranızı giriniz" class="form-control"/>
                        </div>

                        <div class="form-group mt-2">
                            <label for="expire_month">Son Kullanım Ay</label>
                            <input id="expire_month" name="expire_month" label="Son Kullanım Ay" placeholder="Son kullanım ay giriniz" class="form-control" type="text"/>
                        </div>

                        <div class="form-group mt-2">
                            <label for="expire_year">Son Kullanım Yılı</label>
                            <input id="expire_year" name="expire_year" label="Son Kullanım Yılı" placeholder="Son kullanım yılını giriniz" class="form-control" type="text"/>
                        </div>

                        <div class="form-group mt-2">
                            <label for="cvc">Cvc</label>
                            <input id="cvc" name="cvc" label="Cvc" placeholder="Cvc kodunu giriniz" class="form-control" type="text"/>
                        </div>


                        <button class="w-100 btn btn-lg btn-success mt-4" type="submit">Satın Al</button>
                    </form>
                </main>
            </div>
        </div>
    </div>
@endsection
