{{-- resources/views/admin/quizzes/create.blade.php --}}
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj Nowy Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">


    {{-- TREŚĆ --}}
    <div class="container">
        <h2 class="mb-4">➕ Utwórz Nowy Quiz</h2>

        <form action="{{ route('admin.quizzes.store') }}" method="POST">
            @csrf
            {{-- Dołączamy plik _form.blade.php z tego samego folderu --}}
            @include('admin.quizzes._form', ['quiz' => null])
        </form>
    </div>

</body>
</html>