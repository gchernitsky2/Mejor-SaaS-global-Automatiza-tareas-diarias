
function registrarTarea() {
    const tarea = document.getElementById('tarea').value;
    const responsable = document.getElementById('responsable').value;
    const fecha = document.getElementById('fecha').value;

    if (tarea && responsable && fecha) {
        const contenedor = document.getElementById('tareas');
        const item = document.createElement('div');
        item.innerHTML = `<strong>${tarea}</strong> - ${responsable} - ${fecha}`;
        contenedor.appendChild(item);
        document.getElementById('tarea').value = '';
        document.getElementById('responsable').value = '';
        document.getElementById('fecha').value = '';
    } else {
        alert('Completa todos los campos.');
    }
}
