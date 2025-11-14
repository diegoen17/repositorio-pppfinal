document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.getElementById('modo-toggle');
  const body = document.body;

  // función para actualizar texto/atributos del botón
  function actualizarToggle(modo) {
    if (!toggle) return;
    if (modo === 'oscuro') {
      toggle.textContent = '☀️ Modo claro';
      toggle.setAttribute('aria-pressed', 'true');
      toggle.title = 'Cambiar a modo claro';
    } else {
      toggle.textContent = '🌙 Modo oscuro';
      toggle.setAttribute('aria-pressed', 'false');
      toggle.title = 'Cambiar a modo oscuro';
    }
  }

  //detectar preferencia de SO
  const preferenciaGuardada = localStorage.getItem('modo');
  if (preferenciaGuardada === 'oscuro') {
    body.classList.add('dark-mode');
    actualizarToggle('oscuro');
  } else if (preferenciaGuardada === 'claro') {
    body.classList.remove('dark-mode');
    actualizarToggle('claro');
  } else {
    // si no hay preferencia guardada, respetar la preferencia del sistema
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      body.classList.add('dark-mode');
      localStorage.setItem('modo', 'oscuro');
      actualizarToggle('oscuro');
    } else {
      actualizarToggle('claro');
    }
  }

  // Si no existe el botón, no hacemos nada más
  if (!toggle) return;

  // listener del botón
  toggle.addEventListener('click', () => {
    const modoActual = body.classList.toggle('dark-mode') ? 'oscuro' : 'claro';
    localStorage.setItem('modo', modoActual);
    actualizarToggle(modoActual);
  });
});