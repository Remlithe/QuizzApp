<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj Pytanie w Quizie: {{ $quiz->title }}</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; background-color: #f4f7f9; }
        .btn { text-decoration: none; padding: 10px 15px; border-radius: 4px; color: white; display: inline-block; border: none; cursor: pointer; }
        .btn-primary { background-color: #007bff; }
        .btn-success { background-color: #28a745; }
        .card { border: 1px solid #ddd; padding: 20px; margin-bottom: 15px; border-radius: 8px; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input[type="text"], .form-group textarea, .form-group select { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        textarea { min-height: 100px; }
        .alert-danger { background: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 4px; }
    </style>
</head>
<body>
    {{-- WAŻNE: Tu musi być admin.QUIZZES.edit (powrót do quizu), a nie admin.QUESTIONS.edit --}}
    {{-- Wymaga tylko ID quizu --}}
    <a href="{{ route('admin.quizzes.edit', $quiz->id) }}" class="btn btn-primary" style="margin-bottom: 20px;">&laquo; Wróć do edycji quizu</a>

    <h1>Edytuj Pytanie</h1>
    <h2>w: {{ $quiz->title }}</h2>

    @if ($errors->any())
        <div class="alert-danger">
            <strong>Wystąpiły błędy:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        {{-- WAŻNE: Formularz wysyła do admin.QUESTIONS.update --}}
        {{-- Wymaga DWÓCH parametrów: ['quiz' => ID, 'question' => ID] --}}
        <form action="{{ route('admin.questions.update', ['quiz' => $quiz->id, 'question' => $question->id]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="text">Treść pytania</label>
                <textarea id="text" name="text" required>{{ old('text', $question->text) }}</textarea>
            </div>

            <div class="form-group">
                <label for="option_a">Opcja A</label>
                {{-- old('options.A', ...) pobiera starą wartość z formularza LUB wartość z bazy danych --}}
                <input type="text" id="option_a" name="options[A]" value="{{ old('options.A', $question->options['A'] ?? '') }}" required>
            </div>
            <div class="form-group">
                <label for="option_b">Opcja B</label>
                <input type="text" id="option_b" name="options[B]" value="{{ old('options.B', $question->options['B'] ?? '') }}" required>
            </div>
            <div class="form-group">
                <label for="option_c">Opcja C</label>
                <input type="text" id="option_c" name="options[C]" value="{{ old('options.C', $question->options['C'] ?? '') }}" required>
            </div>
            <div class="form-group">
                <label for="option_d">Opcja D</label>
                <input type="text" id="option_d" name="options[D]" value="{{ old('options.D', $question->options['D'] ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="correct_answer">Poprawna odpowiedź</label>
                <select id="correct_answer" name="correct_answer" required>
                    <option value="">-- Wybierz --</option>
                    @foreach(['A', 'B', 'C', 'D'] as $option)
                        <option value="{{ $option }}" @if(old('correct_answer', $question->correct_answer) == $option) selected @endif>{{ $option }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Zapisz zmiany</button>
        </form>
    </div>
</body>
</html>