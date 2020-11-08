@extends('layouts.navbar-public')

@section('public-content')

    <div class="container">
        @if (isset($status) && $status === "success")
            <div class="row steps-register">
                <div class="col-sm-6 info" style="margin-bottom: 30px;">
                    <div class="card" style="height: 561px!important;">
                        <div class="card-body">
                            <div style="text-align: center;">
                                <h1 class="icon-status-join"><i class="fas fa-envelope-open-text" style="color: black!important;"></i></h1>
                                <h3>Πρόσκληση Συμμετοχής</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered submision-table-info">
                                        <tbody>
                                        <tr>
                                            <th>Από: </th>
                                            <td>{{ $user_data['firstname'] }} {{ $user_data['lastname'] }} / {{ $user_data['kas'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Όνομα Ομάδας</th>
                                            <td>{{ $submision_data['teamname'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Όνομα Εφαρμογής</th>
                                            <td>{{ $submision_data['appname'] }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p>Έχεις λογαριασμό στο apps.iee.ihu.gr; Κάνε κλίκ <a href="/join/person/api_filler_data">εδώ</a> για να συμπληρωθούν τα προσωπικά σου στοιχεία αυτόματα</p>
                                <p style="color: #f05454!important; font-size: 14px!important;">[Ενημέρωση 08/11/2020] Η υπηρεσία ταυτοποίησης IEE@IHU Apps αντιμετωπίζει αυτήν την στιγμή κάποια τεχνικά θέματα λόγω αυξημένου φόρτου, παρακαλώ συμπληρώστε την φόρμα χειροκίνητα.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <form method="POST" action="{{ url('/join/team/'.$invcodedata) }}">
                                    @csrf
                                    @if(isset($personal_data_filler_arr) && $personal_data_filler_arr !== null )
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Όνομα</label>
                                            <input type="text" class="form-control @error('join-person-user-firstname') is-invalid @enderror" id="exampleFormControlInput1" name="join-person-user-firstname" value="{{ $personal_data_filler_arr['firstname'] }}">
                                            @error('join-person-user-firstname')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Επώνυμο</label>
                                            <input type="text" class="form-control @error('join-person-user-lastname') is-invalid @enderror" id="exampleFormControlInput1" name="join-person-user-lastname" value="{{ $personal_data_filler_arr['lastname'] }}">
                                            @error('join-person-user-lastname')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Αριθμός Μητρώου</label>
                                            <input type="text" class="form-control @error('join-person-user-uid') is-invalid @enderror" id="exampleFormControlInput1" name="join-person-user-uid" value="{{ $personal_data_filler_arr['uid'] }}">
                                            <small id="passwordHelpBlock" class="form-text text-muted">
                                                π.χ it198273 / iee2019123 / el231254
                                            </small>
                                            @error('join-person-user-uid')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Email</label>
                                            <input type="email" class="form-control @error('join-person-user-email') is-invalid @enderror" id="exampleFormControlInput1" name="join-person-user-email" value="{{ $personal_data_filler_arr['email'] }}">
                                            @error('join-person-user-email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Κωδικός Πρόσβασης</label>
                                            <input type="password" class="form-control @error('join-person-user-password') is-invalid @enderror" id="exampleFormControlInput1" name="join-person-user-password">
                                            @error('join-person-user-password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Όνομα</label>
                                            <input type="text" class="form-control @error('join-person-user-firstname') is-invalid @enderror" id="exampleFormControlInput1" name="join-person-user-firstname">
                                            @error('join-person-user-firstname')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Επώνυμο</label>
                                            <input type="text" class="form-control @error('join-person-user-lastname') is-invalid @enderror" id="exampleFormControlInput1" name="join-person-user-lastname">
                                            @error('join-person-user-lastname')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Αριθμός Μητρώου</label>
                                            <input type="text" class="form-control @error('join-person-user-uid') is-invalid @enderror" id="exampleFormControlInput1" name="join-person-user-uid">
                                            <small id="passwordHelpBlock" class="form-text text-muted">
                                                π.χ it198273 / iee2019123 / el231254
                                            </small>
                                            @error('join-person-user-uid')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Email</label>
                                            <input type="email" class="form-control @error('join-person-user-email') is-invalid @enderror" id="exampleFormControlInput1" name="join-person-user-email">
                                            @error('join-person-user-email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Κωδικός Πρόσβασης</label>
                                            <input type="password" class="form-control @error('join-person-user-password') is-invalid @enderror" id="exampleFormControlInput1" name="join-person-user-password">
                                            @error('join-person-user-password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    @endif
                                    <div class="form-check" style="text-align: center; margin-left: auto; margin-right: auto; margin-bottom: 4px;">
                                        <input class="form-check-input" type="checkbox" value="" id="invite-accepted-hehe">
                                        <label class="form-check-label" for="defaultCheck1" >
                                            Αποδέχομαι την πρόσκληση
                                        </label>
                                    </div>
                                    <div style="text-align: center; margin-left: auto; margin-right: auto;">
                                        <button type="submit" class="btn btn-dark" id="join-person-submit-form" name="join-person-submit-form" style="text-align: center;" disabled><i class="fab fa-cloudsmith"></i> Συμμετοχή</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        @elseif(isset($status) && $status === "success_submit"))
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="icon-status-join icon-status-join-success"><i class="fas fa-smile-beam"></i></h1>
                    <h3>Ενταχθήκατε με επιτυχία στην ομάδα!</h3>
                    <p><a href="{{ url('join') }}">Επιστροφή στην σελίδα συμμετοχών</a> </p>
                </div>
            </div>
        </div>
        @else
            <div class="card">
                <div class="card-body">
                    <div style="text-align: center;">
                        <h1 class="icon-status-join icon-status-join-error"><i class="fas fa-frown"></i></h1>
                        <h3>Ωχ κάτι πήγε στραβά, παρακαλώ δοκιμάστε ξανά</h3>
                        <p><a href="{{ url('join') }}">Επιστροφή στην σελίδα συμμετοχών</a> </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        $('#invite-accepted-hehe').on("change", function () {

            if ($(this).is(':checked')) {
                $('#join-person-submit-form').prop("disabled", false);
            } else {
                $('#join-person-submit-form').prop("disabled", true);
            }
        });
    </script>

@endsection
