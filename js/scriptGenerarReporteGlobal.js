import { PDFDocument } from 'https://cdn.skypack.dev/pdf-lib';

const canvas = document.getElementById('myChart1');
const image = canvas.toDataURL('image/png');

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
    const imageBytes = await pdfDoc.embedPng(image); // Cambié de JPG a PNG para coincidir con el formato
    const { width, height } = imageBytes.size();
    const xPos = (pageWidth - 500) / 2; // Ajusta según tus necesidades
    const yPos = pageHeight - (height / width) * 500 - 100;

    page.drawImage(imageBytes, {
        x: xPos,
        y: yPos,
        width: 500,  // Ajusta el ancho
        height: (height / width) * 500  // Mantén la proporción
    });

    // Agregar más elementos si es necesario
    page.drawText('Título del PDF', {
        x: 50,
        y: pageHeight - 50,  // Ajusta la posición
        size: 16,
        bold: true,
    });
}

