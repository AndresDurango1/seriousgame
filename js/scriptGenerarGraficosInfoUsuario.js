fetch('../php/obtenerInformacionGraficosInfoUsuario.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al obtener los datos');
        }
        return response.json();
    })
    .then(data => {
        //Obtencion de los datos para la gráfica 1:
        const partidasLabels = data.partidas.nombre_nivel;
        const partidasCompletadas = data.partidas.completados.map(completado => Number(completado));
        const partidasNoCompletadas = data.partidas.no_completados.map(no_completado => Number(no_completado));
        //Obtencion de los datos para la grafica 2:
        const promediosLabels = data.averageScores.niveles
        const promediosData = data.averageScores.puntajes.map(puntaje => Number(puntaje));
        //Obtencion de los datos para la grafica 3:
        function timeToSeconds(time) { 
            if (time === null) return 0;
            const parts = time.split(':'); 
            return (+parts[0] * 3600) + (+parts[1] * 60) + (+parts[2]);
        }
        const tiemposLabels = data.tiemposTranscurridos.niveles
        const tiemposData = data.tiemposTranscurridos.tiempo.map(timeToSeconds);
        function secondsToMinutesSeconds(seconds) { 
            const mins = Math.floor(seconds / 60); 
            const secs = seconds % 60; 
            return `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`; 
        }
        //Creacion de los contextos (ctx) para cada grafico
        const ctx1 = document.getElementById('myChart1').getContext('2d');
        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const ctx3 = document.getElementById('myChart3').getContext('2d');

        //validacion de los contextos para cada gráfico
        if (!ctx1) {
            console.error('No se pudo obtener el contexto del gráfico');
            return;
        }
        else if (!ctx2) {
            console.error('No se pudo obtener el contexto del gráfico');
            return;
        }
        else if (!ctx3) {
            console.error('No se pudo obtener el contexto del gráfico');
            return;
        }
        const backgroundColor = [
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 205, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(201, 203, 207, 0.2)'
        ];
        const borderColor = [
            'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(201, 203, 207)'
        ];
        //Creacion del 1er Gráfico
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: partidasLabels,
                datasets: [{
                    label: 'Completados',
                    data: partidasCompletadas,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'No Completados',
                    data: partidasNoCompletadas,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Niveles Completados vs No Completados'
                    }
                }
            }
        });
        //Creacion del 2do Gráfico
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: promediosLabels,
                datasets: [{
                    label: 'Puntaje Promedio por nivel',
                    data: promediosData,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Puntaje Promedio por nivel'
                        }
                    },
                }
            }
        });
        //Creacion del 3er Gráfico
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: tiemposLabels,
                datasets: [{
                    label: 'Tiempo promedio trascurrido por nivel',
                    data: tiemposData,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                const index = tooltipItem.dataIndex;
                                const timeInSeconds = bestTimesData[index]; 
                                const timeFormatted = secondsToMinutesSeconds(timeInSeconds); 
                                return `${bestTimesLeyend[index]}: ${timeFormatted}`;
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Tiempo promedio acumulado (s)'
                        }
                    },
                }
            }
        });
    }).catch(error => console.error('Error:', error));