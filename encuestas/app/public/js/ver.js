function eliminarEncuesta(id) {
    if (confirm("¿Seguro que deseas eliminar esta encuesta?")) {
        fetch(`/encuestas/encuestas/eliminar/${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Encuesta eliminada correctamente");
                    window.location.href = "/encuestas";
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => console.error(err));
    }
}