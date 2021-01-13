@extends('layouts.navbar-public')

<!-- /join/person/api_login -->
@section('public-content')

    <div class="container">
        <div class="row steps-register">
            <div class="col-sm-6 info" style="margin-bottom: 30px;">
                <div class="card" style="height: 290px!important;">
                    <div class="card-body">
                        <div style="text-align: center;">
                            <h1 class="icon-status-join"><i class="fas fa-cloud" style="color: black!important;"></i></h1>
                            <h3>Σύνδεση</h3>
                            <p>Έχεις λογαριασμό στο apps.iee.ihu.gr; Κάνε κλίκ <a href="">εδώ</a> για να κάνεις σύνδεση μέσω της υπηρεσίας.</p>
                            <p style="color: #f05454!important; font-size: 14px!important;">[Ενημέρωση 08/11/2020] Η υπηρεσία ταυτοποίησης IEE@IHU Apps αντιμετωπίζει αυτήν την στιγμή κάποια τεχνικά θέματα λόγω αυξημένου φόρτου, παρακαλώ συμπληρώστε την φόρμα χειροκίνητα.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card" style="height: 290px!important;">
                    <div class="card-body">
                        <div>
                            <form method="POST" action="{{ url('/login') }}">
                                @csrf

                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleFormControlInput1" name="email" required>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Κωδικός Πρόσβασης</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="exampleFormControlInput1" name="password" required>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                <div style="text-align: center; margin-left: auto; margin-right: auto;">
                                    <button type="submit" class="btn btn-dark" id="join-person-submit-form" name="login-submit-btn" style="text-align: center;"><i class="fas fa-sign-in-alt"></i> Σύνδεση</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
