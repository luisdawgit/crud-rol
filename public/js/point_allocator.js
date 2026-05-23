function initPointAllocator(config) {
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

      totales[categoria] += valor - config.minimo;
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

    //seguro ini
    //posible bug: +"_actual"
    // Object.keys(totales).forEach((categoria) => {
    //   console.log(categoria); //debug
    //   console.log(categoria.toLowerCase() + "_actual"); //debug
    //   const contador = document.getElementById(
    //     categoria.toLowerCase() + "_actual",
    //   );

    //   if (contador) {
    //     contador.textContent = totales[categoria];
    //   }
    // });
    //seguro fin
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
