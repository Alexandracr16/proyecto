// Función para guardar token en localStorage
function guardarToken(token) {
    localStorage.setItem('token', token);
}

// Función para obtener token
function obtenerToken() {
    return localStorage.getItem('token');
}

// Función para redirigir al dashboard si hay token
function verificarTokenLogin() {
    if(obtenerToken()){
        window.location.href = 'dashboard.html';
    }
}

// Evento submit del formulario de login
document.addEventListener('DOMContentLoaded', () => {
    verificarTokenLogin();

    const formLogin = document.getElementById('formLogin');
    formLogin.addEventListener('submit', async e => {
        e.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        try {
            const res = await fetch('http://localhost:8000/login', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({email, password})
            });

            const data = await res.json();

            if(res.status === 200){
                guardarToken(data.token);
                window.location.href = 'dashboard.html';
            } else {
                alert(data.error);
            }

        } catch(err) {
            console.error('Error en login:', err);
            alert('Error de conexión con el servidor');
        }
    });
});
