@extends('dashboard-master')

@section('main')

    <div class="col-4">
        <div class="card">
            <div class="card-status bg-warning"></div>
            <div class="card-header">
                <h3 class="card-title">Avertissement</h3>
            </div>
            <div class="card-body">
                <p>
                    Cette plateforme est encore en dévelopement et n'est pas encore opérationnelle pour une utilisation
                    porfessionnelle. De nombreuses fontionnalités n'ont pas encore été intégrées et le seront par la
                    suite. Pour plus d'information, n'hésitez pas à contacter l'administrateur.
                </p>
            </div>
        </div>
    </div>

@endsection