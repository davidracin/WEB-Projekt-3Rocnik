@extends('layouts.layout')

@section('title', 'Obnovení hesla')

@section('content')
    <div class="row d-flex justify-content-center align-items-center h-100 m-5">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white">
          <div class="card-body p-5 text-center">
            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Obnovení hesla</h2>
              <p class="text-white-50 mb-5">Zadejte nové heslo</p>

              <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-floating mb-4">
                  <input type="email" id="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" required autocomplete="email" placeholder="Email" />
                  <label for="email">Email</label>
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-floating mb-4 position-relative">
                  <input type="password" id="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required autocomplete="new-password" placeholder="Nové heslo" />
                  <label for="password">Nové heslo</label>
                  <button type="button" class="btn btn-sm btn-secondary position-absolute top-50 end-0 translate-middle-y me-2" style="z-index:2;" onclick="togglePassword('password', this)">
                    <span class="show-icon">👁️</span>
                  </button>
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-floating mb-4 position-relative">
                  <input type="password" id="password-confirm" name="password_confirmation" class="form-control form-control-lg" required autocomplete="new-password" placeholder="Potvrdit heslo" />
                  <label for="password-confirm">Potvrdit heslo</label>
                  <button type="button" class="btn btn-sm btn-secondary position-absolute top-50 end-0 translate-middle-y me-2" style="z-index:2;" onclick="togglePassword('password-confirm', this)">
                    <span class="show-icon">👁️</span>
                  </button>
                </div>

                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" type="submit">Obnovit heslo</button>
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
