<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj Pytanie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">

<div class="container bg-white p-4 rounded shadow" style="max-width: 800px;">
    <h3>➕ Dodaj Pytanie do: {{ $quiz->title }}</h3>

    <form action="{{ route('admin.questions.store', $quiz->id) }}" method="POST">
        @csrf

        {{-- Treść Pytania --}}
        <div class="mb-4">
            <label class="form-label fw-bold">Treść Pytania</label>
            <input type="text" name="text" class="form-control" required placeholder="Np. Co to jest Blade?">
        </div>

        {{-- Opcje Odpowiedzi --}}
        <div class="row mb-4">
            <label class="form-label fw-bold">Opcje Odpowiedzi</label>
            
            <div class="col-md-6 mb-2">
                <div class="input-group">
                    <span class="input-group-text">A</span>
                    <input type="text" name="options[A]" class="form-control" required placeholder="Odpowiedź A">
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <div class="input-group">
                    <span class="input-group-text">B</span>
                    <input type="text" name="options[B]" class="form-control" required placeholder="Odpowiedź B">
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <div class="input-group">
                    <span class="input-group-text">C</span>
                    <input type="text" name="options[C]" class="form-control" required placeholder="Odpowiedź C ">
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <div class="input-group">
                    <span class="input-group-text">D</span>
                    <input type="text" name="options[D]" class="form-control" required placeholder="Odpowiedź D">
                </div>
            </div>
        </div>

        {{-- Wybór poprawnej --}}
        <div class="mb-4">
            <label class="form-label fw-bold">Która odpowiedź jest poprawna?</label>
            <select name="correct_answer" class="form-select w-25" required>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Zapisz Pytanie</button>
        <a href="{{ route('admin.quizzes.edit', $quiz->id) }}" class="btn btn-secondary">Anuluj</a>
    </form>
</div>

</body>
</html>