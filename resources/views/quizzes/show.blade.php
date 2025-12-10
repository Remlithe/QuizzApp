@php
    // Ułatwienie dostępu do URL
    $baseRoute = route('quizzes.question', ['quiz' => $quiz->id, 'questionNumber' => 1]);

    // Opcjonalne odpowiedzi (zakładamy statyczne A, B, C, D na potrzeby demonstracji)
    $options = ['A', 'B', 'C', 'D'];

    
@endphp

<h1>{{ $quiz->title }}</h1>

<div style="display: flex; gap: 20px;">

    <div style="flex: 3;">
        <h2>Pytanie {{ $questionNumber }} z {{ $totalQuestions }}</h2>

        <form method="POST" action="{{ route('quizzes.store_answer', ['quiz' => $quiz->id, 'questionNumber' => $questionNumber]) }}">
            @csrf

           <input type="hidden" name="question_id" value="{{ $currentQuestion->id }}">

            <h3>{{ $currentQuestion->text }}</h3>

            @foreach($currentQuestion->options as $key => $optionText)
                <div style="margin-bottom: 10px;">
                    <label class="list-group-item list-group-item-action">
                            <input 
                                class="form-check-input me-1" 
                                type="radio" 
                                name="answer" 
                                value="{{ $key }}"
                                {{ ($userAnswer === $key) ? 'checked' : '' }}
                            >
                            <strong>{{ $key }}.</strong> {{ $optionText }}
                        </label>
                </div>
            @endforeach

            <button type="submit" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; cursor: pointer;">
                Wybierz Odpowiedź
            </button>

            @if ($questionNumber > 1)
                <a href="{{ route('quizzes.question', ['quiz' => $quiz->id, 'questionNumber' => $questionNumber - 1]) }}"
                   style="margin-left: 10px; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none;">
                    Wróć (Back)
                </a>
            @endif

        </form>

    </div>

    <div style="flex: 1; border-left: 1px solid #ccc; padding-left: 20px;">
        <h3>Panel Pytań</h3>
        <div style="display: flex; flex-wrap: wrap; gap: 5px;">
            @for ($i = 1; $i <= $totalQuestions; $i++)
                @php
                    $q = $questions->get($i - 1);
                    $isAnswered = array_key_exists($q->id, $progress);
                    $isActive = $i == $questionNumber;

                    $color = $isActive ? 'darkred' : ($isAnswered ? 'green' : 'gray');
                    $fontWeight = $isActive ? 'bold' : 'normal';
                @endphp

                <a href="{{ route('quizzes.question', ['quiz' => $quiz->id, 'questionNumber' => $i]) }}"
                   style="
                       display: block;
                       width: 30px;
                       height: 30px;
                       line-height: 30px;
                       text-align: center;
                       border: 1px solid #ccc;
                       text-decoration: none;
                       color: white;
                       background-color: {{ $color }};
                       font-weight: {{ $fontWeight }};
                   ">
                    {{ $i }}
                </a>
            @endfor
        </div>
        <p style="margin-top: 20px;"><span style="color: green;">Zielony:</span> Odpowiedziano</p>
        <p><span style="color: darkred;">Czerwony:</span> Aktualne</p>
    </div>
</div>