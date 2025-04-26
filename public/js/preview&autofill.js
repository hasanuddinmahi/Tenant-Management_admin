const fileInput = document.getElementById('tenant_file');
const filePreview = document.getElementById('filePreview');
const confirmUpload = document.getElementById('confirmUpload');
const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
const docTypeInput = document.getElementById('document_type');
const docTypeHidden = document.getElementById('document_type_hidden');
const tenantFileBase64 = document.getElementById('tenant_file_base64');

let previewCanvas = null;

fileInput.addEventListener('change', handleFile);
confirmUpload.addEventListener('click', handleOCR);

function handleFile() {
    const file = fileInput.files[0];
    if (!file) return;

    filePreview.innerHTML = '';
    docTypeHidden.value = docTypeInput.value;

    // Check if the file is PDF
    if (file.type === 'application/pdf') {
        const reader = new FileReader();
        reader.onload = e => {
            const typedarray = new Uint8Array(e.target.result);
            pdfjsLib.getDocument({ data: typedarray }).promise.then(pdf => pdf.getPage(1))
            .then(page => {
                const viewport = page.getViewport({ scale: 1.5 });
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                page.render({ canvasContext: ctx, viewport }).promise.then(() => {
                    filePreview.appendChild(canvas);
                    previewCanvas = canvas;
                    tenantFileBase64.value = canvas.toDataURL('image/jpeg', 0.8);
                    previewModal.show();
                });
            });
        };
        reader.readAsArrayBuffer(file);
    }
    // Check if the file is an image
    else if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = new Image();
            img.src = e.target.result;
            img.onload = () => {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);
                filePreview.appendChild(canvas);
                previewCanvas = canvas;
                tenantFileBase64.value = canvas.toDataURL('image/jpeg', 0.8);
                previewModal.show();
            };
        };
        reader.readAsDataURL(file);
    } else {
        filePreview.innerHTML = '<div class="alert alert-danger">Unsupported file type.</div>';
        previewModal.show();
    }
}

async function handleOCR() {
    if (!previewCanvas) return alert('No document loaded.');

    confirmUpload.disabled = true;
    confirmUpload.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Scanning...';

    const resizedCanvas = document.createElement('canvas');
    await pica().resize(previewCanvas, resizedCanvas, { width: 1000 });

    Tesseract.recognize(resizedCanvas, 'eng', {
        logger: m => console.log(m)  // For debugging progress
    }).then(({ data: { text } }) => {
        console.log('OCR TEXT:', text);  // Debug the OCR result
        autofillForm(text);  // Autofill the form with the OCR result
        previewModal.hide();

        // Submit the form if autofill is successful
        document.querySelector('form').submit();
    }).catch(err => {
        console.error('OCR Error:', err);
        alert('Failed to read text. Please try again.');
    }).finally(() => {
        confirmUpload.disabled = false;
        confirmUpload.innerHTML = 'Upload & Autofill';
    });
}

function autofillForm(text) {
    console.log("Autofill text:", text);  // Check the text being passed to the autofill

    const fields = {
        name: /(?:Full\s*Name|Name)[:\-]?\s*(.+)/i,
        id_number: /(?:ID\s*Number|NID|National\s*ID|Passport\s*No.)[:\-]?\s*([A-Z0-9]+)/i,
        phone: /(?:Phone|Mobile)[:\-]?\s*(\+?\d{6,})/i,
        father_name: /(?:Father['’]?s?\s*Name)[:\-]?\s*(.+)/i,
        mother_name: /(?:Mother['’]?s?\s*Name)[:\-]?\s*(.+)/i,
        spouse_name: /(?:Spouse|Husband|Wife)[:\-]?\s*(.+)/i,
        email: /(?:Email|E-mail)[:\-]?\s*([\w\.-]+@[\w\.-]+\.\w+)/i,
        address: /(?:Permanent\s*Address|Present\s*Address)[:\-]?\s*(.+)/i
    };

    // Loop over the fields and check if we find matches in the OCR text
    for (const id in fields) {
        const regex = fields[id];
        const match = text.match(regex);
        if (match && match[1]) {
            const element = document.getElementById(id);
            if (element) {
                element.value = match[1].trim();
            }
        }
    }
}
