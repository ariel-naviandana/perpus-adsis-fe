@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Daftar Buku</h2>

    <div class="list-group">
        @foreach($books as $book)
        <button type="button" class="list-group-item list-group-item-action" onclick="showBookDetail({{ $book['id'] }})">
            {{ $book['title'] }} - {{ $book['author'] }}
        </button>
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
        <a href="#" id="downloadBtn" class="btn btn-primary" target="_blank">Download PDF</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function showBookDetail(bookId) {
        const token = '{{ session("api_token") }}';
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
            document.getElementById('downloadBtn').href = `${apiBaseUrl}/books/${book.id}/download`;

            var myModal = new bootstrap.Modal(document.getElementById('bookDetailModal'));
            myModal.show();
        })
        .catch(error => {
            alert('Gagal mengambil detail buku');
        });
    }
</script>
@endsection
