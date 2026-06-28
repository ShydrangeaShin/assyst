// assets/js/wilayah.js
function initCascadingWilayah(dataKota, dataKec, dataDesa, elements) {
    const pSel = document.getElementById(elements.provinsi);
    const koSel = document.getElementById(elements.kota);
    const kecSel = document.getElementById(elements.kecamatan);
    const dSel = document.getElementById(elements.desa);

    if (!pSel || !koSel || !kecSel || !dSel) return;

    function renderOptions(dataArr, filterKey, filterVal, targetSelect, valueKey, textKey, selectedVal) {
        targetSelect.innerHTML = '<option value="">-- Pilih ' + targetSelect.id.replace('Edit', '') + ' --</option>';
        if (!filterVal) { targetSelect.disabled = true; return; }
        
        targetSelect.disabled = false;
        dataArr.filter(item => String(item[filterKey]) === String(filterVal)).forEach(item => {
            const isSelected = String(item[valueKey]) === String(selectedVal) ? 'selected' : '';
            targetSelect.innerHTML += `<option value="${item[valueKey]}" ${isSelected}>${item[textKey]}</option>`;
        });
    }

    function runCascading() {
        const selKota = koSel.getAttribute('data-selected') || '';
        const selKec = kecSel.getAttribute('data-selected') || '';
        const selDesa = dSel.getAttribute('data-selected') || '';

        renderOptions(dataKota, 'id_provinsi', pSel.value, koSel, 'id_kota', 'nama_kota', selKota);
        renderOptions(dataKec, 'id_kota', selKota || koSel.value, kecSel, 'id_kecamatan', 'nama_kecamatan', selKec);
        renderOptions(dataDesa, 'id_kecamatan', selKec || kecSel.value, dSel, 'id_desa', 'nama_desa', selDesa);
    }

    pSel.addEventListener('change', () => { koSel.setAttribute('data-selected',''); kecSel.setAttribute('data-selected',''); dSel.setAttribute('data-selected',''); runCascading(); });
    koSel.addEventListener('change', function() { koSel.setAttribute('data-selected', this.value); kecSel.setAttribute('data-selected',''); dSel.setAttribute('data-selected',''); runCascading(); });
    kecSel.addEventListener('change', function() { kecSel.setAttribute('data-selected', this.value); dSel.setAttribute('data-selected',''); runCascading(); });

    runCascading();
}