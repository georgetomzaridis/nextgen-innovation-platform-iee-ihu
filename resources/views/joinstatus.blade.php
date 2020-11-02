@extends('layouts.navbar-public')

@section('public-content')
    <div class="container">
        @if (isset($status) && $status === "success")
            <div class="card">
                <div class="card-body">
                    <div style="text-align: center;">
                        <h1 class="icon-status-join icon-status-join-success"><i class="fas fa-check-double"></i></h1>
                        <h3>Η συμμετοχή σας καταγράφηκε με επιτυχία. Build something awesome!</h3>
                        <p>Επιβεβαίωση Συμμετοχής: {{ $submision_data['submision_id'] }}</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered submision-table-info">
                            <tbody>
                            <tr>
                                <th>Ονοματεπώνυμο / Αριθμός Μητρώου</th>
                                <td>{{ $user_data['firstname'] }} {{ $user_data['lastname'] }} / {{ $user_data['kas'] }}</td>
                            </tr>
                            <tr>
                                <th>Συμμετοχή</th>
                                <td>
                                    @if ($submision_data['join_type'] === 1)
                                        <p>Ατομική</p>
                                    @elseif ($submision_data['join_type'] === 2)
                                        <p>Ομαδική</p>
                                    @endif
                                </td>
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
@endsection
