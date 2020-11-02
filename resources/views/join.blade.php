@extends('layouts.navbar-public')

@section('public-content')
    <div class="container">
        <h1>Πως θα συμμετέχεις στον διαγωνισμό;</h1>
        <div class="row">
            <div class="col-sm-6">
                <div class="card join-type-cards">
                    <a href="join/person" class="join-link-href">
                        <div class="card-body" style="text-align: center;">
                            <h2 class="card-title"><i class="fas fa-chalkboard-teacher" style="font-size: 40px;"></i> </h2>
                            <h4 class="card-title">Ατομικά</h4>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card join-type-cards">
                    <a href="join/team" class="join-link-href">
                        <div class="card-body" style="text-align: center;">
                            <h2 class="card-title"><i class="fas fa-users" style="font-size: 40px;"></i></h2>
                            <h4 class="card-title">Με ομάδα</h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
