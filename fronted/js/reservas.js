verificarToken();

// Listar reservas
async function listarReservas(){
    const res = await fetch('http://localhost:8000/reservas',{
        headers:{'Authorization':'Bearer '+obtenerToken()}
    });
    const reservas = await res.json();
    const tbody = document.querySelector('#tablaReservas tbody');
    tbody.innerHTML = '';
    reservas.forEach(r => {
        tbody.innerHTML += `<tr>
            <td>${r.id}</td>
            <td>${r.user_id}</td>
            <td>${r.flight_id}</td>
            <td>${r.status}</td>
            <td>${r.reserved_at}</td>
            <td>
                ${r.status==='activa'?`<button onclick="cancelarReserva(${r.id})">Cancelar</button>`:''}
            </td>
        </tr>`;
    });
}

// Crear reserva
document.getElementById('formReserva').addEventListener('submit', async e=>{
    e.preventDefault();
    const data = {
        user_id: document.getElementById('user_id').value,
        flight_id: document.getElementById('flight_id').value
    };

    const res = await fetch('http://localhost:8000/reservas',{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'Authorization':'Bearer '+obtenerToken()
        },
        body: JSON.stringify(data)
    });

    const resp = await res.json();
    if(res.status===200){
        alert('Reserva creada');
        listarReservas();
    } else alert(resp.error);
});

// Cancelar reserva
async function cancelarReserva(id){
    if(!confirm('¿Cancelar reserva?')) return;
    const res = await fetch('http://localhost:8000/reservas/cancelar/'+id,{
        method:'PUT',
        headers:{'Authorization':'Bearer '+obtenerToken()}
    });
    const data = await res.json();
    alert(data.mensaje || data.error);
    listarReservas();
}

listarReservas();
