import Alpine from 'alpinejs';

/**
 * Panel del catálogo de servicios del dashboard admin:
 * actualiza el listado con fetch, sin recargar la página.
 * Sin JavaScript el formulario GET tradicional sigue funcionando.
 */
Alpine.data('catalogoServicios', () => ({
    cargando: false,
    intentos: 0,
    controlador: null,

    init() {
        window.addEventListener('popstate', () => {
            this.pedir(window.location.href, false);
        });
    },

    /** Cambió el orden o el filtro: envía el formulario por fetch. */
    aplicar() {
        const url = new URL(this.$refs.filtros.action, window.location.origin);

        new URLSearchParams(new FormData(this.$refs.filtros)).forEach((valor, clave) => {
            url.searchParams.set(clave, valor);
        });

        this.pedir(url.toString(), true);
    },

    /** Click en un enlace del paginador dentro del panel. */
    alHacerClick(evento) {
        const enlace = evento.target.closest('nav a');

        if (!enlace || !enlace.getAttribute('href')) {
            return;
        }

        evento.preventDefault();

        // El usuario quedó en el pie del panel: sube a ver la lista nueva.
        if (this.$el.getBoundingClientRect().top < 0) {
            this.$el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        this.pedir(enlace.href, true);
    },

    /** Pide el fragmento del catálogo e intercambia el contenido. */
    async pedir(url, empujar) {
        const intento = ++this.intentos;

        this.controlador?.abort();
        this.cargando = true;
        this.controlador = new AbortController();

        try {
            const respuesta = await fetch(url, {
                headers: {
                    'X-Fragmento': 'servicios',
                    'Accept': 'text/html',
                },
                signal: this.controlador.signal,
            });

            if (!respuesta.ok) {
                throw new Error(`HTTP ${respuesta.status}`);
            }

            const documento = new DOMParser().parseFromString(await respuesta.text(), 'text/html');
            const fragmento = documento.querySelector('#catalogo-contenido');

            if (!fragmento) {
                throw new Error('El catálogo no vino en la respuesta');
            }

            if (intento !== this.intentos) {
                return; // Una petición más nueva ya tomó el turno.
            }

            this.$refs.contenido.innerHTML = fragmento.innerHTML;

            if (empujar) {
                window.history.pushState({}, '', url);
            }
        } catch (error) {
            if (error.name !== 'AbortError') {
                window.location.href = url; // Red de seguridad: recarga completa.
            }
        } finally {
            if (intento === this.intentos) {
                this.cargando = false;
            }
        }
    },
}));
