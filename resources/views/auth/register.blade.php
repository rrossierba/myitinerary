@extends('layouts.master')

@section('title', 'Register')

@section('scripts')
    <script>
        $(document).ready(function () {
            console.log('caricata')
            $('form[name=register]').submit(function (event) {
                // Funzione di validazione generica
                function validateField({ inputName, regex = null, emptyMessage, formatMessage, errorId, equalsTo = null, notEqualMessage }) {
                    const $inputField = $(`input[name=${inputName}]`);
                    const value = $inputField.val().trim();

                    if (value === '') {
                        error = true;
                        $(`#${errorId}`).text(emptyMessage);
                        $inputField.addClass('invalidFocus').focus();
                        $(`#${errorId}`).show();
                    } else if (!error && regex && !regex.test(value)) {
                        error = true;
                        $(`#${errorId}`).text(formatMessage);
                        $inputField.addClass('invalidFocus').focus();
                        $(`#${errorId}`).show();
                    } else if (!error && equalsTo && value !== equalsTo) {
                        error = true;
                        $(`#${errorId}`).text(notEqualMessage);
                        $inputField.addClass('invalidFocus').focus();
                        $(`#${errorId}`).show();
                    }
                    else {
                        $inputField.removeClass('invalidFocus');
                        $(`#${errorId}`).hide();
                        $(`#${errorId}`).empty();
                    }
                }

                event.preventDefault();
                let error = false;
                const fields = [
                    {
                        inputName: 'name',
                        regex: /^[a-zA-Z ]+$/,
                        emptyMessage: 'Il nome è obbligatorio',
                        formatMessage: 'Il nome non può contenere caratteri speciali o cifre',
                        errorId: 'errorNameDiv'
                    },
                    {
                        inputName: 'email',
                        regex: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/,
                        emptyMessage: 'La email è obbligatoria',
                        formatMessage: 'Il formato della email non è valido',
                        errorId: 'errorMailDiv'
                    },
                    {
                        inputName: 'password',
                        regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&])[A-Za-z\d@.#$!%*?&]{8,15}$/,
                        emptyMessage: 'La password è obbligatoria',
                        formatMessage: 'La password deve contenere: maiuscole, minuscole, numeri, simboli',
                        errorId: 'errorPasswordDiv'
                    },
                    {
                        inputName: 'password_confirmation',
                        emptyMessage: 'Non hai confermato la password',
                        errorId: 'errorPasswordConfirmDiv',
                        equalsTo: $(`input[name=password]`).val(),
                        notEqualMessage: 'La conferma della password non coincide'
                    }
                ];

                fields.forEach(field => {
                    if (!error)
                        validateField(field);
                });

                if (!error) {
                    $.ajax({
                        url: '{{route('api.user.check')}}',
                        async : true,
                        data : {
                            email:$('input[name=email]').val().trim()
                        },
                        success: function(data){
                            console.log(data);
                            if(data.email_exists === true){
                                $('#errorModal .modal-body').html(`Email “${$('input[name=email]').val()}” già utilizzata, scegline un'altra.`);
                                var modal = new bootstrap.Modal(document.getElementById('errorModal'));
                                modal.show();
                            }
                            else
                            $("form[name='register'")[0].submit();
                        }
                    });
                }

            });
        });
    </script>
@endsection

@section('body')
    
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Errore</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 justify-content-center">
        <div class="col-12 col-lg-3 d-none d-lg-block">
            <img src="https://colorlib.com/etc/regform/colorlib-regform-7/images/signup-image.jpg" alt="" class="float-end">
        </div>
        <div class="col-12 col-lg-6">
            <form name="register" id="register-form" action="{{ route('register') }}" method="post">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control" id="floatingInput" placeholder="Nome">
                    <label for="floatingInput">Nome</label>
                    <div class="alert alert-danger" id="errorNameDiv" style="display: none"></div>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="Indirizzo Email">
                    <label for="floatingInput">Indirizzo Email</label>
                    <div class="alert alert-danger" id="errorMailDiv" style="display: none"></div>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="floatingPassword"
                        placeholder="Password">
                    <label for="floatingPassword">Password</label>
                    <div class="alert alert-danger" id="errorPasswordDiv" style="display: none"></div>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password_confirmation" id="floatingPassword"
                        placeholder="Conferma Password">
                    <label for="floatingPassword">Conferma Password</label>
                    <div class="alert alert-danger" id="errorPasswordConfirmDiv" style="display: none"></div>
                </div>

                <div class="form-group text-center mb-3">
                    <label for="register-submit" class="btn btn-primary w-100"><i class="bi bi-person-plus"></i>
                        Register</label>
                    <input id="register-submit" class="d-none" type="submit" value="Register">
                </div>
            </form>
            <hr>
            <p class="text-center">Hai già un account? <a href="{{route('login')}}">Login</a></p>
        </div>
    </div>
@endsection