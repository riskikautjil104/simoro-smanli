@extends('layouts.master')

@section('title', 'Periksa Ujian')

@section('layoutContent')
<div class="card p-4">
    <h4>Periksa Jawaban Siswa</h4>

    <div class="mb-3">
        <label class="form-label">Pilih Ujian</label>
        <select id="ujian-select" class="form-select"></select>
    </div>

    <div class="mb-3">
        <label class="form-label">Pilih Siswa</label>
        <select id="peserta-select" class="form-select"></select>
    </div>

    <div id="jawaban-container" class="mb-3" style="display:none">
        <h5>Jawaban Siswa</h5>
        <div id="jawaban-list"></div>

        <div class="mt-3">
            <label class="form-label">Nilai</label>
            <input type="number" id="input-nilai" class="form-control" min="0" max="100">
            <button id="btn-simpan-nilai" class="btn btn-success mt-2">
                Simpan Nilai
            </button>
        </div>
    </div>
</div>

<script>
let ujianList = [];
let pesertaList = [];
let selectedUjian = null;
let selectedPeserta = null;

/* ===============================
   AMBIL DAFTAR UJIAN
================================= */
fetch('/guru/ujian/list')
    .then(res => res.json())
    .then(data => {
        ujianList = data;

        const ujianSelect = document.getElementById('ujian-select');
        ujianSelect.innerHTML = '<option value="">-- Pilih Ujian --</option>';

        ujianList.forEach(u => {
            ujianSelect.innerHTML += `
                <option value="${u.id}">
                    ${u.title} (${u.subject ? u.subject.name : ''})
                </option>
            `;
        });
    })
    .catch(() => {
        alert('Gagal mengambil data ujian');
    });

/* ===============================
   PILIH UJIAN → AMBIL PESERTA
================================= */
document.getElementById('ujian-select')
.addEventListener('change', function() {

    selectedUjian = this.value;
    selectedPeserta = null;

    document.getElementById('peserta-select').innerHTML =
        '<option value="">-- Pilih Siswa --</option>';

    document.getElementById('jawaban-container').style.display = 'none';

    if (!selectedUjian) return;

    fetch(`/guru/ujian/${selectedUjian}/peserta`)
        .then(res => res.json())
        .then(data => {

            pesertaList = data;
            const pesertaSelect = document.getElementById('peserta-select');

            data.forEach(p => {
                pesertaSelect.innerHTML += `
                    <option value="${p.user.id}">
                        ${p.user.name}
                    </option>
                `;
            });
        })
        .catch(() => {
            alert('Gagal mengambil data peserta');
        });
});


/* ===============================
   PILIH PESERTA → AMBIL JAWABAN
================================= */
document.getElementById('peserta-select')
.addEventListener('change', function() {

    selectedPeserta = this.value;

    if (!selectedUjian || !selectedPeserta) return;

    fetch(`/guru/ujian/${selectedUjian}/peserta/${selectedPeserta}/jawaban`)
        .then(res => res.json())
        .then(data => {

            document.getElementById('jawaban-container').style.display = '';

            const list = document.getElementById('jawaban-list');
            list.innerHTML = '';

            let scoresArr = [];
            let totalScore = 0;
            let totalCount = 0;
            data.forEach((j, idx) => {
                let tipe = '-';
                if (j.question && j.question.type) {
                    if (j.question.type === 'essay') {
                        tipe = 'Essay';
                    } else if (j.question.type === 'multiple_choice') {
                        tipe = 'PG';
                    } else {
                        tipe = j.question.type;
                    }
                }
                let jawabanBenar = '';
                if (j.question && j.question.type === 'multiple_choice') {
                    jawabanBenar = `<span class='text-success'><b>Jawaban Benar:</b> ${j.question.answer_key || j.question.jawaban_benar || '-'}</span><br>`;
                }
                let scoreVal = j.nilai_essay != null ? j.nilai_essay : '';
                if (scoreVal !== '' && !isNaN(scoreVal)) {
                    totalScore += parseFloat(scoreVal);
                    totalCount++;
                }
                scoresArr.push({answer_id: j.id, score: scoreVal});
                list.innerHTML += `
                    <div class="mb-3 p-2 border rounded">
                        <b>
                            ${idx + 1}. [${tipe}]
                            ${j.question 
                                ? (j.question.question_text || j.question.text)
                                : '-'}
                        </b>
                        <br>
                        <span><b>Jawaban:</b> ${j.answer ?? '-'}</span><br>
                        ${jawabanBenar}
                        <label>Nilai Essay:</label>
                        <input type="number" class="form-control score-input" data-answer-id="${j.id}" value="${scoreVal}" min="0" max="100">
                    </div>
                `;
            });
            // Tambahkan tombol simpan nilai per soal
            list.innerHTML += `<button id='btn-simpan-nilai-per-soal' class='btn btn-primary mt-2'>Simpan Nilai Per Soal</button>`;
            // Set nilai total ke input utama
            document.getElementById('input-nilai').value = totalScore;
            // Event simpan nilai per soal
            setTimeout(() => {
                const btn = document.getElementById('btn-simpan-nilai-per-soal');
                if (btn) {
                    btn.onclick = function() {
                        // Ambil semua nilai dari input
                        const scoreInputs = document.querySelectorAll('.score-input');
                        let scores = [];
                        let total = 0;
                        scoreInputs.forEach(inp => {
                            let val = inp.value;
                            if (val !== '' && !isNaN(val)) total += parseFloat(val);
                            scores.push({
                                answer_id: inp.getAttribute('data-answer-id'),
                                score: val
                            });
                        });
                        fetch(`/guru/ujian/${selectedUjian}/peserta/${selectedPeserta}/nilai-per-soal`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ scores })
                        })
                        .then(res => res.json())
                        .then(res => {
                            document.getElementById('input-nilai').value = total;
                            alert(res.message || 'Nilai per soal berhasil disimpan!');
                        })
                        .catch(() => {
                            alert('Gagal simpan nilai per soal');
                        });
                    }
                }
            }, 100);

            // Ambil nilai terakhir jika ada
            const pesertaObj = pesertaList.find(
                p => p.user && p.user.id == selectedPeserta
            );

            document.getElementById('input-nilai').value =
                pesertaObj && pesertaObj.score != null
                    ? pesertaObj.score
                    : '';
        })
        .catch(() => {
            alert('Gagal mengambil jawaban siswa');
        });
});


/* ===============================
   SIMPAN NILAI
================================= */
document.getElementById('btn-simpan-nilai')
.addEventListener('click', function() {

    if (!selectedUjian || !selectedPeserta) return;

    const nilai = document.getElementById('input-nilai').value;

    fetch(`/guru/ujian/${selectedUjian}/peserta/${selectedPeserta}/nilai`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
        body: JSON.stringify({ nilai })
    })
    .then(res => res.json())
    .then(res => {
        alert(res.message || 'Nilai berhasil disimpan!');
    })
    .catch(() => {
        alert('Gagal simpan nilai');
    });
});
</script>

@endsection