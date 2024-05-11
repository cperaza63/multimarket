
    // Recuerda coloxar el id=myTab en el ul que contiene las pestañas
    document.addEventListener('DOMContentLoaded', () => {
        //verificamos si existe un tab guardado
        var activeTab= localStorage.getItem('activeTab');
        if (activeTab != null) {
            var tab = new bootstrap.Tab(document.getElementById(activeTab));
            tab.show();
        }
        //guardamos el id del tab cuando cambia
        document.getElementById("myTab").addEventListener('shown.bs.tab', function(event) {
            localStorage.setItem('activeTab', event.target.getAttribute('id'));
        })
    });