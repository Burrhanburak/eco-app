@extends('frontend.master_dashboard')

@section('title', '3D Secure Verification')

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <main class="mt-5">
                    <h1>Ödeme basarılılı✅ </h1>
                    <p>Ödemeniz başarıyla alındı. Siparişiniz en kısa sürede hazırlanıp kargoya verilecektir.</p>
                    <a href="/" class="btn btn-primary">Anasayfaya dönün</a>
                    or
                    <a href="{{route('orders')}}" class="btn btn-primary">Siparişlerim</a>
                </main>
            </div>
        </div>
    </div>
@endsection
