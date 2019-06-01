@extends('dashboard-master')

@section('title', "Ajouter un étudiant - ")

@section('main')

    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h2 class="card-title">Choisissez l'étudiant à ajouter</h2>
            </div>

            <div class="table-responsive">

                <table class="table table-outline table-vcenter card-table">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($students as $student)
                        <?php /** @var \App\Lesson $lesson */ ?>
                        <tr>
                            <td>
                                {{ $student->getFullname() }}
                            </td>
                            <td class="text-right">
                                <a href="{{ route('classrooms.students.link', [$classroom, $student]) }}"
                                   class="btn btn-secondary">
                                    Ajouter
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <p class="text-center text-muted">Il n'y a pas d'étudiant disponible.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection