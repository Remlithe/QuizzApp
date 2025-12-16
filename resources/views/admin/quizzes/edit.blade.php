{{-- resources/views/admin/quizzes/edit.blade.php --}}
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edycja Quizu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    {{-- NAWIGACJA --}}
    

    {{-- TREŚĆ --}}
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>✏️ Edytuj Quiz: <span class="text-primary">{{ $quiz->title }}</span></h2>
        </div>

        {{-- Formularz edycji --}}
        <form action="{{ route('admin.quizzes.update', $quiz->id) }}" method="POST" class="mb-5">
            @csrf
            @method('PUT')
            
            @include('admin.quizzes._form', ['quiz' => $quiz])
        </form>

        <hr>

        {{-- Sekcja Pytań --}}
        <div class="card mt-4">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Pytania ({{ $quiz->questions->count() }})</h4>
                <a href="{{ route('admin.questions.create', $quiz->id) }}" class="btn btn-sm btn-light">
                    ➕ Dodaj Pytanie
                </a>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($quiz->questions as $question)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $loop->iteration }}.</strong> {{ $question->text }}
                        </div>
                        <div>
                            <span class="badge bg-success me-2">Odp: {{ $question->correct_answer }}</span>
                            <a href="{{ route('admin.questions.edit', [$quiz->id, $question->id]) }}" class="btn btn-sm btn-outline-primary">Edytuj</a>
                            
                             <form action="{{ route('admin.questions.destroy', [$quiz->id, $question->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Usunąć pytanie?')">Usuń</button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="list-group-item text-center text-muted">Brak pytań w tym quizie.</li>
                @endforelse
            </ul>
        </div>
    </div>

</body>
</html>