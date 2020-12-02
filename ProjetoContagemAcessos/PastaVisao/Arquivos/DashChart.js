const data = {
    labels: <?=$Dias?>,
    datasets: [
        { values: <?=$Data?> }
    ]
}

const chart = new frappe.Chart("#ChartDiaDia", {  // or a DOM element,
                                            // new Chart() in case of ES6 module with above usage
    
    data: data,
    type: 'bar', // or 'bar', 'line', 'scatter', 'pie', 'percentage'
    height: 400,

barOptions: {
   spaceRatio: 0.5

	},
axisOptions: {
    xAxisMode: 'tick',
    xIsSeries: true
},
lineOptions: {
    //dotSize: 1 // default: 4
      hideDots: 1

},
tooltipOptions: {
    formatTooltipX: d => ('Dia '+d ),
    formatTooltipY: d => d==0?("Nenhum acesso"):(d==1?(d + ' acesso'):(d + ' acessos')),

},    valuesOverPoints:1,
    colors: ['#019e91']
})


document.querySelector("#NotificacaoChart").innerHTML='<?=$ChartCSS?>'+'<?=$ChartHTML?>';
