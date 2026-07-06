function initPointAllocator(config) {
  config.minimo = parseInt(config.minimo);
  config.maximo = parseInt(config.maximo);
  config.base = parseInt(config.base);

  const plusButtons = document.querySelectorAll(".plus-btn");
  const minusButtons = document.querySelectorAll(".minus-btn");

  //Mostrar contador de puntos gratuitos en atributos ini
  function actualizarContadores() {
    const inputs = document.querySelectorAll(".point-input");

    let totales = {};

    inputs.forEach((input) => {
      const categoria = input.dataset.categoria;
      const valor = parseInt(input.value);

      if (!totales[categoria]) {
        totales[categoria] = 0;
      }

      // totales[categoria] += valor - config.minimo;
      let base = config.base ?? 0; //nuevo 25/6
      totales[categoria] += valor - base; //nuevo 25/6
    });
    //posible bug: +"_actual"
    Object.keys(totales).forEach((categoria) => {
      const contador = document.getElementById(
        categoria.toLowerCase() + "_actual",
      );

      if (contador) {
        contador.textContent = totales[categoria];
      }
    });
  }
  //Mostrar contador de puntos gratuitos en atributos fin

  plusButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const container = button.closest(".point-row");
      const input = container.querySelector(".point-input");

      let value = parseInt(input.value);

      if (value < config.maximo) {
        input.value = value + 1;
        actualizarContadores();
      }
    });
  });

  minusButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const container = button.closest(".point-row");
      const input = container.querySelector(".point-input");

      let value = parseInt(input.value);

      if (value > config.minimo) {
        input.value = value - 1;
        actualizarContadores();
      }
    });
  });
  actualizarContadores();
}
