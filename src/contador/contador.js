var iniciou = false;
var tempo = 25;
var segundos = 60 * tempo;
var pausas = 15;

window.onload = function() {
    display = document.querySelector('#tempo');
    startTimer(segundos, display);
}

function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        if (!iniciou) { return false};
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;
      
        if (--timer < 0) {
            timer = duration;
            // Acabou
            if ( pausas == 0 ){
                iniciou = false;
                document.getElementById("botao").value = "Iniciar";
                pausas = 15;
            }
            // Pausa Longa
            else if ( pausas === 8 ) {
                tempo = 20;
                pausas -= 1;
                document.getElementById("imagem").src = "../imgs/20min.jpg"
                document.getElementById("texto").value = "Hora da folga longa"
            }
            // Pausa Media
            else if ( (pausas % 2) === 1 ){
                tempo = 25;
                pausas -= 1;
                document.getElementById("imagem").src = "../imgs/25min.jpg"
                document.getElementById("texto").value = "Hora de trabalhar"
                
            } 
            // Tempo corrido
            else if ( (pausas % 2) !== 1 ){
                tempo = 5;
                pausas -= 1;
                document.getElementById("imagem").src = "../imgs/5min.jpg"
                document.getElementById("texto").value = "Descanse um pouco"
            }
        }
    }, 1000);    
}

function start(){
    var botao = document.getElementById("botao")
    if (!iniciou){
        iniciou = true;
        botao.value = "Parar"
    }else{
        iniciou = false;
        botao.value = "Retomar";
    }
}