@extends("dashboard-master")

@section('title', "Paramètres - ")

@section('main')

    <div class="container justify-content-center">

        <div class="d-flex mb-3 mt-3 justify-content-between align-items-end">
            <h1>Paramètres</h1>
        </div>

        <table class="table table-vcenter">
            <tbody>
            <tr>
                <td>Aucun paramètre n'est disponible pour le moment</td>
                {{--<td>
                    <strong>Maintenance</strong><br>
                    <small>
                        Lorsque cette option est activée, le site n'est plus accessible. Une page indique les visiteurs
                        que le site est en maintenance.
                    </small>
                </td>
                <td>
                    @if(true)
                        Activé
                    @else
                        Désactivé
                    @endif
                </td>
                <td class="text-right">
                    <form method="POST" action="{{ route('settings.action.toggleMaintenance') }}">
                        <button class="btn btn-sm btn-outline-secondary">Activer</button>
                        <button class="btn btn-sm btn-secondary">Désactiver</button>
                    </form>
                </td>--}}
            </tr>
            </tbody>
        </table>

    </div>

@endsection
