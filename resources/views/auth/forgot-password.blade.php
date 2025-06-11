@extends('layouts.layout')

@section('title', 'Zapomenuté heslo')

@section('content')
    <div class="row d-flex justify-content-center align-items-center h-100 m-5">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white">
          <div class="card-body p-5 text-center">
            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Zapomenuté heslo</h2>
              <p class="text-white-50 mb-5">Zadejte svůj email pro obnovení hesla</p>

              @if (session('status'))
                <div class="alert alert-success" role="alert">
                  {{ session('status') }}
                </div>
              @endif

              <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-floating mb-4">
                  <input type="email" id="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" />
                  <label for="email">Email</label>
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5 mb-3" type="submit">Odeslat odkaz</button>
              </form>
            </div>

            <div>
              <p class="mb-0">Vzpomněli jste si na heslo? <a href="{{ route('login') }}" class="text-white-50 fw-bold">Přihlaste se!</a></p>
            </div>

          </div>
        </div>
      </div>
    </div>
@endsection
