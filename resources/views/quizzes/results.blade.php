<h1>Wyniki Quizu: {{ $quiz->title }}</h1>
<hr>

<h2>Gratulacje! Quiz ukończony.</h2>

<div style="background-color: #f8f9fa; padding: 20px; border-radius: 5px; border: 1px solid #dee2e6;">
    <p style="font-size: 1.2em;">
        Udało Ci się poprawnie odpowiedzieć na:
    </p>
    
    <h1 style="color: #28a745; font-size: 3em; margin: 0;">
        {{ $correctCount }} / {{ $totalAnswered }}
    </h1>

    <p style="margin-top: 10px;">
        (Poprawnie na {{ $correctCount }} pytań z {{ $totalAnswered }} udzielonych odpowiedzi).
    </p>

    @if ($totalAnswered < $totalQuestions)
        <p style="color: orange;">
            Uwaga: Odpowiedziałeś tylko na {{ $totalAnswered }} z {{ $totalQuestions }} pytań.
        </p>
    @endif
</div>

<div style="margin-top: 30px;">
    {{-- Guzik z możliwością powrotu do listy quizów --}}
    <a href="{{ route('quizzes.index') }}" 
       style="padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
        &laquo; Powrót do Listy Quizów
    </a>
</div>