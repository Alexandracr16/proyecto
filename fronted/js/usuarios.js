verificarToken();

// Listar usuarios
async function listarUsuarios(){
    const res = await fetch('http://localhost:8000/usuarios', {
        headers: {'Authorization':'Bearer '+obtenerToken()}
    });
    const usuarios = await res.json();
    const tbody = document.querySelector('#tablaUsuarios tbody');
    tbody.innerHTML = '';
    usuarios.forEach(u => {
        tbody.innerHTML += `<tr>
            <td>${u.id}</td>
            <td>${u.name}</td>
            <td>${u.email}</td>
            <td>${u.role}</td>
            <td>
                <button onclick="eliminarUsuario(${u.id})">Eliminar</button>
            </td>
        </tr>`;
    });
}

// Crear usuario
document.getElementById('formUsuario').addEventListener('submit', async e=>{
    e.preventDefault();
    const data = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        password: document.getElementById('password').value,
        role: document.getElementById('role').value
    };

    const res = await fetch('http://localhost:8000/usuarios', {
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'Authorization':'Bearer '+obtenerToken()
        },
        body: JSON.stringify(data)
    });

    const resp = await res.json();
    if(res.status === 200){
        alert('Usuario creado');
        listarUsuarios();
    } else {
        alert(resp.error);
    }
});

// Eliminar usuario
async function eliminarUsuario(id){
    if(!confirm('¿Eliminar usuario?')) return;
    const res = await fetch('http://localhost:8000/usuarios/'+id,{
        method:'DELETE',
        headers:{'Authorization':'Bearer '+obtenerToken()}
    });
    const data = await res.json();
    alert(data.mensaje || data.error);
    listarUsuarios();
}

listarUsuarios();