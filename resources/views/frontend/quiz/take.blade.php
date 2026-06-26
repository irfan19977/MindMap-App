@extends('frontend.layouts.app')

@section('content')
    <header class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="intro-body">
            <div class="overlay"></div>
            <div class="container text-left">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="no-pad bold">{{ $quiz->title }}</h1>
                        <p class="lead">{{ $quiz->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="showcase section-small">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3>Quiz: {{ $quiz->title }}</h3>
                                <div>
                                    <span class="badge bg-info"><i class="fa fa-clock"></i> {{ $quiz->time_limit }} menit</span>
                                    <span class="badge bg-warning"><i class="fa fa-trophy"></i> Lulus: {{ $quiz->passing_score }}%</span>
                                </div>
                            </div>

                            @if($currentAttempt)
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> Anda sedang melanjutkan quiz yang sebelumnya.
                                </div>
                            @endif

                            <form id="quizForm" method="POST" action="{{ route('quiz.submit') }}">
                                @csrf
                                <input type="hidden" name="quiz_attempt_id" value="{{ $currentAttempt->id ?? '' }}" id="quizAttemptId">
                                
                                @foreach($quiz->quizQuestions as $index => $question)
                                    <div class="card mb-3 question-card" data-question-id="{{ $question->id }}">
                                        <div class="card-body">
                                            <h5>Soal {{ $index + 1 }} ({{ $question->points }} poin)</h5>
                                            <p>{{ $question->question }}</p>
                                            
                                            @if($question->options)
                                                <div class="options-container">
                                                    @foreach($question->options as $option)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" 
                                                                   name="answers[{{ $index }}][quiz_question_id]" 
                                                                   value="{{ $question->id }}"
                                                                   id="option_{{ $index }}_{{ $loop->iteration }}"
                                                                   data-option="{{ $option }}"
                                                                   onchange="selectOption(this)">
                                                            <input type="hidden" name="answers[{{ $index }}][user_answer]" id="answer_{{ $index }}" value="">
                                                            <label class="form-check-label" for="option_{{ $index }}_{{ $loop->iteration }}">
                                                                {{ $option }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="form-group">
                                                    <textarea class="form-control" 
                                                              name="answers[{{ $index }}][user_answer]" 
                                                              rows="3" 
                                                              placeholder="Masukkan jawaban Anda"></textarea>
                                                    <input type="hidden" name="answers[{{ $index }}][quiz_question_id]" value="{{ $question->id }}">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fa fa-paper-plane"></i> Submit Quiz
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function selectOption(radio) {
            const answerInput = document.getElementById(radio.name.replace('quiz_question_id', 'user_answer'));
            if(answerInput) {
                answerInput.value = radio.dataset.option;
            }
        }

        // Start quiz if no current attempt
        document.addEventListener('DOMContentLoaded', function() {
            const quizId = '{{ $quiz->id }}';
            const attemptIdInput = document.getElementById('quizAttemptId');
            
            if (!attemptIdInput.value) {
                fetch('/api/quiz/start', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        quiz_id: quizId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        attemptIdInput.value = data.attempt.id;
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });

        // Form submission
        document.getElementById('quizForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const attemptId = document.getElementById('quizAttemptId').value;
            
            if (!attemptId) {
                alert('Quiz belum dimulai. Silakan tunggu sebentar atau refresh halaman.');
                return;
            }
            
            const answers = [];
            
            // Collect answers from form data
            const formData = new FormData(this);
            
            // Get all answer inputs
            const answerInputs = document.querySelectorAll('input[name^="answers"]');
            const textareas = document.querySelectorAll('textarea[name^="answers"]');
            
            // Process radio button answers (multiple choice)
            answerInputs.forEach(input => {
                if (input.type === 'radio' && input.checked) {
                    const name = input.name;
                    const index = name.match(/\[(\d+)\]/)[1];
                    const questionId = input.value;
                    const option = input.dataset.option;
                    
                    answers.push({
                        quiz_question_id: questionId,
                        user_answer: option
                    });
                }
            });
            
            // Process textarea answers (essay)
            textareas.forEach(textarea => {
                const name = textarea.name;
                const index = name.match(/\[(\d+)\]/)[1];
                const questionId = document.querySelector(`input[name="answers[${index}][quiz_question_id]"]`).value;
                const userAnswer = textarea.value.trim();
                
                if (userAnswer) {
                    answers.push({
                        quiz_question_id: questionId,
                        user_answer: userAnswer
                    });
                }
            });
            
            if (answers.length === 0) {
                alert('Silakan jawab setidaknya satu pertanyaan sebelum submit.');
                return;
            }
            
            fetch('/api/quiz/submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    quiz_attempt_id: attemptId,
                    answers: answers
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = `/quiz/result/${attemptId}`;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat submit quiz');
            });
        });
    </script>
@endsection
