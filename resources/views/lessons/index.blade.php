@extends('dashboard-master')

@section('title', 'Cours - ')

@section('main')

    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h2 class="card-title">Classes</h2>
                <div class="card-options">
                    <a href="{{ route('lessons.create') }}" class="btn btn-outline-primary btn-sm ml-2"><span class="fe fe-book"></span> Nouveau cours</a>
                </div>
            </div>

            <div class="table-responsive">

                <table class="table table-outline table-vcenter card-table">
                    <thead>
                    <tr>
                        <th>Cours</th>
                        <th>Catégorie</th>
                        <th>Durée</th>
                        <th>Enseignant</th>
                        <th>Classes</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse(\App\Lesson::all() as $lesson)
                        <tr>
                            <td>
                                {{ $lesson->name }}<br>
                                <span class="text-muted">{{ $lesson->description }}</span>
                            </td>
                            <td>{{ \Illuminate\Support\Str::ucfirst($lesson->category) }}</td>
                            <td>{{ $lesson->duration }} min</td>
                            <td>{{ $lesson->teacher ? $lesson->teacher->firstname . ' ' . $lesson->teacher->lastname : '' }}</td>
                            <td>{{ $lesson->grades()->count() }}</td>
                            <td class="text-right">
                                <div class="btn-group" role="group">
                                    @can('update', $lesson)
                                        <a href="{{ route('lessons.edit', $lesson) }}" type="button" class="btn btn-secondary">Modifier</a>
                                    @endcan
                                </div>
                            </td>
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