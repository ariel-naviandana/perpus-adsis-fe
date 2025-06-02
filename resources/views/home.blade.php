@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Daftar Buku</h2>

    <div class="row g-3">
        @foreach($books as $book)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-2">{{ $book['title'] }}</h5>
                    <p class="card-text mb-1"><strong>Penulis:</strong> {{ $book['author'] }}</p>
                    <p class="card-text mb-1"><strong>Kategori:</strong> {{ $book['category'] }}</p>
                    <button type="button" class="btn btn-primary mt-auto" onclick="showBookDetail({{ $book['id'] }})">
                        Detail
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Popup Detail Buku -->
<div class="modal fade" id="bookDetailModal" tabindex="-1" aria-labelledby="bookDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bookDetailLabel">Detail Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 id="bookTitle"></h4>
        <p><strong>Penulis:</strong> <span id="bookAuthor"></span></p>
        <p><strong>Kategori:</strong> <span id="bookCategory"></span></p>
        <p><strong>Deskripsi:</strong></p>
        <p id="bookDescription"></p>
      </div>
      <div class="modal-footer">
        <a href="#" id="downloadBtn" class="btn btn-primary" download>Download PDF</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function showBookDetail(bookId) {
        const token = '{{ session("api_token") }}';
        const baseUrl = "{{ url('') }}";
        const apiBaseUrl = "{{ config('app.api_base_url') }}";

        axios.get(`${apiBaseUrl}/books/${bookId}`, {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })
        .then(response => {
            const book = response.data;

            document.getElementById('bookTitle').innerText = book.title;
            document.getElementById('bookAuthor').innerText = book.author;
            document.getElementById('bookCategory').innerText = book.category;
            document.getElementById('bookDescription').innerText = book.description;

            document.getElementById('downloadBtn').href = baseUrl + '/books/download/' + book.id;

            var myModal = new bootstrap.Modal(document.getElementById('bookDetailModal'));
            myModal.show();
        })
        .catch(error => {
            alert('Gagal mengambil detail buku');
        });
    }
</script>
@endsection
