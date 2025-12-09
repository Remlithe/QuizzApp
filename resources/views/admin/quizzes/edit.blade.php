<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj Quiz: {{ $quiz->title }}</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; background-color: #f4f7f9; }
        .btn { text-decoration: none; padding: 8px 12px; border-radius: 4px; color: white; display: inline-block; margin-right: 5px; font-size: 0.9em; border: none; cursor: pointer; }
        .btn-primary { background-color: #007bff; }
        .btn-success { background-color: #28a745; }
        .btn-warning { background-color: #ffc107; color: black; }
        .btn-danger { background-color: #dc3545; }
        .card { border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 8px; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .question-list-item { display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 1px solid #eee; }
        .question-list-item:last-child { border-bottom: none; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <a href="{{ route('quizzes.index') }}" class="btn btn-primary" style="margin-bottom: 20px;">&laquo; Wróć do listy quizów</a>

    <h1>Edytuj Quiz</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Wystąpiły błędy:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <form action="{{ route('admin.quizzes.update', $quiz->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Tytuł Quizu</label>
                <input type="text" id="title" name="title" value="{{ old('title', $quiz->title) }}" required>
            </div>
            <div class="form-group">
                <label for="description">Opis</label>
                <input type="text" id="description" name="description" value="{{ old('description', $quiz->description) }}">
            </div>
            <button type="submit" class="btn btn-success">Zapisz zmiany</button>
        </form>
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h2>Pytania w quizie ({{ $quiz->questions->count() }})</h2>
            <a href="{{ route('admin.questions.create', $quiz->id) }}" class="btn btn-success">➕ Dodaj nowe pytanie</a>
        </div>

        @if($quiz->questions->isEmpty())
            <p>Ten quiz nie ma jeszcze żadnych pytań. Dodaj pierwsze!</p>
        @else
            <div class="question-list">
                @foreach($quiz->questions as $question)
                    <div class="question-list-item">
                        <span>{{ $loop->iteration }}. {{ Str::limit($question->text, 80) }}</span>
                        <div>
                            <a href="{{ route('admin.questions.edit', ['quiz' => $quiz->id, 'question' => $question->id]) }}" class="btn btn-warning">✏️ Edytuj</a>
                            <form action="{{ route('admin.questions.destroy', ['quiz' => $quiz->id, 'question' => $question->id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Czy na pewno chcesz usunąć to pytanie?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">🗑️ Usuń</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>