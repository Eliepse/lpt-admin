@extends('dashboard-master')

<?php
/**
 * @var \App\Grade $grade
 */
?>

@section('title', 'Modifier une classe - ')

@section('main')

    <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">
        <form class="card" action="{{ route('grades.update', $grade) }}" method="POST">

            @csrf
            @method('put')

            <div class="card-header">
                <h3 class="card-title">Modifier une classe</h3>
            </div>

            <div class="card-body">

                <p class="text-muted">Description</p>

                @component('components.form.input')
                    @slot('title', 'Nom de la classe')
                    @slot('description', "Ce nom sera visible par les parents lors de l'inscription.")
                    @slot('name', 'title')
                    @slot('type', 'text')
                    @slot('placeholder', 'Chinois intensif, cours de dessin, ...')
                    @slot('default', $grade->title)
                @endcomponent

            </div>

            <div class="card-body bg-gray-lightest">
                <h4>Administration</h4>

                @component('components.form.list')
                    @slot('title', 'Local')
                    @slot('name', 'location')
                    @slot('options', [
                        'Belleville' => 'belleville',
                        'Aubervilliers' => 'aubervilliers',
                    ])
                    @slot('default', $grade->location)
                @endcomponent

                <?php
                /** @var \Illuminate\Database\Eloquent\Collection $teachers */
                $teachers = \App\User::teacher()->select(['id', 'firstname', 'lastname'])->get();
                $options = $teachers->map(function (\App\User $teacher) {
                    return ['name' => $teacher->getFullname(), 'value' => $teacher->id,];
                });
                $options->prepend(['name' => 'Aucun', 'value' => '']);
                ?>
                @component('components.form.select')
                    @slot('title', 'Enseignant responsable')
                    @slot('name', 'teacher')
                    @slot('options', $options)
                    @slot('default', $grade->teacher_id)
                @endcomponent

                @component('components.form.input-group')
                    @slot('title', 'Prix')
                    @slot('name', 'price')
                    @slot('type', 'number')
                    @slot('classes', 'text-right')
                    @slot('attrs', ['min' => '1', 'max' => '65000'])
                    @slot('placeholder', 'Le prix en euros')
                    @slot('default', $grade->price)
                    @slot('after')
                        <span class="input-group-append"><span class="input-group-text">€</span></span>
                    @endslot
                @endcomponent

                @component('components.form.input-group')
                    @slot('title', 'Effectif maximum')
                    @slot('name', 'max_students')
                    @slot('type', 'number')
                    @slot('classes', 'text-right')
                    @slot('attrs', ['min' => '1', 'max' => '255'])
                    @slot('placeholder', 'Nombre d\'étudiant max')
                    @slot('default', $grade->max_students)
                    @slot('after')
                        <span class="input-group-append"><span class="input-group-text">étudiants</span></span>
                    @endslot
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Ouverture de l\'inscription')
                    @slot('description', 'Le jour renseigné est inclu.')
                    @slot('name', 'booking_open_at')
                    @slot('placeholder', 'YYYY-MM-DD')
                    @slot('attrs', [])
                    @slot('type', 'date')
                    @slot('default', optional($grade->booking_open_at)->toDateString())
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Fermeture de l\'inscription')
                    @slot('description', 'Le jour renseigné est inclu.')
                    @slot('name', 'booking_close_at')
                    @slot('placeholder', 'YYYY-MM-DD')
                    @slot('attrs', [])
                    @slot('type', 'date')
                    @slot('default', optional($grade->booking_close_at)->toDateString())
                @endcomponent

            </div>

            <div class="card-body">
                <h4>Organisation</h4>

                @component('components.form.input')
                    @slot('title', 'Premier jour')
                    @slot('name', 'first_day')
                    @slot('type', 'date')
                    @slot('default', $grade->first_day->toDateString())
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Dernier jour')
                    @slot('name', 'last_day')
                    @slot('type', 'date')
                    @slot('default', $grade->last_day->toDateString())
                @endcomponent

                @component('components.form.list')
                    @slot('title', 'Jour de cours')
                    @slot('name', 'timetable_day')
                    @slot('options', [
                        'Lun' => "monday",
                        'Mar' => "tuesday",
                        'Mer' => "wednesday",
                        'Jeu' => "thrusday",
                        'Ven' => "friday",
                        'Sam' => "saturday",
                        'Dim' => "sunday"
                    ])
                    @slot('default', $grade->timetable_days[0])
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Heure de début du cours')
                    @slot('name', 'timetable_hour')
                    @slot('type', 'time')
                    @slot('default', $grade->timetable_hour->format('H:i'))
                    @slot('attrs', ['step' => '60000'])
                @endcomponent

            </div>

            <div class="card-body bg-gray-lightest">
                <h4>Contenu</h4>

                @component('components.form.list')
                    @slot('title', 'Niveau')
                    @slot('name', 'level')
                    @slot('options', [
                        '<i class="fe fe-x"></i>' => "0",
                        '1' => "1",
                        '2' => "2",
                        '3' => "3",
                        '4' => "4",
                    ])
                    @slot('default', "{$grade->level}")
                @endcomponent

                <div class="form-group">
                    <label class="form-label">Cours</label>
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#courses-modal">Gérer les cours</button>
                </div>

                <table id="coursesTable" class="table table-vcenter table-md table-striped bg-white">
                    <thead>
                    <tr>
                        <td class="w-60">Cours</td>
                        <td class="w-15">Enseignant</td>
                        <td class="w-10">Durée</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id="noActivity">
                        <td colspan="5" class="text-muted text-center">Aucun cours renseigné</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td class="w-60"></td>
                        <td class="w-20"></td>
                        <td class="w-10 text-muted text-uppercase" id="courses-total-time">0 min</td>
                    </tr>
                    </tfoot>
                </table>

            </div>

            <div class="card-footer text-right">
                <div class="d-flex">
                    {{--<a href="javascript:void(0)" class="btn btn-link">Retour</a>--}}
                    <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                </div>
            </div>

            @component('components.modal')
                @slot('title', "Sélection d'un cours")
                @slot('label', 'courses-modal')
                @slot('size', 'modal-lg')
                <div class="form-group">
                    <div class="row row-cards row-deck">
                        @foreach(\App\Course::orderBy('category')->get() as $course)
                            <?php
                            /**
                             * @var \App\Course $course
                             * @var \App\User $teacher
                             */
                            $teacher = $course->teacher;
                            ?>
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">{{ $course->name }}</div>
                                        <div class="card-options">
                                            <label class="custom-switch m-0" for="course-{{ $course->id }}">
                                                <input id="course-{{ $course->id }}" type="checkbox"
                                                       name="courses[]"
                                                       autocomplete=""
                                                       value="{{ $course->id }}"
                                                       @if($grade->courses->firstWhere('id', $course->id)) checked @endif
                                                       data-teacher="{{ $teacher ? $teacher->getFullname() : ''  }}"
                                                       data-duration="{{ $course->duration  }}"
                                                       data-name="{{ $course->name }}"
                                                       class="custom-switch-input">
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p><span class="tag">{{ $course->category }}</span></p>
                                        <p>{{ $course->description }}</p>
                                        <p>{{ $course->duration }} min</p>
                                        <p>{{ $teacher ? $teacher->getFullname() : '' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endcomponent

        </form>
    </div>

@endsection

@section('scripts')

    @parent

    <script>
        var coursesBody = document.querySelector('#coursesTable tbody')
        var defaultRow = document.querySelector('#noActivity').outerHTML
        var t_row = _.template('<tr><td>[name]</td><td>[teacher]</td><td>[duration]</td></tr>')
        var total_time = $('#courses-total-time')
        var courses = []

        function courseToObject(el) {
            return {
                'id': el.val(),
                'name': el.data('name'),
                'teacher': el.data('teacher'),
                'duration': el.data('duration'),
            }
        }

        function updateTable() {
            var courses = []
            $('input[name="courses[]"]:checked').each(function () {
                courses.push(courseToObject($(this)))
            })
            var html = ''
            if (courses.length === 0) {
                html = defaultRow
            } else {
                _.forEach(courses, function (course) {
                    html += t_row({
                        "name": course.name,
                        "teacher": course.teacher,
                        "duration": course.duration + ' min'
                    })
                })
            }
            coursesBody.innerHTML = html
            var time = _.sumBy(courses, function (course) {return course.duration})
            total_time.html(Math.floor(time / 60) + ' h ' + (time % 60) + ' min')
        }

        updateTable()
        $('input[name="courses[]"]').change(function () { updateTable() })
    </script>

@endsection