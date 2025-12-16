{{-- resources/views/admin/quizzes/_form.blade.php --}}

<div class="card p-4">
    <div class="mb-3">
        <label for="title" class="form-label">Tytuł Quizu</label>
        {{-- old() pozwala zachować wpisany tekst w razie błędu walidacji --}}
        <input type="text" class="form-control @error('title') is-invalid @enderror" 
               id="title" name="title" 
               value="{{ old('title', $quiz->title ?? '') }}" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Opis</label>
        <textarea class="form-control @error('description') is-invalid @enderror" 
                  id="description" name="description" rows="3">{{ old('description', $quiz->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">Anuluj</a>
        <button type="submit" class="btn btn-success">
            {{ isset($quiz) && $quiz->exists ? 'Zapisz Zmiany' : 'Utwórz Quiz' }}
        </button>
    </div>
</div>