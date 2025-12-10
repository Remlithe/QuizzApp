{{-- resources/views/admin/quizzes/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>✏️ Edytuj Quiz: <span class="text-primary">{{ $quiz->title }}</span></h2>
    </div>

    {{-- Formularz edycji danych quizu --}}
    <form action="{{ route('admin.quizzes.update', $quiz->id) }}" method="POST" class="mb-5">
        @csrf
        @method('PUT') {{-- Metoda PUT jest wymagana do aktualizacji --}}
        
        @include('admin.quizzes._form', ['quiz' => $quiz])
    </form>

    <hr>

    {{-- Sekcja Pytań --}}
    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>❓ Pytania w tym quizie ({{ $quiz->questions->count() }})</h3>
            <a href="{{ route('admin.questions.create', $quiz->id) }}" class="btn btn-primary">
                ➕ Dodaj Pytanie
            </a>
        </div>

        @if($quiz->questions->isEmpty())
            <div class="alert alert-warning">Ten quiz nie ma jeszcze żadnych pytań.</div>
        @else
            <ul class="list-group">
                @foreach($quiz->questions as $question)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $question->text }}</span>
                        <div class="badge bg-secondary">Poprawna: {{ $question->correct_answer }}</div>
                        {{-- Opcjonalnie: Tu można dodać guziki edycji/usuwania pytania --}}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection