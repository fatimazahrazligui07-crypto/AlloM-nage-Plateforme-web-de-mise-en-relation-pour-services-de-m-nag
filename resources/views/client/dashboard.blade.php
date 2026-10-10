@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tableau de bord Client') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Vous êtes connecté en tant que client!') }}
                    
                    <div class="mt-4">
                        <h4>Bienvenue {{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h4>
                        <p>Votre compte a été créé le {{ Auth::user()->dateInscription->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
