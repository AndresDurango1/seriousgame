import { PDFDocument, StandardFonts } from 'https://cdn.skypack.dev/pdf-lib';
const fullName = document.getElementById('inputNombre').value + ' ' + document.getElementById('inputApellido').value;
console.log(fullName);
document.getElementById('generatePDFButton').addEventListener('click', async () => {
    try {
        // Capturar todas las imágenes de los canvas visibles
        const images = await captureAllCanvasImages();
        // Verificar si las imágenes se exportaron correctamente
        images.forEach((image, index) => {
            if (image) {
                console.log(`Imagen ${index + 1} exportada correctamente`);
            } else {
                console.error(`Error al exportar la imagen ${index + 1}`);
            }
        });
        // Crear y descargar el PDF
        await loadTemplateAndCreatePDF(images);
    } catch (error) {
        console.error('Error al generar el PDF:', error);
    }
});
async function captureAllCanvasImages() {
    const carousel = document.querySelector("#carouselExample");
    const items = document.querySelectorAll(".carousel-item");
    const images = [];
    for (let i = 0; i < items.length; i++) {
        // Asegurarse de que el item actual sea visible
        carousel.querySelectorAll(".active").forEach((activeItem) => activeItem.classList.remove("active"));
        items[i].classList.add("active");
        // Esperar un pequeño retraso para que el canvas se renderice completamente
        await new Promise((resolve) => setTimeout(resolve, 2000)); // Ajustar el tiempo si es necesario
        // Capturar el canvas del item activo
        const canvas = items[i].querySelector("canvas");
        if (canvas) {
            console.log(`Canvas encontrado en el item ${i}`);
            const image = canvas.toDataURL("image/png");
            images.push(image);
        } else {
            console.error(`No se encontró un canvas en el item ${i}`);
            images.push(null); // Si no hay canvas, agregar un valor nulo
        }
    }
    return images;
}
async function loadTemplateAndCreatePDF(images) {
    // Cargar el archivo de plantilla PDF
    const url = '../recursos/plantillas_pdf/plantilla_reporte_individual.pdf';
    const existingPdfBytes = await fetch(url).then((res) => res.arrayBuffer());
    const pdfDocPlantilla = await PDFDocument.load(existingPdfBytes);
    const pdfDoc = await PDFDocument.load(existingPdfBytes);
    const [templatePage] = await pdfDoc.copyPages(pdfDocPlantilla, [0]);
    const { width, height } = templatePage.getSize();
    let page = pdfDoc.getPages()[0];
    if (!page) {
        page = pdfDoc.addPage(templatePage);
    }
    // Cargar fuente de texto
    const font = await pdfDoc.embedFont(StandardFonts.Helvetica);
    const fontBold = await pdfDoc.embedFont(StandardFonts.HelveticaBold);
    const margin = 55;
    let yPosition = height - margin * 3;
    // Agregar texto al PDF
    const paragraph1 = "1. Resumen";
    yPosition = await addParagraphToPDF(page, paragraph1, fontBold, 14, width, height, margin, yPosition);
    const paragraph2 = "El presente reporte sintetiza los principales resultados del desempeño de "+fullName+" en el juego “Las Aventuras de Go” y las características demográficas relevantes. Este análisis permite revisar de manera objetiva la eficacia del juego como herramienta de aprendizaje para "+fullName+", evaluando su progreso a lo largo de la experiencia y destacando áreas clave de mejora, como [ejemplo: ajustar la dificultad de ciertos niveles o enfocar más en ciertas dinámicas de interacción]. Además, se incluye un perfil demográfico de "+fullName+" que podría influir en su desempeño.";
    yPosition = await addParagraphToPDF(page, paragraph2, font, 12, width, height, margin, yPosition);
    const paragraph3 = "2. Análisis de Desempeño";
    yPosition = await addParagraphToPDF(page, paragraph3, fontBold, 14, width, height, margin, yPosition);
    const paragraph4 = "En esta sección se presenta un análisis detallado del desempeño de "+fullName+" en el juego “Las Aventuras de Go”. El objetivo es identificar patrones en su progreso, niveles de dificultad, y tiempo invertido, destacando los logros más significativos y las áreas de oportunidad. Este análisis permite comprender cómo "+fullName+" interactuó con las dinámicas del juego y cuál fue su impacto en el aprendizaje o desarrollo deseado.";
    yPosition = await addParagraphToPDF(page, paragraph4, font, 12, width, height, margin, yPosition);
    const paragraph5 = " - 2.1. Gráficas de desempeño" 
    yPosition = await addParagraphToPDF(page, paragraph5, fontBold, 14, width, height, margin, yPosition);
    const paragraph6 = "En este bloque se presentan las siguientes gráficas \n\
    - Gráfica 1: Niveles completados y no completados\n\
    - Gráfica 2: Puntaje promedio por nivel\n\
    - Gráfica 3: Tiempo promedio invertido por nivel";
    yPosition = await addParagraphToPDF(page, paragraph6, font, 12, width, height, margin, yPosition);
    // Insertar gráficos
    for (let i = 0; i < images.length; i++) {
        if (images[i]) {
            yPosition = await addChartToPDF(pdfDoc, pdfDocPlantilla, page, width, height, yPosition, images[i]);
        }
    }
    //const paragraph7 = "- 2.2. Perfil demográfico";
    //yPosition = await addParagraphToPDF(page, paragraph7, fontBold, 14, width, height, margin, yPosition);
    // Descargar el PDF
    const pdfBytes = await pdfDoc.save();
    const link = document.createElement('a');
    link.href = URL.createObjectURL(new Blob([pdfBytes], { type: 'application/pdf' }));
    link.download = 'reporte_' + fullName + '.pdf';
    link.click();
}
async function addParagraphToPDF(page, text, font, fontSize, pageWidth, pageHeight, margin, yPosition) {
    const maxWidth = pageWidth - margin * 2;
    const lines = splitTextIntoLines(text, font, fontSize, maxWidth);
    for (const line of lines) {
        if (yPosition - fontSize < margin) {
            const [newPage] = await pdfDoc.copyPages(pdfDocPlantilla, [0]);
            pdfDoc.addPage(newPage);
            page = newPage;
            yPosition = pageHeight - margin * 2;
        }
        page.drawText(line, {
            x: margin,
            y: yPosition,
            size: fontSize,
            font: font,
        });
        yPosition -= fontSize + 8;
    }
    return yPosition;
}
function splitTextIntoLines(text, font, fontSize, maxWidth) {
    const lines = [];
    const paragraphs = text.split('\n');
    paragraphs.forEach((paragraph) => {
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
    try {
        const imageBytes = await pdfDoc.embedPng(image);
        const imageDims = imageBytes.scale(0.7);
        const xPos = (pageWidth - imageDims.width) / 2;
        if (yPosition - imageDims.height - 20 < 80) {
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
    } catch (error) {
        console.error("Error al incrustar la imagen en el PDF:", error);
    }
    return yPosition;
}
