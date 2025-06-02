@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Manajemen Buku</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#bookModal" id="btnAddBook">Tambah Buku</button>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{ $book['title'] }}</td>
                <td>{{ $book['author'] }}</td>
                <td>{{ $book['category'] }}</td>
                <td>
                    <button class="btn btn-sm btn-warning btn-edit"
                        data-id="{{ $book['id'] }}"
                        data-title="{{ $book['title'] }}"
                        data-author="{{ $book['author'] }}"
                        data-category="{{ $book['category'] }}"
                        data-file_path="{{ $book['file_path'] ?? '' }}"
                        data-bs-toggle="modal"
                        data-bs-target="#bookModal">
                        Edit
                    </button>
                    <form action="{{ route('manage.books.destroy', $book['id']) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin hapus buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Form Buku -->
<div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="bookForm" method="POST" action="{{ route('manage.books.store') }}">
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="POST" />
        <input type="hidden" name="book_id" id="bookId" />
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="bookModalLabel">Tambah Buku</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="title" name="title" required />
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Penulis</label>
                    <input type="text" class="form-control" id="author" name="author" required />
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select class="form-select" id="category" name="category" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Teknologi">Teknologi</option>
                        <option value="Sastra">Sastra</option>
                        <option value="Sejarah">Sejarah</option>
                        <option value="Matematika">Matematika</option>
                        <option value="Agama">Agama</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="file_path" class="form-label">URL PDF</label>
                    <input type="url" class="form-control" id="file_path" name="file_path" required />
                </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btnSubmit">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
        </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const bookModal = document.getElementById('bookModal');
    const bookForm = document.getElementById('bookForm');
    const modalTitle = document.getElementById('bookModalLabel');
    const formMethod = document.getElementById('formMethod');
    const bookIdInput = document.getElementById('bookId');

    bookModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;

        if (!button || !button.classList.contains('btn-edit')) {
            modalTitle.textContent = 'Tambah Buku';
            bookForm.action = "{{ route('manage.books.store') }}";
            formMethod.value = 'POST';
            bookIdInput.value = '';
            bookForm.reset();
        } else {
            modalTitle.textContent = 'Edit Buku';
            const id = button.getAttribute('data-id');
            const title = button.getAttribute('data-title');
            const author = button.getAttribute('data-author');
            const category = button.getAttribute('data-category');
            const file_path = button.getAttribute('data-file_path') || '';

            bookForm.action = `/manage/books/${id}`;
            formMethod.value = 'PUT';
            bookIdInput.value = id;

            document.getElementById('title').value = title;
            document.getElementById('author').value = author;
            document.getElementById('category').value = category;
            document.getElementById('file_path').value = file_path;
        }
    });

    document.getElementById('btnAddBook').addEventListener('click', function() {
        bookForm.reset();
        modalTitle.textContent = 'Tambah Buku';
        formMethod.value = 'POST';
        bookForm.action = "{{ route('manage.books.store') }}";
        bookIdInput.value = '';
    });
});
</script>
@endpush
