@extends('frontend.master_dashboard')

@section('title','Home easy online shop')

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-4 offset-4">
                <main class="mt-5">
                    <h1>Ödeme Hatası</h1>
                    <p>Ödeme işlemi esnasında bir hata ile karşılaşıldı.</p>
                    <p>Lütfen girdiğiniz bilgileri ve kart limitinizi kontrol ediniz.</p>
                    <p><strong>Hata:</strong> <span class="text-black">{{$message}}</span></p>
                </main>
            </div>
        </div>
    </div>
@endsection
