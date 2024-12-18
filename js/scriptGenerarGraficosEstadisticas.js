fetch('../php/obtenerInformacionGraficosEstadisticas.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al obtener los datos');
        }
        return response.json();
    })
    .then(data => {
        //Obtencion de los datos para la grafica 1: Grafica de barras para los Jugadores con los 10 mejores puntajes acumulados
        const topLabels = data.topScores.usuarios;
        const topData = data.topScores.puntajes.map(puntaje => Number(puntaje));
        const topLeyend = data.topScores.nombres_completos;
        //Obtencion de los datos para la grafica 2: Grafica de barras para los Jugadores con los 10 peores puntajes acumulados
        const bottomLabels = data.bottomScores.usuarios;
        const bottomData = data.bottomScores.puntajes.map(puntaje => Number(puntaje));
        const bottomLeyend = data.bottomScores.nombres_completos;
        //Obtencion de los datos para la grafica 3: Grafica de pastel para los promedios de los puntajes
        const promediosLabels = data.averageScores.usuarios;
        const promediosLeyend = data.averageScores.niveles
        const promediosData = data.averageScores.puntajes.map(puntaje => Number(puntaje));
        //Obtencion de los datos para la grafica 4: Grafica de barras para los mejores tiempos por nivel
        function timeToSeconds(time) {
            if (time === null) return null;
            const parts = time.split(':');
            return (+parts[0] * 3600) + (+parts[1] * 60) + (+parts[2]);
        }
        const bestTimesLabels = data.bestTimes.usuarios;
        const bestTimesLeyend = data.bestTimes.niveles
        const bestTimesData = data.bestTimes.tiempo_transcurrido.map(timeToSeconds);
        function secondsToMinutesSeconds(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        }
        //Obtencion de los datos para la grafica 5: Grafica de pastel para la distribucion de los generos
        const generosLabels = data.generos.generos;
        const generosData = data.generos.cantidad.map(cantidad => Number(cantidad));
        //obtencion de los datos para la grafica 6: Grafica de barras para la distribucion de las edades
        const edadesLabels = Object.keys(data.edades.rangos);
        const edadesData = Object.values(data.edades.rangos);
        //Obtencion de los datos para la grafica 7: Grafica de barras para la distribucion de los grupos etnicos
        const gruposEtnicosLabels = Object.keys(data.gruposEtnicos.cantidad);
        const gruposEtnicosData = Object.values(data.gruposEtnicos.cantidad);
        //Obtencion de los datos para la grafica 8: Grafica de barras para la distribucion de las ciudades
        const ciudadesLabels = data.ciudades.ciudades;
        console.log(ciudadesLabels);
        const ciudadesData = data.ciudades.usuarios.map(usuarios => Number(usuarios));
        console.log(ciudadesData);

        //Configuracion global de los estilos de los graficos
        Chart.defaults.font.family = 'IMFellDWPica';
        Chart.defaults.font.size = 14;
        Chart.defaults.color = 'black';
        Chart.defaults.plugins.legend.labels.color = 'black';
        Chart.defaults.plugins.legend.labels.font = {
            size: 18,
            weight: 'bold'
        };
        Chart.defaults.maintainAspectRatio = false;
        
        // Plugin para establecer un fondo blanco global
        Chart.register({
            id: 'whiteBackground',
            beforeDraw: (chart) => {
                const ctx = chart.ctx;
                ctx.save();
                ctx.fillStyle = '#FFFFFF'; 
                ctx.fillRect(0, 0, chart.width, chart.height);
                ctx.restore();
            }
        });
        //Creacion de los contextos para los graficos
        const ctx1 = document.getElementById('myChart1').getContext('2d');
        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const ctx3 = document.getElementById('myChart3').getContext('2d');
        const ctx4 = document.getElementById('myChart4').getContext('2d');
        const ctx5 = document.getElementById('myChart5').getContext('2d');
        const ctx6 = document.getElementById('myChart6').getContext('2d');
        const ctx7 = document.getElementById('myChart7').getContext('2d');
        const ctx8 = document.getElementById('myChart8').getContext('2d');
        
        const contextos = [ctx1, ctx2, ctx3, ctx4, ctx5, ctx6, ctx7, ctx8];

        for (let i = 0; i < contextos.length; i++) {
            if (!contextos[i]) {
                console.error(`No se pudo obtener el contexto del gráfico ${i + 1}`);
                return;
            }
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
        const mychart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: topLabels,
                datasets: [{
                    label: 'Top Mejores Puntajes',
                    data: topData,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1,
                    color: 'white',
                    font: {
                        size: 16,
                    }

                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                const index = tooltipItem.dataIndex;
                                return topLeyend[index] + ': ' + tooltipItem.raw + ' puntos';
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 20,
                            padding: 15,
                            font: {
                                size: window.innerWidth < 768 ? 12 : 18,
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Puntaje Total Acumulado'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Usuarios'
                        }
                    }
                }
            }
        });
        //Creacion del 2do Gráfico
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: bottomLabels,
                datasets: [{
                    label: 'Top Peores Puntajes',
                    data: bottomData,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                const index = tooltipItem.dataIndex;
                                return bottomLeyend[index] + ': ' + tooltipItem.raw + ' puntos';
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 20,
                            padding: 15,
                            font: {
                                size: window.innerWidth < 768 ? 12 : 18,
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Puntaje Total Acumulado'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Usuarios'
                        }
                    }
                }
            }
        });
        //Creacion del 3er Gráfico
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: promediosLabels,
                datasets: [{
                    label: 'Top Puntajes Promedio',
                    data: promediosData,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                const index = tooltipItem.dataIndex;
                                return promediosLeyend[index] + ': ' + tooltipItem.raw + ' puntos';
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 20,
                            padding: 15,
                            font: {
                                size: window.innerWidth < 768 ? 12 : 18,
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Puntaje Promedio Acumulado'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Usuarios'
                        }
                    }
                }

            }
        });
        //Creacion del 4to Gráfico
        new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: bestTimesLabels,
                datasets: [{
                    label: 'Top Mejores Tiempos',
                    data: bestTimesData,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1
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
                        position: 'bottom',
                        labels: {
                            boxWidth: 20,
                            padding: 15,
                            font: {
                                size: window.innerWidth < 768 ? 12 : 18,
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Tiempo transcurrido (segundos)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Usuarios'
                        }
                    }
                }
            }
        });
        //Creacion del 5to Gráfico
        new Chart(ctx5, {
            type: 'pie',
            data: {
                labels: generosLabels,
                datasets: [{
                    label: 'Distribucion de Generos Usuarios',
                    data: generosData,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                const index = tooltipItem.dataIndex;
                                return generosLabels[index] + ': ' + tooltipItem.raw + ' usuarios';
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 20,
                            padding: 15,
                            font: {
                                size: window.innerWidth < 768 ? 12 : 18,
                            }
                        }
                    }
                }
            }
        });
        //Creacion del 6to Gráfico
        new Chart(ctx6, {
            type: 'bar',
            data: {
                labels: edadesLabels,
                datasets: [{
                    label: 'Distribucion de Edades de los Usuarios',
                    data: edadesData,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                const index = tooltipItem.dataIndex;
                                return edadesLabels[index] + ': ' + tooltipItem.raw + ' usuarios';
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 20,
                            padding: 15,
                            font: {
                                size: window.innerWidth < 768 ? 12 : 18,
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad de Usuarios'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Edades (años)'
                        }
                    }
                }
            }
        });
        //Creacion del 7mo Gráfico
        new Chart(ctx7, {
            type: 'bar',
            data: {
                labels: gruposEtnicosLabels,
                datasets: [{
                    label: 'Distribucion de Los grupos étnicos de los Usuarios',
                    data: gruposEtnicosData,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                const index = tooltipItem.dataIndex;
                                return gruposEtnicosLabels[index] + ': ' + tooltipItem.raw + ' usuarios';
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 20,
                            padding: 15,
                            font: {
                                size: window.innerWidth < 768 ? 12 : 18,
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad de Usuarios'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Grupo Étnico'
                        }
                    }
                }
            }
        });
        //Creacion del 8vo Gráfico
        new Chart(ctx8, {
            type: 'bar',
            data: {
                labels: ciudadesLabels,
                datasets: [{
                    label: 'Distribucion de Las ciudades de los Usuarios',
                    data: ciudadesData,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                const index = tooltipItem.dataIndex;
                                return ciudadesLabels[index] + ': ' + tooltipItem.raw + ' usuarios';
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 20,
                            padding: 15,
                            font: {
                                size: window.innerWidth < 768 ? 12 : 18,
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad de Usuarios'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Ciudad'
                        }
                    }
                }
            }
        });
    }).catch(error => console.error('Error:', error));
