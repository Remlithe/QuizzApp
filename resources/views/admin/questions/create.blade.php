<h1>Dodaj pytanie do: {{ $quiz->title }}</h1>

<form action="{{ route('admin.questions.store', $quiz->id) }}" method="POST" style="max-width: 500px; display: flex; flex-direction: column; gap: 15px;">
    @csrf

    <div>
        <label>Treść pytania:</label><br>
        <textarea name="text" required style="width: 100%;"></textarea>
    </div>

    <h3>Odpowiedzi:</h3>
    
    <div>
        <label>Opcja A:</label>
        <input type="text" name="option_a" required style="width: 100%;">
    </div>
    
    <div>
        <label>Opcja B:</label>
        <input type="text" name="option_b" required style="width: 100%;">
    </div>

    <div>
        <label>Opcja C:</label>
        <input type="text" name="option_c" required style="width: 100%;">
    </div>

    <div>
        <label>Opcja D:</label>
        <input type="text" name="option_d" required style="width: 100%;">
    </div>

    <div style="background: #eef; padding: 10px; border: 1px solid #ccf;">
        <label><strong>Która odpowiedź jest poprawna?</strong></label>
        <select name="correct_answer">
            <option value="A">Opcja A</option>
            <option value="B">Opcja B</option>
            <option value="C">Opcja C</option>
            <option value="D">Opcja D</option>
        </select>
    </div>

    <button type="submit" style="padding: 10px; background: green; color: white;">Zapisz Pytanie</button>
</form>