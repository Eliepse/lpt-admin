@extends('dashboard-master')

@section('title', 'Ajouter un cours - ')

@section('main')

    <div class="col-12">
        <div class="card">
            <div class="table-responsive">

                <table class="table table-outline table-vcenter card-table">
                    <thead>
                    <tr>
                        <th>Cours</th>
                        <th>Catégorie</th>
                        <th>Durée</th>
                        <th>Enseignant</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse(\App\Course::all() as $course)
                        <tr>
                            <td>
                                {{ $course->name }}<br>
                                <span class="text-muted">{{ $course->description }}</span>
                            </td>
                            <td>{{ \Illuminate\Support\Str::ucfirst($course->category) }}</td>
                            <td>{{ $course->duration }} min</td>
                            <td>{{ $course->teacher ? $course->teacher->firstname . ' ' . $course->teacher->lastname : '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <p class="text-center text-muted">Il n'y a pas de cours enregistré</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection