const fileInput = document.getElementById('tenant_file');
const filePreview = document.getElementById('filePreview');
const confirmUpload = document.getElementById('confirmUpload');
const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
const documentTypeDropdown = document.getElementById('document_type');
const documentTypeHidden = document.getElementById('document_type_hidden');
const tenantFileBase64 = document.getElementById('tenant_file_base64');

fileInput.addEventListener('change', previewFile);
confirmUpload.addEventListener('click', scanAndAutofill);

function previewFile() {
    const file = fileInput.files[0];
    if (!file) return;

    filePreview.innerHTML = '';
    documentTypeHidden.value = documentTypeDropdown.value;

    const reader = new FileReader();
    if (file.type === 'application/pdf') {
        reader.onload = function () {
            const typedarray = new Uint8Array(this.result);
            pdfjsLib.getDocument({ data: typedarray }).promise
                .then(pdf => pdf.getPage(1))
                .then(page => {
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    const viewport = page.getViewport({ scale: 1.5 });
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;
                    return page.render({ canvasContext: context, viewport }).promise.then(() => {
                        filePreview.appendChild(canvas);
                        tenantFileBase64.value = canvas.toDataURL();
                        previewModal.show();
                    });
                });
        };
        reader.readAsArrayBuffer(file);
    } else if (file.type.startsWith('image/')) {
        reader.onload = function (e) {
            const img = new Image();
            img.src = e.target.result;
            img.onload = function () {
                const canvas = document.createElement('canvas');
                const picaInstance = window.pica();
                canvas.width = img.width;
                canvas.height = img.height;
                picaInstance.resize(img, canvas).then(() => {
                    filePreview.appendChild(canvas);
                    tenantFileBase64.value = canvas.toDataURL();
                    previewModal.show();
                });
            };
        };
        reader.readAsDataURL(file);
    } else {
        filePreview.innerHTML = '<div class="alert alert-danger">Unsupported file type.</div>';
        previewModal.show();
    }
}

function scanAndAutofill() {
    const base64Image = tenantFileBase64.value;
    if (!base64Image) {
        alert('No image available to scan.');
        return;
    }

    confirmUpload.disabled = true;
    confirmUpload.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Processing...';

    Tesseract.recognize(base64Image, 'eng', {
        tessedit_char_whitelist: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@. ',
    }).then(({ data: { text, blocks } }) => {
        let detectedDocumentType = '';

        for (const block of blocks) {
            if (block.confidence > 80) {
                if (/(?:National\s?ID|NID|ID\s?Number)/i.test(block.text)) {
                    detectedDocumentType = 'NID';
                    break;
                }
                if (/(?:Passport\s?No\.?|Document\s?No\.?)/i.test(block.text)) {
                    detectedDocumentType = 'Passport';
                    break;
                }
            }
        }

        fillFormFromText(text);

        if (detectedDocumentType) {
            documentTypeDropdown.value = detectedDocumentType;
            documentTypeHidden.value = detectedDocumentType;
        }

        previewModal.hide();
    }).catch(err => {
        console.error('OCR Error:', err);
        alert('Failed to extract text. Please fill manually.');
    }).finally(() => {
        confirmUpload.disabled = false;
        confirmUpload.innerHTML = 'Upload';
    });
}

function fillFormFromText(text) {
    const patterns = {
        name: /(?:Name|Full Name|Name of Holder)[:=\-]?\s*([^\n]+)/i,
        id_number: /(?:Passport\s?(?:No\.?|Number)|PP\s?No\.?|Document\s?No\.?|PassportNumber)[:=\-\s]*([A-Z0-9]{7,15})/i,
        father_name: /(?:Father[']?s? Name|Father)[:=\-]?\s*([^\n]+)/i,
        mother_name: /(?:Mother[']?s? Name|Mother)[:=\-]?\s*([^\n]+)/i,
        spouse_name: /(?:Spouse|Husband|Wife)[:=\-]?\s*([^\n]+)/i,
        address: /(?:Permanent Address|Present Address|Address)[:=\-]?\s*([^\n]+)/i
    };

    const lowerText = text.toLowerCase();
    let documentType = '';

    if (lowerText.includes('passport') && lowerText.includes('no') || lowerText.includes('passportnumber')) {
        documentType = 'passport';
    } else if (lowerText.includes('national id') || lowerText.includes('nid') || lowerText.includes('national identification')) {
        documentType = 'nid';
    }

    console.log('Detected Document Type:', documentType);

    for (const [field, regex] of Object.entries(patterns)) {
        const match = text.match(regex);
        if (match) {
            const fieldElement = document.getElementById(field);
            if (fieldElement) {
                fieldElement.value = match[1].trim();
            }
        }
    }

    if (documentType) {
        documentTypeDropdown.value = documentType;
        documentTypeHidden.value = documentType;
    }
}
