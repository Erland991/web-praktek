import pdfplumber
import sys

pdf_path = sys.argv[1]

with pdfplumber.open(pdf_path) as pdf:
    first_page = pdf.pages[0]
    words = first_page.extract_words()
    
    # We want to find the coordinates of the ':' or the labels to know where the values start.
    labels_to_find = [
        "Latar", "Belakang", "Tujuan", "Target", "Fungsi-fungsi", 
        "Jenis", "Pengguna", "Uraian", "Lampiran", "Disiapkan", "Disetujui",
        "Tanggal:"
    ]
    
    found = []
    for word in words:
        if word['text'] in labels_to_find or ':' in word['text']:
            found.append(f"{word['text']:<15} X: {word['x0']:.2f}, Y: {word['top']:.2f}, W: {word['width']:.2f}, H: {word['height']:.2f}")

    print("\n".join(found))
