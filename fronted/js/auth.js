// Guardar token en localStorage
function guardarToken(token) {
    localStorage.setItem('token', token);
}

// Obtener token
function obtenerToken() {
    return localStorage.getItem('token');
}

// Eliminar token (logout)
function logout() {
    fetch('http://localhost:8000/logout', {
        method: 'POST',
        headers: {
            'Authorization': 'Bearer ' + obtenerToken()
        }
    }).then(res => res.json())
      .then(data => {
          console.log(data.mensaje);
          localStorage.removeItem('token');
          window.location.href = 'index.html';
      });
}

// Verificar si hay token, si no redirige al login
function verificarToken() {
    if(!obtenerToken()){
        window.location.href = 'index.html';
    }
}
