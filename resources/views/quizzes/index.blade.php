<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Lista Quizów</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .quiz-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 8px; background: #f9f9f9; }
        .btn { text-decoration: none; padding: 5px 10px; border-radius: 4px; color: white; display: inline-block; margin-right: 5px; font-size: 0.9em; border: none; cursor: pointer; }
        .btn-play { background-color: #007bff; }
        .btn-add { background-color: #28a745; }
        .btn-edit { background-color: #ffc107; color: black; }
        .btn-delete { background-color: #dc3545; }
        .admin-panel { background-color: #e3f2fd; padding: 15px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #90caf9; }
    </style>
</head>
<body>

    {{-- Komunikaty sukcesu/błędu --}}
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="admin-panel">
        <h2 style="margin-top: 0;">➕ Utwórz Nowy Quiz</h2>
        {{-- Błędy walidacji --}}
        @if ($errors->any() && session('form_error') === 'store_quiz')
            <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 10px; border-radius: 4px;">
                <strong>Wystąpiły błędy:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.quizzes.store') }}" method="POST">
            @csrf
            <input type="text" name="title" placeholder="Nazwa Quizu (np. PHP Expert)" required style="padding: 8px; width: 40%;">
            <input type="text" name="description" placeholder="Krótki opis" style="padding: 8px; width: 40%;">
            <button type="submit" class="btn btn-add">Utwórz</button>
        </form>
    </div>

    <h1>Dostępne Quizy</h1>

    @foreach ($quizzes as $quiz)
        <div class="quiz-card">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="margin: 0 0 5px 0;">{{ $quiz->title }}</h2>
                    <p style="margin: 0; color: #666;">{{ $quiz->description }}</p>
                    <small>Liczba pytań: {{ $quiz->questions->count() }}</small>
                </div>
                
                <div style="text-align: right;">
                    <a href="{{ route('quizzes.start', $quiz->id) }}" class="btn btn-play">▶️ Rozpocznij</a>
                </div>
            </div>

            <hr style="margin: 10px 0; border: 0; border-top: 1px solid #ddd;">

            <div style="display: flex; align-items: center; gap: 5px;">
                <strong>Opcje Nauczyciela:</strong>
                
                <a href="{{ route('admin.questions.create', $quiz->id) }}" class="btn btn-add">➕ Dodaj Pytanie</a>
                
                <a href="{{ route('admin.quizzes.edit', $quiz->id) }}" class="btn btn-edit">✏️ Edytuj</a>
 
                <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Czy na pewno chcesz usunąć ten quiz i wszystkie jego pytania?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete">🗑️ Usuń</button>
                </form>
            </div>
        </div>
    @endforeach

    @if($quizzes->isEmpty())
        <p>Brak quizów. Utwórz pierwszy powyżej!</p>
    @endif

</body>
</html>