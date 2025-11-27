verificarToken();

// Listar naves
async function listarNaves(){
    const res = await fetch('http://localhost:8000/naves',{
        headers:{'Authorization':'Bearer '+obtenerToken()}
    });
    const naves = await res.json();
    const tbody = document.querySelector('#tablaNaves tbody');
    tbody.innerHTML = '';
    naves.forEach(n => {
        tbody.innerHTML += `<tr>
            <td>${n.id}</td>
            <td>${n.name}</td>
            <td>${n.capacity}</td>
            <td>${n.model}</td>
            <td>
                <button onclick="eliminarNave(${n.id})">Eliminar</button>
            </td>
        </tr>`;
    });
}

// Crear nave
document.getElementById('formNave').addEventListener('submit', async e=>{
    e.preventDefault();
    const name = document.getElementById('name').value;
    const capacity = document.getElementById('capacity').value;
    const model = document.getElementById('model').value;

    const res = await fetch('http://localhost:8000/naves',{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'Authorization':'Bearer '+obtenerToken()
        },
        body: JSON.stringify({name,capacity,model})
    });
    const data = await res.json();
    if(res.status===200){
        alert('Nave creada');
        listarNaves();
    } else alert(data.error);
});

// Eliminar nave
async function eliminarNave(id){
    if(!confirm('¿Eliminar nave?')) return;
    const res = await fetch('http://localhost:8000/naves/'+id,{
        method:'DELETE',
        headers:{'Authorization':'Bearer '+obtenerToken()}
    });
    const data = await res.json();
    alert(data.mensaje || data.error);
    listarNaves();
}

listarNaves();
