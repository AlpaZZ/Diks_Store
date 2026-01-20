@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Produk</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5" required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price', $product->price) }}" min="0" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="original_price" class="form-label">Harga Asli (Opsional)</label>
                            <input type="number" class="form-control @error('original_price') is-invalid @enderror" 
                                   id="original_price" name="original_price" 
                                   value="{{ old('original_price', $product->original_price) }}" min="0">
                            @error('original_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="game_server" class="form-label">Server Game</label>
                            <input type="text" class="form-control @error('game_server') is-invalid @enderror" 
                                   id="game_server" name="game_server" 
                                   value="{{ old('game_server', $product->game_server) }}">
                            @error('game_server')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="game_level" class="form-label">Level/Rank</label>
                            <input type="text" class="form-control @error('game_level') is-invalid @enderror" 
                                   id="game_level" name="game_level" 
                                   value="{{ old('game_level', $product->game_level) }}">
                            @error('game_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="account_details" class="form-label">Detail Akun</label>
                        <textarea class="form-control @error('account_details') is-invalid @enderror" 
                                  id="account_details" name="account_details" rows="3">{{ old('account_details', $product->account_details) }}</textarea>
                        @error('account_details')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Produk</label>
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="rounded" style="height: 100px;">
                                <br><small class="text-muted">Gambar saat ini</small>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="available" {{ old('status', $product->status) == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="pending" {{ old('status', $product->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="sold" {{ old('status', $product->status) == 'sold' ? 'selected' : '' }}>Sold</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Opsi Lainnya</label>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                       value="1" {{ $product->is_featured ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Tandai sebagai Produk Featured</label>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Update Produk
                        </button>
                        <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h6><i class="bi bi-info-circle"></i> Info Produk</h6>
                <table class="table table-sm mb-0">
                    <tr>
                        <td class="text-muted">ID</td>
                        <td>{{ $product->id }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Views</td>
                        <td>{{ $product->view_count }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Dibuat</td>
                        <td>{{ $product->created_at->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Diupdate</td>
                        <td>{{ $product->updated_at->format('d M Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <a href="{{ route('product.detail', $product->slug) }}" target="_blank" class="btn btn-outline-primary w-100">
                    <i class="bi bi-eye"></i> Lihat di Website
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
