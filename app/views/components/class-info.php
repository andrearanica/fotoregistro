<div class='modal fade' id='class-info-modal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h1 class='modal-title fs-5' id='exampleModalLabel'>Modifica classe</h1>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body text-center'>
        <form id='edit-class-form'>
            <input id='edit-class-id' style='display: none;'>
            <label for='edit-class-name'>Nome della classe</label>
            <input id='edit-class-name' class='form-control my-2 text-center'>
            <input type='submit' class='btn btn-success' value='Modifica'>
        </form>
        <div id='class-edit-alert'></div>
      </div>
    </div>
  </div>
</div>