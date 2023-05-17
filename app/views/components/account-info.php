<div class='modal fade' id='accountInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h1 class='modal-title fs-5' id='exampleModalLabel'>Il tuo account</h1>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body text-center'>
                <form id='account-info-form'>
                    <label for='account-name'>Nome</label>
                    <input id='account-name' class='form-control my-2 text-center' required>
                    <label for='account-surname'>Cognome</label>
                    <input id='account-surname' class='form-control my-2 text-center' required>
                    <input type='button' id='reset-account-info' class='btn btn-secondary' value='Reset'>
                    <input type='submit' value='Modifica' class='btn btn-success'>
                </form>
                <hr>
                <form id='account-password-form' class='my-2'>
                    <label for='new-password'>Nuova password</label>
                    <input id='new-password' class='form-control my-2 text-center' type='password' required>
                    <label for='confirm-new-password'>Nuova password</label>
                    <input id='confirm-new-password' class='form-control my-2 text-center' type='password' required>
                    <input type='submit' value='Modifica' class='btn btn-success'>
                </form>
                <div id='account-alert'>

                </div>
            </div>
        </div>
    </div>
</div>