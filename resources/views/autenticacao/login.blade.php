<!DOCTYPE html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="{{asset('logo.jpg') }}" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="{{ asset('autenticacao/login.css') }}">


    <title>| Quinta Santa Bárbara | Reservas |</title>
</head>

<body>
    <div class="container">
        <div class="login-page bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <h3 class="mb-3">Login administrativo </h3>
                        <div class="bg-white shadow rounded">
                            <div class="row">
                                <div class="col-md-7 pe-0">
                                    <div class="form-left h-100 py-5 px-5">
                                        @error('error')
                                        <span>{{ $message }}</span>
                                        @enderror

                                        <form action="/validate-login" class="row g-4">
                                            <div class="col-12">
                                                <label>CPF:<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Informe o CPF">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label>Senha<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" placeholder="Informe a senha">
                                                </div>
                                            </div>
                                            <!--
                                            <div class="col-sm-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="inlineFormCheck">
                                                    <label class="form-check-label" for="inlineFormCheck">Remember me</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <a href="#" class="float-end text-primary">Forgot Password?</a>
                                            </div>
-->

                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary px-4 float-end mt-4">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-5 ps-0 d-none d-md-block">
                                    <img src="{{URL('images/hotel.jpg')}}" alt="Image" width="300" height="250" />

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>