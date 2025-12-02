<h1>Edytuj Quiz: {{ $quiz->title }}</h1>

<form action="{{ route('admin.quizzes.update', $quiz->id) }}" method="POST">
    @csrf
    @method('PUT') {{-- Ważne dla aktualizacji --}}

    <div style="margin-bottom: 10px;">
        <label>Tytuł:</label><br>
        <input type="text" name="title" value="{{ $quiz->title }}" required style="width: 300px;">
    </div>

    <div style="margin-bottom: 10px;">
        <label>Opis:</label><br>
        <textarea name="description" style="width: 300px;">{{ $quiz->description }}</textarea>
    </div>

    <button type="submit" style="background: orange; border: none; padding: 10px;">Zapisz Zmiany</button>
    <a href="{{ route('quizzes.index') }}">Anuluj</a>
</form>