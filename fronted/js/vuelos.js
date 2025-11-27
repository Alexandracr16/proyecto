verificarToken();

// Listar vuelos
async function listarVuelos(){
    const res = await fetch('http://localhost:8000/vuelos',{
        headers:{'Authorization':'Bearer '+obtenerToken()}
    });
    const vuelos = await res.json();
    const tbody = document.querySelector('#tablaVuelos tbody');
    tbody.innerHTML = '';
    vuelos.forEach(v => {
        tbody.innerHTML += `<tr>
            <td>${v.id}</td>
            <td>${v.nave_id}</td>
            <td>${v.origin}</td>
            <td>${v.destination}</td>
            <td>${v.departure}</td>
            <td>${v.arrival}</td>
            <td>${v.price}</td>
            <td>
                <button onclick="eliminarVuelo(${v.id})">Eliminar</button>
            </td>
        </tr>`;
    });
}

// Crear vuelo
document.getElementById('formVuelo').addEventListener('submit', async e=>{
    e.preventDefault();
    const data = {
        nave_id: document.getElementById('nave_id').value,
        origin: document.getElementById('origin').value,
        destination: document.getElementById('destination').value,
        departure: document.getElementById('departure').value,
        arrival: document.getElementById('arrival').value,
        price: document.getElementById('price').value
    };

    const res = await fetch('http://localhost:8000/vuelos',{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'Authorization':'Bearer '+obtenerToken()
        },
        body: JSON.stringify(data)
    });

    const resp = await res.json();
    if(res.status===200){
        alert('Vuelo creado');
        listarVuelos();
    } else alert(resp.error);
});

// Eliminar vuelo
async function eliminarVuelo(id){
    if(!confirm('¿Eliminar vuelo?')) return;
    const res = await fetch('http://localhost:8000/vuelos/'+id,{
        method:'DELETE',
        headers:{'Authorization':'Bearer '+obtenerToken()}
    });
    const data = await res.json();
    alert(data.mensaje || data.error);
    listarVuelos();
}

listarVuelos();
