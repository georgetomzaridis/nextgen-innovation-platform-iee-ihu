@extends('layouts.navbar-public')

@section('public-content')
    <div class="container">
        <form method="POST" action="{{ url('/join/team') }}">
            @csrf
            <div class="row steps-register">
                <div class="col-sm-6 info">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Βήμα 1ο - Προσωπικά Στοιχεία Διαχειριστή</h5>
                            <p>Συμπληρώστε τα προσωπικά σας στοιχεία με βάση τις παρακάτω οδηγίες:</p>
                            <p>
                                <ul>
                                    <li>Τα πεδία <b>Όνομα/Επώνυμο</b> συμπληρώνονται με <b>κεφαλαίους ελληνικούς χαρακτήρες</b></li>
                                    <li>
                            <p>
                                Ο Αριθμός Μητρώου είναι ο αριθμός που αναγνωρίζει έναν φοιτητή μοναδικά απο όλους τους άλλους και μπορεί να έχει τις εξής μορφές:
                            </p>
                            <p>
                            <ol>
                                <li>Τμήμα Μηχανικών Πληροφορικής & Ηλεκτρονικών Συστημάτων: <b>iee2019404</b></li>
                                <li>Πρώην Τμήματος Πληροφορικής: <b>it185199</b></li>
                                <li>Πρώην Τμήματος Ηλεκτρονικής: <b>el119986</b></li>
                            </ol>
                            </p>
                            <p>
                                <b>Προσοχή</b>: Στο πεδίο "Αριθμός Μητρώου" θα πρέπει να συμπληρωθεί και ο χαρακτηρισμός του κάθε τμήματος <b>(iee/it/el)</b> αλλά <b>ΟΧΙ ο ειδικός χαρακτήρας [/]</b> (πχ iee2019/167)
                            </p>
                            </li>
                            </ul>
                            </p>
                            <p>Έχεις λογαριασμό στο apps.iee.ihu.gr; Κάνε κλίκ <a href="/join/person/api_filler_data">εδώ</a> για να συμπληρωθούν τα προσωπικά σου στοιχεία αυτόματα</p>
                            @if ($csapi === "success")
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong><i class="fas fa-check-double"></i> Επιτυχία</strong> Η επικοινωνία ήταν επιτυχής και τα απαιτούμενα δεδομένα φορτώθηκαν. Παρακαλώ ελέγξτε για τυχόν λάθη η πιθανές διορθώσεις.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @elseif ($csapi === "error")
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong><i class="fas fa-times"></i> Σφάλμα</strong> Η επικοινωνία για λήψη των στοιχείων δεν ήταν δυνατή, εξαιτίας απόρριψης του αιτήματος απο τον χρήστη η τρίτου συστημικού σφάλματος.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                        </div>

                    </div>
                </div>
                <div class="col-sm-6 form">
                    <div class="card join-type-cards">
                        <div class="card-body">
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
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-6 info">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Βήμα 2ο - Πληροφορίες Project</h5>
                            <p>Συμπληρώστε τις πληροφορίες του project, με το οποίο θα συμμετάσχετε στον διαγωνισμό σύμφωνα με τις παρακάτω οδηγίες:</p>
                            <p>
                                <ul>
                                    <li>Στο πεδίο <b>Όνομα Ομάδας</b> μπορείτε να το αλλάξετε και να βάλετε κάποιο άλλο, αλλιώς αφήστε το όνομα σας.</li>
                                    <li>Στο πεδίο <b>Όνομα Εφαρμογής</b> βάζετε το όνομα του project σας.</li>
                                    <li>
                                        Στις <b>Ετικέτες Εφαρμογής</b> μπορείτε να επιλέξετε τις κατηγορίες που εντάσσεται η εφαρμογή σας
                            <p>
                            <ol>
                                <li><b>Web: </b> Front-end, Back-end, UI, UX, APIs κτλ</li>
                                <li><b>Cloud Infrastructure: </b> Linux Servers, Windows Servers, DevOps, Databases, Administration κτλ</li>
                                <li><b>Internet of Things: </b> Raspberry Pi, Arduino, LoRaWAN, ESP κτλ</li>
                                <li><b>Networking/Telecommunications: </b> PBXs, Firewalls, Virtual Networking, Wireless κτλ</li>
                                <li><b>Artificial Intelligence: </b> Data Analysis, Model Training, Predictions κτλ</li>
                                <li><b>Security: </b> Vulnerabillity Scanner, Pentesting, Securing Apps/Networks κτλ</li>
                                <li><b>Software: </b> Python, Java, C, C++ κτλ</li>
                            </ol>
                            </p>
                            </li>
                            <li>Στο πεδίο <b>Περιγραφή Εφαρμογής</b> αναφέρεται με σύντομα λόγια τον στόχο της εφαρμογής, ποιες τεχνολογίες χρησιμοποιήθηκαν κτλ (μέχρι 800 χαρακτήρες)</li>

                            </ul>
                            </p>
                        </div>

                    </div>
                </div>
                <div class="col-sm-6 form">
                    <div class="card join-type-cards">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="exampleFormControlInput1">Όνομα Ομάδας</label>
                                <input type="text" class="form-control @error('join-person-teamapp-name') is-invalid @enderror" id="exampleFormControlInput1" name="join-person-teamapp-name" value="{{ old('join-person-teamapp-name') }}">
                                @error('join-person-teamapp-name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Όνομα Εφαρμογής</label>
                                <input type="text" class="form-control @error('join-person-app-name') is-invalid @enderror" id="exampleFormControlInput1" name="join-person-app-name" value="{{ old('join-person-app-name') }}">
                                @error('join-person-app-name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">Ετικέτες Εφαρμογής</label>
                                <select multiple class="form-control @error('join-person-app-tags') is-invalid @enderror" id="exampleFormControlSelect2" name="join-person-app-tags[]">
                                    <option>Web</option>
                                    <option>Cloud Infrastructure</option>
                                    <option>Internet of Things</option>
                                    <option>Networking/Telecommuncations</option>
                                    <option>Artificial intelligence</option>
                                    <option>Security</option>
                                    <option>Software</option>
                                </select>
                                @error('join-person-app-tags')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Κρατώντας το Ctrl μπορείτε να επιλέξετε πολλαπλές ετικέτες
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Περιγραφή Εφαρμογής</label>
                                <div class="form-group">
                                    <textarea type="text" class="form-control @error('join-person-app-desc') is-invalid @enderror" id="join-person-app-description" maxlength="800" name="join-person-app-desc">{{ old('join-person-app-desc') }}</textarea>
                                    @error('join-person-app-desc')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <small id="join-person-app-description-charlimit-txt" class="form-text text-muted">
                                    <span id="join-person-app-desc-char-limit-remaining">800</span> χαρακτήρες απομένουν
                                </small>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div style="text-align: center; margin-left: auto; margin-right: auto;">
                <button type="submit" class="btn btn-dark" name="join-person-submit-form" style="text-align: center;"><i class="fab fa-cloudsmith"></i> Δήλωση συμμετοχής</button>
            </div>
        </form>
    </div>
    <script>
        var maxLength = 800;
        $('textarea[id="join-person-app-description"]').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#join-person-app-desc-char-limit-remaining').text(textlen);
            if(textlen <= 0){
                $("#join-person-app-description-charlimit-txt").removeClass('text-muted');
                $("#join-person-app-description-charlimit-txt").addClass('change-red-help-test');
            }else{
                $("#join-person-app-description-charlimit-txt").addClass('text-muted');
                $("#join-person-app-description-charlimit-txt").removeClass('change-red-help-test');
            }
        });

        $('textarea[id="join-person-app-description"]').keydown(function() {
            var textlen = maxLength - $(this).val().length;
            $('#join-person-app-desc-char-limit-remaining').text(textlen);
            if(textlen <= 0){
                $("#join-person-app-description-charlimit-txt").removeClass('text-muted');
                $("#join-person-app-description-charlimit-txt").addClass('change-red-help-test');
            }else{
                $("#join-person-app-description-charlimit-txt").addClass('text-muted');
                $("#join-person-app-description-charlimit-txt").removeClass('change-red-help-test');
            }
        });
    </script>



@endsection
