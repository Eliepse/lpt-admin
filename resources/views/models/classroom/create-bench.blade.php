@extends('dashboard-master')

<?php
use \App\Enums\LessonCategoryEnum;
use \App\Enums\LocationEnum;
use \App\Sets\DaysSet;
use \Illuminate\Support\Str;
?>

@section('title', 'Nouvelle classe - ')

@section('main')

    <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">
        <form class="card" action="{{ route('grades.classrooms.bench-store', $grade) }}" method="POST">

            @csrf

            <div class="card-header">
                <h3 class="card-title">Générer des classes</h3>
            </div>

            <div class="card-body">

                <p class="text-muted">
                    Sur cette page, vous pouvez générer des classes plus simplement pour éviter
                    de les créer une par une. Chaque classe partagera les mêmes caractéristiques,
                    seuls les horaires seront unique à chaque classe.
                </p>

                @component('components.form.list')
                    @slot('title', 'Local')
                    @slot('description', "Détermine le lieu des classes qui seront créées.")
                    @slot('name', 'location')
                    @slot('options', array_combine(LocationEnum::getKeys(), LocationEnum::getValues()))
                    @slot('default', 'aubervilliers')
                    @slot('required', true)
                @endcomponent

                @component('components.form.input-group')
                    @slot('title', 'Effectif maximum')
                    @slot('description', 'Les administrateurs auront toujours la possibilité de surcharger la classe.')
                    @slot('name', 'max_students')
                    @slot('type', 'number')
                    @slot('classes', 'text-right')
                    @slot('attrs', ['min' => '1', 'max' => '255'])
                    @slot('placeholder', 'Nombre d\'étudiant max')
                    @slot('default', 10)
                    @slot('required', true)
                    @slot('after')
                        <span class="input-group-append"><span class="input-group-text">étudiants</span></span>
                    @endslot
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Premier jour')
                    @slot('description', 'Le premier jour de cours.')
                    @slot('name', 'first_day')
                    @slot('type', 'date')
                    @slot('required', true)
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Dernier jour')
                    @slot('description', 'Le dernier jour de cours.')
                    @slot('name', 'last_day')
                    @slot('type', 'date')
                    @slot('required', true)
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Ouverture de l\'inscription')
                    @slot('description', 'Le jour renseigné est inclu.')
                    @slot('name', 'booking_open_at')
                    @slot('placeholder', 'YYYY-MM-DD')
                    @slot('type', 'date')
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Fermeture de l\'inscription')
                    @slot('description', 'Le jour renseigné est inclu.')
                    @slot('name', 'booking_close_at')
                    @slot('placeholder', 'YYYY-MM-DD')
                    @slot('type', 'date')
                @endcomponent

            </div>

            <div class="card-body">

                <div class="form-group">
                    <label class="form-label" for="timetables">Horaires</label>
                    <p>
                        Sélectionnez les jours et les horaires pour lesquels vous souhaitez générer des classes.
                        Une classe par horaire sera créée.
                    </p>

                    <h4>Exemple</h4>
                    <p class="text-muted">
                        Sélection&nbsp;:<br>
                        i>mardi</i> et <i>jeudi</i> avec les heures <i>10:00</i> et <i>14:00.</i><br>
                        <br>
                        Résultat&nbsp;:<br>
                        4 classes sont créées (mardi à 10h, mardi à 14h, jeudi à 10h et jeudi à 14h)
                    </p>

                    @component('components.form.list')
                        @slot('title', "Jours")
                        @slot('name', 'days[]')
                        @slot('group_classes', 'selectgroup-pills')
                        @slot('options', array_combine(\App\Sets\DaysSet::getKeys(), \App\Sets\DaysSet::getKeys()))
                        @slot('type', 'checkbox')
                    @endcomponent

                    <table class="table" id="hours-table">
                        <thead>
                        <tr>
                            <th>Heure</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    @component('components.form.input-group')
                        @slot('type', 'time')
                        @slot('name', 'hour-field')
                        @slot('attrs', ['step' => 3600])
                        @slot('after')
                            <button type="button" class="btn btn-secondary" id="hour-btn">Ajouter</button>
                        @endslot
                        @slot('default', '09:00')
                    @endcomponent

                    <input id="hour-input" class="d-none" type="hidden" name="hours"
                           autocomplete value="{{ old('hour-input', '[]') }}">

                </div>

            </div>

            <div class="card-footer text-right">
                <div class="d-flex">
                    {{--<a href="javascript:void(0)" class="btn btn-link">Annuler</a>--}}

                    <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('scripts')

    @parent

    <script>
        var hours = []
        var hour_btn = $('#hour-btn')
        var hour_field = $('#hour-field')
        var hour_input = $('#hour-input')
        var hour_table = $('#hours-table').find('tbody')

        function updateInputs() {
            hour_input.val(JSON.stringify(hours))
        }

        function updateTable() {
            hour_table.html('')
            for (var i = 0; i < hours.length; i++) {
                hour_table.append(`<tr data-value="${hours[i]}">
                    <td>${hours[i]}</td>
                    <td class="text-right"><button type="button" class="btn btn-outline-secondary btn-sm">
                        <i class="fe fe-x"></i></button></td>
                <tr>`);
            }
        }

        function addHour(hour) {
            if (hour.length < 5)
                return
            for (var i = 0; i < hours.length; i++)
                if (hours[i] === hour)
                    return
            hours.push(hour)
            updateInputs()
            updateTable()
        }

        function removeField(hour) {
            var t_hours = hours
            hours = []
            for (var i = 0; i < t_hours.length; i++)
                if (t_hours[i] !== hour)
                    hours.push(t_hours[i])
            updateInputs()
            updateTable()
        }

        function clearField() {
            hour_field.val('')
        }

        function init() {
            hours = JSON.parse(hour_input.val())
            updateTable()
        }

        hour_btn.click(function (e) {
            addHour(hour_field.val())
        })

        hour_table.on('click', 'button', function () {
            removeField($(this).parent().parent().data('value'))
        })

        init()
    </script>

@endsection