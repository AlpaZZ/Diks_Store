@extends('layouts.admin')

@section('title', 'Kelola Paket Top Up')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Paket Top Up</h2>
        <p class="text-muted mb-0">Kelola paket top up diamond/gems</p>
    </div>
    <a href="{{ route('admin.topups.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Paket
    </a>
</div>

<!-- Filter -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.topups') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari paket..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
                <a href="{{ route('admin.topups') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Top Up List -->
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Game</th>
                    <th>Nama Paket</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topups as $topup)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($topup->category->icon)
                            <img src="{{ Storage::url($topup->category->icon) }}" alt="{{ $topup->category->name }}" 
                                 class="rounded me-2" style="width: 30px; height: 30px; object-fit: cover;">
                            @endif
                            <span>{{ $topup->category->name }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="fw-semibold">{{ $topup->name }}</span>
                        @if($topup->is_popular)
                        <span class="badge bg-primary ms-1">Populer</span>
                        @endif
                    </td>
                    <td>
                        {{ number_format($topup->amount) }} {{ $topup->currency_name }}
                        @if($topup->bonus_amount > 0)
                        <span class="text-success">(+{{ number_format($topup->bonus_amount) }})</span>
                        @endif
                    </td>
                    <td>
                        <span class="fw-semibold">{{ $topup->formatted_price }}</span>
                        @if($topup->has_discount)
                        <br><small class="text-muted text-decoration-line-through">{{ $topup->formatted_original_price }}</small>
                        @endif
                    </td>
                    <td>
                        @if($topup->is_active)
                        <span class="badge bg-success">Aktif</span>
                        @else
                        <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.topups.edit', $topup->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.topups.delete', $topup->id) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <i class="bi bi-gem display-4 text-muted"></i>
                        <p class="mt-2 mb-0">Belum ada paket top up</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $topups->withQueryString()->links('pagination::bootstrap-5') }}
</div>

<style>
    .pagination {
        margin-bottom: 0;
    }
    .pagination .page-link {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
        margin: 0 2px;
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-color: var(--primary-color);
    }
    .pagination .page-link:hover {
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
</style>
@endsection
