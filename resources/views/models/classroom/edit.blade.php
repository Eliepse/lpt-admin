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
        <form class="card" action="{{ route('grades.classrooms.store', $grade) }}" method="POST">

            {{ csrf_field() }}

            <div class="card-header">
                <h3 class="card-title">Ajouter une classe</h3>
            </div>

            <div class="card-body">

                <p class="text-muted">
                    Les <i>classes</i> représentent les horaires de chaque cours, elles sont composées d'étudiants.
                </p>

                @component('components.form.input')
                    @slot('title', 'Nom (optionnel)')
                    @slot('description', "Vous pouvez donner un nom à cette classe, ce n'est pas obligatoire")
                    @slot('name', 'name')
                    @slot('attrs', ['max' => 50])
                    @slot('default', optional($classroom)->name)
                @endcomponent

                @component('components.form.list')
                    @slot('title', 'Local')
                    @slot('name', 'location')
                    @slot('options', array_combine(LocationEnum::getKeys(), LocationEnum::getValues()))
                    @slot('default', $classroom->location)
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
                    @slot('default', $classroom->max_students)
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
                    @slot('default', $classroom->first_day)
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Dernier jour')
                    @slot('description', 'Le dernier jour de cours.')
                    @slot('name', 'last_day')
                    @slot('type', 'date')
                    @slot('required', true)
                    @slot('default', $classroom->last_day)
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Ouverture de l\'inscription')
                    @slot('description', 'Le jour renseigné est inclu.')
                    @slot('name', 'booking_open_at')
                    @slot('placeholder', 'YYYY-MM-DD')
                    @slot('type', 'date')
                    @slot('default', optional(optional($classroom)->booking_open_at)->toDateString())
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Fermeture de l\'inscription')
                    @slot('description', 'Le jour renseigné est inclu.')
                    @slot('name', 'booking_close_at')
                    @slot('placeholder', 'YYYY-MM-DD')
                    @slot('type', 'date')
                    @slot('default', optional(optional($classroom)->booking_close_at)->toDateString())
                @endcomponent

            </div>

            <div class="card-body">

                <div class="form-group">
                    <label class="form-label" for="timetables">Horaires</label>
                    <p class="text-muted">
                        Si cette classe se tient plusieurs fois dans la semaine, il vous est possible d'ajouter
                        plusieurs horaires. (par exemple, une même classe qui aurait un cours le samedi
                        <strong>et</strong> le dimanche à 10h).<br>
                        Attention&nbsp;: il ne s'agit pas des horaires différents que peut proposer un cours (par exemple,
                        un cours qui serait disponible, au choix, le jeudi à 9h, 11h, 13h, etc).
                    </p>

                    <table class="table" id="timetables-table">
                        <thead>
                        <tr>
                            <th>Jour</th>
                            <th>Heure</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <div class="d-flex">
                        <button type="button" class="btn btn-secondary"
                                data-toggle="modal" data-target="#timetable-modal">Ajouter un horaire
                        </button>
                    </div>

                    <input type="hidden"
                           class="d-none form-control @error('timetables') is-invalid @enderror {{ $classes ?? '' }}"
                           name="timetables" value="{{ old('timetables', json_encode($classroom->timetables)) }}"/>

                    @error('timetables')
                    @foreach($errors->get('timetables') as $message)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @endforeach
                    @enderror
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

    @component('components.modal')
        @slot('title', "Ajout d'un horaire")
        @slot('label', 'timetable-modal')
        @slot('size', 'modal-md')
        <div class="form-group">
            @component('components.form.list')
                @slot('title', 'Jour de cours')
                @slot('name', 'day')
                @slot('group_classes', 'selectgroup-pills')
                @slot('options', array_combine(
                    array_map(function($item) { return Str::ucfirst($item); }, DaysSet::getKeys()),
                    DaysSet::getKeys()
                ))
                @slot('default', 'monday')
            @endcomponent

            @component('components.form.input')
                @slot('title', 'Heure de début')
                @slot('name', 'hour')
                @slot('type', 'time')
                @slot('attr', ['step' => 60])
            @endcomponent

            <button class="btn btn-primary" id="timetable-add-btn">Ajouter</button>
        </div>
    @endcomponent

@endsection

@section('scripts')

    @parent

    <script>
        /*
        Timetable format:
        - monday:
            - 10:00:00
            - 12:00:00
        - thursday:
            - 16:30:00
         */
        var timetables = {}
        var modal = $('#timetable-modal')
        var input_hour = $('input[name="hour"]')
        var input_timetable = $('input[name="timetables"]')
        var btn_add = $('#timetable-add-btn')
        var timetable_table_body = $('#timetables-table').find('tbody')

        btn_add.click(function () {
            addTimetable(
                $('input[name="day"]:checked').val(),
                input_hour.val()
            )
        })

        timetable_table_body.on('click', 'button', function () {
            var _line = $(this).parent().parent()
            removeTimetable(
                _line.find('.day').html(),
                _line.find('.hour').html()
            )
        })

        function resetForm() {
            $('input[name="hour"]').prop('checked', false)
            $('input[name="hour"][value="monday"]').prop('checked', true)
        }

        function addTimetable(day, hour) {
            // Prepare if not yet used
            if (!timetables.hasOwnProperty(day))
                timetables[day] = []

            // Check if the hour is already selected
            for (var i = 0; i < timetables[day].length; i++)
                if (timetables[day][i] === hour)
                    return

            // Add the hour to selection
            timetables[day].push(hour)

            // update UI
            updateTimetableInput()
            updatePreviewTable()
            resetForm()
            modal.modal('hide')
        }

        function removeTimetable(day, hour) {
            // Check if data are valid
            if (!timetables.hasOwnProperty(day))
                return

            // copy current data
            var hours = timetables[day]
            timetables[day] = []

            // filters data
            for (var i = 0; i < hours.length; i++) {
                var t_hour = hours[i]
                if (t_hour !== hour)
                    timetables[day] = t_hour
            }

            // update UI
            updateTimetableInput()
            updatePreviewTable()
        }

        function updateTimetableInput() {
            input_timetable.val(JSON.stringify(timetables))
        }

        function updatePreviewTable() {
            // Clear the table
            timetable_table_body.html('')

            // Walk trough each day
            for (var day in timetables) {
                if (!timetables.hasOwnProperty(day))
                    continue

                var hours = timetables[day]

                // Add each hour for the current day
                for (var i = 0; i < hours.length; i++) {
                    var hour = hours[i]
                    timetable_table_body.append(`<tr><td class="day">${day}</td><td class="hour">${hour}</td>
                        <td><button type="button" class="btn btn-outline-secondary"><i class="fe fe-x"></i></button></td></tr>`)
                }
            }
        }

        function loadExistingData() {
            timetables = JSON.parse(input_timetable.val())
            updatePreviewTable()
        }

        loadExistingData()
    </script>

@endsection