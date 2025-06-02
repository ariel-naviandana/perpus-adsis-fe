@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Manajemen User</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#userModal" id="btnAddUser">Tambah User</button>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user['name'] }}</td>
                <td>{{ $user['email'] }}</td>
                <td>{{ ucfirst($user['role']) }}</td>
                <td>
                    <button class="btn btn-sm btn-warning btn-edit" data-id="{{ $user['id'] }}" data-bs-toggle="modal" data-bs-target="#userModal">Edit</button>
                    <form action="{{ route('manage.users.destroy', $user['id']) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin hapus user ini?')">
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

<!-- Modal Form User -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="userForm" method="POST" action="{{ route('manage.users.store') }}">
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="POST" />
        <input type="hidden" name="user_id" id="userId" />
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="userModalLabel">Tambah User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" required />
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required />
                </div>
                <div class="mb-3" id="passwordField">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required />
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="">Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                        <option value="user">User</option>
                    </select>
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const userModal = document.getElementById('userModal');
    const userForm = document.getElementById('userForm');
    const modalTitle = document.getElementById('userModalLabel');
    const formMethod = document.getElementById('formMethod');
    const userIdInput = document.getElementById('userId');
    const passwordField = document.getElementById('passwordField');

    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function () {
            const tr = this.closest('tr');
            modalTitle.textContent = 'Edit User';
            formMethod.value = 'PUT';
            userForm.action = `/manage/users/${this.dataset.id}`;
            userIdInput.value = this.dataset.id;
            document.getElementById('name').value = tr.children[0].textContent.trim();
            document.getElementById('email').value = tr.children[1].textContent.trim();
            document.getElementById('role').value = tr.children[2].textContent.trim().toLowerCase();
            passwordField.style.display = 'none'; // sembunyikan password saat edit
            document.getElementById('password').removeAttribute('required');
        });
    });

    document.getElementById('btnAddUser').addEventListener('click', () => {
        modalTitle.textContent = 'Tambah User';
        formMethod.value = 'POST';
        userForm.action = "{{ route('manage.users.store') }}";
        userIdInput.value = '';
        userForm.reset();
        passwordField.style.display = 'block';
        document.getElementById('password').setAttribute('required', 'required');
    });
});
</script>
@endsection
