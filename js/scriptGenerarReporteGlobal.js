import { PDFDocument, StandardFonts } from 'https://cdn.skypack.dev/pdf-lib';
const canvas1 = document.getElementById('myChart1');
const canvas2 = document.getElementById('myChart2');
const canvas3 = document.getElementById('myChart3');
const canvas4 = document.getElementById('myChart4');
const canvas5 = document.getElementById('myChart5');
const canvas6 = document.getElementById('myChart6');
const canvas7 = document.getElementById('myChart7');
const canvas8 = document.getElementById('myChart8');

// Imágenes a partir de los canvas
const image1 = canvas1.toDataURL('image/png'); 
const image2 = canvas2.toDataURL('image/png'); 
const image3 = canvas3.toDataURL('image/png'); 
const image4 = canvas4.toDataURL('image/png'); 
const image5 = canvas5.toDataURL('image/png'); 
const image6 = canvas6.toDataURL('image/png'); 
const image7 = canvas7.toDataURL('image/png'); 
const image8 = canvas8.toDataURL('image/png'); 

document.getElementById('generatePDFButton').addEventListener('click', loadTemplateAndCreatePDF);

async function loadTemplateAndCreatePDF() {
    // Cargar el archivo de plantilla PDF
    const url = '../recursos/plantillas_pdf/plantilla_reporte_global.pdf';
    const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer());
    const pdfDocPlantilla = await PDFDocument.load(existingPdfBytes);
    const pdfDoc = await PDFDocument.load(existingPdfBytes);

    const [templatePage] = await pdfDoc.copyPages(pdfDocPlantilla, [0]);
    const { width, height } = templatePage.getSize();

    let page = pdfDoc.getPages()[0]; 
    if (!page) { 
        page = pdfDoc.addPage(templatePage); 
    }
    // Cargar fuente de texto en formaro negrita y normal (fuente de la librería)
    const font = await pdfDoc.embedFont(StandardFonts.Helvetica);
    const fontBold = await pdfDoc.embedFont(StandardFonts.HelveticaBold);
    const margin = 55;
    let yPosition = height - margin * 3;
    // Agregar párrafos 
    const paragraph1 = "1. Resumen"; 
    yPosition = await addParagraphToPDF(page, paragraph1, fontBold, 14, width, height, margin, yPosition); 
    const paragraph2 = "El presente reporte sintetiza los principales resultados del desempeño de los colaboradores en el juego “Las Aventuras de Go” y las características demográficas de los participantes. Estos resultados permiten de manera objetiva revisar la eficacia del juego como herramienta de aprendizaje al evaluar el avance de los colaboradores a través del mismo, además permitirá inferir aquellas áreas clave para optimizar la experiencia, como [ejemplo: ajustar la dificultad de los últimos niveles o diversificar las dinámicas de interacción]. Por otra parte, también permite realizar de manera práctica una clasificación demográfica de los colaboradores de acuerdo a atributos clave que se gestionan a través de formularios en la plataforma de seguimiento."; 
    yPosition = await addParagraphToPDF(page, paragraph2, font, 12, width, height, margin, yPosition); 
    const paragraph3 = " " 
    yPosition = await addParagraphToPDF(page, paragraph3, font, 14, width, height, margin, yPosition); 
    const paragraph4 = "2. Análisis de Desempeño" 
    yPosition = await addParagraphToPDF(page, paragraph4, fontBold, 14, width, height, margin, yPosition); 
    const paragraph5 = "En esta sección se presenta un análisis detallado del desempeño de los colaboradores en el juego Las Aventuras de Go. El objetivo es identificar patrones en el progreso, niveles de dificultad y tiempo invertido, destacando los logros más significativos y áreas de oportunidad. Los datos aquí expuestos permiten comprender mejor cómo los colaboradores interactuaron con las dinámicas del juego y su impacto en el aprendizaje o desarrollo deseado." 
    yPosition = await addParagraphToPDF(page, paragraph5, font, 12, width, height, margin, yPosition);
   
    // Agregar gráficos con su sus titulos
    //yPosition = await addParagraphToPDF(page, "- Grafica 1: Top mejores puntajes", fontBold, 13, width, height, margin, yPosition);
    yPosition = await addChartToPDF(pdfDoc, pdfDocPlantilla, page, width, height, yPosition, image1);

    //yPosition = await addParagraphToPDF(page, "- Grafica 2: Top puntajes promédio", fontBold, 13, width, height, margin, yPosition);
    yPosition = await addChartToPDF(pdfDoc, pdfDocPlantilla, page, width, height, yPosition, image3);

    //yPosition = await addParagraphToPDF(page, "- Grafica 3: Top peores puntajes", fontBold, 13, width, height, margin, yPosition);
    yPosition = await addChartToPDF(pdfDoc, pdfDocPlantilla, page, width, height, yPosition, image2);

    //yPosition = await addParagraphToPDF(page, "- Grafica 4: Top mejores tiempos", fontBold, 13, width, height, margin, yPosition);
    yPosition = await addChartToPDF(pdfDoc, pdfDocPlantilla, page, width, height, yPosition, image4);

    // Guardar y descargar el PDF
    const pdfBytes = await pdfDoc.save();
    const link = document.createElement('a');
    link.href = URL.createObjectURL(new Blob([pdfBytes], { type: 'application/pdf' }));
    link.download = 'pdf_con_parrafos_y_grafica.pdf';
    link.click();
}

// Métodos auxiliares para la creación  de elementos en el pdf
//Metodo asincrónico para cargar párrafos en el pdf 
async function addParagraphToPDF(page, text, font, fontSize, pageWidth, pageHeight, margin, yPosition) { 
    const maxWidth = pageWidth - margin * 2; 
    const lines = splitTextIntoLines(text, font, fontSize, maxWidth); 
    for (const line of lines) { 
        if (yPosition - fontSize < margin) { 
            throw new Error('No hay espacio en la página actual para más texto.'); 
        } 
        page.drawText(line, { 
            x: margin, 
            y: yPosition, 
            size: fontSize, 
            font: font, 
        }); 
        yPosition -= fontSize + 5; 
    } 
    return yPosition; 
}
function splitTextIntoLines(text, font, fontSize, maxWidth) {
    const lines = [];
    const paragraphs = text.split('\n');
    paragraphs.forEach(paragraph => {
        const words = paragraph.split(' ');
        let currentLine = '';
        for (const word of words) {
            const testLine = currentLine + (currentLine ? ' ' : '') + word;
            const testWidth = font.widthOfTextAtSize(testLine, fontSize);
            if (testWidth > maxWidth) {
                lines.push(currentLine);
                currentLine = word;
            } else {
                currentLine = testLine;
            }
        }
        if (currentLine) lines.push(currentLine);
    });
    return lines;
}

async function addChartToPDF(pdfDoc, pdfDocPlantilla, page, pageWidth, pageHeight, yPosition, image) {
    const imageBytes = await pdfDoc.embedPng(image);
    const imageDims = imageBytes.scale(0.25);
    const xPos = (pageWidth - imageDims.width) / 2;
    if (yPosition - imageDims.height - 20 < 80) {
        // Clonar la página de la plantilla y agregarla como una nueva página
        const [newPage] = await pdfDoc.copyPages(pdfDocPlantilla, [0]);
        pdfDoc.addPage(newPage);
        page = newPage;
        yPosition = pageHeight - 150; 
    }
    yPosition -= imageDims.height + 20;
    page.drawImage(imageBytes, {
        x: xPos,
        y: yPosition,
        width: imageDims.width,
        height: imageDims.height,
    });
    return yPosition;
}
