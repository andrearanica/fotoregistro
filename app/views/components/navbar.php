<nav class='navbar navbar-expand-lg navbar-dark' style='background-color: rgb(4, 46, 212)'>
  <div class='container-fluid'>
    <a class='navbar-brand'>Dashboard</a>
    <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
      <span class='navbar-toggler-icon'></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarSupportedContent'>
      <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
        <!--<li class='nav-item'>
          <a class='nav-link active' aria-current='page' href='#'>Home</a>
        </li>-->
        <li class='nav-item' data-bs-toggle="modal" data-bs-target="#accountInfo">
            <button class='btn'><a class='nav-link'>Il mio account</a></button>
        </li>
        <li class='nav-item'>
            <button class='btn'><a id='logout' class='nav-link'>Logout</a></button>
        </li>
      </ul>
    </div>
  </div>
</nav>
<script>
document.getElementById('logout').addEventListener('click', () => {
    window.localStorage.setItem('token', '')
    window.location.href = '../public'
})
</script>