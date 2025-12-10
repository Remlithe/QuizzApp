{{-- resources/views/admin/quizzes/create.blade.php --}}
@extends('layouts.admin')

@section('content')
    <h2 class="mb-4">➕ Utwórz Nowy Quiz</h2>

    <form action="{{ route('admin.quizzes.store') }}" method="POST">
        @csrf
        {{-- Dołączamy formularz, przekazując pustą zmienną quiz --}}
        @include('admin.quizzes._form', ['quiz' => null])
    </form>
@endsection