@extends('layouts.admin')

@section('title', 'Tambah Paket Top Up')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.topups') }}">Paket Top Up</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
    <h2 class="mb-1">Tambah Paket Top Up</h2>
    <p class="text-muted mb-0">Buat paket top up baru</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.topups.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Game <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Pilih Game</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="currency_name" class="form-label">Nama Mata Uang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('currency_name') is-invalid @enderror" 
                                   id="currency_name" name="currency_name" value="{{ old('currency_name') }}" 
                                   placeholder="Diamonds, UC, Genesis Crystals, dll" required>
                            @error('currency_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="name" class="form-label">Nama Paket <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="Contoh: 86 Diamonds" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="amount" class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" name="amount" value="{{ old('amount') }}" min="1" required>
                            @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="bonus_amount" class="form-label">Bonus</label>
                            <input type="number" class="form-control @error('bonus_amount') is-invalid @enderror" 
                                   id="bonus_amount" name="bonus_amount" value="{{ old('bonus_amount', 0) }}" min="0">
                            @error('bonus_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="price" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price') }}" min="0" required>
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="original_price" class="form-label">Harga Asli (Rp)</label>
                            <input type="number" class="form-control @error('original_price') is-invalid @enderror" 
                                   id="original_price" name="original_price" value="{{ old('original_price') }}" min="0">
                            @error('original_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Kosongkan jika tidak ada diskon</div>
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="sort_order" class="form-label">Urutan</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}">
                            @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <div class="form-check mt-4">
                                <input type="checkbox" class="form-check-input" id="is_popular" name="is_popular" value="1" 
                                       {{ old('is_popular') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_popular">Tandai sebagai Populer</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check mt-4">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Aktif</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.topups') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Panduan Mata Uang</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><strong>Mobile Legends:</strong> Diamonds</li>
                    <li class="mb-2"><strong>Free Fire:</strong> Diamonds</li>
                    <li class="mb-2"><strong>PUBG Mobile:</strong> UC (Unknown Cash)</li>
                    <li class="mb-2"><strong>Genshin Impact:</strong> Genesis Crystals</li>
                    <li class="mb-2"><strong>Valorant:</strong> VP (Valorant Points)</li>
                    <li class="mb-0"><strong>Clash of Clans:</strong> Gems</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
