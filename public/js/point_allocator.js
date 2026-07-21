function initPointAllocator(config) {
  config.minimo = parseInt(config.minimo);
  config.maximo = parseInt(config.maximo);
  config.base = parseInt(config.base);

  const form = document.querySelector("form");
  const tipoValidacion = form.dataset.tipoValidacion;
  const distribucionEsperada = JSON.parse(form.dataset.distribucion || "null");

  const btnContinuar = document.getElementById("btn-continuar");
  const mensajeValidacion = document.getElementById("mensaje_validacion");

  function calcularTotalActual() {
    let total = 0;
    document.querySelectorAll(".point-input").forEach((input) => {
      total += parseInt(input.value) - (config.base ?? 0);
    });
    return total;
  }

  function totalMaximoPermitido() {
    if (typeof distribucionEsperada === "number") return distribucionEsperada;
    if (Array.isArray(distribucionEsperada)) {
      return distribucionEsperada.reduce((a, b) => a + b, 0);
    }
    return Infinity;
  }

  function obtenerTotalesPorCategoria() {
    const totales = {};
    document.querySelectorAll(".point-input").forEach((input) => {
      const categoria = input.dataset.categoria;
      if (!totales[categoria]) totales[categoria] = 0;
      totales[categoria] += parseInt(input.value) - (config.base ?? 0);
    });
    return totales;
  }

  function permutaciones(array) {
    if (array.length <= 1) return [array];
    const resultado = [];
    array.forEach((valor, i) => {
      const resto = [...array.slice(0, i), ...array.slice(i + 1)];
      permutaciones(resto).forEach((perm) => resultado.push([valor, ...perm]));
    });
    return resultado;
  }

  function esDistribucionPosible(totalesPorCategoria) {
    if (
      tipoValidacion !== "categorias" ||
      !Array.isArray(distribucionEsperada)
    ) {
      return true;
    }

    const categorias = Object.keys(totalesPorCategoria);
    const valoresActuales = categorias.map((c) => totalesPorCategoria[c]);
    const perms = permutaciones(distribucionEsperada);

    // ¿Existe alguna permutación [3,5,7] donde cada categoría
    // pueda "caber" (valor actual <= valor de esa permutación)?
    return perms.some((perm) =>
      valoresActuales.every((valor, i) => valor <= perm[i]),
    );
  }

  function mostrarMensaje(texto, tipo) {
    if (!mensajeValidacion) return;

    const estilos = {
      exito:
        "mt-3 p-3 rounded-lg border border-green-600 bg-green-950/50 text-green-300 text-sm font-semibold",
      aviso:
        "mt-3 p-3 rounded-lg border border-yellow-600 bg-yellow-950/50 text-yellow-300 text-sm font-semibold",
      error:
        "mt-3 p-3 rounded-lg border border-red-600 bg-red-950/50 text-red-300 text-sm font-semibold",
    };

    mensajeValidacion.textContent = texto;
    mensajeValidacion.className = estilos[tipo] || estilos.aviso;
  }

  function mostrarAvisoLimite() {
    mostrarMensaje(
      "Ya has repartido el máximo de puntos permitido en esta categoría o en total. Quita alguno para poder asignar otro.",
      "error",
    );
    clearTimeout(window.__pointAllocatorResetMensaje);
    window.__pointAllocatorResetMensaje = setTimeout(() => {
      const totales = obtenerTotalesPorCategoria();
      validarYActualizarBoton(totales);
    }, 1500);
  }

  function actualizarContadores() {
    const inputs = document.querySelectorAll(".point-input");
    let totales = {};

    inputs.forEach((input) => {
      const categoria = input.dataset.categoria;
      const valor = parseInt(input.value);

      if (!totales[categoria]) {
        totales[categoria] = 0;
      }

      let base = config.base ?? 0;
      totales[categoria] += valor - base;
    });

    Object.keys(totales).forEach((categoria) => {
      const contador = document.getElementById(
        categoria.toLowerCase() + "_actual",
      );
      if (contador) {
        contador.textContent = totales[categoria];
      }
    });

    validarYActualizarBoton(totales);
  }

  // --- NUEVO: validación en tiempo real ---
  function validarYActualizarBoton(totales) {
    if (!btnContinuar) return;

    let valido = false;
    let mensaje = "";

    if (
      tipoValidacion === "categorias" &&
      Array.isArray(distribucionEsperada)
    ) {
      const valores = Object.values(totales).sort((a, b) => a - b);
      const esperado = [...distribucionEsperada].sort((a, b) => a - b);

      valido = JSON.stringify(valores) === JSON.stringify(esperado);

      if (!valido) {
        const totalActual = valores.reduce((a, b) => a + b, 0);
        const totalEsperado = esperado.reduce((a, b) => a + b, 0);

        if (totalActual < totalEsperado) {
          mensaje = `Te faltan ${totalEsperado - totalActual} puntos por repartir.`;
        } else if (totalActual > totalEsperado) {
          mensaje = `Has repartido ${totalActual - totalEsperado} puntos de más.`;
        } else {
          mensaje = `La distribución entre categorías no es correcta. Recuerda: debe quedar ${esperado.join(" / ")} (en cualquier orden entre categorías).`;
        }
      }
    } else if (
      tipoValidacion === "total" &&
      typeof distribucionEsperada === "number"
    ) {
      const totalActual = Object.values(totales).reduce((a, b) => a + b, 0);
      valido = totalActual === distribucionEsperada;

      if (!valido) {
        const diferencia = distribucionEsperada - totalActual;
        mensaje =
          diferencia > 0
            ? `Te faltan ${diferencia} puntos por repartir.`
            : `Has repartido ${Math.abs(diferencia)} puntos de más.`;
      }
    } else {
      valido = true; // sin datos de validación, no bloqueamos por precaución
    }

    btnContinuar.disabled = !valido;

    if (mensajeValidacion) {
      if (valido) {
        mostrarMensaje(
          "✓ Distribución correcta. ¡Listo para continuar!",
          "exito",
        );
      } else {
        mostrarMensaje(mensaje, "aviso");
      }
    }
  }
  // --- FIN NUEVO ---

  function actualizarCirculos() {
    document.querySelectorAll(".point-row").forEach((row) => {
      const input = row.querySelector(".point-input");
      if (!input) return;

      const valor = parseInt(input.value);
      row.querySelectorAll(".point-dot").forEach((dot) => {
        const nivel = parseInt(dot.dataset.value);
        if (nivel <= valor) {
          dot.classList.add("bg-red-700");
          dot.classList.remove("bg-transparent");
        } else {
          dot.classList.remove("bg-red-700");
          dot.classList.add("bg-transparent");
        }
      });
    });
  }

  document.querySelectorAll(".point-dot").forEach((dot) => {
    dot.addEventListener("click", () => {
      const row = dot.closest(".point-row");
      const input = row.querySelector(".point-input");
      const categoria = input.dataset.categoria;

      const valorClicado = parseInt(dot.dataset.value);
      const valorActual = parseInt(input.value);

      let nuevoValor =
        valorClicado === valorActual
          ? Math.max(valorClicado - 1, config.minimo)
          : valorClicado;

      const diferencia = nuevoValor - valorActual;

      if (diferencia > 0 && tipoValidacion === "categorias") {
        const totalesSimulados = obtenerTotalesPorCategoria();
        totalesSimulados[categoria] =
          (totalesSimulados[categoria] || 0) + diferencia;

        if (!esDistribucionPosible(totalesSimulados)) {
          mostrarAvisoLimite();
          return;
        }
      }

      if (diferencia > 0) {
        const totalActual = calcularTotalActual();
        const totalMax = totalMaximoPermitido();

        if (totalActual + diferencia > totalMax) {
          mostrarAvisoLimite();
          return;
        }
      }

      input.value = nuevoValor;
      actualizarContadores();
      actualizarCirculos();
    });
  });

  actualizarContadores();
  actualizarCirculos();
}
