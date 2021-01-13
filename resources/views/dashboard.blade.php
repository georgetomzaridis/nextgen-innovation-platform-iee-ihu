@extends('layouts.navbar-auth')


@section('public-content')
    <div class="container">
        <h1>Καλωσόρισες, {{ \Illuminate\Support\Facades\Auth::user()->firstname }} {{ \Illuminate\Support\Facades\Auth::user()->lastname }}</h1>
        <a href="/logout">Logout</a>
        <br><br>
            <h2>Οι ομάδες μου</h2>
            @if ($haveteamgroups === 1)
                <div class="alert alert-danger" role="alert">
                    <b>ΠΡΟΣΟΧΗ:</b> Σε περίπτωση <b>διαγραφής</b> μιας ομαδικής συμμετοχής, <b>αποχωρούν και τα μέλη της αυτόματα.</b>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark ">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Τύπος Συμμετοχής</th>
                                    <th scope="col">Όνομα Ομάδας</th>
                                    <th scope="col">Όνομα Εφαρμογής</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($submisions_table as $recdata_submission)
                                <tr>
                                    <th scope="row">{{ $recdata_submission['id'] }}</th>
                                    <td>
                                        @if ($recdata_submission['join_type'] === 1)
                                            Ατομική
                                        @elseif ($recdata_submission['join_type'] === 2)
                                            Ομαδική
                                        @endif
                                    </td>
                                    <td>{{ $recdata_submission['teamname'] }}</td>
                                    <td>{{ $recdata_submission['appname'] }}</td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br><br>


        @if($haveteamgroups !== 0)
            <h2>Τα μέλη μου</h2>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark ">
                            <tr>
                                <th scope="col">Διαχειριστής Ομάδας</th>
                                <th scope="col">Όνομα Ομάδας</th>
                                <th scope="col">Όνομα Μέλους</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($teammembers_table as $recdata_submission_team)
                                <tr>
                                    <td>{{ \App\Models\User::find($recdata_submission_team['admin_id'])['firstname'] }} {{ \App\Models\User::find($recdata_submission_team['admin_id'])['lastname'] }}</td>
                                    <td>{{ \App\Models\Submission::find($recdata_submission_team['team_id'])['teamname'] }}</td>
                                    <td>{{ \App\Models\User::find($recdata_submission_team['member_id'])['firstname'] }} {{ \App\Models\User::find($recdata_submission_team['member_id'])['lastname'] }}</td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <br>

    @if($haveteamgroups !== 0)
        <div class="container">
            <h2>Στοιχεία Ομάδας/Project</h2>
            @if(isset($pjstatus) && $pjstatus === 1)
                <div class="alert alert-success" role="alert">
                    <b>Ενημέρωση:</b> Τα στοιχεία ενημερώθηκαν!</b>
                </div>
            @endif

            @if(isset($pjstatus) && $pjstatus === 0)
                <div class="alert alert-danger" role="alert">
                    <b>Σφάλμα:</b> Παρακαλώ δοκιμάστε ξανά αργότερα.</b>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <tbody>
                    <form method="POST" action="/user/dashboard/projectspace">
                        @csrf
                        @foreach ($submisions_table as $recdata_submission)
                            <div class="form-group">
                                <tr>
                                    <td><b>Όνομα ομάδας</b></td>
                                    <td><input type="text" class="form-control" name="info-project-team-edit-teamname" value="{{ $recdata_submission['teamname'] }}"> </td>
                                </tr>
                            </div>

                            <div class="form-group">
                                <tr>
                                    <td><b>Όνομα Project</b></td>
                                    <td><input type="text" class="form-control" name="info-project-team-edit-appname" value="{{ $recdata_submission['appname'] }}"></td>
                                </tr>
                            </div>

                            <div class="form-group">
                                <tr>
                                    <td><b>Περιγραφή</b></td>
                                    <td>
                                        <textarea name="info-project-team-edit-appdesc" class="form-control" rows="4" cols="50">{{ $recdata_submission['appdesc'] }}</textarea>
                                    </td>
                                </tr>
                            </div>
                            <div class="form-group">
                                <tr>
                                    <td><b>Αποθετήριο</b></td>
                                    <td>
                                        <textarea name="info-project-team-edit-projectspace" class="form-control" rows="4" cols="50">{{ $recdata_submission['projectspace'] }}</textarea>
                                        <small id="passwordHelpBlock" class="form-text text-muted">
                                            Μπορείτε εδώ να καταθέσετε οτιδήποτε έχει σχέση με το project (github repository, demo, video link, description, code analysis κτλ).
                                        </small>
                                    </td>
                                </tr>
                            </div>
                            <div class="form-group">
                                <tr>
                                    <td></td>
                                    <td>
                                        <button type="submit" class="btn btn-primary">Αποθήκευση</button>
                                    </td>
                                </tr>

                            </div>
                        @endforeach
                    </form>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
