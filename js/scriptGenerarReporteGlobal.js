import { PDFDocument } from 'https://cdn.skypack.dev/pdf-lib';

const canvas = document.getElementById('myChart1');
const image = canvas.toDataURL('image/png'); // Cambiado a 'image/jpeg'

document.getElementById('generatePDFButton').addEventListener('click', loadTemplateAndCreatePDF);

async function loadTemplateAndCreatePDF() {
    // Cargar el archivo de plantilla PDF
    const url = '../recursos/plantillas_pdf/plantilla_reporte_global.pdf';
    const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer());
    const pdfDoc = await PDFDocument.load(existingPdfBytes);
    const page = pdfDoc.getPages()[0];
    const { width, height } = page.getSize();
    await addChartToPDF(pdfDoc, page, width, height);

    // Guardar y descargar el PDF
    const pdfBytes = await pdfDoc.save();
    const link = document.createElement('a');
    link.href = URL.createObjectURL(new Blob([pdfBytes], { type: 'application/pdf' }));
    link.download = 'pdf_con_grafica.pdf';
    link.click();
}

async function addChartToPDF(pdfDoc, page, pageWidth, pageHeight) {
    // Usa la imagen en formato base64 generada por canvas.toDataURL
    const imageBytes = await pdfDoc.embedPng(image); // Asegúrate de usar embedJpg
    const imageDims = imageBytes.scale(0.5); // Escalar la imagen a la mitad
    const xPos = (pageWidth - imageDims.width) / 2; // Centrar horizontalmente
    const yPos = pageHeight - imageDims.height - 200; // Ajustar verticalmente

    page.drawImage(imageBytes, {
        x: xPos,
        y: yPos,
        width: imageDims.width,
        height: imageDims.height
    });
}
